@extends('layouts.app')

@section('content')
<style>
    .container img {
        max-width:200px;
        max-height:150px;
        width: auto;
        height: auto;
    }
    .card-titles {
        width: 13rem; 
        float: left; 
        margin-right: 1%
    }
</style>
<div class="container">
    
    <div class="accordion" id="accordionExample">
        <div class="card">
            <div class="card-header" id="headingOne">
            <h5 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Controle de Vendas
                </button>
            </h5>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
            
            <div class="row justify-content-center">
        <div class="col-md-12">
        <div class="row">

            <div class="col-sm-6">
                <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Realizar Venda</h5>
                    <p class="card-text">Vender</p>
                    <a href="/Vender" class="btn btn-primary">Conectar</a>
                </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Relatório de Vendas</h5>
                    <p class="card-text">Relatório de Vendas.</p>
                    <a href="/relVenda" class="btn btn-primary">Conectar</a>
                </div>
                </div>
            </div>
        </div>
            
        </div>
            

            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingTwo">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                   Controle Vendedores / Produtos
                </button>
            </h5>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
            
             <div class="row justify-content-center">
        <div class="col-md-12">
        <div class="row">

            <div class="col-sm-6">
                <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Vendedores</h5>
                    <p class="card-text">Controle de Vendedores.</p>
                    <a href="/vendedor" class="btn btn-primary">Conectar</a>
                </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Produtos</h5>
                    <p class="card-text">Controle dos Produtos.</p>
                    <a href="/produto" class="btn btn-primary">Conectar</a>
                </div>
                </div>
            </div>
        </div>
            
        </div>
    </div>
            

            </div>
        </div>
        
        </div>
</div>
@endsection