<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Barber;
use App\Models\Reservasi;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ResourceReservasi;
use Illuminate\Support\Facades\Auth;

class reservasiController extends Controller
{
    public function index(){
        $reservasi = Reservasi::with(['User', 'Barber'])->latest()->get();
        return new ResourceReservasi(true, 'List Data Reservasi', $reservasi);
    }

    public function getRevUser(){
        $id = Auth::id();
        $reservasi = Reservasi::with(['User', 'Barber'])->where('id_pelanggan', $id)->latest()->get();
        return new ResourceReservasi(true, 'List Data Reservasi', $reservasi);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_barber' => 'required',
            'id_pelanggan' => 'required',
            'tanggal' => 'required',
            'waktu' => 'required',
            'service' => 'required',
            'status' => 'required|digits_between:0,1'      
        ]);
        
        if ($validator->fails()) {             
            return response()->json($validator->errors(), 422);         
        } 
    
        //Fungsi Simpan Data ke dalam Database
        $reservasi = Reservasi::create([
            'id_barber' => $request->id_barber,
            'id_pelanggan' => $request->id_pelanggan,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'service' => $request->service,
            'status' => $request->status
        ]);
        
        return new ResourceReservasi(true, 'Data Reservasi Berhasil Ditambahkan', $reservasi);
    }

    public function destroy($id)
    {
        $reservasi = Reservasi::find($id);
        $reservasi->delete();
    
        return new ResourceReservasi(true, 'Data Reservasi Berhasil Dihapus!', $reservasi);
    }

    public function update(Request $request, $id)
    {
        $reservasi = Reservasi::findorfail($id);
        $validator = Validator::make($request->all(), [
            'id_barber' => 'required',
            'id_pelanggan' => 'required',
            'tanggal' => 'required',
            'waktu' => 'required',
            'service' => 'required',
            'status' => 'required|digits_between:0,1'     
        ]);
    
        if($validator->fails()){
            return (response()->json($validator->errors(), 422));
        }
        $reservasi = Reservasi::findorfail($id);
        $reservasi->update([
            'id_barber' => $request->id_barber,
            'id_pelanggan' => $request->id_pelanggan,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'service' => $request->service,
            'status' => $request->status
        ]);
    
        return new ResourceReservasi(true, 'Data Reservasi Berhasil Diedit', $reservasi);
    }
    
    public function show($id){
        $reservasi = Reservasi::find($id);
        return new ResourceReservasi(true, 'Data Reservasi Berhasil Diambil', $reservasi);
    }
}
