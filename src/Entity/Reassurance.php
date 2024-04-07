<?php

namespace App\Entity;

use App\Repository\ReassuranceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReassuranceRepository::class)]
class Reassurance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\Column(length: 255)]
    private ?string $illustration = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $titleLeft = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $contentLeft = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $illustrationLeft = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getIllustration(): ?string
    {
        return $this->illustration;
    }

    public function setIllustration(string $illustration): self
    {
        $this->illustration = $illustration;

        return $this;
    }

    public function getTitleLeft(): ?string
    {
        return $this->titleLeft;
    }

    public function setTitleLeft(?string $titleLeft): self
    {
        $this->titleLeft = $titleLeft;

        return $this;
    }

    public function getContentLeft(): ?string
    {
        return $this->contentLeft;
    }

    public function setContentLeft(?string $contentLeft): self
    {
        $this->contentLeft = $contentLeft;

        return $this;
    }

    public function getIllustrationLeft(): ?string
    {
        return $this->illustrationLeft;
    }

    public function setIllustrationLeft(?string $illustrationLeft): self
    {
        $this->illustrationLeft = $illustrationLeft;

        return $this;
    }
}
