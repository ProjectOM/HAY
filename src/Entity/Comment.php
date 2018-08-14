<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Comment Entity
 *
 * List of column:
 * * id
 * * user
 * * post
 * * comment
 * * date_send
 *
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Post", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $post;

    /**
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_send;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Report", mappedBy="reported_comment")
     */
    private $reported;

    public function __construct()
    {
        $this->date_send = new \Datetime();
        $this->reported = new ArrayCollection();
    }

    public function __toString() {
        $temp = $this->comment;
        if (strlen($temp) > 10) {
            $temp = substr($temp, 0, 7) . '...';
        }
        return 'Comment: '.$this->id.' | ['.$this->user.'] '.$temp;
    }

    public function browse()
    {
        $result = array();

        foreach ($this as $key => $value) {
            if ($value !== NULL) {
                $result[$key] = $value;
            } else {
                $result[$key] = 'NULL';
            }
        }

        return $result;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getDateSend(): ?\DateTimeInterface
    {
        return $this->date_send;
    }

    public function setDateSend(\DateTimeInterface $date_send): self
    {
        $this->date_send = $date_send;

        return $this;
    }

    /**
     * @return Collection|Report[]
     */
    public function getReported(): Collection
    {
        return $this->reported;
    }

    public function addReported(Report $reported): self
    {
        if (!$this->reported->contains($reported)) {
            $this->reported[] = $reported;
            $reported->setReportedComment($this);
        }

        return $this;
    }

    public function removeReported(Report $reported): self
    {
        if ($this->reported->contains($reported)) {
            $this->reported->removeElement($reported);
            // set the owning side to null (unless already changed)
            if ($reported->getReportedComment() === $this) {
                $reported->setReportedComment(null);
            }
        }

        return $this;
    }
}
