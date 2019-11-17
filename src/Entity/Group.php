<?php declare(strict_types = 1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="groups")
 */
class Group
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="group_name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(name="date_created", type="datetime", nullable=true)
     */
    private $created;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="ownedGroups")
     */
    private $admin;

    /**
     ** @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="groupsMember")
     */
    private $members;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GroupJoinRequest", mappedBy="group")
     */
    private $joinRequests;

    public function __construct()
    {
        $this->members = new ArrayCollection();
        $this->created = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * @param mixed $admin
     */
    public function setAdmin($admin): void
    {
        $this->admin = $admin;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created): void
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getJoinRequests()
    {
        return $this->joinRequests;
    }

    /**
     * @param mixed $joinRequests
     */
    public function setJoinRequests($joinRequests): void
    {
        $this->joinRequests = $joinRequests;
    }

    /**
     * @return mixed
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * @param mixed $member
     */
    public function addMember(User $member): void
    {
        $this->members[] = $member;
    }
}