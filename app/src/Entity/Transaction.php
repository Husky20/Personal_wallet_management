<?php
/**
 * Transaction entity.
 */

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Transaction.
 *
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 * @ORM\Table(name="transactions")
 */
class Transaction
{
    /**
     * Primary key.
     *
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Name.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * Date.
     *
     * @var date
     *
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * Amount.
     *
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $amount;

    /**
     * Created at.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     *
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * Updated at.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     *
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * Category.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="transactions",fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * Wallet.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Wallet", inversedBy="transactions", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(nullable=false)
     */
    private $wallet;

    /**
     * Payment.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Payment", inversedBy="transactions", fetch="EXTRA_LAZY",)
     * @ORM\JoinColumn(nullable=false)
     */
    private $payment;

    /**
     * Operation.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Operation", inversedBy="transactions", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(nullable=false)
     */
    private $operation;

    /**
     * Tags.
     *
     * @var array
     *
     * @ORM\ManyToMany(
     *     targetEntity="App\Entity\Tag",
     *     inversedBy="transactions",
     *     fetch="EXTRA_LAZY",
     *     mappedBy="tags",
     *
     * )
     * @ORM\JoinTable(name="transactions_tags")
     */
    private $tags;

    /**
     * Author.
     *
     * @var \App\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * Transaction constructor.
     */
    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    /**
     * Getter for Id.
     *
     * @return int|null Result
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for Name.
     *
     * @return string|null Name
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Setter for Name.
     *
     * @param string $name Name
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Getter for Date.
     *
     * @return datetime|null Name
     */
    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    /**
     * Setter for Date.
     *
     * @param datetime $date Date
     */
    public function setDate(DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Getter for Amount.
     *
     * @return int|null Name
     */
    public function getAmount(): ?int
    {
        return $this->amount;
    }

    /**
     * Setter for Amount.
     *
     * @param int $amount Amount
     */
    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Getter for Created At.
     *
     * @return \DateTimeInterface|null Created at
     */
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Setter for Created at.
     *
     * @param \DateTimeInterface $createdAt Created at
     */
    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Getter for Updated at.
     *
     * @return \DateTimeInterface|null Updated at
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Setter for Updated at.
     *
     * @param \DateTimeInterface $updatedAt Updated at
     */
    public function setUpdatedAt(DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Getter for category.
     *
     * @return \App\Entity\Category|null Category
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * Setter for category.
     *
     * @param \App\Entity\Category|null $category Category
     */
    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Getter for wallet.
     *
     * @return \App\Entity\Wallet|null Wallet
     */
    public function getWallet(): ?Wallet
    {
        return $this->wallet;
    }

    /**
     * Setter for wallet.
     *
     * @param \App\Entity\Wallet|null $wallet Wallet
     */
    public function setWallet(?Wallet $wallet): self
    {
        $this->wallet = $wallet;

        return $this;
    }

    /**
     * Getter for payment.
     *
     * @return \App\Entity\Payment|null Payment
     */
    public function getPayment(): ?Payment
    {
        return $this->payment;
    }

    /**
     * Setter for payment.
     *
     * @param \App\Entity\Payment|null $payment Payment
     */
    public function setPayment(?Payment $payment): self
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * Getter for operation.
     *
     * @return \App\Entity\Operation|null Operation
     */
    public function getOperation(): ?Operation
    {
        return $this->operation;
    }

    /**
     * Setter for opeeration.
     *
     * @param \App\Entity\Operation|null $operation Operation
     */
    public function setOperation(?Operation $operation): self
    {
        $this->operation = $operation;

        return $this;
    }

    /**
     * Getter for tags.
     *
     * @return \Doctrine\Common\Collections\Collection|\App\Entity\Tag[] Tags collection
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    /**
     * Add tag to collection.
     *
     * @param \App\Entity\Tag $tag Tag entity
     */
    public function addTag(Tag $tag): void
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }
    }

    /**
     * Remove tag from collection.
     *
     * @param \App\Entity\Tag $tag Tag entity
     */
    public function removeTag(Tag $tag): void
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

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
}
