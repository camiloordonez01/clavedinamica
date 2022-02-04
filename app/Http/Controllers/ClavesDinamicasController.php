<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ClaveDinamica;
use DB;
use Auth;

class ClavesDinamicasController extends Controller
{
    public function index()
    {
        $claves = DB::table('clavedinamica')->
                        join('users', 'users.id','=','clavedinamica.users_id')->
                        whereRaw('(NOW() < ADDDATE(clavedinamica.creacion, INTERVAL 5 minute) or clavedinamica.utilizacion IS NOT NULL)')->
                        select('clavedinamica.*','users.name')->
                        orderBy('clavedinamica.creacion', 'DESC')->get();
        return view('panel.claves.index', ['claves' => $claves]);
    }

    public function create(){
        $clave = $this->getClaveDinamica();

        $claveDinamica = new ClaveDinamica;
        $claveDinamica->clave = $clave;
        $claveDinamica->creacion = date('Y-m-d H:i:s');
        $claveDinamica->users_id = Auth::user()->id;
        $claveDinamica->save();

        $claveDinamica->responsable = Auth::user()->name;
        return $claveDinamica;
    }

    public function update(Request $request){
        $clave = $request->get("clave");
        $dispositivo = $request->get("dispositivo");
        $responsable = $request->get("responsable");
        $accion = $request->get("acciones");

        $search = DB::table('clavedinamica')->
                            where('clave','=', $clave)->
                            whereRaw('NOW() < ADDDATE(creacion, INTERVAL 5 minute)')->get();
        
        if(count($search)==0){
            return [
                'response' => 0,
                'message' => 'Clave invalida'
            ];
        }else{
            if($search[0]->utilizacion==null){
                $claveDinamica = ClaveDinamica::findOrFail($search[0]->id);
                $claveDinamica->utilizacion =  date('Y-m-d H:i:s');
                $claveDinamica->dispositivo = $dispositivo;
                $claveDinamica->responsable = $responsable;
                $claveDinamica->accion = $accion;
                $claveDinamica->update();
                
                return [
                    'response' => 1,
                    'message' => 'Clave correcta'
                ];
            }else{
                return [
                    'response' => 0,
                    'message' => 'Esta clave ya se utilizo'
                ];
            }
        }
    }

    function getClaveDinamica(){
        $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $clave = "";
        $unica = false;

        while(!$unica){ 
            $clave = "";
            
            for($i=0;$i<6;$i++) {
                $clave .= substr($str,rand(0,62),1);
            }

            $search = DB::table('clavedinamica')->
                            where('clave','=', $clave)->count();

            if($search==0){
                $unica = true;
            }
        }

        return $clave;
    }
}
