<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Laws Entity
 *
 * List of column:
 * * id
 * * date
 * * title
 * * content
 * * user
 *
 * @ORM\Entity(repositoryClass="App\Repository\LawsRepository")
 */
class Laws
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="laws")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Survey", mappedBy="law", cascade={"persist", "remove"})
     */
    private $survey;

    public function __construct()
    {
        $this->date = new \Datetime();
    }

    public function __toString() {
        $temp = $this->title;
        if (strlen($temp) > 10) {
            $temp = substr($temp, 0, 7) . '...';
        }
        return 'Laws: '.$this->id.' | ['.$this->user.'] '.$temp;
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSurvey(): ?Survey
    {
        return $this->survey;
    }

    public function setSurvey(?Survey $survey): self
    {
        $this->survey = $survey;

        // set (or unset) the owning side of the relation if necessary
        $newLaw = $survey === null ? null : $this;
        if ($newLaw !== $survey->getLaw()) {
            $survey->setLaw($newLaw);
        }

        return $this;
    }
}
