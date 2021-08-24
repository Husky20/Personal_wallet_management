<?php
/**
 * Payment controller.
 */

namespace App\Controller;

use App\Entity\Payment;
use App\Form\PaymentType;
use App\Service\PaymentService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PaymentController.
 *
 * @Route("/payment")
 *
 * @IsGranted("ROLE_ADMIN")
 */
class PaymentController extends AbstractController
{
    /**
     * Payment service.
     *
     * @var \App\Service\PaymentService
     */
    private $paymentService;

    /**
     * PaymentController constructor.
     *
     * @param \App\Service\PaymentService $paymentService Payment service
     */
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
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
     *     name="payment_index",
     * )
     */
    public function index(Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $pagination = $this->paymentService->createPaginatedList($page);

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
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
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
    public function create(Request $request): Response
    {
        $payment = new Payment();
        $form = $this->createForm(PaymentType::class, $payment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->paymentService->save($payment);
            $this->addFlash('success', 'message_created_successfully');

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
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Entity\Payment                       $payment Payment entity
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
    public function edit(Request $request, Payment $payment): Response
    {
        $form = $this->createForm(PaymentType::class, $payment, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->paymentService->save($payment);
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
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Entity\Payment                       $payment Payment entity
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
    public function delete(Request $request, Payment $payment): Response
    {
        if ($payment->getTransactions()->count()) {
            $this->addFlash('warning', 'message_payment_contains_transactions');

            return $this->redirectToRoute('payment_index');
        }

        $form = $this->createForm(FormType::class, $payment, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->paymentService->delete($payment);
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
