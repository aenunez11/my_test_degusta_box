<?php

namespace App\Controller;


use Domain\Entity\Portfolio;
use Domain\Services\ClientService;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends AbstractController
{
    /** @var ClientService */
    private $clientService;

    /**
     * ClientController constructor.
     * @param ClientService $clientService
     */
    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }


    /**
     * Get all clients
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAllClients()
    {
        $clientCollection = $this->clientService->getAllClients();
        return $this->render('clients/index.html.twig',[
            'clientCollection' => $clientCollection
        ]);
    }

    /**
     * Show client
     * @param $uidentifier
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getShowClient($uidentifier)
    {
        $clientDTO = $this->clientService->getClientByUidentifier($uidentifier);
        if (is_null($clientDTO)) {
            throw new NotFoundHttpException();
        }

        return $this->render('clients/show.html.twig',[
            'clientDTO' => $clientDTO
        ]);
    }

    /**
     * Updating client
     * @param $uidentifier
     * @param Request $request
     * @return RedirectResponse
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getUpdateClient($uidentifier,Request $request)
    {
        $parameters =  $request->request->all();

        $client = $this->clientService->processUpdatingClient($uidentifier,$parameters);
        if (is_null($client)) {
            throw new RuntimeException("client not exit");
        }
        return $this->redirectToRoute('list_clients');
    }


    /**
     * Deleting client
     * @param $uidentifier
     * @return RedirectResponse
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getDeleteClient($uidentifier)
    {

        $client = $this->clientService->processDeletingClient($uidentifier);
        if (is_null($client)) {
            throw new RuntimeException("client not exit");
        }
        return $this->redirectToRoute('list_clients');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createClient()
    {
        return $this->render('clients/create.html.twig');
    }

    /**
     * saving creation client
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function saveCreateClient(Request $request)
    {
        $parameters =  $request->request->all();
        $client = $this->clientService->processCreateClient($parameters);
        if (is_null($client)) {
            throw new RuntimeException("Error saving data client");
        }
        return $this->redirectToRoute('list_clients');
    }

    /**
     * Show portfolios by client
     * @param $uidentifier
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getShowPortfolioByClient($uidentifier)
    {
        $clientDTO = $this->clientService->getClientByUidentifier($uidentifier);
        if (is_null($clientDTO)) {
            throw new NotFoundHttpException();
        }

        return $this->render('portfolios/index.html.twig',[
            'clientDTO' => $clientDTO
        ]);
    }

    /**
     * @param Request $request
     * @param $uidentifier
     * @return Response
     */
    public function getCreatePortfolioByClient(Request $request, $uidentifier): Response
    {

        $parameters = $this->getPostParameters($request);

        $portfolio = $this->clientService->processCreatePortfolioByClient($uidentifier,$parameters);
        if (is_null($portfolio)) {
            throw new \RuntimeException("client not found");
        }
        return $this->returnJsonAjaxResponse(['success' => true]);
    }

    /**
     * @param Request $request
     * @param $uidentifier
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getCreateOrderByPortfolio(Request $request, $uidentifier): Response
    {

        $parameters = $this->getPostParameters($request);
        $order = $this->clientService->processCreateOrderByPortfolio($uidentifier,$parameters);
        if (is_null($order)) {
            throw new \RuntimeException("Portfolio not found");
        }
        return $this->returnJsonAjaxResponse(['success' => true]);
    }

    /**
     * Deleting Portfolio
     * @param $uidentifier
     * @return RedirectResponse
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getDeletePortfolio($uidentifier)
    {
        /** @var Portfolio $portfolio */
        $portfolio = $this->clientService->processDeletingPortfolio($uidentifier);
        if (is_null($portfolio)) {
            throw new RuntimeException("Portfolio not exit");
        }
        return $this->redirectToRoute('show_client_portfolios',['uidentifier' => $portfolio->getClient()->getUidentifier()]);
    }


    /**
     * Return response for ajax request in json
     * @param $value
     * @return Response
     */
    protected function returnJsonAjaxResponse($value): Response
    {
        $response = new Response();
        $response->setContent(json_encode($value, JSON_THROW_ON_ERROR));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * Get Post Parameters
     * @param Request $request
     * @param string|null $parameterName
     * @param mixed|null $default
     * @param bool $emptyToNull
     * @return array|mixed|null (if the value does not exist)
     */
    protected function getPostParameters(Request $request, ?string $parameterName = null, $default = null, bool $emptyToNull = false)
    {
        if (is_null($parameterName)) {
            return $request->request->all();
        }
        $result = $request->get($parameterName, $default);
        if ($emptyToNull && empty($result)) {
            return null;
        }
        return $result;
    }
}