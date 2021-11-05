<?php

namespace App\Http\Controllers;

use App\Models\MBrand;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function index()
    {
        return view('brand.index', [
            'title' => 'Brand'
        ]);
    }

    public function apiData(Request $req)
    {
        $data = MBrand::orderBy('created_at', 'desc')->get();
        
        return DataTables::of($data)
        ->addColumn('action', function($data) {
            $buttonDetail = "<button onclick='detailData(".$data->bId.")' class='btn btn-warning btn-sm btn-circle mr-1' data-toggle='tooltip' data-placement='top' title='Detail Data ".$data->bId."'><i class='fa fa-eye'></i></button>";
            $buttonEdit = "<button onclick='editData(".$data->bId.")' class='btn btn-info btn-sm btn-circle mr-1' data-toggle='tooltip' data-placement='top' title='Edit Data ".$data->bId."'><i class='fa fa-edit'></i></button>";
            $buttonDelete = "<button onclick='deleteData(".$data->bId.")' class='btn btn-danger btn-sm btn-circle' data-toggle='tooltip' data-placement='top' title='Delete Data ".$data->bId."'><i class='fa fa-trash'></i></button>";

            return $buttonDetail.$buttonEdit.$buttonDelete;
        })
        ->rawColumns(['action'])
        ->make(true);
    }
    
    public function save(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'brand' => ['required', 'string'],
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

            MBrand::create([
                'bName' => $req->brand,
                'bDescription' => $req->description,
            ]);

            $data['title']      = "Success";
            $data['message']    = "Add data brand success!";
            $data['status']     = "success";
            $data['timer']      = 2500;
        } catch (\Throwable $th) {
            $data['title']      = "Failed";
            $data['message']    = "Add data brand failed, because : ". $th;
            $data['status']     = "error";
            $data['timer']      = 10000;
        }

        return response()->json($data);
    }

    public function edit(Request $req)
    {
        $data = MBrand::find($req->id);
        return response()->json($data);
    }

    public function update(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'brand' => ['required', 'string'],
            'description' => ['min:10', 'string']
        ]);

        try {
            if ($validator->fails()) {
                $pesan = '';
                foreach ($validator->messages()->get('*') as $error) {
                    foreach ($error as $q => $a) {
                        $pesan .= $a;
                    }
                }
                $solusi = substr($pesan, 0, -1);

                $data['title'] = "Failed";
                $data['status'] = "error";
                $data['timer'] = 5000;
                $data['message'] = "Failed to add data because : <br>".$solusi.'';

                return response()->json($data);exit;
            }

            $updateBrand = MBrand::find($req->id);
            $updateBrand->bName = $req->brand;
            $updateBrand->bDescription = $req->description;
            $updateBrand->save();
    
            $data['title']      = "Success";
            $data['message']    = "Update data brand success!";
            $data['status']     = "success";
            $data['timer']      = 2500;

        } catch (\Throwable $th) {
            $data['title']      = "Success";
            $data['message']    = "Update data brand failed!";
            $data['status']     = "success";
            $data['timer']      = 10000;
        }

        return response()->json($data);
    }

    public function delete(Request $req)
    {
        try {
            $data = MBrand::find($req->id);
            $data->delete();

            $data['title']      = "Success";
            $data['message']    = "Delete data brand success!";
            $data['status']     = "success";
            $data['timer']      = 2500;
        } catch (\Throwable $th) {
            $data['title']      = "Failed";
            $data['message']    = "Delete data brand failed, because : ". $th;
            $data['status']     = "error";
            $data['timer']      = 10000;
        }

        return response()->json($data);
    }
}
