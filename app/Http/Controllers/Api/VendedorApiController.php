<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ControllerVendedor;


class VendedorApiController extends Controller
{
    public function __construct(ControllerVendedor $vendedor,
                                Request $Request)
    {
        $this->vendedor = $vendedor;
        $this->request = $Request;
    }
    
    public function index()
    {
        $data = ControllerVendedor::all();
        $dataVendedor =  $this->getVendedor($data);
        return response()->json($dataVendedor);
    }

    public function getVendedor($array) 
    {
        $arrayVendedor = [];
        foreach ($array as $key => &$val){
            $arrayVendedor[$key]['id'] = $val['id'];
            $arrayVendedor[$key]['nome'] = $val['nome'];
            $arrayVendedor[$key]['email'] = $val['email'];
            $arrayVendedor[$key]['comissao'] = $val['comissao'];
        }
        return $arrayVendedor;
    }

    public function getVendedorVendaProduto($array) 
    {
        $arrayVendedor = [];
        //var_dump($array);
        foreach ($array as $key => &$val){
            $arrayVendedor[$key]['id'] = $val['id'];
            $arrayVendedor[$key]['nome'] = $val['nome'];
            $arrayVendedor[$key]['email'] = $val['email'];
            $arrayVendedor[$key]['comissao'] = $val['comissao'];

        }
        return $arrayVendedor;
    }

    public function VendedorVendaProduto()
    {
        $data = ControllerVendedor::all();
        $dataVendedor =  $this->getVendedorVendaProduto($data);
        return response()->json($dataVendedor);
    }

    
    public function store(Request $request)
    {
        $this->validate($request, $this->vendedor->rules());
        
        $dataForm =  $request->all();

        $data = $this->vendedor->create($dataForm);
        
        return response()->json($data, 200);
    }

    
    public function show($id)
    {
        if (!$data = $this->vendedor->find($id)) {
            return response()->json(['error'=> 'Nada Encontrado', 404]);
        } else {
            return response()->json($data);
        }
    }

    public function update(Request $request, $id)
    {
        if (!$data = $this->vendedor->find($id)){
            return response()->json(['error'=> 'Nada Encontrado', 404]);
        } else {
            $this->validate($request, $this->vendedor->rules());
        
            $dataForm =  $request->all();

            $data->update($dataForm);
            
            return response()->json($data);
        }
    }

    
    public function destroy($id)
    {
        if (!$data = $this->vendedor->find($id)){
            return response()->json(['error'=> 'Nada Encontrado', 404]);
        } else {
            $data->delete();

            return response()->json(['success'=> 'Deletado com Sucesso']);
        }
    }
}
