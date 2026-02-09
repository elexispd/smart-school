<?php

namespace Tests\Feature;

use App\Models\School;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MultiTenancyTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_are_scoped_by_school()
    {
        $school1 = School::create(['name' => 'School 1', 'slug' => 'school-1']);
        $school2 = School::create(['name' => 'School 2', 'slug' => 'school-2']);

        $user1 = User::factory()->create(['school_id' => $school1->id, 'role' => 'student', 'email' => 'u1@s1.com']);
        $user2 = User::factory()->create(['school_id' => $school2->id, 'role' => 'student', 'email' => 'u2@s2.com']);
        $admin1 = User::factory()->create(['school_id' => $school1->id, 'role' => 'admin', 'email' => 'admin@s1.com']);

        // Login as Admin 1
        $this->actingAs($admin1);

        // Should see user1, but NOT user2
        $this->assertNotNull(User::find($user1->id));
        $this->assertNull(User::find($user2->id));
        
        // Count check: admin1 + user1 = 2
        $this->assertEquals(2, User::count()); 
    }

    public function test_super_admin_can_see_all()
    {
        $school1 = School::create(['name' => 'School 1', 'slug' => 'school-1']);
        $school2 = School::create(['name' => 'School 2', 'slug' => 'school-2']);

        $user1 = User::factory()->create(['school_id' => $school1->id]);
        $user2 = User::factory()->create(['school_id' => $school2->id]);
        $superAdmin = User::factory()->create(['role' => 'super_admin', 'school_id' => null]);

        $this->actingAs($superAdmin);

        $this->assertEquals(3, User::count());
    }
}
