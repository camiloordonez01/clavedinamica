@extends('layouts.app')

@section('navigation')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Lista de Usuarios</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Usuarios</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title mt-2">Todos los usuarios del sistema</h3>
                <a href="usuarios/create" class="btn btn-success btn-sm float-right"><i class="fas fa-folder-plus"></i> Crear</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Nombres</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $usuario)
                        <tr>
                            <td>{{$usuario->name}}</td>
                            <td>{{$usuario->email}}</td>
                            <td>{{$usuario->roleName}}</td>
                            <td>    
                                @can('usuarios.edit')
                                <a href="{{URL::action('UsuariosController@edit',$usuario->id)}}" class="btn btn-info btn-sm">
                                    <i class="fas fa-pencil-alt"></i>
                                    Editar
                                </a>
                                @endcan
                                
                                @can('usuarios.destroy')
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-warning-{{$usuario->id}}">
                                    <i class="fas fa-trash"></i> 
                                    Eliminar
                                </button>
                                <div class="modal fade" id="modal-warning-{{$usuario->id}}" aria-modal="true" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modal-warning-{{$usuario->id}}Label">Eliminar usuario</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            {{Form::Open(array('action'=>array('UsuariosController@destroy',$usuario->id),'method'=>'delete'))}}
                                            <div class="modal-body">
                                            <p class="text-center">Confirme si desea eliminar la usuario</p>
                                            </div>
                                            <div class="modal-footer d-flex justify-content-between">
                                                <button type="button" class="btn btn-primary btn-pill" data-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-danger btn-pill">Confirmar</button>
                                            </div>
                                            {{Form::Close()}}
                                        </div>
                                    </div>
                                </div>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Nombres</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<script>
  $(function () {
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
@endsection