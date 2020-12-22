@extends('admin.layouts.app')

@section('title', 'Search - Github')

@section('content')  
<meta name="csrf-token" content="{{ csrf_token() }}" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<style>
    .linha-vertical {
        height: 12px;
        border-left: 2px solid;        
        margin-right: 1%;
        margin-left: 1%;
    }
</style>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            Vendedores
        </div>
        <form class="form-inline" action="" method="POST">
            <div class="card-body">
            @csrf
                <h5 class="card-title">Selecione o Vendedor</h5>
                <select class="form-control" name="vendedor" id="vendedor">
                @foreach($dados as $dado)
                    <?php echo '<option value="'.$dado['id'].'">'.$dado['nome'].'</option>'; ?>
                @endforeach
                </select>
            </div>
            </form>
        
    </div>

    <hr>
    <h2 class="mb-4">Lista de Produtos</h2>
    <table class="table table-hover github-datatable">
        <thead>
            <tr>
                <th>No</th>
                <th>nome</th>
                <th>descrição</th>
                <th>preco</th>                
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script type="text/javascript">
    var $a = jQuery.noConflict()
    $a.fn.dataTable.ext.errMode = 'throw';
    $a(function() {

        var table = $a('.github-datatable').DataTable({
            processing: true,
            serverSide: true,
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'nome',
                    name: 'nome'
                },
                {
                    data: 'descricao',
                    name: 'descricao'
                },
                {
                    data: 'preco',
                    name: 'preco'
                },                
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                },
            ]
        });
    });

    function cadastrar() {        
        $a('.github-datatable tbody td').on('click', function() {            
            
            let id_vendedor = $('#vendedor option:selected').val();

            let $row = $(this).closest("tr"),
                $tds = $row.find("td");

            dados = [];
            $.each($tds, function() {
                dados.push($(this).text());
            });

            let id_produto = dados[0];
            let qtd_prod = 1;
            let preco = dados[3];
            let total_venda = qtd_prod * dados[3];
            let _token   = $('meta[name="csrf-token"]').attr('content');
           

            $.ajax({
                type: 'POST',
                url: "http://localhost:8000/api/Venda",
                data: {
                    id_vendedor: id_vendedor,
                    id_produto: id_produto,
                    qtd_prod: qtd_prod,                    
                    preco: preco,
                    total_venda: total_venda,
                    _token: _token
                },
                success: function(data) {                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Venda',
                        text: ' Realizada com Sucesso!',
                        footer: '<a href="https://www.tray.com.br/" target="_blank">Tray - O seu Negocio Online</a>'
                    });
                }
            });

        });

    }
</script>


@endsection