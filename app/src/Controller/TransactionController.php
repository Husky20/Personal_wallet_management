<?php
/**
 * Transaction controller.
 */

namespace App\Controller;

use App\Entity\Transaction;
use App\Repository\TransactionRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TransactionController.
 *
 * @Route("/transaction")
 */
class TransactionController extends AbstractController
{
    /**
     * Index action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Repository\TransactionRepository $transactionRepository Transaction repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator Paginator
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="transaction_index",
     * )
     */
    public function index(Request $request, TransactionRepository $transactionRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $transactionRepository->queryAll(),
            $request->query->getInt('page', 1),
            TransactionRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'transaction/index.html.twig',
            ['pagination' => $pagination]
        );
    }
    /**
     * Show action.
     *
     * @param \App\Entity\Transaction $transaction Transaction entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="transaction_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function show(Transaction $transaction): Response
    {
        return $this->render(
            'transaction/show.html.twig',
            ['transaction' => $transaction]
        );
    }

}