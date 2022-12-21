<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reservasi extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_barber',
        'id_pelanggan',
        'tanggal',
        'waktu',
        'service',
        'status',
        ]; 

        
    public function user(){
        return $this->belongsTo(User::class, 'id_pelanggan', 'id');
    }    
    public function barber(){
        return $this->belongsTo(Barber::class, 'id_barber', 'id');
    }
}
