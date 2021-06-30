<?php
/**
 * Transaction service.
 */

namespace App\Service;

use App\Entity\Transaction;
use App\Repository\TransactionRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class TransactionService.
 */
class TransactionService
{
    /**
     * Transaction repository.
     *
     * @var \App\Repository\TransactionRepository
     */
    private $transactionRepository;

    /**
     * Paginator.
     *
     * @var \Knp\Component\Pager\PaginatorInterface
     */
    private $paginator;

    /**
     * TransactionService constructor.
     *
     * @param \App\Repository\TransactionRepository   $transactionRepository Transaction repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator             Paginator
     */
    public function __construct(TransactionRepository $transactionRepository, PaginatorInterface $paginator)
    {
        $this->transactionRepository = $transactionRepository;
        $this->paginator = $paginator;
    }

    /**
     * Create paginated list.
     *
     * @param int $page Page number
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface Paginated list
     */
    public function createPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->transactionRepository->queryByAuthor(),
            $page,
            TransactionRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save transaction.
     *
     * @param \App\Entity\Transaction $transaction Transaction entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Transaction $transaction): void
    {
        $this->transactionRepository->save($transaction);
    }

    /**
     * Delete transaction.
     *
     * @param \App\Entity\Transaction $transaction Transaction entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Transaction $transaction): void
    {
        $this->transactionRepository->delete($transaction);
    }
}
