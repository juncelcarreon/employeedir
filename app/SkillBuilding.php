<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Valuestore\Valuestore;
use Illuminate\Support\Facades\DB;

class SkillBuilding extends Model
{
    protected $table = 'skill_building';

    protected $primaryKey = 'sb_com_num';

    public static function getSB($id, $admin, $all = null)
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
                `skill_building`.*,
                `lnk_focus`.`fc_desc`,
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
                `skill_building`
            ON 
                `skill_building`.`sb_link_id` = `linking_master`.`lnk_id`
            INNER JOIN
                `employee_info`
            ON
                `employee_info`.`id` = `linking_master`.{$column1}
            INNER JOIN
                `lnk_focus`
            ON
                `lnk_focus`.`fc_id` = `skill_building`.`sb_focus`
            WHERE
                `linking_master`.`lnk_type` = 6 AND
                `linking_master`.{$column2} = {$id}
                {$acknowledged}
        ");

        return $data;
    }

    public static function getSession($id)
    {
        $sb = collect(\DB::select("
            SELECT
                `skill_building`.*,
                `employee_info`.`first_name`,
                `employee_info`.`last_name`,
                `lnk_focus`.`fc_desc`,
                `linking_master`.`lnk_date`,
                `linking_master`.`lnk_linker`,
                `linking_master`.`lnk_linkee`
            FROM
                `linking_master`
            INNER JOIN 
                `skill_building`
            ON 
                `skill_building`.`sb_link_id` = `linking_master`.`lnk_id`
            INNER JOIN
                `employee_info`
            ON
                `employee_info`.`id` = `linking_master`.`lnk_linkee`
            INNER JOIN
                `lnk_focus`
            ON
                `lnk_focus`.`fc_id` = `skill_building`.`sb_focus`
            WHERE
                `skill_building`.`sb_com_num` = '{$id}'
        "))->first();

        return $sb;
    }
}
