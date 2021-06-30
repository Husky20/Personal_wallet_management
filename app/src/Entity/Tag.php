<?php
/**
 * Tag entity.
 */

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Tag.
 *
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 * @ORM\Table(name="tags")
 *
 * @UniqueEntity(fields={"name"})
 */
class Tag
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
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="64",
     * )
     */
    private $name;

    /**
     * Created at.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     *
     * @Assert\DateTime
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
     * @Assert\Type(type="\DateTimeInterface")
     *
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * Transactions.
     *
     * @var \Doctrine\Common\Collections\ArrayCollection|\App\Entity\Transaction[] Transactions
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Transaction", mappedBy="tags")
     */
    private $transactions;

    /**
     * Tag constructor.
     */
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
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Getter for Created At.
     *
     * @return \DateTimeInterface|null Created at
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Setter for Created at.
     *
     * @param \DateTimeInterface $createdAt Created at
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Getter for Updated at.
     *
     * @return \DateTimeInterface|null Updated at
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Setter for Updated at.
     *
     * @param \DateTimeInterface $updatedAt Updated at
     */
    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Getter for transactions.
     *
     * @return \Doctrine\Common\Collections\Collection|\App\Entity\Transaction[] Transactions collection
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    /**
     * Add transaction to collection.
     *
     * @param \App\Entity\Transaction $transaction Transaction entity
     */
    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->addTag($this);
        }

        return $this;
    }

    /**
     * Remove transaction from collection.
     *
     * @param \App\Entity\Transaction $transaction Transaction entity
     */
    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            $transaction->removeTag($this);
        }

        return $this;
    }
}
