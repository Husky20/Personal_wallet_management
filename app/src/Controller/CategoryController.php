<?php
/**
 * Category controller.
 */

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoryController.
 *
 * @Route("/category")
 */
class CategoryController extends AbstractController
{
    /**
     * Index action.
     *
     * @param string $name User input
     * @param \App\Repository\CategoryRepository $repository Category repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/{name}",
     *     methods={"GET"},
     *     name="category_index",
     *     defaults={"name":"Category"},
     *     requirements={"name": "[a-zA-Z]+"},
     * )
     */
    public function index(string $name, CategoryRepository $repository): Response
    {
        return $this->render(
            'category/index.html.twig',
            ['name' => $name]
        );
    }


}