<?php

namespace App\Entity;

use App\Repository\MealRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MealRepository")
 */
class Meal
{

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->ingredients = new ArrayCollection();
        $this->mealTrans = new ArrayCollection();
    }

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
     * @ORM\Column(type="string", length=50)
     */
    private $desctription;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deleted_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @Doctrine\ORM\Mapping\ManyToOne(targetEntity="App\Entity\Category", inversedBy="meals")
     */
    private $category;
    /**
     * @Doctrine\ORM\Mapping\OneToMany(targetEntity="App\Entity\MealTrans",
     * mappedBy="meal", cascade={"persist", "remove"})
     */
    private $mealTrans;
    /**
     * @Doctrine\ORM\Mapping\OneToMany(targetEntity="App\Entity\TagMeal", mappedBy="meal", cascade={"remove"})
     */
    private $tags;

    /**
     * @Doctrine\ORM\Mapping\OneToMany(targetEntity="App\Entity\IngredientMeal",
     * mappedBy="meal", cascade={"persist", "remove"})
     */
    private $ingredients;


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

    public function getDesctription(): ?string
    {
        return $this->desctription;
    }

    public function setDesctription(string $desctription): self
    {
        $this->desctription = $desctription;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(?\DateTimeInterface $deleted_at): self
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @param mixed $mealTrans
     */
    public function setMealsTrans($mealTrans): void
    {
        $this->mealTrans = $mealTrans;
    }

    /**
     * @return ArrayCollection
     */
    public function getMealTrans()
    {
        return $this->mealTrans;
    }
    /**
     * @return array
     */
    public function getTags()
    {
        $tags = [];
        foreach ($this->tags as $int) {
            /**
             * @var TagMeal $int
             */
            $tags[] = [
                'ID-Tag' => $int->getTag()->getId(),
                'Title-Tag' => $int->getTag()->getTitle(),
                'Slug-Tag' => $int->getTag()->getSlug(),
            ];
        }
        if (empty($tags)) {
            return null;
        } else {
            return $tags;
        }
    }

    /**
     * @return array
     */
    public function getIngredients()
    {
        $ingredients = [];
        foreach ($this->ingredients as $int) {
            /**
             * @var IngredientMeal $int
             */
            $ingredients[] = [
                'ID-ingredients' => $int->getIngredient()->getId(),
                'Title-ingredients' => $int->getIngredient()->getTitle(),
                'Slug-ingredients' => $int->getIngredient()->getSlug(),
            ];
        }
        if (empty($ingredients)) {
            return null;
        } else {
            return $ingredients;
        }
    }

}
