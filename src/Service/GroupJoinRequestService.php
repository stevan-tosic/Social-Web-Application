<?php

namespace App\Service;

use App\Entity\Group;
use App\Entity\GroupJoinRequest;
use App\Entity\Notification;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class GroupJoinRequestService {
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function execute(User $user, Group $group)
    {
        $joinRequest = new GroupJoinRequest();
        $joinRequest->setUser($user);
        $joinRequest->setGroup($group);

        $notification = new Notification();
        $notification->setUser($group->getAdmin());
        $notification->setMessage($user->getFullName().' want to join the group '.$group->getName());

        $this->entityManager->persist($joinRequest);
        $this->entityManager->flush();

        $this->entityManager->persist($notification);
        $this->entityManager->flush();
    }

    public function accept (GroupJoinRequest $joinRequest)
    {
        /** @var User $user */
        $user = $joinRequest->getUser();
        /** @var Group $group */
        $group = $joinRequest->getGroup();
        $group->addMember($user);
        $groupMembers = $group->getMembers();

        $notification = new Notification();
        $notification->setUser($user);
        $notification->setMessage($group->getName().' accepted your join request.');

        $this->entityManager->persist($group);
        $this->entityManager->flush();
        $this->entityManager->persist($notification);
        $this->entityManager->flush();

        /** @var User $member */
        foreach ($groupMembers as $member){
            if ($member->getId() === $user->getId()) {
                continue;
            }

            $notification = new Notification();
            $notification->setUser($member);
            $notification->setMessage($user->getFullName().' joined the group '. $group->getName());

            $this->entityManager->persist($notification);
            $this->entityManager->flush();
        }

        $this->entityManager->remove($joinRequest);
        $this->entityManager->flush();
    }

    public function refuse (GroupJoinRequest $joinRequest)
    {
        /** @var User $user */
        $user = $joinRequest->getUser();
        /** @var Group $group */
        $group = $joinRequest->getGroup();
        $groupMembers = $group->getMembers();

        $notification = new Notification();
        $notification->setUser($user);
        $notification->setMessage($group->getName().' refused your join request.');

        $this->entityManager->persist($notification);
        $this->entityManager->flush();

        /** @var User $member */
        foreach ($groupMembers as $member){
            if ($member->getId() === $user->getId()) {
                continue;
            }

            $notification = new Notification();
            $notification->setUser($member);
            $notification->setMessage($user->getFullName().' has been refused in the '. $group->getName());

            $this->entityManager->persist($notification);
            $this->entityManager->flush();
        }

        $this->entityManager->remove($joinRequest);
        $this->entityManager->flush();
    }
}