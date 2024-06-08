<?php


namespace Domain\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Domain\Repository\ClientRepository;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
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
     * @ORM\OneToMany(targetEntity="Portfolio", mappedBy="client")
     */
    private $portfolios;

    public function __construct() {
        $this->portfolios = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
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
     * @return mixed
     */
    public function getPortfolios()
    {
        return $this->portfolios->toArray();
    }

    /**
     * @param mixed $portfolios
     */
    public function setPortfolios($portfolios): void
    {
        $this->portfolios = $portfolios;
    }


}