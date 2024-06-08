<?php

namespace Domain\Services;


use Doctrine\ORM\EntityManagerInterface;
use Domain\Collections\PortfolioCollection;
use Domain\DTO\ClientDTO;
use Domain\DTO\PortfolioDTO;
use Domain\Entity\Allocation;
use Domain\Entity\Client;
use Domain\Entity\Order;
use Domain\Entity\Portfolio;
use Domain\Repository\ClientRepository;
use Domain\Repository\PortfolioRepository;
use Symfony\Component\Uid\Uuid;

class ClientService
{

    /** @var ClientRepository */
    private $clientRepository;
    /** @var PortfolioRepository */
    private $portfolioRepository;
    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * ClientService constructor.
     * @param ClientRepository $clientRepository
     * @param PortfolioRepository $portfolioRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(ClientRepository $clientRepository, PortfolioRepository  $portfolioRepository,EntityManagerInterface $entityManager)
    {
        $this->clientRepository = $clientRepository;
        $this->portfolioRepository = $portfolioRepository;
        $this->entityManager = $entityManager;
    }


    /**
     * get all client in collection
     * @return \Domain\Collections\ClientCollection
     */
    public function getAllClients()
    {
        return $this->clientRepository->getAllClients();
    }


    /**
     * get client DTO by uidentifier
     * @param string $uidentifier
     * @return ClientDTO|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getClientByUidentifier(string $uidentifier): ?ClientDTO
    {
        /** @var Client $client */
        $client = $this->clientRepository->getClientEntityByUidentifier($uidentifier);
        if (empty($client)) {
            return null;
        }
        $portfolioColletion = new PortfolioCollection();
        if (count($client->getPortfolios()) > 0 ) {
            $portfolioDTOs = array();
            /** @var Portfolio $portfolio */
            foreach ($client->getPortfolios() as $portfolio) {

                $portfolioDTOs[] = new PortfolioDTO($portfolio->getUidentifier(),$portfolio->getName(),$portfolio->getAllocations());
            }
            $portfolioColletion->setPortfolioDTOCollection($portfolioDTOs) ;
        }

        return new ClientDTO($uidentifier,$client->getName(),$portfolioColletion);
    }

    /**
     * Processing update client data
     * @param string $uidentifier
     * @param array $parameters
     * @return \Domain\Entity\Client|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function processUpdatingClient(string $uidentifier,array $parameters)
    {
        $client = $this->clientRepository->getClientEntityByUidentifier($uidentifier);

        if (is_null($client) || empty($parameters)){
            return null;
        }

        $client->setName($parameters['name']);

        $this->entityManager->persist($client);
        $this->entityManager->flush();

        return $client;
    }

    /**
     * Processing delete client
     * @param string $uidentifier
     * @return \Domain\Entity\Client|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function processDeletingClient(string $uidentifier)
    {
        $client = $this->clientRepository->getClientEntityByUidentifier($uidentifier);
        if (is_null($client)){
            return null;
        }

        //deleting portfolios
        /** @var Portfolio $portfolio */
        foreach ($client->getPortfolios() as $portfolio){
            $this->processDeletingPortfolio($portfolio->getUidentifier());
        }

        $this->entityManager->remove($client);
        $this->entityManager->flush();

        return $client;
    }

    /**
     * Processing creation new client
     * @param array $parameters
     * @return \Domain\Entity\Client|null
     */
    public function processCreateClient(array $parameters)
    {
        if (empty($parameters)){
            return null;
        }
        $client = new Client();
        $client->setUidentifier(Uuid::v4());
        $client->setName($parameters['name']);
        $this->entityManager->persist($client);
        $this->entityManager->flush();
        return $client;
    }

    public function processCreatePortfolioByClient(string $uidentifier,array $parameters)
    {
        $client = $this->clientRepository->getClientEntityByUidentifier($uidentifier);
        if (is_null($client)){
            return null;
        }

        $portfolio = new Portfolio();
        $portfolio->setName($parameters['name']);
        $portfolio->setUidentifier(Uuid::v4());
        $portfolio->setClient($client);
        $this->entityManager->persist($portfolio);
        $this->entityManager->flush();

        if (isset($parameters['allocations']) && count($parameters['allocations'])){
            foreach ($parameters['allocations'] as $shares) {
                if (!empty($shares)) {
                    $this->createAllocation($portfolio,$shares);
                }
            }
        }

        return $portfolio;

    }


    /**
     * @param Portfolio $portfolio
     * @param int $shares
     * @return Allocation
     */
    public function  createAllocation(Portfolio $portfolio,int $shares)
    {
        $allocation = new Allocation();
        $allocation->setPortfolio($portfolio);
        $allocation->setShares($shares);

        $this->entityManager->persist($allocation);
        $this->entityManager->flush();
        return $allocation;
    }

    /**
     * @param $uidentifier
     * @param array $parameters
     * @return null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function processCreateOrderByPortfolio($uidentifier,array $parameters)
    {
        $portfolio = $this->portfolioRepository->getPortfolioEntityByUidentifier($uidentifier);
        if (is_null($portfolio)){
            return null;
        }
        $allocationId = null;
        if (!empty($parameters['allocation_id'])) {
            /** @var Allocation $allocation */
            $allocation = $this->entityManager->getRepository(Allocation::class)->findOneBy([
                'id' => $parameters['allocation_id']
            ]);
            if (!empty($allocation)){
                $allocationId = $allocation->getId();
            }
        }

        $order = new Order();
        $order->setPortfolio($portfolio);
        $order->setType($parameters['order_type']);
        $order->setShares($parameters['allocation_shares']);
        $order->setAllocationId($allocationId);
        $this->entityManager->persist($order);
        $this->entityManager->flush();

        $this->processOrderCompleted($order);

        return $order;
    }

    function processOrderCompleted(Order $order)
    {

        /** @var Allocation $allocation */
        $allocation = $this->entityManager->getRepository(Allocation::class)->findOneBy([
            'id' => $order->getAllocationId()
        ]);

        if ($order->getType() === 'buy') {
            if (!empty($allocation)) {
                $allocation->setShares($allocation->getShares() + $order->getShares());
                $this->entityManager->persist($allocation);
                $this->entityManager->flush();
            } else {
                $allocation=$this->createAllocation($order->getPortfolio(),$order->getShares());
                $order->setAllocationId($allocation->getId());
            }
        } else if ($order->getType() === 'sell') {
            if (!is_null($allocation) && $allocation->getShares() >= $order->getShares()) {
                $allocation->setShares($allocation->getShares() - $order->getShares());
                $this->entityManager->persist($allocation);
                if ($allocation->getShares() === 0) {
                    $this->entityManager->remove($allocation);
                }
                $this->entityManager->flush();
            } else {
                throw new \Exception('Cantidad insuficiente para vender.');
            }
        }
        $order->setCompletedAt(new \DateTime());
        $this->entityManager->persist($order);
        $this->entityManager->flush();
        return $order;
    }

    /**
     * Processing delete Portfolio
     * @param string $uidentifier
     * @return Portfolio|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function processDeletingPortfolio(string $uidentifier)
    {
        $portfolio = $this->portfolioRepository->getPortfolioEntityByUidentifier($uidentifier);
        if (is_null($portfolio)){
            return null;
        }
        //deleting order
        $orders = $this->entityManager->getRepository(Order::class)->findBy([
            'portfolio' => $portfolio
        ]);
        if (!empty($orders)) {
            foreach ($orders as $order) {
                $this->entityManager->remove($order);
            }
        }

        //deleting allocations
        foreach ($portfolio->getAllocations() as $allocation){
            $this->entityManager->remove($allocation);
        }

        $this->entityManager->remove($portfolio);
        $this->entityManager->flush();

        return $portfolio;
    }
}