<?php

namespace App\Entity;

use App\Repository\VisitorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VisitorRepository::class)
 */
class Visitor
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="visiteur")
     */
    private $commentList;

    public function __construct()
    {
        $this->commentList = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getCommentList(): Collection
    {
        return $this->commentList;
    }

    public function addCommentList(Comment $commentList): self
    {
        if (!$this->commentList->contains($commentList)) {
            $this->commentList[] = $commentList;
            $commentList->setVisiteur($this);
        }

        return $this;
    }

    public function removeCommentList(Comment $commentList): self
    {
        if ($this->commentList->removeElement($commentList)) {
            // set the owning side to null (unless already changed)
            if ($commentList->getVisiteur() === $this) {
                $commentList->setVisiteur(null);
            }
        }

        return $this;
    }
}
