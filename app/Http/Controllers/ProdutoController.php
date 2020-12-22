<?php

namespace App\Http\Controllers;
use App\Models\ControllerProduto;

use Illuminate\Http\Request;


class ProdutoController extends Controller
{
    public function __construct(ControllerProduto $produto)
    {
        $this->produto = $produto;
    }
    
    public function index()
    {        
        return view('admin.pages.produto.index');
    }

    public function create()
    {       
        return view('admin.pages.produto.create');
    }

    public function produtoUpdate($id){
        if (!$data = $this->produto->find($id)){
            return view('admin.pages.produto.update', compact('data')); 
        } else {
            return view('admin.pages.produto.update', compact('data'));
        }
    }
    
    public function updateProduto(Request $request)
    {                        
        if (!$data = $this->produto->find($request->id)){
            return response()->json(['error'=> 'Nada Encontrado', 404]);
        } else {
            $this->validate($request, $this->produto->rules());
        
            $dataForm =  $request->all();

            $data->update($dataForm);
            
            return view('admin.pages.produto.index');
        }
    }
}
