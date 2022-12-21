<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class barber extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_barber',
        'umur',
        'alamat',
        ]; 
            
    public function reservasi(){
        return $this->hasMany(Reservasi::class, 'id_barber');
    }
}
