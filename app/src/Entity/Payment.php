<?php
/**
 * Payment entity.
 */

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaymentRepository::class)
 * @ORM\Table(name="payments")
 */
class Payment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Payment method.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=20)
     */
    private $payment_method;

    /**
     * Id_transaction.
     *
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="id_payment")
     */
    private $id_transaction;

    public function __construct()
    {
        $this->id_transaction = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->payment_method;
    }

    public function setPaymentMethod(string $payment_method): self
    {
        $this->payment_method = $payment_method;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getIdTransaction(): Collection
    {
        return $this->id_transaction;
    }

    public function addIdTransaction(Transaction $idTransaction): self
    {
        if (!$this->id_transaction->contains($idTransaction)) {
            $this->id_transaction[] = $idTransaction;
            $idTransaction->setIdPayment($this);
        }

        return $this;
    }

    public function removeIdTransaction(Transaction $idTransaction): self
    {
        if ($this->id_transaction->removeElement($idTransaction)) {
            // set the owning side to null (unless already changed)
            if ($idTransaction->getIdPayment() === $this) {
                $idTransaction->setIdPayment(null);
            }
        }

        return $this;
    }
}
