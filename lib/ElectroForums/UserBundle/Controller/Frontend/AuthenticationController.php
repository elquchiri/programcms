<?php


namespace ElectroForums\UserBundle\Controller\Frontend;

use Doctrine\ORM\EntityManagerInterface;
use ElectroForums\UserBundle\Form\UserRegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\SecurityBundle\Security;
use ElectroForums\UserBundle\Entity\User;

class AuthenticationController extends AbstractController
{

    #[Route('/user/authentication', name: 'electro_forums_user_authentication')]
    public function authenticate(
        AuthenticationUtils $authenticationUtils
    ): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastEmail = $authenticationUtils->getLastUsername();

        return $this->render('@ElectroForumsUser/frontend/authentication/login.html.twig', [
            'email' => $lastEmail,
            'error' => $error
        ]);
    }

    #[Route('/user/register', name: 'electro_forums_user_authentication_register')]
    public function register(
        \Symfony\Component\HttpFoundation\Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager
    ): Response
    {
        $user = new User();
        $form = $this->createForm(UserRegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setRoles(['USER']);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('frontend_home');
        }

        return $this->render('@ElectroForumsUser/frontend/authentication/register.html.twig', [
            'registrationForm' => $form->createView()
        ]);
    }

    #[Route('/user/logout', name: 'electro_forums_user_logout', methods: ['GET'])]
    public function logout(Security $security, UrlGeneratorInterface $urlGenerator)
    {
        // logout the user in on the current firewall
        $response = $security->logout();

        // controller can be blank: it will never be called!
        return new RedirectResponse($urlGenerator->generate('frontend_home'));
    }
}