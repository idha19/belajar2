<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Employee::all();

        return response()->json([
            'success' => true,
            'message' => 'List semua data',
            'data' => $data
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'required|string|max:20|unique:employees,phone',
            'position' => 'required|string|max:100',
            'departement' => 'required|string|max:100',
            'salary' => 'required|numeric|min:0',
            'hire_date' => 'required|date',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('employee-photos', 'public');
            $data['photo'] = $path;
        }

        $employee = Employee::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Karyawan berhasil ditambahkan',
            'data'    => $employee
        ], 201);
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Karyawan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true, 
            'message' => 'Detail Karyawan',
            '$data' => $employee
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Karyawan tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'       => 'sometimes|required|string|max:255',
            'email'      => 'sometimes|required|email|unique:employees,email,' . $employee->id,
            'phone'      => 'sometimes|required|string|max:20|unique:employees,phone,' . $employee->id,
            'position'   => 'sometimes|required|string|max:100',
            'department' => 'sometimes|required|string|max:100',
            'salary'     => 'sometimes|required|numeric|min:0',
            'hire_date'  => 'sometimes|required|date',
            'photo'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('employee-photos', 'public');
            $data['photo'] = $path;
        }

        $employee->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Karyawan berhasil diperbarui',
            'data'    => $employee
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Karyawan tidak ditemukan'
            ], 404);
        }

        $employee->delete();

        return response()->json([
            'success'=> true,
            'message' => 'Karyawan berhasil dihapus'
        ], 200);
    }
}
