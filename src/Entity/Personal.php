<?php

namespace App\Entity;

use App\Repository\PersonalRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7 as Uuid;

#[ORM\Entity(repositoryClass: PersonalRepository::class)]
class Personal
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    private ?string $line_1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $line_2 = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[ORM\Column(length: 255)]
    private ?string $zip_code = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getLine1(): ?string
    {
        return $this->line_1;
    }

    public function setLine1(string $line_1): self
    {
        $this->line_1 = $line_1;

        return $this;
    }

    public function getLine2(): ?string
    {
        return $this->line_2;
    }

    public function setLine2(?string $line_2): self
    {
        $this->line_2 = $line_2;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zip_code;
    }

    public function setZipCode(string $zip_code): self
    {
        $this->zip_code = $zip_code;

        return $this;
    }
}
