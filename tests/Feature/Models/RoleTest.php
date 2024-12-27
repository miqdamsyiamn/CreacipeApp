<?php

namespace Tests\Feature\Models;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;

class RoleTest extends TestCase
{
    /**
     * Test Role model has the correct fillable attributes.
     */
    public function test_role_fillable_attributes()
    {
        $fillable = ['name'];

        $role = new Role();

        $this->assertEquals($fillable, $role->getFillable());
    }

    /**
     * Test Role model has many users.
     */
    public function test_role_has_many_users()
{
    // Buat role
    $role = Role::factory()->create();

    // Buat beberapa user dengan role_id yang sama secara manual
    $users = User::factory()->count(3)->create([
        'role_id' => $role->role_id, // Tetapkan role_id secara eksplisit
    ]);

    // Pastikan relasi role->users berfungsi dengan baik
    $this->assertCount(3, $role->users);

    foreach ($role->users as $user) {
        $this->assertEquals($role->role_id, $user->role_id);
    }
}

}
