<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MasterDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ロール作成
        $adminRole = Role::create(['name' => 'admin']);
        //権限作成
        $deleteUser = Permission::create(['name' => 'delete user']);
        $deleteComment = Permission::create(['name' => 'delete comment']);
        $sendEmail = Permission::create(['name' => 'send email']);

        //adminRoleに管理者の権限を付与
        $adminRole->givePermissionTo($deleteUser, $deleteComment, $sendEmail);

        $administer = User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('adminpass'),
            'img_url' => null,
        ]);

        $administer->assignRole($adminRole);

        User::create([
            'name' => 'Customer1',
            'email' => 'customer1@example.com',
            'password' => bcrypt('pass1234'),
            'img_url' => 'images/dummyImages/bat.png'
        ]);

        User::factory()
            ->count(20)
            ->create();
    }
}
