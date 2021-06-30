<?php
/**
 * Transaction controller.
 */

namespace App\Controller;

use App\Entity\Transaction;
use App\Form\TransactionType;
use App\Service\TransactionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;



/**
 * Class TransactionController.
 *
 * @Route("/transaction")
 */
class TransactionController extends AbstractController
{
    /**
     * Transaction service.
     *
     * @var \App\Service\TransactionService
     */
    private $transactionService;

    /**
     * TransactionController constructor.
     *
     * @param \App\Service\TransactionService $transactionService Transaction service
     */
    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }
    /**
     * Index action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="transaction_index",
     * )
     */
    public function index(Request $request): Response
    {

        $page = $request->query->getInt('page', 1);
        $user = $this->getUser()->getId();

        $pagination = $this->transactionService->createPaginatedList(
            $page,
            $user
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
     * @IsGranted(
     *     "VIEW",
     *     subject="transaction",
     * )
     */
    public function show(Transaction $transaction): Response
    {
        return $this->render(
            'transaction/show.html.twig',
            ['transaction' => $transaction]
        );
    }
    /**
     * Create action.
     *
     * @param \Symfony\Component\HttpFoundation\Request   $request     HTTP request
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="transaction_create",
     * )
     */
    public function create(Request $request): Response
    {
        $transaction = new Transaction();
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $transaction->setAuthor($this->getUser());
            $this->transactionService->save($transaction);
            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('transaction_index');
        }

        return $this->render(
            'transaction/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request     HTTP request
     * @param \App\Entity\Transaction                   $transaction Transaction entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="transaction_edit",
     * )
     */
    public function edit(Request $request, Transaction $transaction): Response
    {
        if ($transaction->getAuthor() !== $this->getUser()) {
            $this->addFlash('warning', 'message.item_not_found');

            return $this->redirectToRoute('transaction_index');
        }

        $form = $this->createForm(TransactionType::class, $transaction, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->transactionService->save($transaction);
            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('transaction_index');
        }

        return $this->render(
            'transaction/edit.html.twig',
            [
                'form' => $form->createView(),
                'transaction' => $transaction,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request        HTTP request
     * @param \App\Entity\Transaction                          $transaction           Transaction entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="transaction_delete",
     * )
     */
    public function delete(Request $request, Transaction $transaction): Response
    {
        if ($transaction->getAuthor() !== $this->getUser()) {
            $this->addFlash('warning', 'message.item_not_found');

            return $this->redirectToRoute('transaction_index');
        }

        $form = $this->createForm(FormType::class, $transaction, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->transactionService->delete($transaction);
            $this->addFlash('success', 'message_deleted_successfully');

            return $this->redirectToRoute('transaction_index');
        }

        return $this->render(
            'transaction/delete.html.twig',
            [
                'form' => $form->createView(),
                'transaction' => $transaction,
            ]
        );
    }
}