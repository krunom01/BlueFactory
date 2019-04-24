<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IngredientRepository")
 */
class Ingredient
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $slug;
    /**
     * @Doctrine\ORM\Mapping\OneToMany(targetEntity="App\Entity\IngredientMeal",
     * mappedBy="ingredient", cascade={"persist", "remove"})
     */
    private $ingredients;

    /**
     * @Doctrine\ORM\Mapping\OneToMany(targetEntity="App\Entity\IngredeintTrans",
     * mappedBy="ingredient", cascade={"persist", "remove"})
     */
    private $ingredientTrans;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }
    public function setIngredients($ingredients): self
    {
        $this->ingredients = $ingredients;
        return $this;
    }
    /**
     * @param mixed $ingredientTrans
     */
    public function setIngredientTrans($ingredientTrans): void
    {
        $this->ingredientTrans = $ingredientTrans;
    }
}
