<?php

namespace Tests\Feature;

use App\Models\Condition;
use App\Models\Item;
use App\Models\PaymentMethod;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    protected $testItem;
    protected $testMethod;
    protected $buyer;

    protected function setUp(): void
    {
        parent::setUp();

        //adminロール、adminユーザーの作成
        Role::create(['name' => 'admin']);
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        //テスト用データの作成
        $seller = User::factory()->create();
        $testCondition = Condition::create([
            'condition' => 'Test Condition',
        ]);
        $this->testItem = Item::factory()->create([
            'seller_id' => $seller->id,
            'condition_id' => $testCondition->id,
        ]);
        $this->testMethod = PaymentMethod::create([
            'method' => 'Test Payment Method',
        ]);

        //購入者の作成
        $this->buyer = User::factory()->create();
    }

    public function test_show_purchase_page()
    {
        $this->actingAs($this->buyer);

        session(['method_id' =>$this->testMethod->id]);

        $response = $this->get(route('purchase.index', ['item_id' => $this->testItem->id]));

        $response->assertOk();
        $response->assertViewIs('purchase');

        $response->assertViewHas('item', $this->testItem);
        $response->assertViewHas('user', $this->buyer);
        $response->assertViewHas('method', $this->testMethod);

        $this->assertEquals(session('item_id'), $this->testItem->id);
        $this->assertEquals(session('transaction_data' . $this->buyer->id), [
            'item_id' => $this->testItem->id,
            'buyer_id' => $this->buyer->id,
            'method_id' => $this->testMethod->id,
        ]);
    }

    public function test_show_purchase_update_address_page()
    {
        //buyerユーザーのProfile作成
        Profile::create([
            'user_id' => $this->buyer->id,
            'postcode' => '123-4567',
            'address' => 'Test Address',
            'building' => 'Test Building',
        ]);

        $this->actingAs($this->buyer);

        $response = $this->get(route('purchase.address'));

        $response->assertOk();
        $response->assertViewIs('purchase_address');

        $response->assertViewHas('profile', function ($profile) {
            return $profile->postcode === '123-4567'
                &&
                $profile->address === 'Test Address'
                &&
                $profile->building === 'Test Building';
        });
    }

    public function test_update_purchase_address()
    {
        Profile::create([
            'user_id' => $this->buyer->id,
            'postcode' => '123-4567',
            'address' => 'Test Old Address',
            'building' => 'Test Old Building',
        ]);

        $this->actingAs($this->buyer);

        session(['item_id' => $this->testItem->id]);

        $testNewProfile = [
            'postcode' => '890-1234',
            'address' => 'Test New Address',
            'building' => 'Test New Building',
        ];

        $response = $this->post(route('purchase.address.update'), $testNewProfile);

        $this->assertDatabaseHas('profiles', [
            'user_id' => $this->buyer->id,
            'postcode' => '890-1234',
            'address' => 'Test New Address',
            'building' => 'Test New Building',
        ]);

        $response->assertRedirect(route('purchase.index', ['item_id' => $this->testItem->id]));
    }

    public function test_add_purchase_address()
    {
        $this->assertDatabaseMissing('profiles', [
            'user_id' => $this->buyer->id,
        ]);

        $this->actingAs($this->buyer);

        session(['item_id' => $this->testItem->id]);

        $testNewProfile = [
            'postcode' => '8901234',
            'address' => 'Test New Address',
            'building' => 'Test New Building',
        ];

        $response = $this->post(route('purchase.address.update'), $testNewProfile);

        $this->assertDatabaseHas('profiles', [
            'user_id' => $this->buyer->id,
            'postcode' => '890-1234',
            'address' => 'Test New Address',
            'building' => 'Test New Building',
        ]);

        $response->assertRedirect(route('purchase.index', ['item_id' => $this->testItem->id]));
    }

    public function test_show_select_payment_method_page()
    {
        $this->actingAs($this->buyer);

        $response = $this->get(route('payment.method'));

        $response->assertOk();
        $response->assertViewIs('payments.method_selection');

        $response->assertViewHas('paymentMethods', function ($methods) {
            return $methods->contains($this->testMethod);
        });
    }

    public function test_store_payment_method_in_session()
    {
        $this->actingAs($this->buyer);

        session(['item_id' => $this->testItem->id]);

        $selectedMethod = [
            'method_id' => $this->testMethod->id,
        ];

        $response = $this->post(route('payment.method.select'), $selectedMethod);

        $this->assertEquals(session('method_id'), $this->testMethod->id);

        $response->assertRedirect(route('purchase.index', ['item_id' => $this->testItem->id]));
    }

    public function test_stripe_without_profile()
    {
        $this->actingAs($this->buyer);

        $response = $this->post(route('payment.stripe'));

        $response->assertRedirect(route('purchase.address'));
    }

    public function test_payment_success()
    {
        $this->actingAs($this->buyer);

        $response = $this->get(route('payment.success'));

        $response->assertOk();
        $response->assertViewIs('payments.credit_success');
    }

    public function test_payment_failed()
    {
        $this->actingAs($this->buyer);

        $response = $this->get(route('payment.failed'));

        $response->assertOk();
        $response->assertViewIs('payments.credit_failed');
    }
}
