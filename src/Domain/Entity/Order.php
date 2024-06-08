<?php


namespace Domain\Entity;


use Doctrine\ORM\Mapping as ORM;
use Domain\Repository\OrderRepository;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="orders")
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Portfolio")
     * @ORM\JoinColumn(nullable=false)
     */
    private $portfolio;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type; // buy or sell

    /**
     *
     * @ORM\Column(type="integer",nullable=true)
     */
    private $allocationId;

    /**
     * @ORM\Column(type="integer")
     */
    private $shares;

    /**
     *  @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $completedAt;

    public function __construct() {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getPortfolio()
    {
        return $this->portfolio;
    }

    /**
     * @param mixed $portfolio
     */
    public function setPortfolio($portfolio): void
    {
        $this->portfolio = $portfolio;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getShares()
    {
        return $this->shares;
    }

    /**
     * @param mixed $shares
     */
    public function setShares($shares): void
    {
        $this->shares = $shares;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getCompletedAt(): \DateTime
    {
        return $this->completedAt;
    }

    /**
     * @param \DateTime $completedAt
     */
    public function setCompletedAt(\DateTime $completedAt): void
    {
        $this->completedAt = $completedAt;
    }

    /**
     * @return mixed
     */
    public function getAllocationId()
    {
        return $this->allocationId;
    }

    /**
     * @param mixed $allocationId
     */
    public function setAllocationId($allocationId): void
    {
        $this->allocationId = $allocationId;
    }


}