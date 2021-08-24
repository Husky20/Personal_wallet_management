<?php
/**
 * Operation service.
 */

namespace App\Service;

use App\Entity\Operation;
use App\Repository\OperationRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class OperationService.
 */
class OperationService
{
    /**
     * Operation repository.
     *
     * @var \App\Repository\OperationRepository
     */
    private $operationRepository;

    /**
     * Paginator.
     *
     * @var \Knp\Component\Pager\PaginatorInterface
     */
    private $paginator;

    /**
     * OperationService constructor.
     *
     * @param \App\Repository\OperationRepository     $operationRepository Operation repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator           Paginator
     */
    public function __construct(OperationRepository $operationRepository, PaginatorInterface $paginator)
    {
        $this->operationRepository = $operationRepository;
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
            $this->operationRepository->queryAll(),
            $page,
            OperationRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save operation.
     *
     * @param \App\Entity\Operation $operation Operation entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Operation $operation): void
    {
        $this->operationRepository->save($operation);
    }

    /**
     * Delete operation.
     *
     * @param \App\Entity\Operation $operation Operation entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Operation $operation): void
    {
        $this->operationRepository->delete($operation);
    }
}
