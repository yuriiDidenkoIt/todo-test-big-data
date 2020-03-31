<?php

namespace App\Repository;

use App\Entity\Todo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Todo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Todo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Todo[]    findAll()
 * @method Todo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TodoRepository extends ServiceEntityRepository
{
    public const ORDER_BY_DESC = 'DESC';
    public const ORDER_BY_ASC = 'ASC';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Todo::class);
    }

    /**
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    public function countAll(): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT c.* FROM todo_count c';

       return $conn->fetchAll($sql)[0];

    }
}
