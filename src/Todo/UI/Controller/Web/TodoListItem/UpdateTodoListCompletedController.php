<?php

namespace Todo\UI\Controller\Web\TodoListItem;

use Shared\UI\Controller\Web\AbstractWebController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Todo\Application\Command\UpdateTodoListItem\UpdateTodoListItemCommand;
use Todo\Infrastructure\Formater\DoctrineTodoListFormater;
use Todo\Infrastructure\Formater\DoctrineTodoListItemFormater;

#[Route('{_locale}/todo-lists/{todoList}/items/{todoListItem}/completed', name: 'update_todo_list_item_completed', methods: ['PUT'])]
#[AsController]
class UpdateTodoListCompletedController extends AbstractWebController
{
    public function __invoke(
        Request $request,
        string $todoList,
        string $todoListItem,
        DoctrineTodoListFormater $todoListFormater,
        DoctrineTodoListItemFormater $todoListItemFormater,
    ): Response {
        $payload = $this->extractJSONPayload($request);

        $this->handle(new UpdateTodoListItemCommand(
            $todoList,
            $todoListItem,
            $payload['completed']
        ));
        if ($request->isXmlHttpRequest()) {
            return new JsonResponse(['success' => true]);
        }

        dd($request->isXmlHttpRequest());
    }
}
