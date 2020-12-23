<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;
use App\Models\ControllerVenda;
use App\Models\ControllerVendedor;
use App\Models\ControllerProduto;


class TraySendMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct()
    {
        $this->venda = new ControllerVenda();
        $this->vendedor = new ControllerVendedor();
        $this->produto = new ControllerProduto();
    }

    public function getVendasDia() 
    {
       // $Venda = new ControllerVenda();
        //$data = $Venda::all();
        $Produtos = new ControllerProduto();
        $data = $Produtos::all();
        $dataComissao =  $this->getComissao($data);
        return response()->json($dataComissao);
    }

    public function getComissao()
    {
        $arrayAcresComissao = [];
        $array = ControllerVenda::all();
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

    public function valorTotal() {
        
        $array = ControllerVenda::all();
        $total = 0;

        foreach ($array as $key => &$val) {
            $total = $total + $val['total_venda'];
        }

        return $total;
    }

    public function valorTotalComissionado() {
        
        $array = ControllerVenda::all();
        $total = 0;

        foreach ($array as $key => &$val) {
            $totalComissionado = $val['total_venda'] + ($val['total_venda'] / 100 * 8.5);
            $total = $total + $totalComissionado;
        }

        return $total;
    }

    public function build()
    {
        $dados = $this->getComissao();
        $valorTotal = $this->valorTotal();
        $valorTotalComissionado = $this->valorTotalComissionado();
       
        return $this->view('emails.TraySendMail', compact('dados', 'valorTotal', 'valorTotalComissionado'));
    }
}
