<?php

namespace Todo\UI\Controller\Web;

use Shared\UI\Controller\Web\AbstractWebController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Todo\Application\Command\DeleteTodoList\DeleteTodoListCommand;

#[Route('{_locale}/todo-lists/{todoList}', name: 'delete_todo_list', methods: ['DELETE'])]
#[AsController]
class DeleteTodoListController extends AbstractWebController
{
    public function __invoke(Request $request, string $todoList): Response
    {
        $this->handle(new DeleteTodoListCommand($todoList));

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse([], Response::HTTP_NO_CONTENT);
        }

        return $this->redirectToRoute('web.todo_lists');
    }
}
