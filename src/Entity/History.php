<?php

namespace App\Entity;

use App\Repository\HistoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistoryRepository::class)]
class History
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;



    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne]
    private ?Module $module = null;

    #[ORM\Column(nullable: true)]
    private ?float $temperatureModule = null;

    #[ORM\Column(nullable: true)]
    private ?float $speedModule = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getModule(): ?Module
    {
        return $this->module;
    }

    public function setModule(?Module $module): static
    {
        $this->module = $module;

        return $this;
    }

    public function getTemperatureModule(): ?float
    {
        return $this->temperatureModule;
    }

    public function setTemperatureModule(?float $temperatureModule): static
    {
        $this->temperatureModule = $temperatureModule;

        return $this;
    }

    public function getSpeedModule(): ?float
    {
        return $this->speedModule;
    }

    public function setSpeedModule(?float $speedModule): static
    {
        $this->speedModule = $speedModule;

        return $this;
    }
}
