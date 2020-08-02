<?php

namespace App\Http\Controllers;

use App\Models\Student; //panggil dulu modelnya
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class StudentController extends Controller
{
    /**
     * Student Index;
     */
    public function index()
    {
        return view('student', [
            'title' => 'Students' /* Data untuk title dan page title */
        ]);
    }

    public function dataTable()
    {
        $data = Student::query(); //harus query supaya serversidenya jalan
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $btn = '<a href="javascript:void(0)" class="fa fa-edit text-primary"  data-id="' . $row->id . '" data-original-title="Edit" id="editBtn"></a> |';

                $btn = $btn . ' <a href="javascript:void(0)" class="fa fa-trash text-danger"  data-id="' . $row->id . '" data-original-title="Delete" id="deleteBtn"></a>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
