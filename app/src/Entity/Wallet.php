<?php
/**
 * Wallet entity.
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
 * Class Wallet.
 *
 * @ORM\Entity(repositoryClass="App\Repository\WalletRepository")
 * @ORM\Table(name="wallets")
 *
 * @UniqueEntity(fields={"name"})
 */
class Wallet
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
     * @ORM\Column(type="string", length=64)
     */
    private $name;

    /**
     * Balance.
     *
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $balance;

    /**
     * Created at.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     *
     * @Assert\Type(type="\DateTimeInterface")
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
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="wallet")
     */
    private $transactions;

    /**
     * Wallet constructor.
     */
    public function __construct()
    {
        $this->transaction = new ArrayCollection();
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
     * Getter for Balance.
     *
     * @return int|null
     */
    public function getBalance(): ?int
    {
        return $this->balance;
    }

    /**
     * Setter for Balance.
     *
     * @param int $balance Balance
     * @return $this
     */
    public function setBalance(int $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * Getter for Created At.
     *
     * @return DateTimeInterface|null
     */
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Setter for Created At.
     *
     * @param DateTimeInterface $createdAt Created At
     * @return $this
     */
    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Getter for Updated At.
     *
     * @return DateTimeInterface|null
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * setter for Updated At.
     *
     * @param DateTimeInterface $updatedAt Updated At
     * @return $this
     */
    public function setUpdatedAt(DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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
            $transaction->setWallet($this);
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
            if ($transaction->getWallet() === $this) {
                $transaction->setWallet(null);
            }
        }

        return $this;
    }
}
