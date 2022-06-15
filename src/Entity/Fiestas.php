<?php

namespace App\Entity;

use App\Repository\FiestasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FiestasRepository::class)]
class Fiestas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nombre;

    /*#[ORM\Column(type: 'integer')]
    private $edad;*/

    /*#[ORM\OneToMany(mappedBy: 'fiestas', targetEntity: Inscripciones::class)]
    private $inscripciones;*/

    #[ORM\Column(type: 'string', length: 255)]
    private $imagen;

    #[ORM\Column(type: 'text', nullable: true)]
    private $descripcion;

    public function __construct()
    {
        $this->inscripciones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**public function getEdad(): ?int
    {
        return $this->edad;
    }

    public function setEdad(int $edad): self
    {
        $this->edad = $edad;

        return $this;
    }*/

    /**
     * @return Collection<int, Inscripciones>
     */
    /*public function getInscripciones(): Collection
    {
        return $this->inscripciones;
    }

    public function addInscripcione(Inscripciones $inscripcione): self
    {
        if (!$this->inscripciones->contains($inscripcione)) {
            $this->inscripciones[] = $inscripcione;
            $inscripcione->setFiestas($this);
        }

        return $this;
    }

    public function removeInscripcione(Inscripciones $inscripcione): self
    {
        if ($this->inscripciones->removeElement($inscripcione)) {
            // set the owning side to null (unless already changed)
            if ($inscripcione->getFiestas() === $this) {
                $inscripcione->setFiestas(null);
            }
        }

        return $this;
    }*/

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(string $imagen): self
    {
        $this->imagen = $imagen;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }
}
