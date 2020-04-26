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
        $formatted = $this->format($todos);
        $this->todos = $formatted['todos'];
        $this->todosIds = $formatted['todosIds'];
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

    private function format(array $todos): array
    {
        $result = [
            'todos' => [],
            'todosIds' => [],
        ];
        foreach ($todos as $todo) {
            $result['todos'][$todo['id']] = [
                'id' => $todo['id'],
                'title' => $todo['title'],
                'likesCount' => $todo['likes_count'],
                'statusId' => $todo['status_id'],
                'createdAt' => $todo['created_at'],
            ];
            $result['todosIds'][] = $todo['id'];
        }

        return $result;
    }
}