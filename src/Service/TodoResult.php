<?php

namespace App\Service;

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
     * TodoResult constructor.
     *
     * @param TodoRepository $repository
     */
    public function __construct(TodoRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param TodosQueryParams $queryParams
     *
     * @return TodoResultResponse
     */
    public function get(TodosQueryParams $queryParams): TodoResultResponse
    {
        $queryBuilder = $this->repository->createQueryBuilder('t');

        if ($queryParams->getStatus()) {
            $queryBuilder
                ->where('t.status = :status')
                ->setParameter('status', $queryParams->getStatus());
        }

        if (
            $queryParams->getPrevLikesCount() !== null
            && $queryParams->getLikesOrderDirection()
            && $queryParams->getLikesOrderDirection() === TodoRepository::ORDER_BY_DESC
        ) {
            $queryBuilder
                ->andWhere('t.likes_count < :likes_count')
                ->setParameter('likes_count', $queryParams->getPrevLikesCount());
        }

        if (
            $queryParams->getPrevLikesCount() !== null
            && $queryParams->getLikesOrderDirection()
            && $queryParams->getLikesOrderDirection() === TodoRepository::ORDER_BY_ASC
        ) {
            $queryBuilder
                ->andWhere('t.likes_count > :likes_count')
                ->setParameter('likes_count', $queryParams->getPrevLikesCount());
        }

        if ($queryParams->getPrevId() && !$queryParams->getLikesOrderDirection()) {
            $queryBuilder
                ->andWhere('t.id < :prev_id')
                ->setParameter('prev_id', $queryParams->getPrevId());
        }

        $result = $queryBuilder
            ->orderBy('t.' . $queryParams->getOrderBy(), $queryParams->getOrderByDirection())
            ->setMaxResults($queryParams->getLimit())
            ->getQuery()
            ->getArrayResult();


        return new TodoResultResponse($result, new TotalItemsCount($this->repository->countAll()));
    }
}