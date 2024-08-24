<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Models\Comment;
use App\Models\Condition;
use App\Models\Item;
use App\Models\ItemImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function search(Request $request)
    {
        $items = Item::query();

        $keyword = $request->input('search');

        if (!empty($keyword)) {
            $items->where('name', 'LIKE', "%{$keyword}%")
                ->orWhere('brand', 'LIKE', "%{$keyword}%")
                ->orWhere('description', 'LIKE', "%{$keyword}%")
                ->orWhereHas('categories', function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', "%{$keyword}%");
                })
                ->orWhereHas('condition', function ($query) use ($keyword) {
                    $query->where('condition', 'LIKE', "%{$keyword}%");
                });
        }

        $searchItems = $items->paginate(10)->appends(['search' => $keyword]);

        $countItems = $searchItems->total();

        return view('search_items', compact(
            'keyword',
            'searchItems',
            'countItems'
        ));
    }

    public function sell()
    {
        $conditions = Condition::all();

        return view('sell', compact(
            'conditions',
        ));
    }

    public function sale(ItemRequest $request)
    {
        $user = Auth::user();

        $item = Item::create([
            'name' => $request->input('name'),
            'brand' => $request->input('brand'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'seller_id' => $user->id,
            'condition_id' => $request->input('condition_id')
        ]);

        // 画像イメージがあればitem_imagesテーブルにデータ挿入
        if ($request->hasFile('img_url')) {
            foreach ($request->file('img_url') as $img) {
                $path = $img->store('public/images/items');
                ItemImage::create([
                    'item_id' => $item->id,
                    'img_url' => str_replace('public', '', $path),
                ]);
            }
        }
        // 中間テーブルcategory_itemへのデータ挿入
        DB::table('category_item')->insert([
            'item_id' => $item->id,
            'category_id' => $request->input('category_id_1'),
        ]);
        if ($request->input('category_id_2')) {
            DB::table('category_item')->insert([
                'item_id' => $item->id,
                'category_id' => $request->input('category_id_2'),
            ]);
        }

        return redirect()->route('index');
    }

    public function detail($id)
    {
        $item = Item::findOrFail($id);
        $itemImages = $item->itemImages;

        $countLikes = $item->likes->count();

        $countComments = $item->comments->count();

        $categories = $item->categories;

        return view('item', compact(
            'item',
            'itemImages',
            'countLikes',
            'countComments',
            'categories',
        ));
    }

    public function comment($item_id)
    {
        $item = Item::findOrFail($item_id);
        $itemImages = $item->itemImages;
        $comments = Comment::where('item_id', $item_id)
            ->orderby('created_at', 'asc')
            ->get();
        $countLikes = $item->likes->count();
        $countComments = $comments->count();

        return view('comment', compact(
            'item',
            'itemImages',
            'comments',
            'countLikes',
            'countComments',
        ));
    }

    public function createComment(Request $request, $item_id)
    {
        $user = Auth::user();

        Comment::create([
            'user_id' => $user->id,
            'item_id' => $item_id,
            'comment' => $request->input('comment'),
        ]);

        return redirect()->back();
    }

    public function deleteComment($comment_id)
    {
        Comment::find($comment_id)->delete();

        return back();
    }
}
