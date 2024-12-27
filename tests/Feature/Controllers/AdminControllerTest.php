<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;

class AdminControllerTest extends TestCase
{
  use DatabaseTransactions;

  protected function setUp(): void
  {
    parent::setUp();

    // Tambahkan data awal untuk roles dan status
    DB::table('roles')->insertOrIgnore([
      ['role_id' => 1, 'name' => 'Admin'],
      ['role_id' => 2, 'name' => 'Editor'],
      ['role_id' => 3, 'name' => 'Member'],
    ]);

    DB::table('status')->insertOrIgnore([
      ['status_id' => 1, 'name' => 'Aktif'],
      ['status_id' => 2, 'name' => 'Nonaktif'],
    ]);
  }

  protected function authenticateAdmin()
  {
    // Autentikasi sebagai Admin
    $admin = User::factory()->create([
      'role_id' => 1,
      'status_id' => 1,
    ]);
    $this->actingAs($admin);
  }

  /** @test */
  public function it_can_display_editors_list()
  {
    $this->authenticateAdmin();

    // Buat beberapa editor
    User::factory()->count(5)->create(['role_id' => 2, 'status_id' => 1]);

    $response = $this->get(route('admin.editors'));

    $response->assertStatus(200);
    $response->assertViewIs('dashboard.admin.editor');
    $response->assertViewHas('editors');
  }

  /** @test */
  public function it_can_store_a_new_editor()
  {
    Mail::fake();
    $this->authenticateAdmin();

    $data = [
      'name' => 'Editor Baru',
      'email' => 'editor@example.com',
      'password' => 'password',
      'password_confirmation' => 'password',
    ];

    $response = $this->post(route('admin.editors.store'), $data);

    $response->assertRedirect(route('admin.editors'));
    $response->assertSessionHas('success', 'Editor berhasil ditambahkan dan detail akun dikirim ke email.');

    $this->assertDatabaseHas('users', [
      'email' => 'editor@example.com',
      'role_id' => 2,
    ]);

    Mail::assertSent(\App\Mail\EditorAccountMail::class);
  }

  /** @test */
  public function it_can_delete_an_editor()
  {
    $this->authenticateAdmin();

    // Buat data editor
    $editor = User::factory()->create(['role_id' => 2, 'status_id' => 1]);

    // Hapus editor
    $response = $this->delete(route('admin.editors.delete', $editor->user_id));

    // Periksa redirect
    $response->assertRedirect(route('admin.editors'));
    $response->assertSessionHas('success', 'Editor berhasil dihapus.');

    // Periksa bahwa editor sudah dihapus dari database
    $this->assertDatabaseMissing('users', ['id' => $editor->user_id]);
  }


  /** @test */
  public function it_can_toggle_an_editor_status()
  {
    $this->authenticateAdmin();

    // Buat data editor
    $editor = User::factory()->create(['role_id' => 2, 'status_id' => 1]);

    // Toggle status
    $response = $this->patch(route('admin.editors.toggle', $editor->user_id));

    // Periksa redirect
    $response->assertRedirect(route('admin.editors'));
    $response->assertSessionHas('success', 'Status berhasil diperbarui.');

    // Periksa bahwa status_id berubah
    $this->assertEquals(2, $editor->fresh()->status_id);
  }


  /** @test */
  public function it_can_display_members_list()
  {
    $this->authenticateAdmin();

    // Buat beberapa member
    User::factory()->count(5)->create(['role_id' => 3, 'status_id' => 1]);

    $response = $this->get(route('admin.members'));

    $response->assertStatus(200);
    $response->assertViewIs('dashboard.admin.member');
    $response->assertViewHas('members');
  }

  /** @test */
  public function it_can_delete_a_member()
  {
    $this->authenticateAdmin();

    // Buat data member
    $member = User::factory()->create(['role_id' => 3, 'status_id' => 1]);

    // Hapus member
    $response = $this->delete(route('admin.members.delete', $member->user_id));

    // Periksa redirect
    $response->assertRedirect(route('admin.members'));
    $response->assertSessionHas('success', 'Member berhasil dihapus.');

    // Periksa bahwa member sudah dihapus dari database
    $this->assertDatabaseMissing('users', ['users' => $member->user_id]);
  }
}
