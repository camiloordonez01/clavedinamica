<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Caffeinated\Shinobi\Models\Role;
use caffeinated\shinobi\src\Concerns\HasRoles;
use App\User;
use DB;


class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = DB::table('users')->
                    join('role_user', 'role_user.user_id', '=', 'users.id')->
                    join('roles', 'roles.id', '=', 'role_user.role_id')->
                    select('users.*','roles.name as roleName')->get();
        return view('panel.usuarios.index',['usuarios' => $usuarios]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rolesAux = DB::table('roles')->
                        select('roles.slug','roles.name')->get();
        $roles;
        foreach($rolesAux as $role){
            $roles[$role->slug] = $role->name;
        }
        
        return view('panel.usuarios.create',['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $this->validate($request, [
                'password' => 'required|min:8',
            ]);
            $user = new User;
            $user->email = $request->get('correo');
            $user->name = $request->get('nombres');
            $user->password = bcrypt($request->get('password'));
            $user->created_at = date("Y-m-d H:i:s");
            $user->updated_at = date("Y-m-d H:i:s");
            $user->save();
            
            $user->assignRoles($request->get('roles_slug'));

            return Redirect::to('usuarios')->withSuccess('Usuario creado exitosamente');
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            return Redirect::back()->withErrors($e->errorInfo[2]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rolesAux = DB::table('roles')->
                        select('roles.slug','roles.name')->get();
        $roles;
        foreach($rolesAux as $role){
            $roles[$role->slug] = $role->name;
        }

        $usuarios = DB::table('users')->
                    join('role_user', 'role_user.user_id', '=', 'users.id')->
                    join('roles', 'roles.id', '=', 'role_user.role_id')->
                    where('users.id','=',$id)->
                    select('users.*','roles.slug as roleSlug')->get();
        
        return view('panel.usuarios.edit',['roles' => $roles, 'usuario' => $usuarios[0]]);
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
        try{
            $this->validate($request, [
                'password' => 'required|min:8',
            ]);
            $user = User::findOrFail($id);
            $user->email = $request->get('correo');
            $user->name = $request->get('nombres');
            $user->password = bcrypt($request->get('password'));
            $user->created_at = date("Y-m-d H:i:s");
            $user->updated_at = date("Y-m-d H:i:s");
            $user->save();
            
            $user->assignRoles($request->get('roles_slug'));

            return Redirect::to('usuarios')->withSuccess('Usuario editado exitosamente');
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            return Redirect::back()->withErrors($e->errorInfo[2]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return Redirect::to('usuarios')->withSuccess('Usuario eliminado exitosamente');
    }
}
