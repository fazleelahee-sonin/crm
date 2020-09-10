<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CompanyLogoTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(User::factory()->create(),
            ['*']
        );

    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testComapnyLogo()
    {
        $data = [
            'name' => 'ABC International',
            'email' => 'abcd@test.com',
            'website' => 'http://www.test.com',
            'company_logo' => UploadedFile::fake()->image('avatar.jpg', 100, 100),
        ];

        $response = $this->json('POST', '/api/v1/companies', $data, ['Accept' => 'application/json']);
        $response->assertStatus(201);

        $company = Company::find($response->json()['data']['id']);
        $response = $this->get($company->logo);
        $response->assertStatus(200);
        $this->assertEquals($response->headers->get('content-type'), 'image/jpeg');

        $location = storage_path('app/public' . $company->logo);

        if (file_exists($location)) {
            unlink($location);
        }
    }
}