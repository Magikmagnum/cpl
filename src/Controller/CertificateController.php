<?php

namespace App\Controller;

use App\Entity\Certificate;
use App\Form\CertificateType;
use App\Repository\CertificateRepository;
use App\Services\QrcodeServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class CertificateController extends AbstractController
{

    private $repository;
    private $root = "q=-8LauRaPdGtn07BqRXYdIqpOpx6hoYMydx8exOH/8x43DlFDZ0e/b/";
    private $prefix = "PiLL4KwvdmGRd2FNzTExLTE5OTQ7MTU6TmVnYXRpZ";
    private $sufix = "jsxNDoxNS0xMi0yMDIxOzk6MjExMjE1UDMzMDEzMzM=";
    private $coeficiant = 9978;
    private $polePremier = 407;

    public function __construct(CertificateRepository $repository)
    {
        $this->repository = $repository;
    }


    #[Route('/admin/', name: 'certificate_index', methods: ['GET'])]
    public function index(CertificateRepository $certificateRepository): Response
    {
        return $this->render('certificate/index.html.twig', [
            'certificates' => $certificateRepository->findAll(),
        ]);
    }

    #[Route('/admin/new', name: 'certificate_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $certificate = new Certificate();
        $form = $this->createForm(CertificateType::class, $certificate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($certificate);
            $entityManager->flush();

            return $this->redirectToRoute('certificate_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('certificate/new.html.twig', [
            'certificate' => $certificate,
            'form' => $form,
        ]);
    }


    #[Route('/admin/{id}', name: 'certificate_show', methods: ['GET'])]
    /**
     * Undocumented function
     *
     * @param Certificate $certificate
     * @param QrcodeServices $qrcodeService
     * @return Response
     */
    public function show($id, QrcodeServices $qrcodeService): Response
    {
        $certificate = $this->repository->find($id);
        $link = "http://192.168.0.2:8080/" . $this->root . $this->getEncodeId($certificate->getId());
        //dd($link);

        $qrcode = $qrcodeService->qrcode('http://192.168.0.2:8080/' . $this->root . $this->getEncodeId($certificate->getId()));

        return $this->render('certificate/show.html.twig', [
            'certificate' => $certificate,
            'qrcode' => $qrcode
        ]);
    }



    #[Route('/', name: 'certificate_show', methods: ['GET'])]
    /**
     * Undocumented function
     *
     * @param Certificate $certificate
     * @param QrcodeServices $qrcodeService
     * @return Response
     */
    public function public_show_n(): Response
    {
        return $this->render('certificate/show.html.twig', [
            'certificate' => null
        ]);
    }



    #[Route("/q=-8LauRaPdGtn07BqRXYdIqpOpx6hoYMydx8exOH/8x43DlFDZ0e/b/{slug}", name: 'certificate_public_show', methods: ['GET'])]
    /**
     * Undocumented function
     *
     * @param Certificate $certificate
     * @param QrcodeServices $qrcodeService
     * @return Response
     */
    public function public_show($slug, QrcodeServices $qrcodeService): Response
    {
        $decodeid = $this->getDecodeId($slug);
        $certificate = $this->repository->find($decodeid);

        return $this->render('certificate/public_show.html.twig', [
            'certificate' => $certificate,
        ]);
    }


    #[Route('/admin/{id}/edit', name: 'certificate_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Certificate $certificate, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CertificateType::class, $certificate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('certificate_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('certificate/edit.html.twig', [
            'certificate' => $certificate,
            'form' => $form,
        ]);
    }



    #[Route('/admin/{id}', name: 'certificate_delete', methods: ['POST'])]
    public function delete(Request $request, Certificate $certificate, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $certificate->getId(), $request->request->get('_token'))) {
            $entityManager->remove($certificate);
            $entityManager->flush();
        }

        return $this->redirectToRoute('certificate_index', [], Response::HTTP_SEE_OTHER);
    }



    private function getEncodeId(int $id)
    {
        return $this->prefix . ($id + $this->polePremier) * $this->coeficiant . $this->sufix;
    }

    private function getDecodeId(string $encodeid)
    {
        $withoutPrefix = str_replace($this->prefix, "", $encodeid);
        $withoutSufixAndPrefix = str_replace($this->sufix, "", $withoutPrefix);
        return ($withoutSufixAndPrefix / $this->coeficiant) - $this->polePremier;
    }
}
