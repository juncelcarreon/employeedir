<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Valuestore\Valuestore;
use Illuminate\Support\Facades\DB;

class QuickLink extends Model
{
    protected $table = 'quick_link';

    protected $primaryKey = 'rf_lnk_id';

    protected $fillable = [
        'rf_lnk_id', 'rf_focus', 'rf_comments'
    ];

    public static function getQL($id, $admin, $all = null)
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
                `quick_link`.`rf_lnk_id`,
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
                `quick_link`
            ON 
                `quick_link`.`rf_lnk_id` = `linking_master`.`lnk_id`
            INNER JOIN
                `employee_info`
            ON
                `employee_info`.`id` = `linking_master`.{$column1}
            INNER JOIN
                `lnk_focus`
            ON
                `lnk_focus`.`fc_id` = `quick_link`.`rf_focus`
            WHERE
                `linking_master`.`lnk_type` = 1 AND
                `linking_master`.{$column2} = {$id}
                {$acknowledged}
        ");

        return $data;
    }

    public static function getSession($id)
    {
        $ql = collect(\DB::select("
            SELECT
                `quick_link`.*,
                `employee_info`.`first_name`,
                `employee_info`.`last_name`,
                `lnk_focus`.`fc_desc`,
                `linking_master`.`lnk_date`,
                `linking_master`.`lnk_linker`,
                `linking_master`.`lnk_linkee`
            FROM
                `linking_master`
            INNER JOIN 
                `quick_link`
            ON 
                `quick_link`.`rf_lnk_id` = `linking_master`.`lnk_id`
            INNER JOIN
                `employee_info`
            ON
                `employee_info`.`id` = `linking_master`.`lnk_linkee`
            INNER JOIN
                `lnk_focus`
            ON
                `lnk_focus`.`fc_id` = `quick_link`.`rf_focus`
            WHERE
                `quick_link`.`rf_lnk_id` = {$id}
        "))->first();

        return $ql;
    }
}
