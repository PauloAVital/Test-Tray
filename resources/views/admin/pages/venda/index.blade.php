@extends('admin.layouts.app')

@section('title', 'Admin User - Github')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<div class="col-8 m-auto">
    @csrf
    <div class="text-center mt-3 mb-4">
        <h3>RELATÓRIO DE VENDAS DOS VENDEDORES</h3>
    </div>
    
    <table class="table text-center">
        <thead class="thead-dark">
            <tr>
                <th>Id</th>                
                <th>nome</th>
                <th>email</th>
                <th>comissão</th>            
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="rest">
            
        </tbody>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
  
    $("#rest").html("");
    let html = "";
    let subhtml = "";    

    $(document).ready(function(){
        $.ajax({
            url: "{{ url('api/Vendedor') }}",
            type: "GET",
            dataType: "json",
            success:function(resp){                
                $.each(resp, function(index, value){
                    montarTabela(value);
                });
            },
            error:function(xhr, err){
                console.log(erro.toString());
            }
        });       
    });

    function montarTabela(valueEnv) {
        var surl = "";
        html += "<tr>";
        html += "<td>"+valueEnv.id+"</td>";
        html += "<td>"+valueEnv.nome+"</td>";
        html += "<td>"+valueEnv.email+"</td>";
        html += "<td>"+valueEnv.comissao+"</td>";      
        html += "<td  width='200'>";
        html += "   <a href='#' onclick='esconderLinha("+valueEnv.id+")'> <button class='btn btn-light fa fa-plus'></button> </a>";
        html += "   <a href='#' onclick='VendedorUpdate("+valueEnv.id+")'> <button class='btn btn-primary fa fas fa-edit'></button> </a>";
        html += "   <a href='#' onclick='DeletarVendedor("+valueEnv.id+")'> <button class='btn btn-danger fa fas fa-eraser'></button> </a>";
        html += "</td>";
        html += "</tr>";
        html += "<tr id='"+valueEnv.id+"' style='display: none'>";
        html += "   <td></td>";
        html += "   <td colspan='4'>";
        html += "       <table class='table table-bordered'>";
        html += "           <thead><tr>";
        html += "           <th> Produto </th>";
        html += "           <th> Preco </th>";
        html += "           <th> Quantidade </th>";
        html += "           <th> Valor da Venda </th>";
        html += "           <th> Valor da Venda Comissionada </th>";
        html += "           <th> Data da Venda </th>";
        html += "           <th> Action </th>";
        html += "           </tr></thead>";
        html += "           <tbody id='SubRest"+valueEnv.id+"'>";

       var surl = "http://localhost:8000/api/VendedorVenda/"+valueEnv.id;

        $.ajax({
            url: surl,
            type: "GET",
            dataType: "Json",
            success:function(resp){
                $("#SubRest"+valueEnv.id).html("");
                console.log(resp);
                $.each(resp, function(index, value){
                   subhtml += "<tr>";
                   subhtml += "  <td>"+value.produto+"</td>";
                   subhtml += "  <td>"+value.preco+"</td>";
                   subhtml += "  <td>"+value.qtd_prod+"</td>";
                   subhtml += "  <td>"+value.total_venda+"</td>";
                   subhtml += "  <td>"+value.total_comissionado+"</td>";
                   subhtml += "  <td>"+value.data_venda+"</td>";
                   subhtml += "<td  width='200'>";                   
                   subhtml += "   <a href='#' onclick='ProdutoUpdate("+value.id_produto+")'> <button class='btn btn-primary fa fas fa-edit'></button> </a>";
                   subhtml += "   <a href='#' onclick='DeletarProduto("+value.id_produto+")'> <button class='btn btn-danger fa fas fa-eraser'></button> </a>";
                   subhtml += "</td>";
                   subhtml += "</tr>";
                });
                $("#SubRest"+valueEnv.id).html(subhtml);
                subhtml = "";
            },
            error:function(xhr, err){
                console.log(erro.toString());
            }
        });
                
        html += "           </tbody>";
        html += "       </table>";
        html += "   </td>";
        html += "</tr>";


        $("#rest").html(html);
        
    }

    function esconderLinha(idDaLinha) {
        $("#" + idDaLinha).toggle();
    }

    function DeletarVendedor(id) {

        var url = "http://localhost:8000/api/Vendedor/"+id;
        Swal.fire({
            title: 'Exclusão?',
            text: "Você tem certeza que deseja excluir o Vendedor!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, Deletar!'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: "DELETE",
                    dataType: "json",
                    success:function(resp){                
                        Swal.fire(
                            'Excluído!',
                            'Vendedor excluído com sucesso.',
                            'success'
                            )
                        location.reload();
                    },
                    error:function(xhr, err){
                        console.log(erro.toString());
                    }
                });
                
            }
        });
        }

        function DeletarProduto(id) {

            var url = "http://localhost:8000/api/Produto/"+id;
            Swal.fire({
                title: 'Exclusão?',
                text: "Você tem certeza que deseja excluir o Produto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, Deletar!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: "DELETE",
                        dataType: "json",
                        success:function(resp){                
                            Swal.fire(
                                'Excluído!',
                                'Produto excluído com sucesso.',
                                'success'
                                )
                            location.reload();
                        },
                        error:function(xhr, err){
                            console.log(erro.toString());
                        }
                    });
                    
                }
            });
            }


    function ProdutoUpdate(id){
    var url = "http://localhost:8000/ProdutoUpdate/"+id;
    $(location).attr('href', url);
    }

    function VendedorUpdate(id){
        var url = "http://localhost:8000/VendedorUpdate/"+id;
        $(location).attr('href', url);
    }

    
</script>

@endsection