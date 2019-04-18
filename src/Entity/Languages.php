<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LanguagesRepository")
 * @UniqueEntity(fields={"name"}, message="There is already an language with this name")
 * @UniqueEntity(fields={"code"}, message="There is already an language with this code")
 */
class Languages
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     * @Symfony\Component\Validator\Constraints\Regex(
     * pattern     = "/^[a-z ćčžđš A-Z-]+$/i",
     *  message     = "Letters only")
     * @Symfony\Component\Validator\Constraints\NotBlank(message="Please insert Language name")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=2)
     * * @Symfony\Component\Validator\Constraints\Regex(
     * pattern     = "/^[a-z ćčžđš A-Z-]+$/i",
     *  message     = "Letters only")
     * @Symfony\Component\Validator\Constraints\NotBlank(message="Please insert Language code")
     * @\Symfony\Component\Validator\Constraints\Length(min = 2 , max = 2)
     */
    private $code;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }
}
