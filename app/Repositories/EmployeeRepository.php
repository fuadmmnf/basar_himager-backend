<?php


namespace App\Repositories;


use App\Exceptions\UserTokenHandler;
use App\Models\Employee;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function createEmployee(array $request)
    {
        $userTokenHandler = new UserTokenHandler();
        $user = $userTokenHandler->createUser($request['nid'], $request['name'], $request['phone'], $request['name'] . '_' . $request['phone']);
        $newEmployee = new Employee();
        $newEmployee->user_id = $user->id;
        $newEmployee->designation = $request['designation'];
        $newEmployee->father_name = $request['father_name'];
        $newEmployee->mother_name = $request['mother_name'];
        $newEmployee->present_address = $request['present_address'];
        $newEmployee->permanent_address = $request['permanent_address'];
        $newEmployee->basic_salary = $request['basic_salary'];
        $newEmployee->special_salary = $request['special_salary'];
        $newEmployee->eid_bonus = $request['eid_bonus'];
        $newEmployee->save();

        return $newEmployee;
    }

}
