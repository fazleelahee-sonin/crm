<?php

namespace Tests\Feature\Api;

use App\Models\Company;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class EmployeesTest extends TestCase
{
    use RefreshDatabase;

    protected $company;
    protected $endpoint;

    public function setUp(): void
    {
        parent::setUp();
        Sanctum::actingAs(User::factory()->create(),
            ['*']
        );

        $this->company = Company::factory()->create();
        $this->endpoint = '/api/v1/employees';
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testAddNewEmployeeWithRequiredField(): void
    {
        $response = $this->json('POST', $this->endpoint, ['Accept' => 'application/json']);
        $response->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "first_name" => [
                        0 => "The first name field is required.",
                    ],
                    "last_name" => [
                        0 => "The last name field is required.",
                    ],
                ],
            ]);
    }

    public function testAddNewEmployeeSuccess(): void
    {
        $data = [
            'first_name' => 'Fazle',
            'last_name' => 'Elahee',
            'email' => 'felahee@gmail.com',
            'phone' => '+447415352423',
            'company_id' => $this->company->id,
        ];

        //$this->company->employees()->save(new Employee($data));

        $response = $this->json('POST', $this->endpoint, $data, ['Accept' => 'application/json']);
        $response->assertStatus(201);
    }

    public function testShowEmployeeDetails(): void
    {
        $data = [
            'first_name' => 'Fazle',
            'last_name' => 'Elahee',
            'email' => 'fazle.elahee@gmail.com',
            'phone' => '+447415352423',
        ];

        $employee = $this->company->employees()->save(new Employee($data));

        $endpoint = $this->endpoint . '/' . $employee->id;

        $response = $this->json('GET', $endpoint, ['Accept' => 'application/json']);
        $response->assertStatus(200);

        $this->assertContains('fazle.elahee@gmail.com', $response->json()['data']);
    }

    public function testUpdateEmployeeDetails(): void
    {
        $data = [
            'first_name' => 'Steve',
            'last_name' => 'Roger',
            'email' => 'steve.roger@captin-america.com',
            'phone' => '+1 456 8978 9876',

        ];

        $employee = $this->company->employees()->save(new Employee($data));

        $endpoint = $this->endpoint . '/' . $employee->id;

        $updatedData = [
            'first_name' => 'Captin',
            'last_name' => 'America',
            'company_id' => $this->company->id,
        ];

        $response = $this->json('PUT', $endpoint, $updatedData, ['Accept' => 'application/json']);
        $response->assertStatus(204);

        $employee = Employee::find($employee->id);

        //to make sure first name has been updated
        $this->assertEquals($employee->first_name, 'Captin');

        //to make sure other information not been modified.
        $this->assertEquals($employee->phone, '+1 456 8978 9876');
    }

    public function testDeleteEmployeeDetails(): void
    {
        $data = [
            'first_name' => 'Steve',
            'last_name' => 'Roger',
            'email' => 'info@captin-america.com',
            'phone' => '+1 456 8978 9876',
        ];

        $employee = $this->company->employees()->save(new Employee($data));

        $endpoint = $this->endpoint . '/' . $employee->id;
        $response = $this->json('DELETE', $endpoint, ['Accept' => 'application/json']);
        $response->assertStatus(204);

        //to make sure its deleted from the database
        $employee = Employee::find($employee->id);
        $this->assertIsNotObject($employee, "Employee not been deleted");
    }

}