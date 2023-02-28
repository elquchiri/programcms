<?php


namespace ElectroForums\UserBundle\Controller\Account;


use Doctrine\ORM\EntityManagerInterface;
use ElectroForums\UserBundle\Entity\User;
use ElectroForums\UserBundle\Form\UserRegistrationType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends \ElectroForums\CoreBundle\Controller\Adminhtml\AbstractController
{

    private UserPasswordHasherInterface $userPasswordHasher;
    private EntityManagerInterface $entityManager;
    private \ElectroForums\RouterBundle\Service\Request $request;

    public function __construct(
        \ElectroForums\RouterBundle\Service\Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager
    )
    {
        parent::__construct($request);
        $this->userPasswordHasher = $userPasswordHasher;
        $this->entityManager = $entityManager;
        $this->request = $request;
    }

    public function execute()
    {
        $user = new User();
        $form = $this->createForm(UserRegistrationType::class, $user);
        $form->handleRequest($this->request->getCurrentRequest());

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            // Set Account Role as 'USER'
            $user->setRoles(['USER']);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->redirectToRoute('frontend_home');
        }

        return $this->render('@ElectroForumsUser/frontend/authentication/register.html.twig', [
            'registrationForm' => $form->createView()
        ]);
    }
}