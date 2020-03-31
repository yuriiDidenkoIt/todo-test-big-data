<?php

namespace App\DataObject;

use App\Entity\Todo;

/**
 * Class TotalItemsCount
 */
class TotalItemsCount implements \JsonSerializable
{

    /**
     * @var array
     */
    private $totalItemsCount;

    /**
     * TodoResult constructor.

     * @param array $totalItemsCount
     */
    public function __construct(array $totalItemsCount)
    {
        $this->totalItemsCount = $totalItemsCount;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
                'all' => $this->totalItemsCount['all_items'],
                Todo::STATUS_NEW => $this->totalItemsCount[Todo::STATUS_NEW . '_items'],
                Todo::STATUS_REJECTED => $this->totalItemsCount[Todo::STATUS_REJECTED . '_items'],
                Todo::STATUS_COMPLETED => $this->totalItemsCount[Todo::STATUS_COMPLETED . '_items'],
                Todo::STATUS_IN_PROGRESS => $this->totalItemsCount[Todo::STATUS_IN_PROGRESS . '_items'],
        ];
    }
}