<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Barang;
use Illuminate\Http\Request;
use Auth;

class BarangController extends Controller{
    
  public function index(){
      $barang = Barang::all();
      
      return response()->json([
        'code' => '200',
        'success' => true,
        'barang' => $barang
      ]);
  }

  public function store(Request $request){
    $validator = Validator::make($request->all(), 
    [ 
      'title' => 'required',
      'description' => 'required',
    ]);  

    if ($validator->fails()) {  
      return response()->json(['code' => 400, 'error'=>$validator->errors()], 400); 
    }   

    $barang = new Barang();
    $barang->title = $request->title;
    $barang->description = $request->description;
    $barang->save();

    return response()->json([
      'code' => 201,
      'success' => true,
      'data' => $barang
  ], 201);
  }

  public function show($id){
    $barang = Barang::where('_id', $id)->first();
      
    return response()->json([
      'code' => '200',
      'success' => true,
      'barang' => $barang
    ]);
  }

  public function update(Request $request, $id){
    $validator = Validator::make($request->all(), 
      [ 
        'title' => 'required',
        'description' => 'required',
      ]);  

      if ($validator->fails()) {  
        return response()->json(['code' => 400, 'error'=>$validator->errors()], 400); 
      }   

      $barang = Barang::where('_id', $id)->first();
      $barang->title = $request->title;
      $barang->description = $request->description;
      $barang->save();

      return response()->json([
        'code' => 201,
        'success' => true,
        'data' => $barang
    ], 201);
  }

  public function delete($id){
    $barang = Barang::where('_id', $id)->first();
    $barang->delete();
      
    return response()->json([
      'code' => '200',
      'success' => true,
    ]);
  }
}
