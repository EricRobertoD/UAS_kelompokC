<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Saran;
use App\Models\Reservasi;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ResourceSaran;

class saranController extends Controller
{
    public function index(){
        $saran = Saran::with('Reservasi')->latest()->get();
        return new ResourceSaran(true, 'List Data Saran', $saran);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_reservasi' => 'required',
            'kritik' => 'required',
            'saran' => 'required'
        ]);
        
        if ($validator->fails()) {             
            return response()->json($validator->errors(), 422);         
        } 
    
        //Fungsi Simpan Data ke dalam Database
        $saran = Saran::create([
            'id_reservasi' => $request->id_reservasi,
            'kritik' => $request->kritik,
            'saran' => $request->saran
        ]);
        
        return new ResourceSaran(true, 'Data Saran Berhasil Ditambahkan', $saran);
    }

    public function destroy($id)
    {
        $saran = Saran::find($id);
        $saran->delete();
    
        return new ResourceSaran(true, 'Data Saran Berhasil Dihapus!', $saran);
    }

    public function update(Request $request, $id)
    {
        $saran = Saran::findorfail($id);
        $validator = Validator::make($request->all(), [
            'id_reservasi' => 'required',
            'kritik' => 'required',
            'saran' => 'required'
        ]);
    
        if($validator->fails()){
            return (response()->json($validator->errors(), 422));
        }
        $saran = Saran::findorfail($id);
        $reservasi->update([
            'id_reservasi' => $request->id_reservasi,
            'kritik' => $request->kritik,
            'saran' => $request->saran
        ]);
    
        return new ResourceSaran(true, 'Data Saran Berhasil Diedit', $saran);
    }
    
    public function show($id){
        $saran = Saran::find($id);
        return new ResourceSaran(true, 'Data Saran Berhasil Diambil', $saran);
    }
}
