<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    //
    protected $table = 'hotel';

    protected $fillable = [ 'nama_hotel',
                            'slug', 
                            'deskripsi',
                            'foto',
                            'kamar',
                            'lokasi', 
                            'harga',];

     public function order()
    {
        return $this->hasOne('App\Models\Order');
    }

}
