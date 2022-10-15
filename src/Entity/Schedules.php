<?php

namespace App\Entity;

use App\Repository\SchedulesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SchedulesRepository::class)]
class Schedules
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'schedules')]
    private ?Route $route = null;

    #[ORM\Column]
    private ?int $week_num = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fromm = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $too = null;

    #[ORM\Column]
    private ?bool $active = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoute(): ?Route
    {
        return $this->route;
    }

    public function setRoute(?Route $route): self
    {
        $this->route = $route;

        return $this;
    }

    public function getWeekNum(): ?int
    {
        return $this->week_num;
    }

    public function setWeekNum(int $week_num): self
    {
        $this->week_num = $week_num;

        return $this;
    }

    public function getFromm(): ?\DateTimeInterface
    {
        return $this->fromm;
    }

    public function setFromm(\DateTimeInterface $fromm): self
    {
        $this->fromm = $fromm;

        return $this;
    }

    public function getToo(): ?\DateTimeInterface
    {
        return $this->too;
    }

    public function setToo(\DateTimeInterface $too): self
    {
        $this->too = $too;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
