<?php declare(strict_types = 1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string")
     */
    private $lastName;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Group", mappedBy="admin")
     */
    private $ownedGroups;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GroupJoinRequest", mappedBy="user")
     */
    private $groupJoinRequest;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Group", mappedBy="members")
     */
    private $groupsMember;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Notification", mappedBy="user")
     */
    private $notification;


    public function __construct()
    {
        parent::__construct();

        $this->groupsMember = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getFullName()
    {
        return "$this->firstName $this->lastName";
    }

    /**
     * @return mixed
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * @param mixed $notification
     */
    public function setNotification($notification): void
    {
        $this->notification = $notification;
    }

    public function getGroupMembershipIds()
    {
        $groupMembershipIds = [];

        foreach ($this->groupsMember as $group) {
            $groupMembershipIds[] = $group->getId();
        }

        return $groupMembershipIds;
    }

    public function getJoinRequestGroupIds()
    {
        $groupMembershipIds = [];

        foreach ($this->groupsMember as $group) {
            $groupMembershipIds[] = $group->getId();
        }

        return $groupMembershipIds;
    }



}