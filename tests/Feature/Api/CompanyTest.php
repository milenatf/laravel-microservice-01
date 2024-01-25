<?php

namespace Tests\Feature\Api;

use App\Models\Company;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    protected $endpoint = '/companies';

    /**
     * Get all company
     */
    public function test_get_all_companies(): void
    {
        Company::Factory()->count(6)->create();

        $response = $this->getJson($this->endpoint);
        $response->assertJsonCount(6, 'data');
        $response->assertStatus(200);
    }

    /**
     * Error get single company
     */
    public function test_error_get_single_company(): void
    {
        $company = 'fake-uuid';

        $response = $this->getJson("{$this->endpoint}/{$company}");

        $response->assertStatus(404);
    }

    /**
     * Get single company
     */
    public function test_get_single_company(): void
    {
        $company = Company::factory()->create();

        $response = $this->getJson("{$this->endpoint}/{$company->uuid}");

        $response->assertStatus(200);
    }

    /**
     * Validation Store company
     */
    public function test_validation_store_company(): void
    {
        $response = $this->postJson($this->endpoint, [
            'name' => '',
            'whatsapp' => '',
            'email' => '',
            'phone' => '',
            'facebook' => '',
            'instagram' => '',
            'youtube' => '',
        ]);

        $response->dump();

        $response->assertStatus(422); // Erro de validação
    }

    /**
     * Store company
     */
    public function test_store_company(): void
    {
        $category = Category::factory()->create();

        $response = $this->postJson($this->endpoint, [
            'category_id' => $category->id,
            'name' => 'Especializa TI',
            'email' => 'contato@mail.com',
            'whatsapp' => '91987654321'
        ]);

        $response->assertStatus(201); // Status Code created
    }

    /**
     * Update Category
     */
    public function test_update_ccompany(): void
    {
        // Cria uma compania (que será editada neste teste) através da factory
        $company = Company::factory()->create();
        $category = Category::factory()->create();

        $data = [
            'category_id' => $category->id,
            'name' => 'companhia 03',
            'whatsapp' => '91326547891',
            'email' => 'companhia03@mail.com',
        ];

        // Faz a validação para saber se a url é inválida
        $response = $this->putJson("$this->endpoint/fake-company", $data);
        $response->assertStatus(404);

        // Passa valores inválidos dos dados
        $response = $this->putJson("$this->endpoint/{$company->uuid}", []);
        $response->assertStatus(422);

        // Editar a company que existe
        $response = $this->putJson("$this->endpoint/{$company->uuid}", $data);
        $response->assertStatus(200);
    }

    /**
     * Delete Category
     */
    public function test_delete_company(): void
    {
        // Cria uma categoria (que será deletada neste teste) através da factory
        $company = Company::factory()->create();

        // Deletar uma categoria que não existe
        $response = $this->deleteJson("$this->endpoint/fake-company");
        $response->assertStatus(404);

        $response = $this->deleteJson("$this->endpoint/{$company->uuid}");
        $response->assertStatus(204);
    }
}
