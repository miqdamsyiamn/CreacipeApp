<?php

namespace Tests\Feature\Mail;

use Tests\TestCase;
use App\Mail\PasswordUpdatedMail;
use App\Models\User;

class PasswordUpdatedMailTest extends TestCase
{
    /**
     * Test the PasswordUpdatedMail builds correctly.
     */
    public function test_password_updated_mail_builds_correctly()
    {
        // Buat user sebagai objek
        $user = new User([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);

        $password = 'newpassword123';

        // Buat instance dari mail
        $mail = new PasswordUpdatedMail($user, $password);

        // Jalankan metode build untuk inisialisasi properti
        $mail->build();

        // Verifikasi properti email
        $this->assertEquals('noreply@creacipe.com', $mail->from[0]['address']);
        $this->assertEquals('Creacipe', $mail->from[0]['name']);
        $this->assertEquals('Password Anda Telah Diperbarui!', $mail->subject);

        // Render email dan pastikan data yang diharapkan muncul
        $rendered = $mail->render();
        $this->assertStringContainsString('John Doe', $rendered);
        $this->assertStringContainsString('newpassword123', $rendered);
    }
}
