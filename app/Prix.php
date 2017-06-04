<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Prix extends Model
{
    protected $fillable = ['nom', 'description', 'montant'];
    protected $table = "prixs";

    public function editions() {
        return $this->belongsToMany('\App\Edition')->withTimestamps();
    }

    public static function isValid($data = array()) {
        return Validator::make($data, [
            'id' => 'exists:prixs|sometimes|required',
            'nom' => 'string|sometimes|required',
            'description' => 'string|sometimes|required',
            'montant' => 'float|min:0|sometimes|required'
        ])->passes();
    }
}