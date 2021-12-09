<?php


namespace App\Repositories;


use App\Handlers\UserTokenHandler;
use App\Models\Employee;
use App\Models\Employeesalary;
use App\Models\User;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use Spatie\Permission\Models\Role;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function createEmployee(array $request)
    {
//        $role = Role::where('name', $request['role'])->firstOrFail();
        $userTokenHandler = new UserTokenHandler();
        $user = $userTokenHandler->createUser($request['nid'], $request['name'], $request['phone'], $request['nid'] );
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

        if ($request['photo']) {
            // $image = time(). '.' . explode('/', explode(':', substr($request->image, 0, strpos($request->image, ':')))[1])[0];
            $filename = random_string(5) . time() . '.' . explode(';', explode('/', $request['photo'])[1])[0];
            $location = public_path('/images/employees/' . $filename);
            // Image::make($request->image)->resize(800, null, function ($constraint) { $constraint->aspectRatio(); })->save($location);
//            Image::make($request['photo'])->resize(300, 300)->save($location);
            Image::make($request['photo'])->save($location);
            $newEmployee->photo = $filename;
        }
        if ($request['nid_photo']) {
            // $image = time(). '.' . explode('/', explode(':', substr($request->image, 0, strpos($request->image, ':')))[1])[0];
            $filename = random_string(5) . time() . '_nid.' . explode(';', explode('/', $request['nid_photo'])[1])[0];
            $location = public_path('/images/employees/' . $filename);
            // Image::make($request->image)->resize(800, null, function ($constraint) { $constraint->aspectRatio(); })->save($location);
//            Image::make($request['nid_photo'])->resize(300, 300)->save($location);
            Image::make($request['nid_photo'])->save($location);
            $newEmployee->nid_photo = $filename;
        }
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
        $employees = Employee::with('user')->paginate(15);
        return $employees;
    }
}


