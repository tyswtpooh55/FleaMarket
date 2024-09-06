<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Condition;
use App\Models\Item;
use App\Models\ItemImage;
use App\Models\Like;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ItemTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    protected $testCategory;
    protected $exampleCategory;
    protected $testCondition;
    protected $testItem;

    protected function setUp(): void
    {
        parent::setUp();

        $seller = User::factory()->create();

        Role::create(['name' => 'admin']);
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->testCategory = Category::create([
            'name' => 'Test Category',
        ]);

        $this->exampleCategory = Category::create([
            'name' => 'Example Category',
        ]);

        $this->testCondition = Condition::create([
            'condition' => 'Test Condition',
        ]);

        $exampleCondition = Condition::create([
            'condition' => 'Example Condition',
        ]);

        $this->testItem = Item::create([
            'name' => 'Test Item',
            'brand' => 'Test Brand',
            'price' => 10000,
            'description' => 'Test Description',
            'seller_id' => $seller->id,
            'condition_id' => $this->testCondition->id,
        ]);

        $this->testItem->categories()->attach($this->testCategory);

        $exampleItem = Item::create([
            'name' => 'Example Item',
            'brand' => 'Example Brand',
            'price' => 12000,
            'description' => 'Example Description',
            'seller_id' => $seller->id,
            'condition_id' => $exampleCondition->id,
        ]);

        $exampleItem->categories()->attach($this->exampleCategory);
    }

    public function test_show_item_index()
    {
        $response = $this->get('/');    // トップページへのGETリクエストをシミュレート

        $response->assertOk();  // ステータスコードが200か
        $response->assertViewIs('index');   // Viewが正しいか
        $response->assertSeeLivewire('item-list');
    }

    //Livewire item-list

    public function test_search_with_empty_keyword()
    {

        $response = $this->get('/item/search');     // キーワードなしでの検索をシミュレート

        $response->assertOk();  // ステータスコードが200か
        $response->assertViewIs('search_items');    // Viewが正しいか
        $response->assertViewHas('searchItems', function ($items) {
            return $items->count() === Item::count();
        });     // キーワードなしの検索結果数がitems総数と等しいか
    }

    public function test_search_by_item_name()
    {
        $response = $this->get('/item/search?search=Test Item');     // キーワードTest Itemの検索結果をシミュレート

        $response->assertOk();      // ステータスコードが200か
        $response->assertViewHas('searchItems', function ($items) {
            return $items->contains('name', 'Test Item');   // 検索結果の商品のnameカラムにTest Itemが含まれるか
        });
    }

    public function test_search_by_item_brand()
    {
        $response = $this->get('/item/search?search=Test Brand');   // キーワードTest Brandの検索結果をシミュレート

        $response->assertOk();      // ステータスコードが200か
        $response->assertViewHas('searchItems', function ($items) {
            return $items->contains('brand', 'Test Brand');    // 検索結果の商品のbrandカラムにTest Brandが含まれるか
        });
    }

    public function test_search_by_category()
    {
        $response = $this->get('/item/search?search=Test Category');

        $response->assertOk();    // ステータスコードが200か
        $response->assertViewHas('searchItems', function ($items) {
            return $items->first()->categories->contains('name', 'Test Category');
        });
    }

    public function test_search_by_condition()
    {
        $response = $this->get('/item/search?search=Test Condition');

        $response->assertOk();
        $response->assertViewHas('searchItems', function ($items) {
            return $items->first()->condition->condition === 'Test Condition';
        });
    }

    public function test_search_by_description()
    {
        $response = $this->get('/item/search?search=Test Description');

        $response->assertOk();
        $response->assertViewHas('searchItems', function ($items) {
            return $items->contains('description', 'Test Description');
        });
    }

    public function test_show_sell_page_with_user()
    {
        /** @var User $user */
        $user = User::factory()->create();     //ログイン済みユーザー作成
        $response = $this->actingAs($user)->get('/item/sell');    //ログイン状態をシミュレート

        $response->assertOk();    //ステータスコードが200か
        $response->assertViewIs('sell');    //Viewが正しいか
        $response->assertSeeLivewire('item-img');   //LivewireコンポーネントがViewに含まれているか
        $response->assertSeeLivewire('select-categories');
    }

    public function test_show_sell_page_with_guest()
    {
        $response = $this->get('/item/sell');   //未ログインユーザーが/sellにアクセス

        $response->assertRedirect('/login');    //ログインページにリダイレクトされるか
    }

    public function test_sale_item()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        Storage::fake('public');

        $testItemImg = [UploadedFile::fake()->image('test-item.png')];

        //リクエストデータ
        $data = [
            'img_url' => $testItemImg,
            'name' => 'Sell Test Item',
            'brand' => 'Sell Test Brand',
            'category_id_1' => $this->testCategory->id,
            'category_id_2' => $this->exampleCategory->id,
            'price' => 15000,
            'description' => 'Sell Test Description',
            'seller_id' => $user->id,
            'condition_id' => $this->testCondition->id,
        ];

        $response = $this->post(route('sale'), $data);  //リクエストを送信
        $response->assertRedirect(route('index'));    //リダイレクトを確認

        //アイテムがデータベースに保存されているか
        $this->assertDatabaseHas('items', [
            'name' => 'Sell Test Item',
            'brand' => 'Sell Test Brand',
            'price' => 15000,
            'description' => 'Sell Test Description',
            'seller_id' => $user->id,
            'condition_id' => $this->testCondition->id,
        ]);

        $item = Item::where('name', 'Sell Test Item')->first();
        //画像がデータベースに保存されているか
        $this->assertDatabaseHas('item_images', [
            'item_id' => $item->id,
            'img_url' => '/images/items/' . $testItemImg[0]->hashName(),
        ]);

        //カテゴリーが中間テーブルに保存されているか
        $this->assertDatabaseHas('category_item', [
            'item_id' => $item->id,
            'category_id' => $this->testCategory->id,
        ]);
        $this->assertDatabaseHas('category_item', [
            'item_id' => $item->id,
            'category_id' => $this->exampleCategory->id,
        ]);
    }

    public function test_show_item_detail_with_guest()
    {
        $itemImages = ItemImage::factory()->count(3)->create([
            'item_id' => $this->testItem->id,
        ]); //商品の画像の作成

        Like::factory()->count(5)->create([
            'item_id' => $this->testItem->id,
        ]);  //商品に関連するいいねの作成
        Comment::factory()->count(2)->create([
            'item_id' => $this->testItem->id,
        ]); //商品のコメントの作成

        $response = $this->get(route('item', ['item_id' => $this->testItem->id]));

        $response->assertOk();
        $response->assertViewIs('item');
        $response->assertViewHas('item', $this->testItem);
        $response->assertViewHas('itemImages', $this->testItem->itemImages);

        if ($itemImages->count() > 1) {
            $response->assertSeeLivewire('image-carousel');
        }
        $response->assertDontSeeLivewire('like-toggle');
        $response->assertViewHas('countLikes', 5);
        $response->assertViewHas('countComments', 2);
    }

    public function test_show_item_detail_with_user()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('item', ['item_id' => $this->testItem->id]));
        $response->assertSeeLivewire('like-toggle');
    }

    public function test_show_comment_page()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $itemImages = ItemImage::factory()->count(3)->create([
            'item_id' => $this->testItem->id,
        ]);
        $likes = Like::factory()->count(5)->create([
            'item_id' => $this->testItem->id,
        ]);
        $comments = Comment::factory()->count(2)->create([
            'item_id' => $this->testItem->id,
        ]);

        $response = $this->get(route('comment', ['item_id' => $this->testItem->id]));

        $response->assertOk();
        $response->assertViewIs('comment');
        $response->assertViewHas('item', $this->testItem);
        $response->assertViewHas('itemImages', $this->testItem->itemImages);

        if ($itemImages->count() > 1) {
            $response->assertSeeLivewire('image-carousel');
        }

        $response->assertSeeLivewire('like-toggle');
        $response->assertViewHas('countLikes', 5);
        $response->assertViewHas('countComments', 2);
        $response->assertViewHas('comments', function ($viewComments) use ($comments) {
            $expectedIds = $comments->pluck('id')->sort()->values()->all();
            $actualIds = $viewComments->pluck('id')->sort()->values()->all();
            return $expectedIds === $actualIds;
        });
    }

    public function test_create_comment()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $testComment = [
            'comment' => 'This is a Test Comment',
        ];

        $response = $this->post(route('comment.create', ['item_id' => $this->testItem->id]), $testComment, ['HTTP_REFERER' => route('comment', ['item_id' => $this->testItem->id])]);

        $response->assertStatus(302);
        $response->assertRedirect(route('comment', ['item_id' => $this->testItem->id]));

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $this->testItem->id,
            'comment' => 'This is a Test Comment',
        ]);
    }

    public function test_delete_comment()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $testComment = Comment::create([
            'user_id' => $user->id,
            'item_id' => $this->testItem->id,
            'comment' => 'This is a Test Comment',
        ]);

        $response = $this->post(route('comment.delete', ['comment_id' => $testComment->id]), [], ['HTTP_REFERER' => route('comment', ['item_id' => $this->testItem->id])]);

        $response->assertStatus(302);
        $response->assertRedirect(route('comment', ['item_id' => $this->testItem->id]));
        $this->assertDatabaseMissing('comments', [
            'id' => $testComment->id,
            'user_id' => $user->id,
            'item_id' => $this->testItem->id,
            'comment' => 'This is a Test Comment',
        ]);
    }
}
