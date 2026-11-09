<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DemoSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_creates_demo_accounts_and_dozens_of_records(): void
    {
        $this->seed();

        $this->assertTrue(User::firstWhere('email', 'admin@portal.test')->hasRole('admin'));
        $this->assertTrue(User::firstWhere('email', 'staf@portal.test')->hasRole('staf'));
        $this->assertCount(0, User::firstWhere('email', 'user@portal.test')->roles);
        $this->assertNotNull(User::firstWhere('email', 'admin@portal.test')->email_verified_at);

        $this->assertDatabaseCount('departemens', 5);
        $this->assertDatabaseCount('mahasiswas', 60);
        $this->assertDatabaseCount('dosens', 20);
        $this->assertDatabaseCount('tugas', 30);
    }
}
