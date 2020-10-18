<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $table = 'order';

    protected $fillable = [ 'tgl_checkin',
                            'tgl_checkout', 
                            'kamar',
                            'tempat_tidur',
                            'total_harga',
                            'user_id', 
                            'hotel_id',];

    public function user()
    {
      return $this->belongsTo('App\Models\User');
    }

    public function hotel()
    {
      return $this->belongsTo('App\Models\Hotel');
    }
}
