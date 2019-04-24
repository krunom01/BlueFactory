<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IngredientMealRepository")
 */
class IngredientMeal
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ingredient", inversedBy="ingredients")
     */
    private $ingredient;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Meal", inversedBy="ingredients")
     */
    private $meal;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIngredient()
    {
        return $this->ingredient;
    }

    public function setIngredient($ingredient): self
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    public function getMeal()
    {
        return $this->meal;
    }

    public function setMeal($meal): self
    {
        $this->meal = $meal;

        return $this;
    }
}
