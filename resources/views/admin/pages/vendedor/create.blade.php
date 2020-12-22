@extends('admin.layouts.app')

@section('title', 'Admin User - Github')

@section('content')
<h1 class="text-center">
    Inserir Vendedor
</h1>
<hr>
<div class="col-8 m-auto">
<div class="text-center mt-3 mb-4">
        <a href="/vendedor">
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
               name="email" 
               id="email" 
               value="" 
               placeholder="E-mail">
        <input class="form-control mt-3 mb-4" 
               type="text" 
               name="comissao" 
               id="comissao" 
               value="" 
               placeholder="Comissão">
        
        <input class="btn btn-primary mt-3 mb-4" 
               type="submit"
               onclick="EnviarVendedor()" 
               value="Enviar">
    </form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    function EnviarVendedor(){        
        let nome = $("#nome").val();
        let email = $("#email").val();
        let comissao = $("#comissao").val();
        let _token   = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{ url('api/Vendedor') }}",
            type: "POST",
            data: {
                    nome: nome,
                    email: email,
                    comissao: comissao,                    
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
    $('#comissao').keyup(function() {
       $(this).val(this.value.replace(/[^0-9\.]/g,''));
    });
</script>
@endsection