<?php
/**
 * Category entity.
 */

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\Nullable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Category.
 *
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 * @ORM\Table(name="categories")
 *
 * @UniqueEntity(fields={"name"})
 */
class Category
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
     * Create at.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     *
     * @Assert\Type(type="\DateTimeInterface")
     *
     * @Gedmo\Timestampable(on="create")
     */
    private $createAt;

    /**
     * Update at.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     *
     * @Assert\Type(type="\DateTimeInterface")
     *
     * @Gedmo\Timestampable(on="update")
     */
    private $updateAt;

    /**
     * Name.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=64,
     * )
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="64",
     * )
     */
    private $name;

    /**
     * Transactions.
     *
     * @var \Doctrine\Common\Collections\ArrayCollection|\App\Entity\Transaction[] $transaction Transaction
     *
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Transaction",
     *     mappedBy="category",
     * )
     */
    private $transactions;

    /**
     * Code.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=64,
     * )
     *
     * @Assert\Type(type="string")
     * @Assert\Length(
     *     min="3",
     *     max="64",
     * )
     *
     * @Gedmo\Slug(fields={"name"})
     */
    private $code;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
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
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Getter for Create At.
     *
     * @return DateTimeInterface|null
     */
    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    /**
     * Setter for Create At.
     *
     * @param DateTimeInterface $createAt
     * @return $this
     */
    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * Getter for Update At.
     *
     * @return DateTimeInterface|null
     */
    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    /**
     * Setter for Update At.
     *
     * @param DateTimeInterface $updateAt
     * @return $this
     */
    public function setUpdateAt(\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Getter for Transactions.
     *
     * @return Collection|Transaction[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    /**
     * Add for Transactions.
     *
     * @param Transactions $transaction Transaction Entity
     *
     * @return $this
     */
    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setCategory($this);
        }

        return $this;
    }

    /**
     * Remove for Transactions.
     *
     * @param Transaction $Transaction
     * @return $this
     */
    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            if ($transaction->getCategory() === $this) {
                $transaction->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * Getter for Code.
     *
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Setter for Code
     *
     * @param string $code Code
     * @return $this
     */
    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * getteer Can Delete.
     *
     * @return bool|null
     */
    public function getCanDelete(): ?bool
    {
        return is_null($this->transactions);
    }
}