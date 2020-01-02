<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategorysRepository")
 */
class Categorys
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Articles", mappedBy="categorys")
     */
    private $articleId;

    public function __construct()
    {
        $this->articleId = new ArrayCollection();
    }

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

    /**
     * @return Collection|Articles[]
     */
    public function getArticleId(): Collection
    {
        return $this->articleId;
    }

    public function addArticleId(Articles $articleId): self
    {
        if (!$this->articleId->contains($articleId)) {
            $this->articleId[] = $articleId;
            $articleId->setCategorys($this);
        }

        return $this;
    }

    public function removeArticleId(Articles $articleId): self
    {
        if ($this->articleId->contains($articleId)) {
            $this->articleId->removeElement($articleId);
            // set the owning side to null (unless already changed)
            if ($articleId->getCategorys() === $this) {
                $articleId->setCategorys(null);
            }
        }

        return $this;
    }
}
