@extends('layouts.app')

@section('navigation')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Editar usuario</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="/usuarios">Usuarios</a></li>
              <li class="breadcrumb-item active">Editar</li>
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
                <h3 class="card-title mt-2">Actualizar los datos de un usuario</h3>
            </div>
            <!-- /.card-header -->
            {!!Form::model($usuario,['method'=>'PUT','route'=>['Usuarios.update',$usuario->id]])!!}
            {{Form::token()}}
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="nombres">Nombre completo</label>
                        <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombres completos" required value="{{$usuario->name}}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="roles_id">Rol</label>
                        {!!Form::select('roles_slug', $roles, $usuario->roleSlug, ['id' => 'roles','class'=>'form-control selectpicker p-0','data-live-search' => 'true','placeholder' => 'Seleccionar rol','required'])!!}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="correo">Correo</label>
                        <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo electronico" required value="{{$usuario->email}}">
                    </div>
                    <div class="form-group  col-md-6">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-info">Editar</button>
                <a href="/usuarios" class="btn btn-default float-right">Cancelar</a>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
</div>
@endsection