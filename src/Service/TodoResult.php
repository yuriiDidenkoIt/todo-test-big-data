<?php

namespace App\Service;

use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\DataObject\{
    TodosQueryParams,
    TodoResult as TodoResultResponse,
    TotalItemsCount
};
use App\Repository\TodoRepository;

/**
 * Class TodoResult
 */
class TodoResult
{
    /**
     * @var TodoRepository
     */
    private $repository;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * TodoResult constructor.
     *
     * @param TodoRepository $repository
     * @param ValidatorInterface $validator
     */
    public function __construct(TodoRepository $repository, ValidatorInterface $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * @param TodosQueryParams $queryParams
     *
     * @return TodoResultResponse
     * @throws Exception
     */
    public function get(TodosQueryParams $queryParams): TodoResultResponse
    {
        $this->validate($queryParams);
        $todoCount = new TotalItemsCount($this->repository->countAll());
        [$from, $till] = $this->getFromTill($queryParams, $todoCount);

        $result = $this
            ->repository
            ->getFromMaterialized(
                $queryParams->getStatusId(),
                $from,
                $till,
                $queryParams->getOrder()
            );

        return new TodoResultResponse($result, $todoCount);
    }

    /**
     * @param TodosQueryParams $queryParams
     * @param TotalItemsCount $todoCount
     *
     * @return array
     */
    private function getFromTill(TodosQueryParams $queryParams, TotalItemsCount $todoCount): array
    {
        if ($queryParams->getOrder() === TodoRepository::ORDER_BY_DESC) {
            $lustRowId = $todoCount->jsonSerialize()[$queryParams->getStatusId()];
            $from = $lustRowId - $queryParams->getActivePage() * $queryParams->getLimit();
            $till = $from + $queryParams->getLimit();

            return [$from, $till];
        }

        $till = $queryParams->getActivePage() * $queryParams->getLimit();
        $from = $till - $queryParams->getLimit() + 1;

        return [$from, $till];
    }

    /**
     * @param TodosQueryParams $queryParams
     *
     * @throws Exception
     */
    private function validate(TodosQueryParams $queryParams): void
    {
        $errors = $this->validator->validate($queryParams);
        if (count($errors)) {
            $errorsString = (string)$errors;
            throw new Exception($errorsString);
        }
    }
}