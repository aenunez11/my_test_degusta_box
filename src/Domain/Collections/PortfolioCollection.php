<?php

namespace Domain\Collections;

use Domain\DTO\PortfolioDTO;

class PortfolioCollection
{

    /**
     * @var PortfolioDTO[]
     */
    private $portfolioDTOCollection;

    /**
     * PortfolioCollection constructor.
     */
    public function __construct()
    {
        $this->portfolioDTOCollection = [];
    }


    /**
     * @return PortfolioDTO[]
     */
    public function getPortfolioDTOCollection(): array
    {
        return $this->portfolioDTOCollection;
    }

    /**
     * @param PortfolioDTO[] $portfolioDTOCollection
     */
    public function setPortfolioDTOCollection(array $portfolioDTOCollection): void
    {
        $this->portfolioDTOCollection = $portfolioDTOCollection;
    }
}