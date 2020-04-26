<?php

namespace App\Service;

use App\DataObject\Status;
use App\DataObject\TodoResult as TodoResultResponse;
use App\DataObject\TodosQueryParams;
use App\Entity\Todo;
use App\Repository\TodoRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class TodoCRUD
 */
class TodoCRUD
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var TodoRepository
     */
    private $repository;

    /**
     * @var TodoResult
     */
    private $result;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * TodoCRUD constructor.
     *
     * @param EntityManagerInterface $em
     * @param ValidatorInterface $validator
     * @param TodoRepository $repository
     * @param TodoResult $result
     */
    public function __construct(
        EntityManagerInterface $em,
        ValidatorInterface $validator,
        TodoRepository $repository,
        TodoResult $result
    )
    {
        $this->em = $em;
        $this->validator = $validator;
        $this->repository = $repository;
        $this->result = $result;
    }

    /**
     * @param Request $request
     *
     * @return Todo
     * @throws Exception
     */
    public function create(Request $request): Todo
    {
        $title = $request->request->get('title');
        $id = $this->repository->getMaxId();
        $todo = new Todo();
        $todo->setId($id ? $id + 1 : 1);
        $todo->setTitle($title);
        $todo->setLikesCount(0);
        $todo->setStatusId(Status::ID_NEW);
        $todo->setCreatedAt(new DateTime());

        $this->validate($todo);

        $this->em->persist($todo);
        $this->em->flush();

        return $todo;
    }

    /**
     * @param Request $request
     *
     * @return TodoResultResponse
     * @throws Exception
     */
    public function read(Request $request): TodoResultResponse
    {
        return $this->result->get(new TodosQueryParams($request->query));
    }

    /**
     * @param int $id
     * @param Request $request
     *
     * @return Todo
     * @throws Exception
     */
    public function update(int $id, Request $request): Todo
    {
        $todo = $this->find($id);
        $title = trim($request->request->get('title'));
        $statusId = trim($request->request->get('newStatusId'));

        if ($statusId) {
            $todo->setStatusId($statusId);
        }

        if ($title) {
            $todo->setTitle($title);
        }
        $this->validate($todo);
        $this->em->flush();

        return $todo;
    }

    /**
     * @param int $id
     */
    public function delete(int $id): void
    {
        $this->em->remove($this->find($id));
        $this->em->flush();
    }

    /**
     * @param int $id
     *
     * @return Todo
     */
    private function find(int $id): Todo
    {
        $todo = $this->repository->find($id);
        if (!$todo) {
            throw new NotFoundHttpException('No todo found for id ' . $id);
        }

        return $todo;
    }

    /**
     * @param Todo $todo
     *
     * @throws Exception
     */
    private function validate(Todo $todo): void
    {
        $errors = $this->validator->validate($todo);
        if (count($errors)) {
            $errorsString = (string)$errors;
            throw new Exception($errorsString);
        }
    }
}