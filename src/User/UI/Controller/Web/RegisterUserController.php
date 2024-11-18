<?php

namespace User\UI\Controller\Web;

use Shared\Domain\Translator\TranslatorInterface;
use Shared\UI\Controller\Web\AbstractWebController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use User\Application\Command\UserCreated\UserCreatedCommand;
use User\Application\Command\UserCreated\UserCreatedHandler;
use User\Infrastructure\Form\RegisterUserFormType;

#[Route(path: '/register', name: 'register', methods: ['GET', 'POST'])]
class RegisterUserController extends AbstractWebController
{
    public function __invoke(Request $request, UserCreatedHandler $createdHandler, UserPasswordHasherInterface $passwordHasher, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(RegisterUserFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $userData = $form->getData();

            $this->handle(new UserCreatedCommand(
                id: null,
                name: $userData['name'],
                lastname: $userData['lastname'],
                username: $userData['username'],
                email: $userData['email'],
                password: $userData['password'],
                active: $userData['active'],
            ));

            return $this->redirectToRoute('task_success');
        }

        return $this->render('user/register.html.twig', [
            'form' => $form,
        ]);
    }
}
