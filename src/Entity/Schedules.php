<?php

namespace App\Entity;

use App\Repository\SchedulesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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


    #[Assert\DateTime]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTime $fromm = null;


    #[Assert\DateTime]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $too = null;

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

    public function getFromm(): ?\DateTime
    {
        return $this->fromm;
    }


    public function setFromm(?string $fromm): self
    {
        $this->fromm = $fromm;

        return $this;
    }

    public function getToo(): ?\DateTime
    {
        return $this->too;
    }



    public function setToo(?string $too): self
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
