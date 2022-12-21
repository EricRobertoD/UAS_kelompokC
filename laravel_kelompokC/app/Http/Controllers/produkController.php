<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ResourceProduk;

class produkController extends Controller
{
    public function index(){
        $produk = Produk::latest()->get();
        return new ResourceProduk(true, 'List Data Produk',$produk);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required',
            'harga' => 'required',
            'stock' => 'required'
        ]);
        
        if ($validator->fails()) {             
            return response()->json($validator->errors(), 422);         
        } 
    
        //Fungsi Simpan Data ke dalam Database
        $produk = Produk::create([
            'nama_produk' => $request->nama_produk,
            'harga' => $request->harga,
            'stock' => $request->stock
        ]);
        
        return new ResourceProduk(true, 'Data Produk Berhasil Ditambahkan', $produk);
    }

    public function destroy($id)
    {
        $produk = Produk::find($id);
        $produk->delete();
    
        return new ResourceProduk(true, 'Data Produk Berhasil Dihapus!', $produk);
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findorfail($id);
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required',
            'harga' => 'required',
            'stock' => 'required'
        ]);
    
        if($validator->fails()){
            return (response()->json($validator->errors(), 422));
        }
        $produk = Produk::findorfail($id);
        $produk->update([
            'nama_produk' => $request->nama_produk,
            'harga' => $request->harga,
            'stock' => $request->stock
        ]);
    
        return new ResourceProduk(true, 'Data Produk Berhasil Diedit', $produk);
    }
    
    public function show($id){
        $produk = Produk::find($id);
        return new ResourceProduk(true, 'Data Produk Berhasil Diambil', $produk);
    }
}
