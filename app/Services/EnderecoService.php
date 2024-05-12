<?php

namespace App\Services;

use App\Repositories\EnderecoRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class EnderecoService
{
    private $client;
    private $uri;

    public function __construct() {
        $this->client = new Client();
        $this->uri = env('VIACEP_URL');
    }

    public function requestCep($cep) {
        $uri = explode('cep-exemplo' ,$this->uri);
        $uri = "{$uri[0]}{$cep}{$uri[1]}";
        try {
            $response = json_decode($this->client->request('GET', $uri)->getBody(),true);
            return $fields = [
                'cep' => str_replace('-','',$response['cep']),
                'logradouro' => $response['logradouro'],
                'bairro' => $response['bairro'],
                'municipio' => $response['localidade'],
                'uf' => $response['uf']
            ];
        } catch (GuzzleException $exception) {
            return response()->json(['errors' => ['message' => 'Erro ao requisitar serviço do VIACEP']], 503);
        }
    }
}
