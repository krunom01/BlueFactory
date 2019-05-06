<?php

namespace App\Entity;

use App\Entity\MealTrans;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\EntityManagerInterface;



/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 * @UniqueEntity(fields={"slug"}, message="There is already an category with this slug")
 */
class Category
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
     * @Symfony\Component\Validator\Constraints\NotBlank(message="Please insert Category title")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=10, unique=true)
     * @Symfony\Component\Validator\Constraints\Regex(
     * pattern     = "/^[a-z ćčžđš A-Z-]+$/i",
     *  message     = "Letters only")
     * @Symfony\Component\Validator\Constraints\NotBlank(message="Please insert Category slug")
     */
    private $slug;

    /**
     * @Doctrine\ORM\Mapping\OneToMany(targetEntity="App\Entity\CategoryTrans",
     * mappedBy="category", cascade={"persist", "remove"})
     */
    private $categoryTrans;
    /**
     * @Doctrine\ORM\Mapping\OneToMany(targetEntity="App\Entity\Meal",
     * mappedBy="category", cascade={"persist", "remove"})
     */
    private $meals;


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
     * @param mixed $categoryTrans
     */
    public function setCategoryTrans($categoryTrans): void
    {
        $this->categoryTrans = $categoryTrans;
    }
    /**
     * @param mixed $meals
     */
    public function setMeals($meals): void
    {
        $this->meals = $meals;
    }
}
