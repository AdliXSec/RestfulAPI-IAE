<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Http\Resources\StudentResource;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $student = Student::all();
        return new StudentResource($student, 'success', 'Data Berhasil Diambil');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nim' => 'required',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return (new StudentResource(null, "failed", $validator->errors()))->response()->setStatusCode(422);
        }

        $student = Student::create($request->all());
        return new StudentResource($student, 'success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::find($id);

        if ($student) {
            return new StudentResource($student, 'success', 'Data Berhasil Diambil');
        } else {
            return (new StudentResource(null, "failed", "data tidak ditemukan"))->response()->setStatusCode(404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = Student::find($id);

        if ($student) {
            $student->update($request->all());
            return new StudentResource($student, 'success', 'Data Berhasil Diupdate');
        } else {
            return (new StudentResource(null, "failed", "data tidak ditemukan"))->response()->setStatusCode(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::find($id);

        if ($student) {
            $student->delete();
            return new StudentResource($student, 'success', 'Data Berhasil Dihapus');
        } else {
            return (new StudentResource(null, "failed", "data tidak ditemukan"))->response()->setStatusCode(404);
        }
    }
}