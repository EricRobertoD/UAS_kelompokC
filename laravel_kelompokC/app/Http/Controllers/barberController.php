<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\barber;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ResourceBarber;

class barberController extends Controller
{
    public function index(){
        $barber = Barber::latest()->get();
        return new ResourceBarber(true, 'List Barber Departemen',$barber);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_barber' => 'required',
            'umur' => 'required',
            'alamat' => 'required'
        ]);
        
        if ($validator->fails()) {             
            return response()->json($validator->errors(), 422);         
        } 
    
        //Fungsi Simpan Data ke dalam Database
        $barber = Barber::create([
            'nama_barber' => $request->nama_barber,
            'umur' => $request->umur,
            'alamat' => $request->alamat
        ]);
        
        return new ResourceBarber(true, 'Data Barbel Berhasil Ditambahkan', $barber);
    }

    public function destroy($id)
    {
        $barber = Barber::find($id);
        $barber->delete();
    
        return new ResourceBarber(true, 'Data Barber Berhasil Dihapus!', $barber);
    }

    public function update(Request $request, $id)
    {
        $barber = Barber::findorfail($id);
        $validator = Validator::make($request->all(), [
            'nama_barber' => 'required',
            'umur' => 'required',
            'alamat' => 'required'
        ]);
    
        if($validator->fails()){
            return (response()->json($validator->errors(), 422));
        }
        $barber = Barber::findorfail($id);
        $barber->update([
            'nama_barber' => $request->nama_barber,
            'umur' => $request->umur,
            'alamat' => $request->alamat
        ]);
    
        return new ResourceBarber(true, 'Data Barber Berhasil Diedit', $barber);
    }
    
    public function show($id){
        $barber = Barber::find($id);
        return new ResourceBarber(true, 'Data Barber Berhasil Diambil', $barber);
    }
}
