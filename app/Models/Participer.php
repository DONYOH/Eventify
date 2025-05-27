<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participer extends Model
{
    use HasFactory;

    static function getTotalEvenement(){
        $Event=Evenement::all();
        return $Event->count();
    }

    static function getCategorieEvenement(){
        $Categorie=Categorie_event::all();
        return $Categorie->count();
    }

    static function getTotalClient(){
        $Client=User::where('role','=',"client")->get();
        return $Client->count();
    }

    static function getTotalTypePlace(){
        $Client=Typeplace::all();
        return $Client->count();
    }
}
