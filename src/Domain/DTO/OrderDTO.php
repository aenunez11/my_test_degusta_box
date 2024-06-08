<?php

namespace Domain\DTO;


class OrderDTO
{

    /**
     * @var string
     */
    private $portfolioName;

    /**
     * @var string
     */
    private $type;

    /**
     * @var int|null
     */
    private $allocationId;

    /**
     *  @var int
     */
    private $shares;

    /**
     *  @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime|null
     */
    private $completedAt;

    /**
     * OrderDTO constructor.
     * @param string $portfolioName
     * @param string $type
     * @param int|null $allocationId
     * @param int $shares
     * @param \DateTime $createdAt
     * @param \DateTime|null $completedAt
     */
    public function __construct(string $portfolioName, string $type, ?int $allocationId, int $shares, \DateTime $createdAt, ?\DateTime $completedAt)
    {
        $this->portfolioName = $portfolioName;
        $this->type = $type;
        $this->allocationId = $allocationId;
        $this->shares = $shares;
        $this->createdAt = $createdAt;
        $this->completedAt = $completedAt;
    }

    /**
     * @return string
     */
    public function getPortfolioName(): string
    {
        return $this->portfolioName;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return int|null
     */
    public function getAllocationId(): ?int
    {
        return $this->allocationId;
    }

    /**
     * @return int
     */
    public function getShares(): int
    {
        return $this->shares;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime|null
     */
    public function getCompletedAt(): ?\DateTime
    {
        return $this->completedAt;
    }
}