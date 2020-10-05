<?php

namespace Database\Seeders;

use App\Exceptions\UserTokenHandler;
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
        $adminManagerRole = Role::create(['name' => 'manager:admin']);
        $accountManagerRole = Role::create(['name' => 'manager:account']);
        $storeManagerRole = Role::create(['name' => 'manager:store']);
        $workerRole = Role::create(['name' => 'worker']);


        $adminCreatePermission = Permission::create(['name' => 'crud:admin']);
        $managerCreatePermission = Permission::create(['name' => 'crud:manager']);
        $workerCreatePermission = Permission::create(['name' => 'crud:worker']);
        $accountPermission = Permission::create(['name' => 'crud:account']);
        $storePermission = Permission::create(['name' => 'crud:store']);

        $adminCreatePermission->syncRoles([$superAdminRole]);
        $managerCreatePermission->syncRoles([$superAdminRole, $adminRole]);
        $workerCreatePermission->syncRoles([$superAdminRole, $adminRole, $adminManagerRole]);
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
