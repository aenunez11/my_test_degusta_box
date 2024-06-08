<?php

namespace Domain\DTO;


use Domain\Collections\PortfolioCollection;

class ClientDTO
{

    /** @var string */
    private $uidentifier;
    /** @var string */
    private $name;
    /** @var array */
    private $portfolioCollection;

    /**
     * ClientDTO constructor.
     * @param string $uidentifier
     * @param string $name
     * @param PortfolioCollection $portfolioCollection
     */
    public function __construct(string $uidentifier,string $name,PortfolioCollection $portfolioCollection)
    {
        $this->uidentifier = $uidentifier;
        $this->name = $name;
        $this->portfolioCollection = $portfolioCollection;
    }

    /**
     * @return string
     */
    public function getUidentifier(): string
    {
        return $this->uidentifier;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getPortfolios(): array
    {
        return $this->portfolioCollection->getPortfolioDTOCollection();
    }

    /**
     * @return int
     */
    public function getTotalPortfolios(): int
    {
        return count($this->portfolioCollection->getPortfolioDTOCollection());
    }
}