<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordUpdatedMail;

class ProfileControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected function authenticateUser()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        return $user;
    }

    /** @test */
    public function it_can_display_user_profile()
    {
        $user = $this->authenticateUser();

        $response = $this->get(route('profile.showprofile'));

        $response->assertStatus(200);
        $response->assertViewIs('profile.showprofile');
        $response->assertViewHas('user', $user);
    }

    /** @test */
    public function it_can_display_edit_profile_form()
    {
        $user = $this->authenticateUser();

        $response = $this->get(route('profile.edit'));

        $response->assertStatus(200);
        $response->assertViewIs('profile.edit');
        $response->assertViewHas('user', $user);
    }

    /** @test */
    public function it_can_update_user_profile()
    {
        $user = $this->authenticateUser();

        Storage::fake('public');

        $file = UploadedFile::fake()->image('profile_picture.jpg');

        $data = [
            'bio' => 'Updated bio',
            'profile_picture' => $file,
        ];

        $response = $this->put(route('profile.update'), $data);

        $response->assertRedirect(route('profile.showprofile'));
        $response->assertSessionHas('success', 'Profil berhasil diperbarui.');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'bio' => 'Updated bio',
        ]);

        Storage::disk('public')->assertExists('assets/upload/' . $file->hashName());
    }

    /** @test */
    public function it_can_display_change_password_form()
    {
        $this->authenticateUser();

        $response = $this->get(route('password.change'));

        $response->assertStatus(200);
        $response->assertViewIs('profile.changepassword');
    }

    /** @test */
    public function it_can_update_password_successfully()
    {
        Mail::fake();

        $user = $this->authenticateUser();

        $data = [
            'current_password' => 'password',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ];

        $response = $this->post(route('password.update'), $data);

        $response->assertRedirect(route('profile.showprofile'));
        $response->assertSessionHas('success', 'Password berhasil diperbarui.');

        $this->assertTrue(Hash::check('newpassword', $user->fresh()->password));

        Mail::assertSent(PasswordUpdatedMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    /** @test */
    public function it_fails_to_update_password_with_invalid_current_password()
    {
        $this->authenticateUser();

        $data = [
            'current_password' => 'wrongpassword',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ];

        $response = $this->post(route('password.update'), $data);

        $response->assertSessionHasErrors(['current_password']);
    }
}
