<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Caffeinated\Shinobi\Models\Role;
use DB;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datos = DB::table('roles')->
                    select('roles.*')->
                    get();
        return view('panel.roles.index',['roles' => $datos,'name' => 'Lista de roles']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datos = DB::table('permissions')->
                    select('permissions.*')->
                    get();
        return view("panel.roles.create",['permisos' => $datos,'name' => 'Crear un rol']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role= new Role;
        $role->name = $request->get('name');
        $role->slug = $request->get('slug');
        $role->description = $request->get('description');
        if(!($request->get('special')=='ninguno')){
            $role->special = $request->get('special');
        }
        $role->created_at = date("y-m-d h:i:s");
        $role->updated_at = date("y-m-d h:i:s");
        $role->save();

        $role->givePermissionTo($request->get('permissions'));
        return Redirect::to('roles')->withSuccess('Rol creado exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $datos = DB::table('roles')->
                    select('roles.*')->
                    where('id','=',$id)->
                    get();
        $permisos = '';
        if(!($datos[0]->special=='all-access' || $datos[0]->special=='no-access')){
            $permisos = DB::table('permissions')->
                            join('permission_role', 'permissions.id', '=', 'permission_role.permission_id')->
                            select('permissions.*')->
                            where('permission_role.role_id','=',$datos[0]->id)->
                            get();
        }
        return view("panel.roles.show",["rol"=> $datos[0],'permisos' => $permisos, 'name' => 'Ver rol']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $datos = DB::table('roles')->
                    select('roles.*')->
                    where('id','=',$id)->
                    get();
        $permisos_rol = '';
        if(!($datos[0]->special=='all-access' || $datos[0]->special=='no-access')){
            $permisos_rol = DB::table('permissions')->
                            join('permission_role', 'permissions.id', '=', 'permission_role.permission_id')->
                            select('permissions.*')->
                            where('permission_role.role_id','=',$datos[0]->id)->
                            get();
        }
        $permisos = DB::table('permissions')->
                    select('permissions.*')->
                    get();
        return view("panel.roles.edit",["rol"=> $datos[0],'permisos_rol' => $permisos_rol,'permisos' => $permisos ,'name' => 'Editar rol']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role= Role::findOrFail($id);
        $role->name = $request->get('name');
        $role->slug = $request->get('slug');
        $role->description = $request->get('description');
        if(!($request->get('special')=='ninguno')){
            $role->special = $request->get('special');
        }else{
            $role->special = null;
        }
        $role->updated_at = date("y-m-d h:i:s");
        $role->update();
        if($request->get('permissions')==null){
            $role->syncPermissions([]);
        }else{
            $role->syncPermissions($request->get('permissions'));
        }
        return Redirect::to('roles')->withSuccess('Rol editado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role=ROLE::findOrFail($id);
        $role->delete();

        return Redirect::to('roles')->withSuccess('Rol eliminado exitosamente');
    }
}
