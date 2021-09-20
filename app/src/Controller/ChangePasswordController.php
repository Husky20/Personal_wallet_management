<?php
/**
 * Change Password Controller.
 */

namespace App\Controller;

use App\Form\ChangePasswordType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class ChangePasswordController.
 */
class ChangePasswordController extends AbstractController
{

    /**
     * @Route("/change/password", name="app_change_password")
     *
     * @param Request                      $request
     * @param UserRepository               $userRepository
     * @param UserPasswordEncoderInterface $passwordEncoder
     *
     * @return Response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function index(Request $request, UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        // just setup a fresh $task object (remove the example data)

        $form = $this->createForm(ChangePasswordType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $password = $form->get('password')->getData();
            $passwordRepeated = $form->get('passwordRepeated')->getData();

            if (0 !== strcmp($password, $passwordRepeated)) {
                return $this->render('change_password/index.html.twig', [
                    'form' => $form->createView(), 'error' => 'Podałeś różne hasła',
                ]);
            }

            $userName = $this->getUser()->getUsername();
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $encodedPassword = $passwordEncoder->encodePassword(
                $this->getUser(),
                $password
            );

            $userRepository->upgradePassword($user, $encodedPassword);

            return $this->render('change_password/index.html.twig', [
                'form' => $form->createView(), 'success' => 'Hasło pomyślnie zmienione',
            ]);
        }

        return $this->render('change_password/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
