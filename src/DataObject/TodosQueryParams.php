<?php

namespace App\DataObject;

use App\Repository\TodoRepository;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Class TodosQueryParams
 */
class TodosQueryParams
{
    private const DEFAULT_LIMIT = 50;

    /**
     * @var int
     */
    private $activePage;

    /**
     * @var int
     */
    private $statusId;

    /**
     * @var string
     */
    private $order;

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
        $this->activePage = $query->get('activePage', 1);
        $this->limit = $query->get('limit', self::DEFAULT_LIMIT);
        $this->statusId = (int) $query->get('statusId', 0);
        $this->order = strtoupper($query->get('order', TodoRepository::ORDER_BY_ASC));
    }

    /**
     * @return int
     */
    public function getStatusId(): int
    {
        return $this->statusId;
    }

    /**
     * @return string
     */
    public function getOrder(): string
    {
        return $this->order;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getActivePage(): int
    {
        return $this->activePage;
    }
}