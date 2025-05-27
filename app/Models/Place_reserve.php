<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place_reserve extends Model
{
    use HasFactory;
    static function getTotalReservation($id){
        $Place=Place_reserve::where('id_event','=',$id)->get();
        return $Place->count();
    }
}
