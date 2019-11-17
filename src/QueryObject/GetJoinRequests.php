<?php declare(strict_types=1);

namespace App\QueryObject;

use App\Entity\Group;
use App\Entity\GroupJoinRequest;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class GetGroups
 */
class GetJoinRequests
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * GetGroups constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param array $params
     * @param User  $user
     *
     * @return array
     */
    public function execute(array $params, User $user): array
    {
        $query = $this->entityManager->createQueryBuilder()
            ->from(GroupJoinRequest::class, 'gjr')
            ->select('gjr')
            ->leftJoin(User::class, 'u', 'WITH', 'u.id = gjr.user')
            ->leftJoin(Group::class, 'g', 'WITH', 'g.id = gjr.group')
            ->where('g.admin = :user')
            ->setParameter('user', $user);

        if ($params['search']) {
            $query->where('g.name LIKE :searchParam')
                ->setParameter('searchParam', "%" . $params['search'] . "%");
        }

        if ($params['isMyGroups']) {
            $query->where('g.admin = :user')
                ->setParameter('user', $user);
        }

        return $query->getQuery()->getResult();
    }
}
