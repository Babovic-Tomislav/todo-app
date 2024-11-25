<?php

namespace Todo\UI\Controller\Web;

use Shared\UI\Controller\Web\AbstractWebController;
use Storage\Doctrine\Entity\TodoList;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Todo\Infrastructure\Mapper\DoctrineTodoListMapper;

#[Route('{_locale}/todo-lists/{todoList}', name: 'view_todo_list', methods: ['GET'])]
#[AsController]
class ViewTodoListController extends AbstractWebController
{
    public function __invoke(Request $request, TodoList $todoList, DoctrineTodoListMapper $mapper): Response
    {
        return $this->render('todo/list/view.html.twig', [
            'todoList' => $mapper->toDomainModel($todoList),
            'edit' => false,
        ]);
    }
}
