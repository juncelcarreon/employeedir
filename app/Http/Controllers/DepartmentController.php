<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EmployeeDepartment;
use App\ElinkDivision;
use App\ElinkAccount;
use App\User;

class DepartmentController extends Controller
{
    public function index()
    {
        $data['departments'] = EmployeeDepartment::all();

        return view('admin.department', $data);
    }

    public function create()
    {
        $data['divisions'] = ElinkDivision::all();
        $data['accounts'] = ElinkAccount::all();
        $data['departments'] = EmployeeDepartment::all();

        return view('admin.department.create', $data);
    }

    public function store(Request $request)
    {
        $employeeDepartment = new EmployeeDepartment();
        $employeeDepartment->department_name = $request->department_name;
        $employeeDepartment->department_code = $request->department_code;
        $employeeDepartment->division_id = $request->division_id;
        $employeeDepartment->account_id = $request->account_id;
        $employeeDepartment->save();

        return redirect('department')->with('success', "Successfully created department");
    }

    public function edit($id)
    {
        $data['department'] = EmployeeDepartment::find($id);
        $data['divisions'] = ElinkDivision::all();
        $data['accounts'] = ElinkAccount::all();
        $data['departments'] = EmployeeDepartment::where('id', '<>', $id)->whereNull('deleted_at')->get();

        return view('admin.department.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $employeeDepartment = EmployeeDepartment::find($id);
        $employeeDepartment ->department_name = $request->department_name;
        $employeeDepartment->department_code = $request->department_code;
        $employeeDepartment->division_id = $request->division_id;
        $employeeDepartment->account_id = $request->account_id;
        $employeeDepartment->update();

        return redirect('department')->with('success', "Successfully edited department");
    }

    public function destroy($id)
    {
        $employeeDepartment = EmployeeDepartment::find($id);
        $employeeDepartment->delete();
        
        return redirect('department')->with('success', "Successfully deleted department");
    }
}
