<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MealTransRepository")
 */
class MealTrans
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Doctrine\ORM\Mapping\ManyToOne(targetEntity="App\Entity\Meal", inversedBy="mealTrans")
     */
    private $meal;

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

    /**
     * @return mixed
     */

    public function getMeal(): ?int
    {
        return $this->meal;
    }
    /**
     * @param Meal $meal
     */

    public function setCategory(Meal $meal)
    {
        $this->meal = $meal;
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
