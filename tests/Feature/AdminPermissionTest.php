<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class AdminPermissionTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_AdminCanViewAdminsListWithPermission()
    {
        $admin = User::factory()->create();

        $adminRole = Role::create(['name' => 'admin']);
        $viewAdminsPermission = Permission::create(['name' => 'view.admins']);

        $admin->roles()->attach($adminRole);
        $admin->permissions()->attach($viewAdminsPermission);

        $this->actingAs($admin, 'admin');

        $response = $this->get('/admin/ViewAdmins');
        $response->assertStatus(200);
    }

    public function test_AdminCannotViewAdminsListWithPermission()
    {
        $admin = User::factory()->create();

        $adminRole = Role::create(['name' => 'admin']);

        $admin->roles()->attach($adminRole);

        $this->actingAs($admin, 'admin');

        $response = $this->get('/admin/ViewAdmins');

        $response->assertStatus(403);
    }

    public function test_AdminCanViewUsersListWithPermission()
    {
        $admin = User::factory()->create();

        $adminRole = Role::create(['name' => 'admin']);
        $viewAdminsPermission = Permission::create(['name' => 'view.all.users']);

        $admin->roles()->attach($adminRole);
        $admin->permissions()->attach($viewAdminsPermission);

        $this->actingAs($admin, 'admin');

        $response = $this->get('/admin/ViewUsers');

        $response->assertStatus(200);
    }

    public function test_AdminCannnotViewUsersListWithPermission()
    {
        $admin = User::factory()->create();

        $adminRole = Role::create(['name' => 'admin']);

        $admin->roles()->attach($adminRole);

        $this->actingAs($admin, 'admin');

        $response = $this->get('/admin/ViewUsers');

        $response->assertStatus(403);
    }

    public function test_AdminCannnotViewUsersListWithOtherPermission()
    {
        $admin = User::factory()->create();

        $adminRole = Role::create(['name' => 'admin']);
        $viewAdminsPermission = Permission::create(['name' => 'view.admins']);

        $admin->roles()->attach($adminRole);
        $admin->permissions()->attach($viewAdminsPermission);

        $this->actingAs($admin, 'admin');

        $response = $this->get('/admin/ViewUsers');

        $response->assertStatus(403);
    }

}
