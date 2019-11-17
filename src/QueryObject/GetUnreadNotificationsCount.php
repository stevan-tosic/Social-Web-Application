<?php declare(strict_types = 1);

namespace App\QueryObject;

use App\Entity\Notification;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class GetUnreadNotificationsCount
 */
class GetUnreadNotificationsCount
{
    /** @var EntityManagerInterface  */
    private $entityManager;

    /**
     * GetUnreadNotificationsCount constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param User $user
     *
     * @return int|null
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function execute(User $user): ?int
    {
        $query = $this->entityManager->createQueryBuilder()
            ->from(Notification::class, 'n')
            ->select('COUNT(n)')
            ->innerJoin(User::class, 'u', 'WITH', 'u.id = n.user')
            ->where('n.user = :user')
            ->andWhere('n.readed is null')
            ->setParameter('user', $user);

        return (int) $query->getQuery()->getSingleScalarResult();
    }
}
