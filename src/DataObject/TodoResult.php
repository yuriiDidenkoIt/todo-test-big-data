<?php

namespace App\DataObject;

use JsonSerializable;

/**
 * Class TodoResult
 */
class TodoResult implements JsonSerializable
{

    /**
     * @var array
     */
    private $todos;

    /**
     * @var array
     */
    private $todosIds;

    /**
     * @var array
     */
    private $totalItemsCount;

    /**
     * TodoResult constructor.
     *
     * @param array $todos
     * @param TotalItemsCount $totalItemsCount
     */
    public function __construct(array $todos, TotalItemsCount $totalItemsCount)
    {
        $this->todos = array_column($todos, null, 'id');
        $this->todosIds = array_column($todos, 'id');
        $this->totalItemsCount = $totalItemsCount;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'todos' => $this->todos,
            'todosIds' => $this->todosIds,
            'totalItemsCount' => $this->totalItemsCount,
        ];
    }
}