<?php


namespace Domain\Collections;


use Domain\DTO\ClientDTO;

class ClientCollection
{

    /**
     * @var ClientDTO[]
     */
    private $clientDTOCollection;

    /**
     * ClientCollection constructor.
     * @param array $clientDTOCollection
     */
    public function __construct(array $clientDTOCollection)
    {
        $this->clientDTOCollection = $clientDTOCollection;
    }

    /**
     * @return ClientDTO[]
     */
    public function getClientDTOCollection(): array
    {
        return $this->clientDTOCollection;
    }

    public function getTotalClientsWithPortfolios()
    {
        $count = 0;
        foreach ($this->clientDTOCollection as $clientDTO){
            if (count($clientDTO->getPortfolios())>0){
                $count++;
            }
        }
        return $count;
    }

    public  function getTotalClients()
    {
        return count($this->clientDTOCollection);
    }

}