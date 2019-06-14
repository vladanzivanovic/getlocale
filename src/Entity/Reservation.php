<?php

namespace App\Entity;

use App\Validator\Constraints\DateInAdvance;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use \DateTime;
use \DateTimeInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn()
     */
    private $user;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Mandatory field", groups={"ReservationEdit"})
     * @Assert\Email(message="Email is not valid", mode="html5", groups={"ReservationEdit"})
     */
    private $email;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Mandatory field", groups={"ReservationEdit"})
     *
     */
    private $comment;

    /**
     * @var DateTime|null
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message="Mandatory field", groups={"ReservationEdit"})
     * @DateInAdvance(days="3", groups={"ReservationEdit"})
     */
    private $date;

    /**
     * @var string
     * @ORM\Column(length=20)
     */
    private $code;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    private $modifiedAt;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private $adminComment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     *
     * @return Reservation
     */
    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return Reservation
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAdminComment(): ?string
    {
        return $this->adminComment;
    }

    /**
     * @param string|null $adminComment
     *
     * @return Reservation
     */
    public function setAdminComment(?string $adminComment): self
    {
        $this->adminComment = $adminComment;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     *
     * @return Reservation
     */
    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getModifiledAt(): DateTime
    {
        return $this->modifiedAt;
    }

    /**
     * @param DateTime $modifiedAt
     *
     * @return Reservation
     */
    public function setModifiedAt(DateTime $modifiedAt): self
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }
}
