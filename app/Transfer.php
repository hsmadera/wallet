<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $table = "transfers";
    public function wallet(){
        return $this->belongsTo('App\Wallet');
    }
}
