<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; //Library Validasi
use App\Models\Product;

class ProductController extends Controller
{  
    /////////////////////////INPUT DATA////////////////////////////////
    public function store(Request $request){ 
        $validator = Validator::make($request->all(),[
            'product_name'=>'required|max:100',
            'product_type'=>'required|in:minuman,makanan,rokok',
            'product_price'=>'required|numeric',
            'expired_at'=>'required|date'
        ]);
        //Kondisi inpuatan salah
        if($validator->fails()) {
            return response()->json($validator->messages())->setStatusCode(422);
        }
        //Inputan yang benar
        $validated = $validator->validated();
        //Input ke tabel product
        Product::create([
            'product_name'=>$validated['product_name'],
            'product_type'=>$validated['product_type'],
            'product_price'=>$validated['product_price'],
            'expired_at'=>$validated['expired_at']
        ]);

        return response()->json('Produk Berhasil Disimpan')->setStatusCode(201);
    }

    ///////////////////////LIHAT DATA//////////////////////////////////
    public function show(){ 
        $products = Product::all();

        return response()->json($products)->setStatusCode(200);
    }

    /////////////////////UPDATE DATA/////////////////////////////////
    public function update(Request $request,$id){
        //Validasi inputan
        $validator = Validator::make($request->all(),[
            'product_name'=>'required|max:100',
            'product_type'=>'required|in:minuman,makanan,rokok',
            'product_price'=>'required|numeric',
            'expired_at'=>'required|date'
        ]);
        //Kondisi inputan salah
        if($validator->fails()) {
            return response()->json($validator->messages())->setStatusCode(422);
        }
        //Inputan yang benar
        $validated = $validator->validated();

        $checkData = Product::find($id);

        if($checkData){
            Product::where('id',$id)
                ->update([
                'product_name'=>$validated['product_name'],
                'product_type'=>$validated['product_type'],
                'product_price'=>$validated['product_price'],
                'expired_at'=>$validated['expired_at']
                ]);
             return response()->json('Produk Berhasil Diupdate')->setStatusCode(201);
        }
        return response()->json('Data Produk Tidak Ditemukan')->setStatusCode(404);
    }

    /////////////////////////HAPUS DATA/////////////////////////////
    public function destroy($id){
        $checkData = Product::find($id);

        if($checkData){
            Product::destroy($id);
            return response()->json('Produk Berhasil Dihapus')->setStatusCode(200);       
        }
        return response()->json('Data Produk Tidak Ditemukan')->setStatusCode(404);  
    }
}
