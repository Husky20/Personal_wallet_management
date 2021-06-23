<?php
/**
 * Payment controller.
 */

namespace App\Controller;

use App\Entity\Payment;
use App\Form\PaymentType;
use App\Repository\PaymentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PaymentController.
 *
 * @Route("/payment")
 */
class PaymentController extends AbstractController
{
    /**
     * Index action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Repository\PaymentRepository $paymentRepository Payment repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator Paginator
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="payment_index",
     * )
     */
    public function index(Request $request, PaymentRepository $paymentRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $paymentRepository->queryAll(),
            $request->query->getInt('page', 1),
            PaymentRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'payment/index.html.twig',
            ['pagination' => $pagination]
        );
    }
    /**
     * Show action.
     *
     * @param \App\Entity\Payment $payment Payment entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="payment_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function show(Payment $payment): Response
    {
        return $this->render(
            'payment/show.html.twig',
            ['payment' => $payment]
        );
    }

    /**
     * Create action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Repository\PaymentRepository        $paymentRepository Payment repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="payment_create",
     * )
     */
    public function create(Request $request, PaymentRepository $paymentRepository): Response
    {
        $payment = new Payment();
        $form = $this->createForm(PaymentType::class, $payment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $paymentRepository->save($payment);

            return $this->redirectToRoute('payment_index');
        }

        return $this->render(
            'payment/create.html.twig',
            ['form' => $form->createView()]
        );
    }
    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Entity\Payment                      $payment           Payment entity
     * @param \App\Repository\PaymentRepository        $paymentRepository Payment repository
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
     *     name="payment_edit",
     * )
     */
    public function edit(Request $request, Payment $payment, PaymentRepository $paymentRepository): Response
    {
        $form = $this->createForm(PaymentType::class, $payment, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $payment->setUpdatedAt(new \DateTime());
            $paymentRepository->save($payment);

            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('payment_index');
        }

        return $this->render(
            'payment/edit.html.twig',
            [
                'form' => $form->createView(),
                'payment' => $payment,
            ]
        );
    }
    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Entity\Payment                      $payment           Payment entity
     * @param \App\Repository\PaymentRepository        $paymentRepository Payment repository
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
     *     name="payment_delete",
     * )
     */
    public function delete(Request $request, Payment $payment, PaymentRepository $repository): Response
    {
        if ($payment->getTransaction()->count()) {
            $this->addFlash('warning', 'message_payment_contains_transactions');

            return $this->redirectToRoute('payment_index');
        }

        $form = $this->createForm(FormType::class, $payment, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->delete($payment);
            $this->addFlash('success', 'message_deleted_successfully');

            return $this->redirectToRoute('payment_index');
        }

        return $this->render(
            'payment/delete.html.twig',
            [
                'form' => $form->createView(),
                'payment' => $payment,
            ]
        );
    }
}