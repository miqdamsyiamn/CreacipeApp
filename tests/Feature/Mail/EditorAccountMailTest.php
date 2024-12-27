<?php

namespace Tests\Feature\Mail;

use Tests\TestCase;
use App\Mail\EditorAccountMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class EditorAccountMailTest extends TestCase
{
    /**
     * Test the EditorAccountMail builds correctly.
     */
    public function test_editor_account_mail_builds_correctly()
    {
        // Buat user sebagai objek
        $user = new User([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);

        $password = 'password123';

        // Buat instance dari mail
        $mail = new EditorAccountMail($user, $password);

        // Jalankan metode build untuk inisialisasi properti
        $mail->build();

        // Verifikasi properti email
        $this->assertEquals('noreply@creacipe.com', $mail->from[0]['address']);
        $this->assertEquals('Creacipe', $mail->from[0]['name']);
        $this->assertEquals('Detail Akun Editor Anda', $mail->subject);

        // Render email dan pastikan data yang diharapkan muncul
        $rendered = $mail->render();
        $this->assertStringContainsString('John Doe', $rendered);
        $this->assertStringContainsString('password123', $rendered);
    }
}
