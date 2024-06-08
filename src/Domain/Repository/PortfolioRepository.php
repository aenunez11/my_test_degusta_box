<?php

namespace Domain\Repository;


use Doctrine\ORM\AbstractQuery;
use Domain\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Domain\Entity\Portfolio;

class PortfolioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Portfolio::class);
    }


    /**
     * @param Client $client
     * @return mixed
     */
    public function getAllPortfoliosByClient(Client $client)
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->andWhere("p.client = :client")
            ->setParameter("client", $client)
            ->getQuery()->getResult(AbstractQuery::HYDRATE_ARRAY);

    }


    /**
     * @param $uidentifier
     * @return Portfolio|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getPortfolioEntityByUidentifier($uidentifier): ?Portfolio
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.uidentifier = :uid')
            ->setParameter('uid',$uidentifier)
            ->getQuery()->getOneOrNullResult();

    }
}