<?php

namespace Todo\UI\Controller\Web;

use Shared\UI\Controller\Web\AbstractWebController;
use Storage\Doctrine\Entity\TodoList;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Todo\Application\Command\EditTodoList\EditTodoListCommand;
use Todo\Infrastructure\Form\TodoListType;
use Todo\Infrastructure\Formater\DoctrineTodoListFormater;

#[Route('{_locale}/todo-lists/{todoList}/edit', name: 'edit_todo_list', methods: ['GET', 'POST'])]
#[AsController]
class EditTodoListController extends AbstractWebController
{
    public function __invoke(Request $request, TodoList $todoList, DoctrineTodoListFormater $formater): Response
    {
        $form = $this->createForm(TodoListType::class, $formater->format($todoList));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->handle(new EditTodoListCommand(
                id: $data['id'],
                name: $data['name'],
                user: $data['user'],
                items: $data['items'],
                description: $data['description'],
            ));

            return $this->redirectToRoute('web.todo_lists');
        }

        return $this->render('todo/list/add.html.twig', [
            'form' => $form,
            'edit' => true,
        ]);
    }
}
