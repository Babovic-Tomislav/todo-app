<?php

namespace Todo\UI\Controller\Web;

use Auth\Domain\Model\AuthUser;
use Shared\UI\Controller\Web\AbstractWebController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Todo\Application\Query\GetTodoList\GetTodoListsQuery;

#[Route('{_locale}/todo-lists', name: 'todo_lists', methods: ['GET'])]
#[AsController]
#[IsGranted('ROLE_USER')]
class ListTodoListController extends AbstractWebController
{
    public function __invoke(Request $request, Security $security): Response
    {
        /** @var AuthUser $user */
        $user = $security->getUser();

        $paginatedLists = $this->ask(new GetTodoListsQuery(
            $user->getId(),
            $this->extractPaginationData($request),
        ));

        return $this->render('todo/list.html.twig', [
            'lists' => $paginatedLists->getResults(),
        ]);
    }
}
