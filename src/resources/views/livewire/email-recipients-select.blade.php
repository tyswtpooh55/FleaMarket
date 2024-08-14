<div>
    <div class="writing__box">
        <label for="recipients" class="email__label">To. </label>
        <select name="recipients" id="recipients" class="select__pull-down" wire:model='recipients'>
            <option hidden>送信先を選択してください</option>
            <option value="all_users">全てのユーザー</option>
            <option value="select_users">ユーザーを選ぶ</option>
            <option value="specified_sellers">出品数の指定</option>
            <option value="specified_buyers">購入数の指定</option>
            <option value="random_users">ランダム選択</option>
        </select>


        {{-- 特定のユーザーを選択 --}}
        @if ($recipients == 'select_users')
        <div class="recipients__select-users--box">
            <table class="select-box__table">
                <tr class="select-box__row">
                    <th class="select-box__label">
                        選択
                    </th>
                    <th class="select-box__label">
                        ユーザー名
                    </th>
                    <th class="select-box__label">
                        出品数
                    </th>
                    <th class="select-box__label">
                        購入数
                    </th>
                    <th class="select-box__label">
                        会員登録日
                    </th>
                </tr>
                @foreach ($users as $user)
                <tr class="select-box__row">
                    <td class="select-box__data">
                        <input type="checkbox" id="user_{{ $user->id }}" value="{{ $user->id }}" wire:model='selectedUsers' class="select-box__data--checkbox">
                    </td>
                    <td class="select-box__data">
                        <label for="user_{{ $user->id }}" class="recipient__label">{{ $user->name }}</label>
                    </td>
                    <td class="select-box__data">
                        {{ $user->items->count() }}
                    </td>
                    <td class="select-box__data">
                        {{ $user->transactions->count() }}
                    </td>
                    <td class="select-box__data">
                        {{ $user->created_at->format('Y-m-d') }}
                    </td>
                </tr>
                @endforeach
            </table>
        </div>

        {{-- 購入数、出品数の指定 --}}
        @elseif($recipients == 'specified_sellers' || $recipients == 'specified_buyers')
        <div class="recipients__select--box">
            <div class="specification__box">
                <label for="count" class="specification__label">数を指定</label><br>
                <input type="number" id="count" wire:model='count' min="0" class="specification__input">
            </div>
            <div class="specification__box">
                <label for="condition" class="specification__label">条件を指定</label><br>
                <select name="condition" id="condition" wire:model='condition' class="specification__select">
                    <option hidden>選択してください</option>
                    <option value="greater">以上</option>
                    <option value="less">以下</option>
                </select>
            </div>
        </div>

        {{-- ランダムで選択する数の指定 --}}
        @elseif($recipients == 'random_users')
        <div class="recipients__select--box">
            <label for="random_count" class="specification__label">数を指定</label><br>
            <input type="number" wire:model='count' min="1" max="{{ $countAllUsers }}" class="specification__input">
        </div>
        @endif

        @if ($selectedUsers && $recipients != 'select_users')
        <div class="selectedUsers__list">
            <table class="selectedUsers__table">
                <tr class="selectedUsers__row">
                    <th class="selectedUsers__label">
                        ユーザー名
                    </th>
                    <th class="selectedUsers__label">
                        出品数
                    </th>
                    <th class="selectedUsers__label">
                        購入数
                    </th>
                    <th class="selectedUsers__label">
                        会員登録日
                    </th>
                </tr>
                @foreach ($selectedUsersData as $user)
                <tr class="selectedUsers__row">
                    <td class="selectedUsers__data">
                        {{ $user->name }}
                    </td>
                    <td class="selectedUsers__data">
                        {{ $user->items->count() }}
                    </td>
                    <td class="selectedUsers__data">
                        {{ $user->transactions->count() }}
                    </td>
                    <td class="selectedUsers__data">
                        {{ $user->created_at->format('Y-m-d') }}
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        @endif

        <input type="hidden" name="recipients" value="{{ implode(',', $selectedUsers) }}">
    </div>
</div>
