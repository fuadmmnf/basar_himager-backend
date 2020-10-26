<?php

namespace Database\Seeders;

use App\Handlers\UserTokenHandler;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AuthorizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdminRole = Role::create(['name' => 'super_admin']);
        $adminRole = Role::create(['name' => 'admin']);
        $adminManagerRole = Role::create(['name' => 'manager_admin']);
        $accountManagerRole = Role::create(['name' => 'manager_account']);
        $storeManagerRole = Role::create(['name' => 'manager_store']);
        $workerRole = Role::create(['name' => 'worker']);


        $adminCreatePermission = Permission::create(['name' => 'crud:admin']);
        $adminManagerCreatePermission = Permission::create(['name' => 'crud:manager_admin']);
        $storeManagerCreatePermission = Permission::create(['name' => 'crud:manager_store']);
        $accountManagerCreatePermission = Permission::create(['name' => 'crud:manager_account']);
        $workerCreatePermission = Permission::create(['name' => 'crud:worker']);
        $accountPermission = Permission::create(['name' => 'crud:account']);
        $storePermission = Permission::create(['name' => 'crud:store']);

        $adminCreatePermission->syncRoles([$superAdminRole]);
        $adminManagerCreatePermission->syncRoles([$superAdminRole, $adminRole]);
        $storeManagerCreatePermission->syncRoles([$superAdminRole, $adminRole, $adminManagerRole]);
        $accountManagerCreatePermission->syncRoles([$superAdminRole, $adminRole, $adminManagerRole]);
        $workerCreatePermission->syncRoles([$superAdminRole, $adminRole, $adminManagerRole, $accountManagerRole]);
        $accountPermission->syncRoles([$superAdminRole, $adminRole, $adminManagerRole, $accountManagerRole]);
        $storePermission->syncRoles([$superAdminRole, $adminRole, $adminManagerRole, $accountManagerRole, $storeManagerRole]);



        $userTokenHandler = new UserTokenHandler();
        $user = $userTokenHandler->createUser('112r12r1', 'superadmin', '00000000000', 'admin123');
        $superadmin = new Admin();
        $superadmin->user_id = $user->id;
        $superadmin->save();
        $user->assignRole('super_admin');
    }
}
