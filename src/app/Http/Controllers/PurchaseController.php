<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\PaymentMethod;
use App\Models\Profile;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Stripe;

class PurchaseController extends Controller
{
    public function index($id)
    {
        $item = Item::findOrFail($id);
        $itemImages = $item->itemImages;
        $user = Auth::user();

        //支払い方法をpaymentMethodSelectionメソッドで保存したsession('method_id')から取得
        $method_id = 1;  //初期値:クレジット払い
        if (session('method_id')) {
            $method_id = session('method_id');
            session()->forget('method_id');
        }
        $method = PaymentMethod::findOrFail($method_id);


        //商品のIDをsession('item_id')に保存
        session(['item_id' => $id]);


        //取引(TransactionsTable)のためのデータをsession('transaction_data')に保存
        $transactionData = null;

        if (session('transaction_data')) {
            session()->forget('transaction_data'); //session('transaction_data')がある場合、削除
        }
        //sessionにtransaction_dataを作成
        $transactionData = [
            'item_id' => $id,
            'buyer_id' => $user->id,
            'method_id' => $method_id,
        ];

        session(['transaction_data' . $user->id => $transactionData]);

        return view('purchase', compact(
            'item',
            'itemImages',
            'user',
            'method',
        ));
    }

    public function address()
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)
            ->first();

        return view('purchase_address', compact(
            'profile',
        ));
    }

    public function updateAddress(Request $request)
    {
        $user= Auth::user();

        $postcode = $request->input('postcode');
        if (!strpos($postcode, '-')) {
            $postcode = preg_replace('/(\d{3})(\d{4})/', '$1-$2', $postcode);
        }

        if ($user->profile) {
            $profile = $user->profile->first();

            $profile->postcode = $postcode;
            $profile->address = $request->input('address');
            $profile->building = $request->input('building');

            $profile->save();
        } else {
            Profile::create([
                'user_id' => $user->id,
                'postcode' => $postcode,
                'address' => $request->input('address'),
                'building' => $request->input('building'),
            ]);
        }

        $itemId = session('item_id');
        return redirect()->route('purchase.index', ['item_id' => $itemId]);
    }

    public function paymentMethod()
    {
        $paymentMethods = PaymentMethod::all();

        return view('payments/method_selection', compact(
            'paymentMethods',
        ));
    }

    public function paymentMethodSelection(Request $request)
    {
        //入力した支払い方法をsession('method_id')に保存
        session(['method_id' => $request->input('method_id')]);

        $itemId = session('item_id');
        return redirect()->route('purchase.index', ['item_id' => $itemId]);
    }

    public function stripe()
    {
        $user = Auth::user();

        //住所未登録の場合、住所変更ページへリダイレクト
        if (empty($user->profile)) {
            return redirect()->route('purchase.address');
        }

        //indexメソッドで保存したsession('transaction_data')を取得
        $transactionData = session('transaction_data' . $user->id);
        //transactionsTableに取引内容を作成
        if ($transactionData) {
            Transaction::create($transactionData);
        }

        $item = Item::findOrFail($transactionData['item_id']);

        $method_id = $transactionData['method_id'];

        switch ($method_id) {
            case '1':
                $paymentMethod = 'card';
                break;
            case '2':
                $paymentMethod = 'konbini';
                break;
            case '3':
                $paymentMethod = 'customer_balance';
                break;
            default:
                return redirect()->route('payment.failed');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $sessionParams = [
            'customer' => Customer::create()->id,
            'payment_method_types' => [$paymentMethod],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'jpy',
                        'product_data' => [
                            'name' => $item->name,
                        ],
                        'unit_amount' => $item->price,
                    ],
                    'quantity' => 1,
                ]
            ],
            'mode' => 'payment',
            'success_url' => route('payment.success'),
            'cancel_url' => route('payment.failed'),
        ];

        if ($paymentMethod === 'customer_balance') {
            $sessionParams['payment_method_options'] = [
                'customer_balance' => [
                    'funding_type' => 'bank_transfer',
                    'bank_transfer' => [
                        'type' => 'jp_bank_transfer',
                    ],
                ],
            ];
        }

        $session = Session::create($sessionParams);

        return redirect($session->url);
    }

    public function paymentSuccess()
    {
        $user = Auth::user();
        session()->forget('transaction_data' . $user->id); //session('transaction_data')を削除

        return view('payments/credit_success');
    }

    public function paymentFailed()
    {
        $user = Auth::user();
        $transactionData = session('transaction_data' . $user->id);

        //保存した取引データを削除
        if ($transactionData) {
            $transaction = Transaction::where($transactionData)
                ->first();
            if ($transaction) {
                $transaction->delete();
            }
        }
        session()->forget('transaction_data' . $user->id); //session('transaction_data')を削除

        return view('payments/credit_failed');
    }
}
