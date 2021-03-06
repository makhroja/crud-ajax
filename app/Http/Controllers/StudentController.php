<?php

namespace App\Http\Controllers;

use App\Models\Student; //panggil dulu modelnya
use Illuminate\Http\Request;
use Validator;
use Yajra\DataTables\DataTables;

class StudentController extends Controller
{
    /**
     * Student Index;
     */
    public function index()
    {
        return view('student', [
            'title'         => 'Students' /* Data untuk title dan page title */
        ]);
    }

    /**
     * Menyimpan data student ke database
     */
    public function store(Request $request, Student $student)
    {
        Validator::make($request->all(), [
            'name'          => 'required|min:5',
            'class_id'      => 'required|numeric',
            'age'           => 'required|numeric',
            'gender'        => 'required',
            'address'       => 'required'
        ])->validate();

        $student->create($request->all());

        return response()->json('Saved Successfully', 200);
    }

    public function edit(Request $request, Student $student)
    {
        return response()->json($student->find($request->id), 200);
    }

    public function delete(Request $request, Student $student)
    {
        $student->find($request->id)->delete();
        return response()->json('Delete Successfully', 200);
    }

    public function update(Request $request, Student $student)
    {
        Validator::make($request->all(), [
            'name'          => 'required|min:5',
            'class_id'      => 'required|numeric',
            'age'           => 'required|numeric',
            'gender'        => 'required',
            'address'       => 'required',
            'id'            => 'required'
        ])->validate();

        $student->find($request->id)->update($request->all());

        return response()->json('Update Successfully', 200);
    }

    /**
     * Yajradatatables
     */
    public function dataTable()
    {
        $data = Student::query(); //harus query supaya serversidenya jalan
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $btn = '<a href="javascript:void(0)"
                 data-id="' . $row->id . '" data-original-title="Edit"
                 id="editBtn"><i class="fa fa-edit text-primary"></i></a> |';

                $btn = $btn . ' <a href="javascript:void(0)"
                data-id="' . $row->id . '" data-original-title="Delete"
                id="deleteBtn"><i class="fa fa-trash text-danger"></i></a>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
