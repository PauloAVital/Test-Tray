<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ControllerVenda;

class ControllerVendedor extends Model
{
    protected $table = 'vendedor';
    protected $fillable = ['id', 
                           'nome',
                           'email',
                           'comissao'
                          ];

    public function rules()
    {
        return [
            'nome' => 'required',
            'email' => 'required',
            'comissao' => 'required'
        ];
    }

    /*public function relVendedor() {
        return $this->hasMany('App\Models\venda', 'id_vendedor' ); 
    }*/
    public function venda() {
        return $this->belongsTo(ControllerVenda::class, 'id_vendedor', 'id');
    }

}
