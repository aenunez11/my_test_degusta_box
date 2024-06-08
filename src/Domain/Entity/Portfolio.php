<?php


namespace Domain\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Domain\Repository\PortfolioRepository;

/**
 * @ORM\Entity(repositoryClass=PortfolioRepository::class)
 */
class Portfolio
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $uidentifier;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="portfolios")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity="Allocation", mappedBy="portfolio", cascade={"persist", "remove"})
     */
    private $allocations;

    public function __construct() {
        $this->allocations = new ArrayCollection();
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
     * @return string
     */
    public function getUidentifier(): string
    {
        return $this->uidentifier;
    }

    /**
     * @param string $uidentifier
     */
    public function setUidentifier(string $uidentifier): void
    {
        $this->uidentifier = $uidentifier;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client): void
    {
        $this->client = $client;
    }

    /**
     * @return mixed
     */
    public function getAllocations()
    {
        return $this->allocations->toArray();
    }

    /**
     * @param mixed $allocations
     */
    public function setAllocations($allocations): void
    {
        $this->allocations = $allocations;
    }


}