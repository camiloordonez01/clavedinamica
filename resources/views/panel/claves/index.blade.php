@extends('layouts.app')

@section('navigation')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Lista de claves generadas</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Claves dinamicas</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('content')
<style>
    #digitos{
        font-size: 220px;
    }
    @media (max-width: 600px) {
        #digitos{
            font-size: 85px;
        }
    }
</style>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <button type="button" class="btn btn-primary" id="generarClave">Generar Clave</button>
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                            <th>Clave</th>
                            <th width="150">Creacion</th>
                            <th width="150">Utilizacion</th>
                            <th>Responsable 1</th>
                            <th>Responsable 2</th>
                            <th>Acciones</th>
                            <th width="300">Dispositivo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($claves as $clave)
                        <tr>
                            <td>{{$clave->clave}}</td>
                            <td>{{date('Y-m-d h:i A',strtotime($clave->creacion))}}</td>
                            <td>@if($clave->utilizacion) {{date('Y-m-d h:i A',strtotime($clave->utilizacion))}} @else N/A @endif</td>
                            <td>{{$clave->name}}</td>
                            <td>@if($clave->responsable) {{$clave->responsable}} @else N/A @endif</td>
                            <td>@if($clave->accion) {{$clave->accion}} @else N/A @endif</td>
                            <td width="300">@if($clave->dispositivo) {{$clave->dispositivo}} @else N/A @endif</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <div class="row">
            <div class="col-md text-center">
                <h1 id="digitos">A</h1>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
    $(document).ready(function () {
        let table = $('#table').DataTable({
            "order": [[ 1, "desc" ]],
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
        $('#generarClave').click(function(){
            $.ajax({
                url:'claves/generar',
                data:{"_token": "{{ csrf_token() }}"},
                type:'GET',
                success: function (response) {
                    $('#digitos').html(response.clave);

                    // $('#table').DataTable().destroy();
                    // let html = '<tr>';
                    // html += '       <td>'+response.clave+'</td>';
                    // html += '       <td>'+response.creacion+'</td>';
                    // html += '       <td> N/A </td>';
                    // html += '       <td>'+response.responsable+'</td>';
                    // html += '       <td> N/A </td>';
                    // html += '       <td> N/A </td>';
                    // html += '       <td> N/A </td>';
                    // html += '   </tr>';
                    // $('#table tbody').before(html);

                    // $('#table').DataTable({
                    //     "order": [[ 1, "desc" ]],
                    //     "paging": true,
                    //     "lengthChange": false,
                    //     "searching": false,
                    //     "info": true,
                    //     "autoWidth": false,
                    //     "responsive": true,
                    // });
                    $('#exampleModalCenter').modal('show');
                }
            });
        });
    });
</script>
@endsection