<?php

namespace App\DataObject;

/**
 * Class Status
 */
class Status
{
    public const ALL = 'all';
    public const NEW = 'new';
    public const COMPLETED = 'completed';
    public const REJECTED = 'rejected';
    public const IN_PROGRESS = 'in_progress';
    public const ID_ALL = 0;
    public const ID_NEW = 1;
    public const ID_COMPLETED = 2;
    public const ID_REJECTED = 3;
    public const ID_IN_PROGRESS = 4;

    public const STATUSES = [
        self::ID_NEW => self::NEW,
        self::ID_COMPLETED => self::COMPLETED,
        self::ID_REJECTED => self::REJECTED,
        self::ID_IN_PROGRESS => self::IN_PROGRESS,
    ];
}