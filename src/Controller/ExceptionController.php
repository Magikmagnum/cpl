<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ExceptionController extends AbstractController
{
    public function catchException(\Throwable $exception)
    {

        return $this->render('certificate/public_show.html.twig', [
            'certificate' => null,
        ]);
    }
}
