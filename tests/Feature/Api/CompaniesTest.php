<?php

namespace Tests\Feature\Api;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CompaniesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(User::factory()->create(),
            ['*']
        );

    }

    public function testRequiredFieldForCompany(): void
    {
        $response = $this->json('POST', '/api/v1/companies', ['Accept' => 'application/json']);
        $response->assertStatus(422);
    }

    public function testSuccessfulCompanyCreateWithoutLogo(): void
    {

        $data = [
            'name' => 'ABC International',
            'email' => 'abcd@test.com',
            'website' => 'http://www.test.com',
        ];

        $response = $this->json('POST', '/api/v1/companies', $data, ['Accept' => 'application/json']);
        $response->assertStatus(201);
    }

    public function testDeleteCompany(): void
    {

        $company = Company::factory()->create();
        $response = $this->json('DELETE', '/api/v1/companies/' . $company->id, ['Accept' => 'application/json']);
        $response->assertStatus(204);
    }

    public function testShowCompanyInformation(): void
    {

        $company = Company::factory()->create([
            'name' => 'ABC International',
            'email' => 'abcd2@test.com',
            'website' => 'http://www.test.com',
            'logo' => null,
        ]);

        $response = $this->json('GET', '/api/v1/companies/' . $company->id, ['Accept' => 'application/json']);
        $response->assertStatus(200)
            ->assertJson([
                "data" => [
                    "id" => 3,
                    "name" => "ABC International",
                    "logo" => null,
                    "email" => "abcd2@test.com",
                    "website" => "http://www.test.com",
                ],
            ]);
    }

    public function testCreateCompanyWithInvalidLogoDimension(): void
    {

        $data = [
            'name' => 'ABC International',
            'email' => 'abcd@test.com',
            'website' => 'http://www.test.com',
            'company_logo' => UploadedFile::fake()->image('avatar.jpg', 95, 90),
        ];

        $response = $this->json('POST', '/api/v1/companies', $data, ['Accept' => 'application/json']);
        $response->assertStatus(422);
    }

    public function testCreateCompanyWithLogo(): void
    {

        $data = [
            'name' => 'ABC International',
            'email' => 'abcd@test.com',
            'website' => 'http://www.test.com',
            'company_logo' => UploadedFile::fake()->image('avatar.jpg', 100, 100),
        ];

        $response = $this->json('POST', '/api/v1/companies', $data, ['Accept' => 'application/json']);
        $response->assertStatus(201);

        $companyId = $response->json()['data'];
        $location = storage_path('app/public/logo/' . $companyId['id'] . '-abc-international.jpg');
        $this->assertTrue(file_exists($location));
        unlink($location);
    }

}