<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ControllerProduto;
use App\Models\ControllerVendedor;

class ControllerVenda extends Model
{
    protected $table = 'venda';
    protected $fillable = ['id', 
                           'id_vendedor',
                           'id_produto',
                           'qtd_prod',
                           'total_venda'
                          ];

    public function rules()
    {
        return [
            'id_vendedor' => 'required',
            'id_produto' => 'required',
            'total_venda' => 'required'
        ];
    }

    public function produto()
    {
        return $this->hasMany(ControllerVenda::class, 'id_produto', 'id');
    }

    public function vendedor()
    {
        return $this->hasMany(ControllerVenda::class, 'id_vendedor', 'id');
    }

}
