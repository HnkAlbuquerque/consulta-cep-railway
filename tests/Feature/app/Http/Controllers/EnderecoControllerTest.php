<?php

namespace tests\Feature\app\Http\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EnderecoControllerTest extends TestCase
{

    use RefreshDatabase;

    public function testCadastrarNovoCep()
    {
        $payload = [
            'cep' => '12235200',
            'logradouro' => 'Logradouro Teste',
            'bairro' => 'Bairro Teste',
            'municipio' => 'Municipio Teste',
            'uf' => 'UF'
        ];
        $response = $this->post(route('cadastrar'), $payload);
        $response->assertStatus(201);
        $response->assertJson([
            'cep' => '12235200',
            'logradouro' => 'Logradouro Teste',
            'bairro' => 'Bairro Teste',
            'municipio' => 'Municipio Teste',
            'uf' => 'UF'
        ], 201);
    }

    public function testCepRequestValidation()
    {
        $payload = [
            'cep' => '1223520',
            'logradouro' => 'Logradouro Teste',
            'bairro' => 'Bairro Teste',
            'municipio' => 'Municipio Teste',
            'uf' => 'UF'
        ];
        $response = $this->post(route('cadastrar'), $payload);
        $response->assertStatus(422);
        $response->assertJson([
            'errors' => [
                "cep" => ["Cep deve ter no mínimo 8 dígitos"],
            ],
        ], 422);
    }

    public function testConsultarCep()
    {
        $this->createEndereco(['cep' => '11111111']);
        $response = $this->get('api/consultar-cep/11111111');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'cep' => '11111111',
        ]);
    }

    public function testConsultarCepNaoExistenteNaBaseDeDadosLocal()
    {
        $response = $this->get('api/consultar-cep/13181796');
        $response->assertStatus(201);
        $response->assertJsonFragment([
            'cep' => '13181796',
            "logradouro" => "Rua Rozendo Alves de Souza",
        ]);
    }

    public function testEditarCepExistente()
    {
        $this->createEndereco(['cep' => '10100100','logradouro' => 'Rua Teste']);
        $payload = [
            'cep' => '10100100',
            'logradouro' => 'Logradouro Alterado',
            'bairro' => 'Bairro Teste',
            'municipio' => 'Municipio Teste',
            'uf' => 'UF'
        ];
        $response = $this->put(route('editar'), $payload);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'cep' => '10100100',
            'logradouro' => 'Logradouro Alterado',
        ]);
    }
}
