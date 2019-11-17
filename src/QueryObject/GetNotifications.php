<?php declare(strict_types = 1);

namespace App\QueryObject;

use App\Entity\Notification;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class GetNotifications
 */
class GetNotifications
{
    /** @var EntityManagerInterface  */
    private $entityManager;

    /**
     * GetNotifications constructor.
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
     * @return array
     */
    public function execute(User $user): array
    {
        $query = $this->entityManager->createQueryBuilder()
            ->from(Notification::class, 'n')
            ->select('n')
            ->innerJoin(User::class, 'u', 'WITH', 'u.id = n.user')
            ->where('n.user = :user')
            ->setParameter('user', $user);

        return $query->getQuery()->getResult();
    }
}
