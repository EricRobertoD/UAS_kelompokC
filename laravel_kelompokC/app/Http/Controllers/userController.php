<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ResourceUser;

class userController extends Controller
{
    public function index(){
        $user = User::latest()->get();
        return new ResourceUser(true, 'List Data User',$user);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
    
        return new ResourceUser(true, 'Data user Berhasil Dihapus!', $user);
    }

    public function update(Request $request, $id)
    {
        $user = User::findorfail($id);
        $validator = Validator::make($request->all(), [
            'nama_user' => 'required',
            'username' => 'required',
            'telepon' => 'digits_between:10,13',
            'email' => 'required|email:rfc,dns'
        ]);
    
        if($validator->fails()){
            return (response()->json($validator->errors(), 422));
        }
        $user = User::findorfail($id);
        $user->update([
            'nama_user' => $request->nama_user,
            'username' => $request->username,
            'telepon' => $request->telepon,
            'email' => $request->email,
        ]);
    
        return new ResourceUser(true, 'Data user Berhasil Diedit', $user);
    }
    
    public function show($id){
        $user = User::find($id);
        return new ResourceUser(true, 'Data user Berhasil Diambil', $user);
    }
}
