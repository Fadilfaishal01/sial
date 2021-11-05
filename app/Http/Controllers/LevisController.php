<?php

namespace App\Http\Controllers;

use App\Models\MBrand;
use App\Models\MLevis;
use App\Models\MType;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class LevisController extends Controller
{
    public function index()
    {
        return view('levis.index', [
            'title' => 'Levis'
        ]);
    }

    public function apiData(Request $req)
    {
        $data = MLevis::with('Brand', 'Type')->orderBy('created_at', 'desc')->get();
        
        return DataTables::of($data)
        ->addColumn('action', function($data) {
            $buttonDetail = "<button onclick='detailData(".$data->lId.")' class='btn btn-warning btn-sm btn-circle mr-1' data-toggle='tooltip' data-placement='top' title='Detail Data ".$data->lId."'><i class='fa fa-eye'></i></button>";
            $buttonEdit = "<button onclick='editData(".$data->lId.")' class='btn btn-info btn-sm btn-circle mr-1' data-toggle='tooltip' data-placement='top' title='Edit Data ".$data->lId."'><i class='fa fa-edit'></i></button>";
            $buttonDelete = "<button onclick='deleteData(".$data->lId.")' class='btn btn-danger btn-sm btn-circle' data-toggle='tooltip' data-placement='top' title='Delete Data ".$data->lId."'><i class='fa fa-trash'></i></button>";

            return $buttonDetail.$buttonEdit.$buttonDelete;
        })
        ->addColumn('Price', function($data) {

            return 'Rp. '.$data->lPrice;
        })
        ->rawColumns(['action','Price'])
        ->make(true);
    }
    
    public function save(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'levis' => ['required', 'string'],
            'brand' => ['required', 'not_in:0'],
            'type' => ['required', 'not_in:0'],
            'price' => ['required', 'numeric'],
            'description' => ['min:10', 'string'],
            // 'image' => ['mimes:jpeg,jpg,png']
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

            $data = new MLevis();
            $data->lName = $req->levis;
            $data->typeId = $req->type;
            $data->brandId = $req->brand;
            $data->lPrice = $req->price;
            $data->lDescription = $req->description;
            $data->save();

            $data['title']      = "Success";
            $data['message']    = "Add data levis success!";
            $data['status']     = "success";
            $data['timer']      = 2500;
        } catch (\Throwable $th) {
            $data['title']      = "Failed";
            $data['message']    = "Add data levis failed, because : ". $th;
            $data['status']     = "error";
            $data['timer']      = 10000;
        }

        return response()->json($data);
    }

    public function edit(Request $req)
    {
        $data = MLevis::with('Brand', 'Type')->find($req->id);
        return response()->json($data);
    }

    public function update(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'levis' => ['required', 'string'],
            'brand' => ['required', 'not_in:0'],
            'type' => ['required', 'not_in:0'],
            'price' => ['required', 'number'],
            'description' => ['min:10', 'string'],
            'image' => ['mimes:jpeg,jpg,png']
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

            $updateLevis = MLevis::find($req->id);
            $updateLevis->lName = $req->levis;
            $updateLevis->brandId = $req->brand;
            $updateLevis->typeId = $req->type;
            $updateLevis->lPrice = $req->price;
            $updateLevis->lDescription = $req->description;
            $updateLevis->save();
    
            $data['title']      = "Success";
            $data['message']    = "Update data levis success!";
            $data['status']     = "success";
            $data['timer']      = 2500;

        } catch (\Throwable $th) {
            $data['title']      = "Failed";
            $data['message']    = "Update data levis failed!";
            $data['status']     = "error";
            $data['timer']      = 10000;
        }

        return response()->json($data);
    }

    public function delete(Request $req)
    {
        try {
            $data = MLevis::find($req->id);
            $data->delete();

            $data['title']      = "Success";
            $data['message']    = "Delete data levis success!";
            $data['status']     = "success";
            $data['timer']      = 2500;
        } catch (\Throwable $th) {
            $data['title']      = "Failed";
            $data['message']    = "Delete data levis failed, because : ". $th;
            $data['status']     = "error";
            $data['timer']      = 10000;
        }

        return response()->json($data);
    }

    public function getBrand(Request $req)
    {
        $search = $req->search;

        if($search == ''){
            $data = MBrand::orderBy('bName', 'asc')->get();
        }else{
            $data = MBrand::orderBy('bName', 'asc')->where('bName', 'like', '%'.$search.'%')->get();
        }

        $response = array();
        foreach($data as $Brand) {
            $response[] = array(
                "id" => $Brand->bId,
                "text" => $Brand->bName
            );
        }

        echo json_encode($response);
        exit;
    }

    public function getType(Request $req)
    {
        $search = $req->search;

        if($search == ''){
            $data = MType::orderBy('tName', 'asc')->get();
        }else{
            $data = MType::orderBy('tName', 'asc')->where('tName', 'like', '%'.$search.'%')->get();
        }

        $response = array();
        foreach($data as $Type) {
            $response[] = array(
                "id" => $Type->tId,
                "text" => $Type->tName
            );
        }

        echo json_encode($response);
        exit;
    }
}
