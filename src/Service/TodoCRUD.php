<?php

namespace App\Service;

use App\DataObject\TodoResult as TodoResultResponse;
use App\DataObject\TodosQueryParams;
use App\Entity\Todo;
use App\Repository\TodoRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * TodoCRUD constructor.
     *
     * @param EntityManagerInterface $em
     * @param TodoRepository $repository
     * @param TodoResult $result
     */
    public function __construct(EntityManagerInterface $em, TodoRepository $repository, TodoResult $result)
    {
        $this->em = $em;
        $this->repository = $repository;
        $this->result = $result;
    }

    /**
     * @param Request $request
     *
     * @return Todo
     */
    public function create(Request $request): Todo
    {
        $title = $request->request->get('title');
        $todo = new Todo();
        $todo->setTitle($title);
        $todo->setLikesCount(0);
        $todo->setStatus('new');
        $todo->setCreatedAt(new \DateTime());
        $this->em->persist($todo);
        $this->em->flush();

        return $todo;
    }

    /**
     * @param Request $request
     *
     * @return TodoResultResponse
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
     */
    public function update(int $id, Request $request): Todo
    {
        $todo = $this->find($id);
        $title = trim($request->request->get('title'));
        $status = trim($request->request->get('newStatus'));

        if ($status) {
            $todo->setStatus($status);
        }

        if ($title) {
            $todo->setTitle($title);
        }

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
}