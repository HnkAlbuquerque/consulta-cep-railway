<?php

namespace App\Repositories;

use App\Exceptions\SQLException;
use App\Models\Endereco;
use App\Services\EnderecoService;
use Illuminate\Support\Facades\DB;

class EnderecoRepository
{
    private $enderecoService;

    public function __construct(EnderecoService $enderecoService) {
        $this->enderecoService = $enderecoService;
    }
    public function encontrarCep($cep) {
        try {
            $result = Endereco::where('cep', $cep)->first();
            if(!isset($result)) {
                $fields = $this->enderecoService->requestCep($cep);
                $result = $this->cadastrarEndereco($fields);
            }
            return $result;
        } catch (\Exception $exception) {
            throw new SQLException('Erro ao consultar banco de dados', 500);
        }
    }

    public function encontrarEndereco($logradouro) {
        try {
            return Endereco::where('logradouro', 'like', "%{$logradouro}%")->get();
        } catch (\Exception $exception) {
            throw new SQLException('Erro ao consultar banco de dados', 500);
        }
    }

    public function encontrarUf($uf) {
        try {
            return Endereco::where('uf', $uf)->get();
        } catch (\Exception $exception) {
            throw new SQLException('Erro ao consultar banco de dados', 500);
        }
    }

    public function cadastrarEndereco($fields) {
        return DB::transaction(function () use($fields) {
            return Endereco::create($fields);
        });
    }

    public function editarEndereco($fields) {
        return DB::transaction(function () use($fields) {
            Endereco::where('cep', $fields['cep'])->update($fields);
            return Endereco::where('cep', $fields['cep'])->first();
        });
    }
}
