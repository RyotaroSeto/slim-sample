<?php

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class SampleAction {

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(Request $request, Response $response, $args)
    {

        $test_data = $this->getApi();

        $payload = json_encode($test_data);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    private function getApi(): string|false
    {
        $url = 'https://umayadia-apisample.azurewebsites.net/api/persons';

        // ストリームコンテキストのオプションを作成
        $options = array(
            // HTTPコンテキストオプションをセット
            'http' => array(
                'method'=> 'GET',
                'header'=> 'Content-type: application/json; charset=UTF-8' //JSON形式で表示
            )
        );

        // ストリームコンテキストの作成
        $context = stream_context_create($options);

        $response_data = file_get_contents($url, false,$context);
        return $response_data;
    }
}
