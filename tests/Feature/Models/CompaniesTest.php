<?php

namespace Tests\Feature\Models;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompaniesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCompanies()
    {
        $companies = Company::factory()->count(3)->make();
        $this->assertEquals(3, $companies->count());
    }

    public function testCompaniesWithEmployee()
    {
        $companies = Company::factory()
            ->count(3)
            ->has(Employee::factory()->count(3))
            ->create();
        $this->assertEquals(9, count(Employee::all()));
    }
}
