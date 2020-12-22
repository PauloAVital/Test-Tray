@extends('admin.layouts.app')

@section('title', 'Admin User - Github')

@section('content')
<h1 class="text-center">
    Inserir Pessoa
</h1>
<hr>
<div class="col-8 m-auto">
<div class="text-center mt-3 mb-4">
        <a href="/users">
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
               name="endereco" 
               id="endereco" 
               value="" 
               placeholder="Endereço">
        
        <input class="btn btn-primary mt-3 mb-4" 
               type="submit"
               onclick="EnviarPessoa()" 
               value="Enviar">
    </form>
</div>

<script>
    function EnviarPessoa(){        
        let nome = $("#nome").val();
        let endereco = $("#endereco").val();
        let _token   = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{ url('api/Pessoa') }}",
            type: "POST",
            data: {
                    nome: nome,
                    endereco: endereco,                    
                    _token: _token
            },
            dataType: "json",
            success:function(resp){                
                alert(resp);
            },
            error:function(xhr, err){
                console.log(erro.toString());
            }
        });
    }

</script>
@endsection