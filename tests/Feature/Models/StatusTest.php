<?php

namespace Tests\Feature\Models;

use Tests\TestCase;
use App\Models\Status;
use App\Models\User;

class StatusTest extends TestCase
{
    /**
     * Test Status model has the correct fillable attributes.
     */
    public function test_status_fillable_attributes()
    {
        $fillable = ['name'];
        $status = new Status();

        $this->assertEquals($fillable, $status->getFillable());
    }

    /**
     * Test Status has many users relationship.
     */
    public function test_status_has_many_users()
    {
        // Create a Status
        $status = Status::factory()->create();

        // Create related users
        User::factory()->count(3)->create([
            'status_id' => $status->status_id,
        ]);

        // Verify the relationship
        $this->assertCount(3, $status->users);

        foreach ($status->users as $user) {
            $this->assertEquals($status->status_id, $user->status_id);
        }
    }
}
