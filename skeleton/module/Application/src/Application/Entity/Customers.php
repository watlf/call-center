<?php
/**
 * Created by PhpStorm.
 * User: <andrey.lyahovski@gmail.com>
 * Date: 6/24/15
 * Time: 10:49 AM
 */

namespace Application\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="customers")
 * @ORM\Entity(repositoryClass="Application\Repositories\Customers")
 */
class Customers
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=false)
     */
    protected $firstName;

    /**
     * @ORM\Column(name="last_name", type="string", length=255, nullable=false)
     */
    protected $lastName;

    /**
     * @ORM\Column(name="phone", type="string", length=12, nullable=false)
     */
    protected $phone;

    /**
     * @ORM\Column(name="address", type="string", length=255, nullable=false)
     */
    protected $address;

    /**
     * @ORM\Column(name="status", type="string", length=1, nullable=false)
     */
    protected $status = 'in progress';

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Calls", mappedBy="customers")
     */
    private $calls;

    const STATUS_DONE = 'done';
    const STATUS_IN_PROGRESS = 'in progress';

    public function __construct()
    {
        $this->calls = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Customers
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     *
     * @return Customers
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     *
     * @return Customers
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     *
     * @return Customers
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     *
     * @return Customers
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return Customers
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }
}