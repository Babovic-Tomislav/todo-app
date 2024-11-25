<?php

namespace Todo\UI\Controller\Web;

use Shared\UI\Controller\Web\AbstractWebController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Todo\Application\Command\EditTodoList\EditTodoListCommand;
use Todo\Infrastructure\Form\TodoListType;

#[Route('{_locale}/todo-list', name: 'add_todo_list', methods: ['GET', 'POST'])]
#[AsController]
class AddTodoListController extends AbstractWebController
{
    public function __invoke(Request $request): Response
    {
        $form = $this->createForm(TodoListType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $todoListData = $form->getData();

            $this->handle(
                new EditTodoListCommand(
                    id: null,
                    name: $todoListData['name'],
                    user: $todoListData['user'],
                    items: $todoListData['items'],
                    description: $todoListData['description'],
                )
            );

            return $this->redirectToRoute('web.todo_lists');
        }

        return $this->render('todo/list/add.html.twig', [
            'form' => $form,
        ]);
    }
}
