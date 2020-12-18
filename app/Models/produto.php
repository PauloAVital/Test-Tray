<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class produto extends Model
{
    protected $table = 'produto';
    protected $fillable = ['id', 
                           'nome',
                           'descricao',
                           'preco'
                          ];

    public function rules()
    {
        return [
            'nome' => 'required',
            'preco' => 'required'
        ];
    }

    public function relProduto() {
        return $this->hasMany('App\Models\venda', 'id_produto' ); 
    }
}
