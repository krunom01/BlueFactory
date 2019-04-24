<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagMealRepository")
 */
class TagMeal
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tag", inversedBy="tags")
     */
    private $tag;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Meal", inversedBy="tags")
     */
    private $meal;


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTag()
    {
        return $this->tag;
    }
    /**
     * @param mixed $tag
     */
    public function setTag($tag): void
    {
        $this->tag = $tag;
    }

    /**
     * @return mixed
     */
    public function getMeal()
    {
        return $this->meal;
    }
    /**
     * @param mixed $meal
     */
    public function setMeal($meal): void
    {
        $this->meal = $meal;
    }
}
