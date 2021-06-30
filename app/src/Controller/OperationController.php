<?php
/**
 * Operation controller.
 */

namespace App\Controller;

use App\Entity\Operation;
use App\Form\OperationType;
use App\Service\OperationService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class OperationController.
 *
 * @Route("/operation")
 *
 */
class OperationController extends AbstractController
{
    /**
     * Operation service.
     *
     * @var \App\Service\OperationService
     */
    private $operationService;

    /**
     * OperationController constructor.
     *
     * @param \App\Service\OperationService $operationService Operation service
     */
    public function __construct(OperationService $operationService)
    {
        $this->operationService = $operationService;
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
     *     name="operation_index",
     * )
     */
    public function index(Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $pagination = $this->operationService->createPaginatedList($page);

        return $this->render(
            'operation/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param \App\Entity\Operation $operation Operation entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="operation_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function show(Operation $operation): Response
    {
        return $this->render(
            'operation/show.html.twig',
            ['operation' => $operation]
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
     *     name="operation_create",
     * )
     */
    public function create(Request $request): Response
    {
        $operation = new Operation();
        $form = $this->createForm(OperationType::class, $operation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->operationService->save($operation);
            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('operation_index');
        }

        return $this->render(
            'operation/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request  HTTP request
     * @param \App\Entity\Operation                      $operation Operation entity
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
     *     name="operation_edit",
     * )
     */
    public function edit(Request $request, Operation $operation): Response
    {
        $form = $this->createForm(OperationType::class, $operation, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->operationService->save($operation);
            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('operation_index');
        }

        return $this->render(
            'operation/edit.html.twig',
            [
                'form' => $form->createView(),
                'operation' => $operation,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request  HTTP request
     * @param \App\Entity\Operation                      $operation Operation entity
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
     *     name="operation_delete",
     * )
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Operation $operation): Response
    {
        if ($operation->getTransactions()->count()) {
            $this->addFlash('warning', 'message_operation_contains_transactions');

            return $this->redirectToRoute('operation_index');
        }

        $form = $this->createForm(FormType::class, $operation, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->operationService->delete($operation);
            $this->addFlash('success', 'message_deleted_successfully');

            return $this->redirectToRoute('operation_index');
        }

        return $this->render(
            'operation/delete.html.twig',
            [
                'form' => $form->createView(),
                'operation' => $operation,
            ]
        );
    }
}