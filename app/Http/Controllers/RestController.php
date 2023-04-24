<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RestController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $str = $user->perscode;
        $sql = "
           SELECT
            [id_Pers]  ,[shtat_name],[TypeRest_Name] ,[Length_OnDate],[id_work], [Work]
           FROM [shtat].[dbo].[V_Rest]
          WHERE  id_Pers = :id_pers
        " ;
        $id_pers = $str;



        $rests = DB::connection('shtat_sqlsrv')->select($sql,["id_pers" => $id_pers]);

        return view('rest.show', array('rests' => $rests));
    }
}
