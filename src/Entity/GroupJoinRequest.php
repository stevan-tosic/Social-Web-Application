<?php declare(strict_types = 1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="group_join_request")
 */
class GroupJoinRequest
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="groupJoinRequest")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Group", inversedBy="joinRequests")
     */
    private $group;

    /**
     * @ORM\Column(type="datetime")
     */
    private $requested;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->group = new ArrayCollection();
        $this->requested = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @param mixed $user
     */
    public function addUser(User $user): void
    {
        $this->user[] = $user;
    }

    /**
     * @return mixed
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param mixed $group
     */
    public function setGroup($group): void
    {
        $this->group = $group;
    }

    /**
     * @param mixed $group
     */
    public function addGroup(Group $group): void
    {
        $this->group[] = $group;
    }

    /**
     * @return mixed
     */
    public function getRequested()
    {
        return $this->requested;
    }

    /**
     * @param mixed $requested
     */
    public function setRequested($requested): void
    {
        $this->requested = $requested;
    }

}