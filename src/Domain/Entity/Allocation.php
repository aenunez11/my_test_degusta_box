<?php


namespace Domain\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Allocation
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Portfolio", inversedBy="allocations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $portfolio;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $shares;

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
     * @return Portfolio
     */
    public function getPortfolio() :Portfolio
    {
        return $this->portfolio;
    }

    /**
     * @param Portfolio $portfolio
     */
    public function setPortfolio(Portfolio $portfolio): void
    {
        $this->portfolio = $portfolio;
    }

    /**
     * @return int
     */
    public function getShares(): int
    {
        return $this->shares;
    }

    /**
     * @param int $shares
     */
    public function setShares(int $shares): void
    {
        $this->shares = $shares;
    }

}