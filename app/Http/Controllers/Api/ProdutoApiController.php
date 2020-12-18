<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ControllerProduto;

class ProdutoApiController extends Controller
{
    public function __construct(ControllerProduto $produto,
                                Request $Request)
    {
        $this->produto = $produto;
        $this->request = $Request;
    }


    public function index()
    {
        $data = ControllerProduto::all();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->produto->rules());
        
        $dataForm =  $request->all();

        $data = $this->produto->create($dataForm);
        
        return response()->json($data, 200);
    }

    public function show($id)
    {
        if (!$data = $this->produto->find($id)) {
            return response()->json(['error'=> 'Nada Encontrado', 404]);
        } else {
            return response()->json($data);
        }
    }

    public function update(Request $request, $id)
    {
        if (!$data = $this->produto->find($id)){
            return response()->json(['error'=> 'Nada Encontrado', 404]);
        } else {
            $this->validate($request, $this->produto->rules());
        
            $dataForm =  $request->all();

            $data->update($dataForm);
            
            return response()->json($data);
        }
    }

    public function destroy($id)
    {
        if (!$data = $this->produto->find($id)){
            return response()->json(['error'=> 'Nada Encontrado', 404]);
        } else {
            $data->delete();

            return response()->json(['success'=> 'Deletado com Sucesso']);
        }
    }
}
