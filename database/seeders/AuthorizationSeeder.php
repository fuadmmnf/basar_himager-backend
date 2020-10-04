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
        $managerRole = Role::create(['name' => 'manager']);
        $workerRole = Role::create(['name' => 'worker']);


        $adminCreatePermission = Permission::create(['name' => 'crud:admin']);
        $managerCreatePermission = Permission::create(['name' => 'crud:manager']);
        $workerCreatePermission = Permission::create(['name' => 'crud:worker']);

        $adminCreatePermission->syncRoles([$superAdminRole]);
        $managerCreatePermission->syncRoles([$superAdminRole, $adminRole]);
        $workerCreatePermission->syncRoles([$superAdminRole, $adminRole, $managerRole]);



        $userTokenHandler = new UserTokenHandler();
        $user = $userTokenHandler->createUser('112r12r1', 'superadmin', '00000000000', 'admin123');
        $superadmin = new Admin();
        $superadmin->user_id = $user->id;
        $superadmin->save();
    }
}
