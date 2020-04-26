<?php

namespace App\Repository;

use App\Entity\Todo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

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
     * @return array
     */
    public function countAll(): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT c.* FROM todo_count c';

        return $conn->fetchAll($sql)[0];
    }

    /**
     * @param int $statusId
     * @param int $from
     * @param int $till
     * @param string $order
     *
     * @return array
     */
    public function getFromMaterialized(int $statusId, int $from, int $till, string $order = 'ASC'): array
    {
        $orderByColumn = !$statusId ? 'row_num_all' : 'row_num_by_status_id';
        $where = !$statusId
            ? ' tm.row_num_all BETWEEN ' . $from . ' AND ' . $till
            : ' tm.status_id=' . $statusId . ' AND tm.row_num_by_status_id BETWEEN ' . $from . ' AND ' . $till;
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT t.*
                FROM todo_materialized AS tm
                LEFT JOIN todo AS t ON tm.todo_id = t.id
                WHERE '  . $where . '
                ORDER BY ' . $orderByColumn. ' ' . $order;

        return $conn->fetchAll($sql);
    }

    /**
     * @return int|null
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getMaxId(): ?int
    {
        return $this->createQueryBuilder('t')
            ->select('MAX(t.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
