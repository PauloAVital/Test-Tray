<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ControllerVenda;
use App\Models\ControllerVendedor;
use App\Models\ControllerProduto;

class VendaApiController extends Controller
{
    public function __construct(ControllerVenda $venda,
                                ControllerVendedor $vendedor,
                                ControllerProduto $produto,
                                Request $Request)
    {
        $this->venda = $venda;
        $this->vendedor = $vendedor;
        $this->produto = $produto;
        $this->request = $Request;
    }
    
    public function index()
    {
        $data = ControllerVenda::all();

        $dataComissao =  $this->getComissao($data);
        return response()->json($dataComissao);
    }

    public function getComissao($array)
    {
        $arrayAcresComissao = [];
        $valorTotal = '';
        $valorTotalComissionado = '';
        foreach ($array as $key => &$val) {

           $arrayAcresComissao[$key]['id'] = $val['id_vendedor'];
           $arrayAcresComissao[$key]['id_produto'] = $val['id_produto'];

           #Busca Dados Vendedor
           $dataVendedor = $this->vendedor::where('id', $val['id_vendedor'])->get(['nome','email','comissao']);
           $arrayAcresComissao[$key]['nome'] = $dataVendedor[0]['nome'];
           $arrayAcresComissao[$key]['email'] = $dataVendedor[0]['email'];
           $arrayAcresComissao[$key]['comissao'] = $dataVendedor[0]['comissao'];

           #Busca Dados Produto
           $dataProduto = $this->produto::where('id', $val['id_produto'])->get(['nome','preco']);
           $arrayAcresComissao[$key]['produto'] = $dataProduto[0]['nome'];
           $arrayAcresComissao[$key]['qtd_produto'] = $val['qtd_prod'];
           $arrayAcresComissao[$key]['preco_produto'] = $dataProduto[0]['preco'];

           $total = $val['total_venda'];

           $arrayAcresComissao[$key]['total_venda'] = number_format($val['total_venda'], 2, ',', '.');
           $totalComissionado = $total + ($total / 100 * $arrayAcresComissao[$key]['comissao']);           
           
           $arrayAcresComissao[$key]['total_comissionado'] =  number_format($totalComissionado, 2, ',', '.');
           $arrayAcresComissao[$key]['data_venda'] = date( 'd/m/Y H:i' , strtotime($val['created_at']));
           
        }        
        return $arrayAcresComissao;
    }

    public function validaRequisao() 
    {
        $qtdVendedor = ControllerVendedor::all();
        $qtdProduto = ControllerProduto::all();
        $valid = true;
        
        
        if ($qtdVendedor->count() == 0) {
            $valid = false;
        }

        if ($qtdProduto->count() == 0) {
            $valid = false;
        }
        
        return $valid;
    }

    public function store(Request $request)
    {
        if ($this->validaRequisao() == false) {
            return response()->json(['error'=> 'Produto ou Vendedor Não cadastrado', 404]);
        } else {
            $this->validate($request, $this->venda->rules());
        
            $dataForm =  $request->all();                                    
    
            $data = $this->venda->create($dataForm);
          
            return response()->json($data, 200);
        }
        
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

    public function VendedorVenda($id) 
    {
        if (!$data = $this->venda::where('id_vendedor', $id)->get(['id', 'id_vendedor', 'id_produto','qtd_prod','total_venda','created_at'])) {// AQUI
            return response()->json(['error'=> 'Nada Encontrado', 404]);
        } else {
            $dataVendedorVenda =  $this->getVendaProduto($data);
            return response()->json($dataVendedorVenda);
        }
    }

    public function getVendaProduto($array)
    {
        $arrayVendaProduto = [];
        foreach ($array as $key => &$val) {            
            
            $arrayVendaProduto[$key]['id_produto'] = $val['id_produto'];
            $dataProduto = $this->produto::where('id', $val['id_produto'])->get(['nome','preco']);
        
            $arrayVendaProduto[$key]['produto'] = $dataProduto[0]['nome'];
            $arrayVendaProduto[$key]['preco'] = $dataProduto[0]['preco'];

            $arrayVendaProduto[$key]['qtd_prod'] = $val['qtd_prod'];
            $arrayVendaProduto[$key]['total_venda'] = $val['total_venda'];
            $arrayVendaProduto[$key]['data_venda'] = date( 'd/m/Y H:i' , strtotime($val['created_at']));
            $arrayVendaProduto[$key]['total_venda'] = number_format($val['total_venda'], 2, ',', '.');
            
            $total = $val['total_venda'];
            $dataVendedor = $this->vendedor::where('id', $val['id_vendedor'])->get(['comissao']);
            $totalComissionado = $total + ($total / 100 * $dataVendedor[0]['comissao']);
            $arrayVendaProduto[$key]['total_comissionado'] = number_format($totalComissionado, 2, ',', '.');

        }
        return $arrayVendaProduto;
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
