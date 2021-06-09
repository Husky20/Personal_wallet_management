<?php
/**
 * Operation entity.
 */

namespace App\Entity;

use App\Repository\OperationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Operation.
 * @ORM\Entity(repositoryClass=OperationRepository::class)
 * @ORM\Table(name="operations")
 */
class Operation
{
    /**
     * Primary key.
     *
     * var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Name operation.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name_operation;

    /**
     * Id_transaction.
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="id_operation")
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

    public function getNameOperation(): ?string
    {
        return $this->name_operation;
    }

    public function setNameOperation(string $name_operation): self
    {
        $this->name_operation = $name_operation;

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
            $idTransaction->setIdOperation($this);
        }

        return $this;
    }

    public function removeIdTransaction(Transaction $idTransaction): self
    {
        if ($this->id_transaction->removeElement($idTransaction)) {
            // set the owning side to null (unless already changed)
            if ($idTransaction->getIdOperation() === $this) {
                $idTransaction->setIdOperation(null);
            }
        }

        return $this;
    }
}
