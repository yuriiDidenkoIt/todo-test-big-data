<?php

namespace App\DataObject;

use App\Entity\Todo;
use App\Repository\TodoRepository;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Class TodosQueryParams
 */
class TodosQueryParams
{
    private const ORDER_BY_LIKES = 'likes_count';
    private const ORDER_BY_ID = 'id';
    private const DEFAULT_LIMIT = 50;

    /**
     * @var string
     */
    private $prevId;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $likesOrderDirection;

    /**
     * @var int|null
     */
    private $prevLikesCount;

    /**
     * @var int
     */
    private $limit;

    /**
     * TodosQueryParams constructor.
     *
     * @param ParameterBag $query
     */
    public function __construct(ParameterBag $query)
    {
        $this->limit = $query->get('limit', self::DEFAULT_LIMIT);
        $this->status = strtolower($query->get('status'));
        $this->likesOrderDirection = strtoupper($query->get('orderByLikes', ''));
        $this->prevId = $query->get('prevId', null);
        $prevLikesCount = trim($query->get('prevLikesCount'));
        $this->prevLikesCount = $prevLikesCount !== '' ? $prevLikesCount : null;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return in_array($this->status, Todo::STATUSES) ? $this->status : null;
    }

    /**
     * @return string|null
     */
    public function getLikesOrderDirection(): ?string
    {
        return in_array($this->likesOrderDirection, [TodoRepository::ORDER_BY_DESC, TodoRepository::ORDER_BY_ASC])
            ? $this->likesOrderDirection
            : null;
    }

    /**
     * @return string|null
     */
    public function getPrevId(): ?int
    {
        return !empty($this->prevId) ? $this->prevId : null;
    }

    /**
     * @return string
     */
    public function getOrderBy(): string
    {
        return $this->getLikesOrderDirection() ? self::ORDER_BY_LIKES : self::ORDER_BY_ID;
    }

    /**
     * @return string
     */
    public function getOrderByDirection(): string
    {
        return $this->getLikesOrderDirection() ?? TodoRepository::ORDER_BY_DESC;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return int|null
     */
    public function getPrevLikesCount(): ?int
    {
        return $this->prevLikesCount;
    }
}