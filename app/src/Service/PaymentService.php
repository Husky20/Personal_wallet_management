<?php
/**
 * Payment service.
 */

namespace App\Service;

use App\Entity\Payment;
use App\Repository\PaymentRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class PaymentService.
 */
class PaymentService
{
    /**
     * Payment repository.
     *
     * @var \App\Repository\PaymentRepository
     */
    private $paymentRepository;

    /**
     * Paginator.
     *
     * @var \Knp\Component\Pager\PaginatorInterface
     */
    private $paginator;

    /**
     * PaymentService constructor.
     *
     * @param \App\Repository\PaymentRepository      $paymentRepository Payment repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator          Paginator
     */
    public function __construct(PaymentRepository $paymentRepository, PaginatorInterface $paginator)
    {
        $this->paymentRepository = $paymentRepository;
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
            $this->paymentRepository->queryAll(),
            $page,
            PaymentRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save payment.
     *
     * @param \App\Entity\Payment $payment Payment entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Payment $payment): void
    {
        $this->paymentRepository->save($payment);
    }

    /**
     * Delete payment.
     *
     * @param \App\Entity\Payment $payment Payment entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Payment $payment): void
    {
        $this->paymentRepository->delete($payment);
    }
}