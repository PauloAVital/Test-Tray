<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vendedor extends Model
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

    public function relVendedor() {
        return $this->hasMany('App\Models\venda', 'id_vendedor' ); 
    }

}
