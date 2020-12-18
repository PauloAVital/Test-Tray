<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ControllerVenda;

class VendaApiController extends Controller
{
    public function __construct(ControllerVenda $venda,
                                Request $Request)
    {
        $this->venda = $venda;
        $this->request = $Request;
    }
    
    public function index()
    {
        $data = ControllerVenda::all();
        return response()->json($data);
    }
 
    public function store(Request $request)
    {
        $this->validate($request, $this->venda->rules());
        
        $dataForm =  $request->all();

        $data = $this->venda->create($dataForm);
        
        return response()->json($data, 200);
    }

    public function show($id)
    {
        if (!$data = $this->venda->find($id)) {
            return response()->json(['error'=> 'Nada Encontrado', 404]);
        } else {
            return response()->json($data);
        }
    }

    public function update(Request $request, $id)
    {
        if (!$data = $this->venda->find($id)){
            return response()->json(['error'=> 'Nada Encontrado', 404]);
        } else {
            $this->validate($request, $this->venda->rules());
        
            $dataForm =  $request->all();

            $data->update($dataForm);
            
            return response()->json($data);
        }
    }

    public function destroy($id)
    {
        if (!$data = $this->venda->find($id)){
            return response()->json(['error'=> 'Nada Encontrado', 404]);
        } else {
            $data->delete();

            return response()->json(['success'=> 'Deletado com Sucesso']);
        }
    }

    public function ProdutoVenda($id) 
    {
        if (!$data = $this->venda::where('id_produto', $id)->get(['id','id_produto'])) {
            return response()->json(['error'=> 'Nada Encontrado', 404]);
        } else {
            return response()->json($data);
        }
    }

    public function Produtos($id)
    {        
        if(!$data = $this->venda->with('produto')->find($id)) {
            return response()->json(['error'=> 'Nada Encontrado', 404]);
        } else {
            return response()->json($data);
        }
    }

    public function Vendedores($id)
    {        
        if(!$data = $this->venda->with('vendedor')->find($id)) {
            return response()->json(['error'=> 'Nada Encontrado', 404]);
        } else {
            return response()->json($data);
        }
    }
}
