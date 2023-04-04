<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TabulagramController extends Controller
{


    private function mergeMonths($month)
    {
        $m = substr($month, -2);

        $m_name = '';
        switch ($m) {
            case "01":
                $m_name = 'январь';     break;
            case "02":
                $m_name = 'февраль';    break;
            case "03":
                $m_name = 'март';       break;
            case "04":
                $m_name = 'апрель';     break;
            case "05":
                $m_name = 'май';        break;
            case "06":
                $m_name = 'июнь';       break;
            case "07":
                $m_name = 'июль';       break;
            case "08":
                $m_name = 'август';     break;
            case "09":
                $m_name = 'сентрябрь';  break;
            case "10":
                $m_name = 'октябрь';    break;
            case "11":
                $m_name = 'ноябрь';     break;
            case "12":
                $m_name = 'декабрь';    break;
        }
        $y_name = substr($month, 0, 4);

        return $m_name . ' '. $y_name;
    }

    public function getDates($id_pers)
    {
        $sql = "
            SELECT  distinct  [Month]
            FROM [shtat].[dbo].[RListHead]
            WHERE id_Pers= :id_pers
            ORDER BY [Month] desc
        " ;
        $tmp_array = array();
        $months = DB::connection('shtat_sqlsrv')->select($sql,["id_pers" => $id_pers]);

        if ($months) {
            foreach ($months as $month) {
                $tmp =  new \StdClass();
                $tmp->id = $month->Month;
                $tmp->name = $this->mergeMonths($month->Month);
                $tmp_array []= $tmp;
            }
        }

        return $tmp_array;
    }
    //
    public function show()
    {
        // узнать какие есть даты по снилс
        $user = Auth::user();
        $str = $user->perscode;
        $id_pers = $str[0] . $str[1] . $str[2] . '-' . $str[3] . $str[4] . $str[5] . '-' . $str[6] . $str[7] . $str[8] . ' ' . $str[9] . $str[10];

        //$id_pers='126-053-187 29';
        $id_pers='023-996-176 82';


        $dates = $this->getDates($id_pers);


        $c_month = \request()->get('c_month');

        if ($c_month) {
            $r_head = $this->getRListHead($id_pers, $c_month);
            if ($r_head) {
                $r_head->r_date = $this->mergeMonths($c_month);
            }
            $r_list = $this->getRList($id_pers, $c_month);
            $r_footer = $this->getRListFooter($id_pers, $c_month);
        }

        $args = array(
            'dates' => $dates,
            'r_head' => $r_head ?? false,
            'r_list' => $r_list ?? false,
            'r_footer' => $r_footer ?? false,
        );
        return view('tabulagram.show', $args);

    }

    private function getRListHead(string $id_pers, $c_month)
    {
        $sql = "
        SELECT *
        FROM [shtat].[dbo].[RListHead]
        WHERE id_Pers= :id_pers and [Month] = :c_month
        " ;
        $tmp_array = array();
        $r_head = DB::connection('shtat_sqlsrv')->select($sql,["id_pers" => $id_pers, "c_month" => $c_month ]);
        if ($r_head) {
            return $r_head[0];
        }
        return  NULL;

    }

    private function getRList(string $id_pers, $c_month)
    {
        $sql = "
        SELECT *
        FROM [shtat].[dbo].[RList]
        WHERE id_Pers= :id_pers and [Month] = :c_month
        ORDER BY [id_str] asc
        " ;

        $r_list =  DB::connection('shtat_sqlsrv')->select($sql,["id_pers" => $id_pers, "c_month" => $c_month ]);

        $array = array();
        if ($r_list)
        {


            foreach ($r_list as $single)
            {
                $array["$single->tip"]['summa'] = 0;
            }


            foreach ($r_list as $single)
            {
                $array["$single->tip"]['tip'] = $single->tip;
                $array["$single->tip"]['summa'] += $single->summa;
                $array["$single->tip"]["items"][] = $single;

            }
        }
        return $array;

    }

    private function getRListFooter(string $id_pers, $c_month)
    {
        $sql = "
        SELECT *
        FROM [shtat].[dbo].[RListFoot]
        WHERE id_Pers= :id_pers and [Month] = :c_month
        " ;
        $tmp_array = array();
        $r_footer = DB::connection('shtat_sqlsrv')->select($sql,["id_pers" => $id_pers, "c_month" => $c_month ]);
        if ($r_footer) {
            return $r_footer[0];
        }
        return  NULL;
    }


}
