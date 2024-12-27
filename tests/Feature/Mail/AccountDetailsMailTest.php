<?php

namespace Tests\Feature\Mail;

use Tests\TestCase;
use App\Mail\AccountDetailsMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class AccountDetailsMailTest extends TestCase
{
    /**
     * Test if AccountDetailsMail is built correctly.
     */
    public function test_account_details_mail_is_built_correctly()
    {
        // Mock data
        $user = (object) [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
        ];
        $password = 'securepassword123';

        // Create the mail instance
        $mail = new AccountDetailsMail($user, $password);

        // Assert the sender and subject
        $this->assertEquals('noreply@creacipe.com', $mail->build()->from[0]['address']);
        $this->assertEquals('Creacipe', $mail->build()->from[0]['name']);
        $this->assertEquals('Detail Akun Anda', $mail->build()->subject);

        // Assert the view data
        $this->assertArrayHasKey('user', $mail->build()->viewData);
        $this->assertArrayHasKey('password', $mail->build()->viewData);
        $this->assertEquals($user, $mail->build()->viewData['user']);
        $this->assertEquals($password, $mail->build()->viewData['password']);

        // Assert the view name
        $this->assertEquals('Email.accountdetails', $mail->build()->view);
    }

    /**
     * Test if AccountDetailsMail is sent correctly.
     */
    public function test_account_details_mail_is_sent()
    {
        // Mock data
        $user = (object) [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
        ];
        $password = 'securepassword123';

        // Fake Mail
        Mail::fake();

        // Send the mail
        Mail::send(new AccountDetailsMail($user, $password));

        // Assert mail was sent
        Mail::assertSent(AccountDetailsMail::class, function ($mail) use ($user, $password) {
            return $mail->user->name === $user->name &&
                   $mail->user->email === $user->email &&
                   $mail->password === $password;
        });
    }
}
