<?php

namespace Tests;

use App\Models\Endereco;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function createEndereco(array $options = []) {
        return Endereco::factory()->create($options);
    }
}
