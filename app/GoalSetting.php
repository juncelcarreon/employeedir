<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Valuestore\Valuestore;
use Illuminate\Support\Facades\DB;

class GoalSetting extends Model
{
    protected $table = 'goal_setting';  

    protected $primaryKey = 'gs_com_id';

    public static function getGS($id, $admin, $all = null)
    {
        $column1 = '`lnk_linker`';
        $column2 = '`lnk_linkee`';
        $acknowledged = "AND `linking_master`.`lnk_acknw` = 1";
        if($admin) {
            $column1 = '`lnk_linkee`';
            $column2 = '`lnk_linker`';
        }

        if(!empty($all)) { $acknowledged = ''; }

        $data = DB::select("
            SELECT
                `goal_setting`.*,
                `employee_info`.`first_name`,
                `employee_info`.`last_name`,
                `linking_master`.`lnk_date`,
                `linking_master`.`lnk_linker`,
                `linking_master`.`lnk_linkee`,
                `linking_master`.`lnk_acknw`,
                `linking_master`.`created_at`
            FROM
                `linking_master`
            INNER JOIN 
                `goal_setting`
            ON 
                `goal_setting`.`gs_link_id` = `linking_master`.`lnk_id`
            INNER JOIN
                `employee_info`
            ON
                `employee_info`.`id` = `linking_master`.{$column1}
            WHERE
                `linking_master`.`lnk_type` = 7 AND
                `linking_master`.{$column2} = {$id}
                {$acknowledged}
        ");

        return $data;
    }

    public static function getSession($id)
    {
        $gs = collect(\DB::select("
            SELECT
                `goal_setting`.*,
                `employee_info`.`first_name`,
                `employee_info`.`last_name`,
                `linking_master`.`lnk_date`,
                `linking_master`.`lnk_linker`,
                `linking_master`.`lnk_linkee`
            FROM
                `linking_master`
            INNER JOIN 
                `goal_setting`
            ON 
                `goal_setting`.`gs_link_id` = `linking_master`.`lnk_id`
            INNER JOIN
                `employee_info`
            ON
                `employee_info`.`id` = `linking_master`.`lnk_linkee`
            WHERE
                `goal_setting`.`gs_com_id` = '{$id}'
        "))->first();

        return $gs;
    }
}
