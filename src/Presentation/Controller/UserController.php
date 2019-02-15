<?php

namespace App\Presentation\Controller;

use App\Application\Command\CreateUserCommand;
use App\Application\Query\GetUserByIdQuery;
use App\Domain\Model\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/users")
 */
class UserController extends BaseController
{
    use HandleTrait;

    /**
     * @var MessageBusInterface
     */
    protected $commandBus;

    public function __construct(MessageBusInterface $queryBus, MessageBusInterface $commandBus)
    {
        $this->messageBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    /**
     * @Route(path="/{id}", methods={"GET"})
     */
    public function user($id)
    {
        $query = new GetUserByIdQuery($id);
        $errors = $this->get('validator')->validate($query);

        if (count($errors) > 0) {
            return $this->json($errors);
        }

        /** @var User $user */
        $user = $this->handle($query);

        return $this->json($user);
    }

    /**
     * @Route(path="", methods={"POST"})
     */
    public function create(Request $request)
    {
        $command = new CreateUserCommand($request->request->get('username'), $request->request->get('password'));
        $errors = $this->get('validator')->validate($command);

        if (count($errors) > 0) {
            return $this->json($errors);
        }

        $this->commandBus->dispatch($command);

        return $this->json([], 201);
    }
}
