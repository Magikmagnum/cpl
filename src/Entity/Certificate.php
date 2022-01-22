<?php

namespace App\Entity;

use App\Repository\CertificateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CertificateRepository::class)]
class Certificate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $surname;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'date')]
    private $birthDate;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $result;

    #[ORM\Column(type: 'date')]
    private $sampleDate;

    #[ORM\Column(type: 'string', length: 255)]
    private $testNumber;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getResult(): ?bool
    {
        return $this->result;
    }

    public function setResult(?bool $result): self
    {
        $this->result = $result;

        return $this;
    }

    public function getSampleDate(): ?\DateTimeInterface
    {
        return $this->sampleDate;
    }

    public function setSampleDate(\DateTimeInterface $sampleDate): self
    {
        $this->sampleDate = $sampleDate;

        return $this;
    }

    public function getTestNumber(): ?string
    {
        return $this->testNumber;
    }

    public function setTestNumber(string $testNumber): self
    {
        $this->testNumber = $testNumber;

        return $this;
    }
}
