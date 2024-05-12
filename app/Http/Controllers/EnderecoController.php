<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnderecoRequest;
use App\Http\Resources\EnderecoCollection;
use App\Http\Resources\EnderecoResource;
use App\Repositories\EnderecoRepository;
use App\Services\EnderecoService;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    private $enderecoRepository;

    public function __construct(EnderecoRepository $enderecoRepository) {
        $this->enderecoRepository  = $enderecoRepository;
    }

    /**
     * @OA\Get(
     *      path="/api/consultar-cep/{cep}",
     *      description="Retorna informações de um cep na base de dados através de um cep",
     *      tags={"GET Routes"},
     *      @OA\Parameter(
     *         description="Numero do CEP",
     *         name="cep",
     *         in="path",
     *         required=true,
     *         example="10100100",
     *         @OA\Schema(type="numeric")
     *      ),
     *      @OA\Response(response="200", description="Retorna endereço cadastrado na base"),
     *      @OA\Response(response="201", description="Retorna endereço que previamente não existia, porém adicionado ao consultar")
     * )
     */
    public function consultarCep(Request $request) {
        $result = $this->enderecoRepository->encontrarCep($request->cep);
        return new EnderecoResource($result);
    }

    /**
     * @OA\Get(
     *      path="/api/consultar-endereco/{endereco}",
     *      description="Retorna informações de um cep na base de dados através de um logradouro",
     *      tags={"GET Routes"},
     *      @OA\Parameter(
     *         description="Nome do logradouro",
     *         name="endereco",
     *         in="path",
     *         required=true,
     *         example="Rua josé matias",
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Response(response="200", description="Retorna uma lista de endereços cadastrados na base"),
     * )
     */
    public function consultarEndereco(Request $request) {
        $result = $this->enderecoRepository->encontrarEndereco($request->endereco);
        return new EnderecoCollection($result);
    }

    /**
     * @OA\Get(
     *      path="/api/consultar-uf/{uf}",
     *      description="Retorna informações de um cep na base de dados através de uma sigla",
     *      tags={"GET Routes"},
     *      @OA\Parameter(
     *         description="Sigla da Unidade Federal",
     *         name="uf",
     *         in="path",
     *         required=true,
     *         example="SP",
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Response(response="200", description="Retorna uma lista de endereços cadastrados na base"),
     * )
     */
    public function consultarUf(Request $request) {
        $result = $this->enderecoRepository->encontrarUf($request->uf);
        return new EnderecoCollection($result);
    }

    /**
     * @OA\Post(
     *     path="/api/cadastrar-cep",
     *     summary="Cadastra um novo cep",
     *     tags={"POST Routes"},
     *     @OA\Parameter(
     *         name="cep",
     *         in="query",
     *         description="Número identificador de endereço com 8 digitos",
     *         required=true,
     *         @OA\Schema(type="numeric")
     *     ),
     *     @OA\Parameter(
     *         name="logradouro",
     *         in="query",
     *         description="Nome da rua",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="bairro",
     *         in="query",
     *         description="Nome do bairro",
     *         required=true,
     *         @OA\Schema(type="numeric")
     *     ),
     *     @OA\Parameter(
     *          name="municipio",
     *          in="query",
     *          description="Nome do bairro",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *     @OA\Parameter(
     *          name="uf",
     *          in="query",
     *          description="Unidade Federal",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *     @OA\Response(response="201", description="Retorna endereço que foi cadastrado com sucesso"),
     *     @OA\Response(response="422", description="Erros de Validação")
     * )
     */
    public function cadastrar(EnderecoRequest $request) {
        $fields = [
            'cep' => $request->cep,
            'logradouro' => $request->logradouro,
            'bairro' => $request->bairro,
            'municipio' => $request->municipio,
            'uf' => $request->uf
        ];
        try {
            $result = $this->enderecoRepository->cadastrarEndereco($fields);
            return new EnderecoResource($result);
        } catch (\Exception $exception) {
            return response()->json(['errors' => ['message' => 'Erro interno ao tentar inserir no banco de dados']], 500);
        }
    }

    /**
     * @OA\Put (
     *     path="/api/editar-cep",
     *     summary="Edita um cep já existente na base",
     *     tags={"PUT Routes"},
     *     @OA\Parameter(
     *         name="cep",
     *         in="query",
     *         description="Número identificador de endereço com 8 digitos",
     *         required=true,
     *         @OA\Schema(type="numeric")
     *     ),
     *     @OA\Parameter(
     *         name="logradouro",
     *         in="query",
     *         description="Nome da rua",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="bairro",
     *         in="query",
     *         description="Nome do bairro",
     *         required=true,
     *         @OA\Schema(type="numeric")
     *     ),
     *     @OA\Parameter(
     *          name="municipio",
     *          in="query",
     *          description="Nome do bairro",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *     @OA\Parameter(
     *          name="uf",
     *          in="query",
     *          description="Unidade Federal",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *     @OA\Response(response="200", description="Retorna endereço que foi editado com sucesso"),
     *     @OA\Response(response="422", description="Erros de Validação")
     * )
     */
    public function editar(EnderecoRequest $request) {
        $fields = [
            'cep' => $request->cep,
            'logradouro' => $request->logradouro,
            'bairro' => $request->bairro,
            'municipio' => $request->municipio,
            'uf' => $request->uf
        ];
        try {
            $result = $this->enderecoRepository->editarEndereco($fields);
            return new EnderecoResource($result);
        } catch (\Exception $exception) {
            return response()->json(['errors' => ['message' => 'Erro interno ao tentar editar no banco de dados']], 500);
        }
    }
}
