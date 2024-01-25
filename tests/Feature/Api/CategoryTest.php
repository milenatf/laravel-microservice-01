<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    protected $endpoint = '/categories';

    /**
     * Get all categories
     */
    public function test_get_all_categories(): void
    {
        Category::Factory()->count(6)->create();

        $response = $this->getJson($this->endpoint);
        $response->assertJsonCount(6, 'data');
        $response->assertStatus(200);
    }

    /**
     * Error get single category
     */
    public function test_error_get_single_category(): void
    {
        $category = 'fake-url';

        $response = $this->getJson("{$this->endpoint}/{$category}");

        $response->assertStatus(404);
    }

    /**
     * Get single category
     */
    public function test_get_single_category(): void
    {
        $category = Category::factory()->create();

        $response = $this->getJson("{$this->endpoint}/{$category->url}");

        $response->assertStatus(200);
    }

    /**
     * Validation Store Category
     */
    public function test_validation_store_category(): void
    {
        $response = $this->postJson($this->endpoint, [
            'title'  => '',
            'description' => ''
        ]);

        $response->dump();

        $response->assertStatus(422); // Erro de validação
    }

    /**
     * Store Category
     */
    public function test_store_category(): void
    {
        $response = $this->postJson($this->endpoint, [
            'title'  => 'Category test',
            'description' => 'Description of category test'
        ]);

        $response->dump();

        $response->assertStatus(201); // Status Code created
    }

    /**
     * Update Category
     */
    public function test_update_category(): void
    {
        // Cria uma categoria (que será editada neste teste) através da factory
        $category = Category::factory()->create();

        $data = [
            'title' => 'Title update',
            'description' => 'Description update'
        ];

        // Faz a validação para saber se a url é inválida
        $response = $this->putJson("$this->endpoint/fake-category", $data);
        $response->assertStatus(404);

        // Passa valores inválidos dos dados
        $response = $this->putJson("$this->endpoint/{$category->url}", []);
        $response->assertStatus(422);

        // Editar a categoria que existe
        $response = $this->putJson("$this->endpoint/{$category->url}", $data);
        $response->assertStatus(200);
    }

    /**
     * Delete Category
     */
    public function test_delete_category(): void
    {
        // Cria uma categoria (que será deletada neste teste) através da factory
        $category = Category::factory()->create();

        // Deletar uma categoria que não existe
        $response = $this->deleteJson("$this->endpoint/fake-category");
        $response->assertStatus(404);

        $response = $this->deleteJson("$this->endpoint/{$category->url}");
        $response->assertStatus(204);
    }
}
