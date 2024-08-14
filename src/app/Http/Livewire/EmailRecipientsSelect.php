<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EmailRecipientsSelect extends Component
{
    public $recipients;
    public $users;
    public $countAllUsers;
    public $condition;
    public $count;
    public $selectedUsers = [];
    public $selectedUsersData = [];

    public function mount()
    {
        $this->countAllUsers = User::withoutRole('admin')->count();
    }

    public function updatedCount()
    {
        $this->updatedRecipients();
    }

    public function updatedCondition()
    {
        $this->updatedRecipients();
    }

    public function updatedRecipients()
    {
        $this->selectedUsers = [];

        switch ($this->recipients) {
            case 'all_users':
                //全ユーザを取得
                $this->selectedUsers = User::withoutRole('admin')->pluck('id')->toArray();
                break;

            case 'select_users':
                //ユーザーの選択
                $this->users = User::withoutRole('admin')->get();
                break;

            case 'specified_sellers':
                //出品数の指定
                $query = User::withoutRole('admin')
                    ->select('users.*', DB::raw('COUNT(items.id) as items_count'))
                    ->leftJoin('items', 'users.id', '=', 'items.seller_id')
                    ->groupBy('users.id');

                if ($this->condition == 'greater') {
                    //以上の場合
                    $this->users = $query->havingRaw('items_count >= ?', [$this->count])->get();
                } else {
                    //以下の場合
                    $this->users = $query->havingRaw('items_count <= ?', [$this->count])->get();
                }
                $this->selectedUsers = $this->users->pluck('id')->toArray();
                break;

            case 'specified_buyers':
                //購入数を指定
                $query = User::withoutRole('admin')
                    ->select('users.*', DB::raw('COUNT(transactions.id) as transactions_count'))
                    ->leftJoin('transactions', 'users.id', '=', 'transactions.buyer_id')
                    ->groupBy('users.id');

                if ($this->condition == 'greater') {
                    //以上の場合
                    $this->users = $query->havingRaw('transactions_count >= ?' , [$this->count])->get();
                } else {
                    //以下の場合
                    $this->users = $query->havingRaw('transactions_count <= ?', [$this->count])->get();
                }
                $this->selectedUsers = $this->users->pluck('id')->toArray();
                break;

            case 'random_users':
                //ランダム選択
                $this->users = User::withoutRole('admin')->inRandomOrder()->take($this->count)->get();
                $this->selectedUsers = $this->users->pluck('id')->toArray();
                break;
        }
        $this->updateSelectedUsersData();
    }

    public function updateSelectedUsersData()
    {
        $this->selectedUsersData = User::whereIn('id', $this->selectedUsers)->get();
    }

    public function render()
    {
        return view('livewire.email-recipients-select');
    }
}
