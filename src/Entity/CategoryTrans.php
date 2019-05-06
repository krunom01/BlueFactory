<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Category;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryTransRepository")
 */
class CategoryTrans
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Doctrine\ORM\Mapping\ManyToOne(targetEntity="App\Entity\Category", inversedBy="categoryTrans")
     */
    private $category;

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

    public function getCategory()
    {
        return $this->category;
    }
    /**
     * @param Category $category
     */

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getLanguageCode(): ?string
    {
        return $this->languageCode;
    }

    public function setLanguageCode($languageCode): self
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
