<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        Employee::all();

        return response([
            'message' => 'This is the index method from the EmployeeController',
            'employees' => Employee::all()
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {

        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:employees',
            'job_title' => 'required',
            'phone' => 'required',
        ]);

        $employee =Employee::create($validatedData);

        if (!$employee) {
            return response([
                'message' => 'Employee not created',
            ], 500);
        }

        return response([
            'message' => 'Employee created successfully',
            'employee' => $employee,
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show($id): Response
    {
        $data=Employee::find($id);

        if (!$data) {
            return response([
                'message' => 'Employee not found',
            ], 404);
        }

        return response([
            'message' => 'This is the show method from the EmployeeController',
            'employee' => $data
        ], 200);

    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): Response
    {
        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:employees',
            'job_title' => 'required',
            'phone' => 'required',
        ]);

        $employee = Employee::where('id', $id)->update($validatedData);

        $newEmployee = Employee::find($id);

        if (!$employee) {
            return response([
                'message' => 'Employee not updated',
            ], 500);
        }

        return response([
            'message' => 'Employee updated successfully',
            'employee' => $newEmployee,
        ], 201);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): Response
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response([
                'message' => 'Employee not found',
            ], 404);
        }

        $employee->delete();

        return response([
            'message' => 'Employee deleted successfully',
        ], 200);
    }

}
