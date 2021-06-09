<?php
/**
 * Wallet entity.
 */

namespace App\Entity;

use App\Repository\WalletRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class wallet.
 *
 * @ORM\Entity(repositoryClass=WalletRepository::class)
 * @ORM\Table(name="wallets")
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
     */
    private $createdAt;

    /**
     * Updated at.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="id_wallet")
     */
    private $id_transactions;

    public function __construct()
    {
        $this->id_transactions = new ArrayCollection();
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

    public function getBalance(): ?int
    {
        return $this->balance;
    }

    public function setBalance(int $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getIdTransactions(): Collection
    {
        return $this->id_transactions;
    }

    public function addIdTransaction(Transaction $idTransaction): self
    {
        if (!$this->id_transactions->contains($idTransaction)) {
            $this->id_transactions[] = $idTransaction;
            $idTransaction->setIdWallet($this);
        }

        return $this;
    }

    public function removeIdTransaction(Transaction $idTransaction): self
    {
        if ($this->id_transactions->removeElement($idTransaction)) {
            // set the owning side to null (unless already changed)
            if ($idTransaction->getIdWallet() === $this) {
                $idTransaction->setIdWallet(null);
            }
        }

        return $this;
    }
}
