<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IngredeintTransRepository")
 */
class IngredeintTrans
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @\Doctrine\ORM\Mapping\ManyToOne(targetEntity="App\Entity\Ingredient", inversedBy="ingredientTrans")
     */
    private $ingredient;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $languageCode;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $translation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIngredient(): ?int
    {
        return $this->ingredient;
    }

    public function setIngredient(int $ingredient): self
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    public function getLanguageCode(): ?string
    {
        return $this->languageCode;
    }

    public function setLanguageCode(string $languageCode): self
    {
        $this->languageCode = $languageCode;

        return $this;
    }

    public function getTranslation(): ?string
    {
        return $this->translation;
    }

    public function setTranslation(string $translation): self
    {
        $this->translation = $translation;

        return $this;
    }
}
