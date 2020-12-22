<?php

namespace App\Http\Controllers;
use App\Models\ControllerVenda;
use App\Models\ControllerVendedor;
use GuzzleHttp\Client;
use DataTables;

use Illuminate\Http\Request;

class VendaController extends Controller
{
    public function __construct(ControllerVenda $venda,
                                ControllerVendedor $vendedores)
    {
        $this->venda = $venda;
        $this->vendedores = $vendedores;
    }
    
    public function index()
    {        
        return view('admin.pages.venda.index');
    }

    public function create()
    {       
        return view('admin.pages.venda.create');
    }

    public function relVenda()
    {        
        return view('admin.pages.venda.index');
    }

    public function vendaUpdate($id){
        if (!$data = $this->venda->find($id)){
            return view('admin.pages.venda.update', compact('data')); 
        } else {
            return view('admin.pages.venda.update', compact('data'));
        }
    }
    
    public function updateVenda(Request $request)
    {                        
        if (!$data = $this->venda->find($request->id)){
            return response()->json(['error'=> 'Nada Encontrado', 404]);
        } else {
            $this->validate($request, $this->venda->rules());
        
            $dataForm =  $request->all();

            $data->update($dataForm);
            
            return view('admin.pages.venda.index');
        }
    }

    public function Vender(Request $request) {
        
        $client = new Client();
       
        $response = $client->request('GET', 'http://tray-nginx/api/Produto/');        
        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        $retProdutos = json_decode($body, true);
       
        $response = array();
        foreach ($retProdutos as $result) {
            $elements = array(
                    "nome" => $result['nome'], 
                    "descricao" => $result['descricao'],
                    "preco" => $result['preco']
                );
            array_push($response, $elements);
        }

        if ($request->ajax()) {
            return DataTables::of($response)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" id="buttonLocalizar" class="edit btn btn-info btn-sm" onclick="cadastrar()">Vender</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $dados = ControllerVendedor::all();
        return view('admin.pages.venda.realizaVenda', compact('dados'));
    }
}
