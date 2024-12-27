<?php

namespace Tests\Feature\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Status;

class UserTest extends TestCase
{
    /**
     * Test user model has the correct fillable attributes.
     */
    public function test_user_fillable_attributes()
    {
        $fillable = [
            'name',
            'email',
            'role_id',
            'status_id',
            'password',
            'bio',
            'profile_picture',
        ];

        $this->assertEquals($fillable, (new User())->getFillable());
    }

    /**
     * Test user belongs to a role.
     */
    public function test_user_belongs_to_role()
    {
        $role = Role::factory()->create();
        $user = User::factory()->create(['role_id' => $role->role_id]);

        $this->assertEquals($role->role_id, $user->role->role_id);
        $this->assertInstanceOf(Role::class, $user->role);
    }

    /**
     * Test user belongs to a status.
     */
    public function test_user_belongs_to_status()
    {
        $status = Status::factory()->create();
        $user = User::factory()->create(['status_id' => $status->status_id]);

        $this->assertEquals($status->status_id, $user->status->status_id);
        $this->assertInstanceOf(Status::class, $user->status);
    }
}
