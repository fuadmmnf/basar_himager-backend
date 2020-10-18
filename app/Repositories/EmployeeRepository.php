<?php


namespace App\Repositories;


use App\Handlers\UserTokenHandler;
use App\Models\Employee;
use App\Models\Employeesalary;
use App\Models\User;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function createEmployee(array $request)
    {
//        $role = Role::where('name', $request['role'])->firstOrFail();
        $userTokenHandler = new UserTokenHandler();
        $user = $userTokenHandler->createUser($request['nid'], $request['name'], $request['phone'], $request['name'] . '_' . $request['phone']);
        $newEmployee = new Employee();
        $newEmployee->user_id = $user->id;
        $newEmployee->name = $request['name'];
        $newEmployee->designation = $request['designation'];
        $newEmployee->father_name = $request['father_name'];
        $newEmployee->mother_name = $request['mother_name'];
        $newEmployee->present_address = $request['present_address'];
        $newEmployee->permanent_address = $request['permanent_address'];
        $newEmployee->basic_salary = $request['basic_salary'];
        $newEmployee->special_salary = $request['special_salary'];
        $newEmployee->eid_bonus = $request['eid_bonus'];
        $newEmployee->save();
        $user->assignRole($request['role']);

        return $newEmployee;
    }

    public function getEmployeesByRole($role)
    {
        // TODO: Implement getEmployeesByRole() method.
        $users = User::role($role)->with('employee')->paginate(15);
        //$employees = Employee::where('role', $role)->paginate(15);
        return $users;
    }

    public function getEmployees()
    {
        // TODO: Implement getEmployees() method.
        $employees = Employee::paginate(15);
        return $employees;
    }


    public function storeEmployeeSalary(array $request)
    {
        // TODO: Implement storeEmployeeSalary() method.
        $employee = Employee::findOrFail($request['employee_id']);
        $newEmployeeSalary = new Employeesalary();
        $newEmployeeSalary->employee_id = $employee->id;
        $newEmployeeSalary->basic_salary = $request['basic_salary'];
        $newEmployeeSalary->special_salary = $request['special_salary'];
        $newEmployeeSalary->eid_bonus = $request['eid_bonus'];
        $newEmployeeSalary->payment_time = Carbon::parse($request['payment_time']);
        $newEmployeeSalary->save();
        return $newEmployeeSalary;

    }
}


