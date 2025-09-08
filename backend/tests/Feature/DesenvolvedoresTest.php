<?php

use App\Models\Desenvolvedor;
use App\Models\Nivel;

test('Listagem de desenvolvedores', function () {
    // Inicialmente não há desenvolvedores
    $response = $this->get('/api/desenvolvedores');
    $response->assertStatus(404);

    // Após criar um desenvolvedor, ele deve aparecer na listagem
    $this->post('/api/desenvolvedores', [
        'nome' => 'Dev Teste',
        'sexo' => 'M',
        'hobby' => 'Programar',
        'data_nascimento' => '1990-01-01',
        'nivel_id' => Nivel::create(['nivel' => 'Nível Teste'])->id,
    ]);
    $response = $this->get('/api/desenvolvedores');
    $response->assertStatus(200);

    // Verifica a estrutura do JSON retornado
    $response->assertJsonStructure([
        'data' => [
            '*' => [
                'id', 'nivel_id', 'nome', 'sexo', 'hobby', 'data_nascimento', 'created_at', 'updated_at',
                'nivel' => ['id', 'nivel'],
            ],
        ],
        'meta' => ['total', 'per_page', 'current_page', 'last_page'],
    ]);
});

test('Criação de desenvolvedor', function () {
    $response = $this->post('/api/desenvolvedores', [
        'nome' => 'Dev Teste',
        'sexo' => 'M',
        'hobby' => 'Programar',
        'data_nascimento' => '1990-01-01',
        'nivel_id' => Nivel::create(['nivel' => 'Nível Teste'])->id,
    ]);

    $response->assertStatus(201);

    $this->assertDatabaseHas('desenvolvedores', [
        'nome' => 'Dev Teste',
        'sexo' => 'M',
        'hobby' => 'Programar',
        'data_nascimento' => '1990-01-01',
    ]);
});

test('Criação de desenvolvedor com dados inválidos', function () {
    $response = $this->post('/api/desenvolvedores', [
        'nome' => 'Dev Teste',
        'sexo' => 'X', // Sexo inválido
        'hobby' => 'Programar',
        'data_nascimento' => '2990-01-01', // Data no futuro
        'nivel_id' => 9999, // Nível inexistente
    ]);

    $response->assertStatus(422);

    $response->assertJsonValidationErrors(['sexo', 'nivel_id', 'data_nascimento']);
});

test('Atualização de no nível', function () {
    $this->post('/api/desenvolvedores', [
        'nome' => 'Dev Teste',
        'nivel_id' => Nivel::create(['nivel' => 'Nível Teste'])->id,
        'sexo' => 'M',
        'hobby' => 'Programar',
        'data_nascimento' => '1990-01-01',
    ]);

    $desenvolvedor = Desenvolvedor::query()->where('nome', 'Dev Teste')->first();

    $response = $this->put("/api/desenvolvedores/{$desenvolvedor->id}", [
        'nome' => 'Dev Teste Atualizado',
        'nivel_id' => $desenvolvedor->nivel_id,
        'sexo' => 'M',
        'hobby' => 'Programar',
        'data_nascimento' => '1990-01-01',
    ]);

    $response->assertStatus(200);

    $response->assertJsonFragment(['nome' => 'Dev Teste Atualizado']);
});

test('Exclusão de desenvolvedor', function () {
    $this->post('/api/desenvolvedores', [
        'nome' => 'Dev Teste',
        'nivel_id' => Nivel::create(['nivel' => 'Nível Teste'])->id,
        'sexo' => 'M',
        'hobby' => 'Programar',
        'data_nascimento' => '1990-01-01',
    ]);

    $desenvolvedor = Desenvolvedor::query()->where('nome', 'Dev Teste')->first();

    $response = $this->delete("/api/desenvolvedores/{$desenvolvedor->id}");

    $response->assertStatus(204);

    $this->assertDatabaseMissing('desenvolvedores', ['id' => $desenvolvedor->id]);
});