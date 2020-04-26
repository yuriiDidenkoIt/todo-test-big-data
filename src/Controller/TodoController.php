<?php

namespace App\Controller;

use App\DataObject\TodosQueryParams;
use App\DataObject\TotalItemsCount;
use App\Repository\TodoRepository;
use App\Service\TodoCRUD;
use App\Service\TodoResult;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TodoController
 */
class TodoController extends AbstractController
{

    /**
     * @var TodoRepository
     */
    private $todoRepository;

    /**
     * @var TodoResult
     */
    private $todoResultService;

    /**
     * @var TodoCRUD
     */
    private $CRUD;

    /**
     * TodoController constructor.
     *
     * @param TodoRepository $todoRepository
     * @param TodoResult $todoResultService
     * @param TodoCRUD $CRUD
     */
    public function __construct(TodoRepository $todoRepository, TodoResult $todoResultService, TodoCRUD $CRUD)
    {
        $this->todoRepository = $todoRepository;
        $this->todoResultService = $todoResultService;
        $this->CRUD = $CRUD;
    }

    /**
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('base.html.twig');
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function read(Request $request): JsonResponse
    {
        return $this->json($this->CRUD->read($request));
    }

    /**
     * @param int $id
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $lastTodo = null;
        try {
            $todo = $this->CRUD->update($id, $request);
        } catch (Exception $exception) {
            throw $this->createNotFoundException($exception->getMessage());
        }

        if (!trim($request->request->get('title')) && trim($request->request->get('status'))) {
            $lastTodo = $this->todoResultService->get(new TodosQueryParams($request->request));
            $lastTodo = current($lastTodo->jsonSerialize()['todos']);
        }

        return $this->json([
            'todo' => $todo,
            'lastTodo' => $lastTodo,
            'totalItemsCount' => new TotalItemsCount($this->todoRepository->countAll()),
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws \Doctrine\DBAL\DBALException
     */
    public function add(Request $request): JsonResponse
    {
        try {
            $todo = $this->CRUD->create($request);
        } catch (Exception $exception) {
            throw $this->createNotFoundException($exception->getMessage());
        }

        return $this->json([
            'todo' => $todo,
            'totalItemsCount' => new TotalItemsCount($this->todoRepository->countAll()),
        ]);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function delete(int $id, Request $request): JsonResponse
    {
        try {
            $this->CRUD->delete($id);
        } catch (Exception $exception) {
            throw $this->createNotFoundException($exception->getMessage());
        }
        $lastTodo = $this->todoResultService->get(new TodosQueryParams($request->request));
        $lastTodo = current($lastTodo->jsonSerialize()['todos']);

        return $this->json([
            'id' => $id,
            'lastTodo' => $lastTodo,
            'totalItemsCount' => new TotalItemsCount($this->todoRepository->countAll()),
        ]);
    }
}