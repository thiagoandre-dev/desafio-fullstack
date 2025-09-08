<?php

use App\Models\Nivel;

test('Listagem de níveis', function () {
    // Inicialmente não há níveis
    $response = $this->get('/api/niveis');
    $response->assertStatus(404);

    // Após criar um nível, ele deve aparecer na listagem
    $this->post('/api/niveis', ['nivel' => 'Nível Teste']);
    $response = $this->get('/api/niveis');
    $response->assertStatus(200);

    // Verifica a estrutura do JSON retornado
    $response->assertJsonStructure([
        'data' => [
            '*' => ['id', 'nivel', 'created_at', 'updated_at'],
        ],
        'meta' => ['total', 'per_page', 'current_page', 'last_page'],
    ]);
});

test('Criação de nível', function () {
    $response = $this->post('/api/niveis', ['nivel' => 'Nível Teste']);

    $response->assertStatus(201);

    $this->assertDatabaseHas('niveis', [
        'nivel' => 'Nível Teste',
    ]);
});

test('Atualização de nível', function () {
    $this->post('/api/niveis', ['nivel' => 'Nível Teste']);

    $nivel = Nivel::query()->where('nivel', 'Nível Teste')->first();

    $response = $this->put("/api/niveis/{$nivel->id}", [
        'nivel' => 'Nível Teste Atualizado',
    ]);

    $response->assertStatus(200);

    $response->assertJsonFragment(['nivel' => 'Nível Teste Atualizado']);
});

test('Exclusão de nível', function () {
    $this->post('/api/niveis', ['nivel' => 'Nível Teste']);

    $nivel = Nivel::query()->where('nivel', 'Nível Teste')->first();

    $response = $this->delete("/api/niveis/{$nivel->id}");

    $response->assertStatus(204);

    $this->assertDatabaseMissing('niveis', ['id' => $nivel->id]);
});

test('Exclusão de nível com desenvolvedor associado', function () {
    $this->post('/api/niveis', ['nivel' => 'Nível Teste']);

    $nivel = Nivel::query()->where('nivel', 'Nível Teste')->first();

    // Cria um desenvolvedor associado a esse nível
    $this->post('/api/desenvolvedores', [
        'nome' => 'Dev Teste',
        'sexo' => 'M',
        'hobby' => 'Programar',
        'data_nascimento' => '1990-01-01',
        'nivel_id' => $nivel->id,
    ]);

    $response = $this->delete("/api/niveis/{$nivel->id}");

    $response->assertStatus(400);

    $response->assertJsonFragment(['message' => 'Não é possível excluir um nível que possui desenvolvedores associados']);
});
