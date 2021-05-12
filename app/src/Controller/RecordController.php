<?php
/**
 * Record controller.
 */

namespace App\Controller;

use App\Repository\RecordRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RecordController.
 *
 * @Route("/record")
 */
class RecordController extends AbstractController
{
    /**
     * Index action.
     *
     * @param \App\Repository\RecordRepository $repository Record repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="record_index",
     * )
     */
    public function index(RecordRepository $repository): Response
    {
        return $this->render(
            'record/index.html.twig',
            ['data' => $repository->findAll()]
        );
    }
}