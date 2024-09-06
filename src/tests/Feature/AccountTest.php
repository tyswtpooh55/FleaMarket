<?php

namespace Tests\Feature;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

     //テスト用共通

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        //テスト用ユーザーの作成
        /** @var User $user */
        $this->user = User::create([
            'email' => 'test@example.com',
            'password' => bcrypt('pass1234'),
        ]);

        // ユーザーの認証
        $this->actingAs($this->user);
    }

    public function test_show_mypage()
    {

        $response = $this->get('/mypage');  // /mypage へのGETリクエストをシミュレート

        $response->assertOk();  // ステータスコードが200か
        $response->assertViewIs('mypage');  // Viewが正しいか
        $response->assertViewHas('user', function($viewUser) {
            return $viewUser->id === $this->user->id;
        });     // Viewに返される'user'が正しいか
        $response->assertSeeLivewire('mypage');
    }

    public function test_show_profile_edit_page()
    {

        $response = $this->get('/mypage/profile');  // /mypage/profile へのGETリクエストをシミュレート

        $response->assertOk();  // ステータスコードが200か
        $response->assertViewIs('mypage_profile');  //View が正しいか
        $response->assertViewHas('user', $this->user);
        $response->assertViewHas('profile', $this->user->profile);
    }

    public function test_update_profile_with_new_profile()
    {
        // 作成する新しいプロフィール情報
        $testImg = UploadedFile::fake()->image('test_image.png');

        $newData = [
            'name' => 'new name',
            'postcode' => '1234567',
            'address' => 'new address',
            'building' => 'new building',
            'imgUrl' => $testImg,
        ];

        Storage::fake('public');    // ストレージをテスト用仮想ストレージに

        $response = $this->post(route('mypage.profile.update'), $newData);


        $response->assertRedirect(route('mypage.index'));   // リダイレクト先が正しいか

        // UsersTableの更新が正しくできているか
        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'name' => 'new name',
            'img_url' => '/images/profile/' . $testImg->hashName(),
        ]);

        // ProfilesTableに$userのデータが存在しない場合、新規作成されるか
        $this->assertDatabaseHas('profiles', [
            'user_id' => $this->user->id,
            'postcode' => '123-4567',
            'address' => 'new address',
            'building' => 'new building',
        ]);
    }

    public function test_update_profile_with_existing_profile()
    {
        // 既存のProfileを作成
        Profile::create([
            'user_id' => $this->user->id,
            'postcode' => '123-4567',
            'address' => 'existing address',
            'building' => 'existing building',
        ]);

        // 更新するプロフィール情報
        $testImg = UploadedFile::fake()->image('test_img.png');

        $newData = [
            'name' => 'new name',
            'postcode' => '8901234',
            'address' => 'new address',
            'building' => 'new building',
            'imgUrl' => $testImg,
        ];

        // ストレージをテスト用仮想ストレージに
        Storage::fake('public');

        $response = $this->post(route('mypage.profile.update'), $newData);

        // リダイレクト先が正しいか
        $response->assertRedirect(route('mypage.index'));

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'name' => 'new name',
            'img_url' => '/images/profile/' . $testImg->hashName(),
        ]);

        $this->assertDatabaseHas('profiles', [
            'user_id' => $this->user->id,
            'postcode' => '890-1234',
            'address' => 'new Address',
            'building' => 'new building',
        ]);
    }
}
