<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class saran extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_reservasi',
        'kritik',
        'saran',
        ]; 
        
    public function reservasi(){
        return $this->belongsTo(Reservasi::class, 'id_reservasi', 'id');
    }
}
