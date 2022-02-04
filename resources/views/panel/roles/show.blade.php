@extends('layouts.app')

@section('navigation')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Ver rol</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="/roles">Roles</a></li>
              <li class="breadcrumb-item active">Ver</li>
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
                <h3 class="card-title mt-2">Información de un rol del sistema</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="responsive-data-table">
                        <tbody>
                            <tr>
                                <th colspan="2" class="text-center">Datos</th>
                            </tr>
                            <tr>
                                <th>Nombre</th>
                                <td>{{$rol->name}}</td>
                            </tr>
                            <tr>
                                <th>Slug</th>
                                <td>{{$rol->slug}}</td>
                            </tr>
                            <tr>
                                <th>Descripcion</th>
                                <td>
                                    @if($rol->description==null)
                                    Ninguna
                                    @else
                                    {{$rol->description}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Fecha de creacion</th>
                                <td>{{$rol->created_at}}</td>
                            </tr>
                            <tr>
                                <th>Fecha de actualizacion</th>
                                <td>{{$rol->updated_at}}</td>
                            </tr>
                            <tr>
                                <th>Especial</th>
                                <td>
                                    @if($rol->special==null)
                                    Ninguno
                                    @elseif($rol->special=='all-access')
                                    Acceso completo
                                    @elseif($rol->special=='no-access')
                                    Acceso bloqueado
                                    @endif
                                </td>
                            </tr>
                            @if(!($permisos == ''))
                            <tr>
                                <th colspan="2" class="text-center">Permisos</th>
                            </tr>
                            <tr>
                                <th colspan="2" class="text-center">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Slug</th>
                                                <th>Descripcion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($permisos as $permiso)
                                            <tr>
                                                <th>{{$permiso->name}}</th>
                                                <th>{{$permiso->slug}}</th>
                                                <th>{{$permiso->description}}</th>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </th>
                            </tr>
                            @endif
                        </tbody>
                </table>
            </div>
            <div class="card-footer">
                <a href="/roles"  class="btn btn-primary mt-3 float-right">Volver</a>
            </div>
        </div>
    </div>
</div>
@endsection