<?php

namespace App\Entity;

use App\Repository\InscripcionesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscripcionesRepository::class)]
class Inscripciones
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Usuario::class, inversedBy: 'inscripciones')]
    #[ORM\JoinColumn(nullable: false)]
    private $usuario;

    #[ORM\ManyToOne(targetEntity: Fiestas::class, inversedBy: 'inscripciones')]
    #[ORM\JoinColumn(nullable: false)]
    private $fiestas;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsuario(): ?usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?usuario $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getFiestas(): ?fiestas
    {
        return $this->fiestas;
    }

    public function setFiestas(?fiestas $fiestas): self
    {
        $this->fiestas = $fiestas;

        return $this;
    }
}
