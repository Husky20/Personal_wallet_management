<?php
/**
 * Transaction entity.
 *
 */
namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Transaction.
 *
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
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
     * Id category.
     *
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="id_transaction")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_category;

    /**
     * Id wallet.
     *
     * @ORM\ManyToOne(targetEntity=Wallet::class, inversedBy="id_transactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_wallet;

    /**
     * Id payment.
     *
     * @ORM\ManyToOne(targetEntity=Payment::class, inversedBy="id_transaction")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_payment;

    /**
     * Id operation.
     *
     * @ORM\ManyToOne(targetEntity=Operation::class, inversedBy="id_transaction")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_operation;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

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

    public function getIdCategory(): ?Category
    {
        return $this->id_category;
    }

    public function setIdCategory(?Category $id_category): self
    {
        $this->id_category = $id_category;

        return $this;
    }

    public function getIdWallet(): ?Wallet
    {
        return $this->id_wallet;
    }

    public function setIdWallet(?Wallet $id_wallet): self
    {
        $this->id_wallet = $id_wallet;

        return $this;
    }

    public function getIdPayment(): ?Payment
    {
        return $this->id_payment;
    }

    public function setIdPayment(?Payment $id_payment): self
    {
        $this->id_payment = $id_payment;

        return $this;
    }

    public function getIdOperation(): ?Operation
    {
        return $this->id_operation;
    }

    public function setIdOperation(?Operation $id_operation): self
    {
        $this->id_operation = $id_operation;

        return $this;
    }
}
