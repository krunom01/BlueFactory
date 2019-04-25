<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 */
class Tag
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
     * @ORM\Column(type="string", length=30)
     */
    private $slug;

    /**
     * @Doctrine\ORM\Mapping\OneToMany(targetEntity="App\Entity\TagMeal",
     * mappedBy="tag", cascade={"persist", "remove"})
     */
    private $tags;

    /**
     * @Doctrine\ORM\Mapping\OneToMany(targetEntity="App\Entity\TagTrans",
     * mappedBy="tag", cascade={"persist", "remove"})
     */
    private $tagTrans;

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
    public function getTags()
    {
        return $this->tags;
    }
    public function setCategories($tags): self
    {
        $this->tags = $tags;
        return $this;
    }
    /**
     * @param mixed $tagTrans
     */
    public function setTagTrans($tagTrans): void
    {
        $this->tagTrans = $tagTrans;
    }
}
