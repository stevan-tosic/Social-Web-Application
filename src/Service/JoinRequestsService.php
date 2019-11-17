<?php

namespace App\Service;

use App\Entity\Group;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class JoinRequestsService {
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function execute(User $user, array $formData)
    {
        $group = new Group();
        $group->setName($formData['name']);
        $group->setAdmin($user);

        $this->entityManager->persist($group);
        $this->entityManager->flush();
    }
}