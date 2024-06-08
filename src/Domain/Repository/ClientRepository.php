<?php

namespace Domain\Repository;


use Doctrine\ORM\AbstractQuery;
use Domain\Collections\ClientCollection;
use Domain\Collections\PortfolioCollection;
use Domain\DTO\ClientDTO;
use Domain\DTO\PortfolioDTO;
use Domain\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    /**
     * get all client in collection
     * @return ClientCollection
     */
    public function getAllClients(): ClientCollection
    {
        $clients = $this->createQueryBuilder('c')
            ->select('c,p')
            ->leftJoin('c.portfolios', 'p')
            ->getQuery()->getResult(AbstractQuery::HYDRATE_ARRAY);

        $clientsDTO = array_map(function ($client){
            $portfolioCollection = new PortfolioCollection();
            if (count($client['portfolios']) > 0) {
                $portfolioDTOs = array();
                foreach ($client['portfolios'] as $portfolio) {
                    $portfolioDTOs[] = new PortfolioDTO($portfolio['uidentifier'],$portfolio['name']);
                }
                $portfolioCollection->setPortfolioDTOCollection($portfolioDTOs) ;
            }
            return new ClientDTO($client['uidentifier'],$client['name'],$portfolioCollection);
        },$clients);

        return new ClientCollection($clientsDTO);
    }

    /**
     * @param $uidentifier
     * @return Client|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getClientEntityByUidentifier($uidentifier): ?Client
    {
        return $this->createQueryBuilder('c')
            ->select('c')
            ->where('c.uidentifier = :uid')
            ->setParameter('uid',$uidentifier)
            ->getQuery()->getOneOrNullResult();

    }
}