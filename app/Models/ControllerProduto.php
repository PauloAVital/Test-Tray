<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ControllerVenda;

class ControllerProduto extends Model
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
    
    public function venda() {
        return $this->belongsTo(ControllerVenda::class, 'id_produto', 'id');
    }

    /*public function relProduto() {
        return $this->hasMany('App\Models\ControllerVenda', 'id_produto' ); 
    }*/

}
