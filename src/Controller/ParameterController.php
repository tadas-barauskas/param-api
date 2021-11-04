<?php

namespace App\Controller;

use Predis\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParameterController extends AbstractController
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @Route("/parameter", name="parameter_list")
     */
    public function list(Request $request)
    {
        $key = 'filters';
        $key = $this->appendParameters($key, $request, 'param1');
        $key = $this->appendParameters($key, $request, 'param2');

        return new Response($this->client->get($key));
    }

    private function appendParameters(string $key, Request $request, string $name): string
    {
        if ($value = $request->query->get($name)) {
            $key = sprintf('%s:%s:%s', $key, $name, $value);
        }

        return $key;
    }
}
