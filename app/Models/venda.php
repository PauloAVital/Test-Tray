<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class venda extends Model
{
    protected $table = 'venda';
    protected $fillable = ['id', 
                           'id_vendedor',
                           'id_produto',
                           'qtd_prod',
                           'total_venda',
                           'data_venda'
                          ];

    public function rules()
    {
        return [
            'id_vendedor' => 'required',
            'id_produto' => 'required',
            'total_venda' => 'required',
            'data_venda' => 'required'
        ];
    }

    public function relVendedor() {
        return $this->hasOne('App\User', 'id', 'id_vendedor' );
    }

    public function relProduto() {
        return $this->hasOne('App\User', 'id', 'id_produto' );
    }
}
