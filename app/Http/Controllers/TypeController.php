<?php

namespace App\Http\Controllers;

use App\Models\MType;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class TypeController extends Controller
{
    public function index()
    {
        return view('type.index', [
            'title' => 'Type'
        ]);
    }

    public function apiData(Request $req)
    {
        $data = MType::orderBy('created_at', 'desc')->get();
        
        return DataTables::of($data)
        ->addColumn('action', function($data) {
            $buttonDetail = "<button onclick='detailData(".$data->tId.")' class='btn btn-warning btn-sm btn-circle mr-1' data-toggle='tooltip' data-placement='top' title='Detail Data ".$data->tId."'><i class='fa fa-eye'></i></button>";
            $buttonEdit = "<button onclick='editData(".$data->tId.")' class='btn btn-info btn-sm btn-circle mr-1' data-toggle='tooltip' data-placement='top' title='Edit Data ".$data->tId."'><i class='fa fa-edit'></i></button>";
            $buttonDelete = "<button onclick='deleteData(".$data->tId.")' class='btn btn-danger btn-sm btn-circle' data-toggle='tooltip' data-placement='top' title='Delete Data ".$data->tId."'><i class='fa fa-trash'></i></button>";

            return $buttonDetail.$buttonEdit.$buttonDelete;
        })
        ->rawColumns(['action'])
        ->make(true);
    }
    
    public function save(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'type' => ['required', 'string'],
            'description' => ['min:10', 'string']
        ]);

        try {

            if ($validator->fails()) {
                $pesan = '';
                foreach ($validator->messages()->get('*') as $error) {
                    foreach ($error as $q => $a) {
                        $pesan .= '<b>- '.$a. '</b><br>';
                    }
                }
                $solusi = substr($pesan, 0, -1);

                $data['title'] = "Failed";
                $data['status'] = "error";
                $data['timer'] = 5000;
                $data['message'] = "Failed to add data because : <br>".$solusi.'';

                return response()->json($data);exit;
            }

            MType::create([
                'tName' => $req->type,
                'tDescription' => $req->description,
            ]);

            $data['title']      = "Success";
            $data['message']    = "Add data type success!";
            $data['status']     = "success";
            $data['timer']      = 2500;
        } catch (\Throwable $th) {
            $data['title']      = "Failed";
            $data['message']    = "Add data type failed, because : ". $th;
            $data['status']     = "error";
            $data['timer']      = 10000;
        }

        return response()->json($data);
    }

    public function edit(Request $req)
    {
        $data = MType::find($req->id);
        return response()->json($data);
    }

    public function update(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'type' => ['required', 'string'],
            'description' => ['min:10', 'string']
        ]);

        try {
            if ($validator->fails()) {
                $pesan = '';
                foreach ($validator->messages()->get('*') as $error) {
                    foreach ($error as $q => $a) {
                        $pesan .= '<b>- '.$a. '</b><br>';
                    }
                }
                $solusi = substr($pesan, 0, -1);

                $data['title'] = "Failed";
                $data['status'] = "error";
                $data['timer'] = 5000;
                $data['message'] = "Failed to add data because : <br>".$solusi.'';

                return response()->json($data);exit;
            }

            $updateType = MType::find($req->id);
            $updateType->tName = $req->type;
            $updateType->tDescription = $req->description;
            $updateType->save();
    
            $data['title']      = "Success";
            $data['message']    = "Update data type success!";
            $data['status']     = "success";
            $data['timer']      = 2500;

        } catch (\Throwable $th) {
            $data['title']      = "Success";
            $data['message']    = "Update data type failed!";
            $data['status']     = "success";
            $data['timer']      = 10000;
        }

        return response()->json($data);
    }

    public function delete(Request $req)
    {
        try {
            $data = MType::find($req->id);
            $data->delete();

            $data['title']      = "Success";
            $data['message']    = "Delete data type success!";
            $data['status']     = "success";
            $data['timer']      = 2500;
        } catch (\Throwable $th) {
            $data['title']      = "Failed";
            $data['message']    = "Delete data type failed, because : ". $th;
            $data['status']     = "error";
            $data['timer']      = 10000;
        }

        return response()->json($data);
    }

}
