@extends('admin.layouts.app')

@section('title', 'Admin User - Github')

@section('content')
<h1 class="text-center">
    Inserir Produto
</h1>
<hr>
<div class="col-8 m-auto">
<div class="text-center mt-3 mb-4">
        <a href="/produto">
            <button class="btn btn-info">Voltar</button>
        </a>
    </div>
   
        <form name="formCad" id="formCad" method="" action="">   
        
        <input class="form-control mt-3 mb-4" 
               type="text" 
               name="nome" 
               id="nome" 
               value="" 
               placeholder="Nome">

        <input class="form-control mt-3 mb-4" 
               type="text" 
               name="descricao" 
               id="descricao" 
               value="" 
               placeholder="Descrição">

        <input class="form-control mt-3 mb-4" 
               type="text" 
               name="preco" 
               id="preco" 
               value="" 
               placeholder="Preço">
        
        <input class="btn btn-primary mt-3 mb-4" 
               type="submit"
               onclick="EnviarProduto()" 
               value="Enviar">
    </form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    function EnviarProduto(){        
        let nome = $("#nome").val();
        let descricao = $("#descricao").val();
        let preco = $("#preco").val();
        let _token   = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{ url('api/Produto') }}",
            type: "POST",
            data: {
                    nome: nome,
                    descricao: descricao,
                    preco: preco,                    
                    _token: _token
            },
            dataType: "json",
            success:function(resp){                
                alert('Gravado com Sucesso');
            },
            error:function(xhr, err){
                console.log(erro.toString());
            }
        });
    }

    $('#preco').keyup(function() {
       $(this).val(this.value.replace(/[^0-9\.]/g,''));
    });
</script>


@endsection