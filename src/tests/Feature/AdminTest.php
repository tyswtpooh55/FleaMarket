<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    protected $admin;
    protected $user1;
    protected $user2;

    protected function setUp(): void
    {
        parent::setUp();

        Role::create([
            'name' => 'admin',
        ]);

        $this->admin = User::create([
            'email' => 'admin@example.com',
            'password' => bcrypt('admin-pass'),
        ]);

        $this->admin->assignRole('admin');

        $this->actingAs($this->admin);

        $this->user1 = User::create([
            'email' => 'test1@example.com',
            'password' => bcrypt('pass1234'),
        ]);
        $this->user2 = User::create([
            'email' => 'test2@example.com',
            'password' => bcrypt('pass1234'),
        ]);
    }

    public function test_show_admin_top_page()
    {
        $response = $this->get(route('admin.index'));

        $response->assertOk();
        $response->assertViewIs('admin.index');
    }

    public function test_show_manage_users_page()
    {
        $response = $this->get(route('admin.users'));

        $response->assertOk();
        $response->assertViewIs('admin.user_management');

        $response->assertViewHas('users', function ($users) {
            return $users->count() === 2 && $users->contains('id', $this->user1->id) && $users->contains('id', $this->user2->id);
        });
    }

    public function test_delete_users()
    {
        $this->assertDatabaseHas('users', ['id' => $this->user1->id]);

        $response = $this->post(route('admin.delete.user', ['user_id' => $this->user1->id]), [], ['HTTP_REFERER' => route('admin.users')]);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.users'));
        $this->assertDatabaseMissing('users', ['id' => $this->user1->id]);
    }

    public function test_show_writing_email_page()
    {
        $response = $this->get(route('admin.write.email'));

        $response->assertOk();
        $response->assertViewIs('admin.email');
        $response->assertSeeLivewire('email-recipients-select');
    }

    public function test_send_email()
    {
        Mail::fake();

        $emailData = [
            'recipients' => "{$this->user1->id},{$this->user2->id}",
            'subject' => 'Test Subject',
            'message' => 'Test Message',
        ];

        $response = $this->post(route('admin.send.email'), $emailData);

        $response->assertStatus(302);
        $response->assertSessionHas('success', 'メールを送信しました');
    }
}
