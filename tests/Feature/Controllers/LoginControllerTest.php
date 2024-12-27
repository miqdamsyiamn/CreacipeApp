<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Anhskohbo\NoCaptcha\Facades\NoCaptcha;


class LoginControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_can_display_login_page()
    {
        $response = $this->get(route('login'));
        $response->assertStatus(200);
        $response->assertViewIs('home.home');
    }

    /** @test */
    public function it_can_login_successfully_with_valid_credentials()
    {
        NoCaptcha::shouldReceive('verifyResponse')
            ->andReturn(true);

        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'status_id' => 1,
        ]);

        $response = $this->post(route('login.post'), [
            'email' => 'user@example.com',
            'password' => 'password',
            'g-recaptcha-response' => 'dummy-response',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function it_fails_login_with_invalid_credentials()
    {
        NoCaptcha::shouldReceive('verifyResponse')
            ->andReturn(true);

        $response = $this->post(route('login.post'), [
            'email' => 'invaliduser@example.com',
            'password' => 'wrongpassword',
            'g-recaptcha-response' => 'dummy-response',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['login_error']);
        $this->assertGuest();
    }

    /** @test */
    public function it_handles_login_for_disabled_user()
    {
        NoCaptcha::shouldReceive('verifyResponse')
            ->andReturn(true);

        $user = User::factory()->create([
            'email' => 'disabled@example.com',
            'password' => bcrypt('password'),
            'status_id' => 2,
        ]);

        $response = $this->post(route('login.post'), [
            'email' => 'disabled@example.com',
            'password' => 'password',
            'g-recaptcha-response' => 'dummy-response',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['error' => 'Akun Anda telah dinonaktifkan.']);
        $this->assertGuest();
    }

    /** @test */
    public function it_logs_out_user_successfully()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('logout'));

        $response->assertRedirect(route('home'));
        $this->assertGuest();
    }

    /** @test */
    public function it_registers_a_new_user_successfully()
    {
        NoCaptcha::shouldReceive('verifyResponse')
            ->andReturn(true);

        $response = $this->post(route('register.post'), [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'g-recaptcha-response' => 'dummy-response',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('users', [
            'email' => 'testuser@example.com',
        ]);
    }

    /** @test */
    public function it_fails_registration_with_invalid_data()
    {
        NoCaptcha::shouldReceive('verifyResponse')
            ->andReturn(false);

        $response = $this->post(route('register.post'), [
            'name' => '', // Invalid name
            'email' => 'invalid-email', // Invalid email
            'password' => 'short', // Invalid password
            'password_confirmation' => 'mismatch', // Mismatched password confirmation
            'g-recaptcha-response' => '', // Missing reCAPTCHA
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors([
            'name',
            'email',
            'password',
            'g-recaptcha-response',
        ]);
    }

    /** @test */
    public function it_fails_login_due_to_validation_errors()
    {
        $response = $this->post(route('login.post'), [
            'email' => '', // Tidak mengirim email
            'password' => '', // Tidak mengirim password
            'g-recaptcha-response' => '', // Tidak mengirim captcha
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['email', 'password', 'g-recaptcha-response']);
        $this->assertGuest();
    }

    /** @test */
    public function it_prevents_login_for_inactive_user()
    {
        // Tambahkan mock reCAPTCHA
        NoCaptcha::shouldReceive('verifyResponse')->once()->andReturn(true);
        NoCaptcha::shouldReceive('getClientIp')->andReturn('127.0.0.1');

        // Buat user dengan status nonaktif
        $user = User::factory()->create([
            'email' => 'inactive@example.com',
            'password' => bcrypt('password'),
            'status_id' => 2, // Gunakan status_id = 2 sesuai data di database
        ]);

        // Kirim permintaan login
        $response = $this->post(route('login.post'), [
            'email' => 'inactive@example.com',
            'password' => 'password',
            'g-recaptcha-response' => 'dummy-response',
        ]);

        // Periksa bahwa user tidak dapat login
        $response->assertRedirect();
        $response->assertSessionHasErrors(['error' => 'Akun Anda telah dinonaktifkan.']);
        $this->assertGuest();
    }

    /** @test */
    public function it_redirects_user_based_on_role()
    {
        // Tambahkan mock reCAPTCHA
        NoCaptcha::shouldReceive('verifyResponse')->once()->andReturn(true);
        NoCaptcha::shouldReceive('getClientIp')->andReturn('127.0.0.1');

        // Buat admin user
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role_id' => 1,
            'status_id' => 1, // Pastikan status_id valid
        ]);

        $response = $this->post(route('login.post'), [
            'email' => 'admin@example.com',
            'password' => 'password',
            'g-recaptcha-response' => 'dummy-response',
        ]);

        $response->assertRedirect(route('admin.dashboard'));

        // Tambahkan mock reCAPTCHA untuk editor
        NoCaptcha::shouldReceive('verifyResponse')->once()->andReturn(true);

        // Buat editor user
        $editor = User::factory()->create([
            'email' => 'editor@example.com',
            'password' => bcrypt('password'),
            'role_id' => 2,
            'status_id' => 1, // Pastikan status_id valid
        ]);

        $response = $this->post(route('login.post'), [
            'email' => 'editor@example.com',
            'password' => 'password',
            'g-recaptcha-response' => 'dummy-response',
        ]);
        
        $response->assertRedirect(route('editor.dashboard'));
    }
}
