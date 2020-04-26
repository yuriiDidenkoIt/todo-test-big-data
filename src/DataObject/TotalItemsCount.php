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
            Status::ID_ALL => $this->totalItemsCount[Status::ALL . '_items'],
            Status::ID_NEW => $this->totalItemsCount[Status::NEW . '_items'],
            Status::ID_REJECTED => $this->totalItemsCount[Status::REJECTED . '_items'],
            Status::ID_COMPLETED => $this->totalItemsCount[Status::COMPLETED . '_items'],
            Status::ID_IN_PROGRESS => $this->totalItemsCount[Status::IN_PROGRESS . '_items'],
        ];
    }
}