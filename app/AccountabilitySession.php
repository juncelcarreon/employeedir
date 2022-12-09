<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Valuestore\Valuestore;
use Illuminate\Support\Facades\DB;

class AccountabilitySession extends Model
{
    protected $table = 'accblty_conv';

    protected $primaryKey = 'ac_com_id';
    
    protected $fillable = [
        'ac_link_id', 'ac_com_id', 'ac_focus', 'ac_skill', 'ac_when_use', 'ac_why_use', 'ac_expectations', 'ac_expectation_date', 'ac_comments', 'ac_feedback'
    ];

    public static function getAS($id, $admin, $all = null)
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
                `accblty_conv`.`ac_com_id`,
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
                `accblty_conv`
            ON 
                `accblty_conv`.`ac_link_id` = `linking_master`.`lnk_id`
            INNER JOIN
                `employee_info`
            ON
                `employee_info`.`id` = `linking_master`.{$column1}
            INNER JOIN
                `lnk_focus`
            ON
                `lnk_focus`.`fc_id` = `accblty_conv`.`ac_focus`
            WHERE
                `linking_master`.`lnk_type` = 3 AND
                `linking_master`.{$column2} = {$id}
                {$acknowledged}
        ");

        return $data;
    }

    public static function getSession($id)
    {
        $as = collect(\DB::select("
            SELECT
                `accblty_conv`.*,
                `employee_info`.`first_name`,
                `employee_info`.`last_name`,
                `lnk_focus`.`fc_desc`,
                `linking_master`.`lnk_date`,
                `linking_master`.`lnk_linker`,
                `linking_master`.`lnk_linkee`
            FROM
                `linking_master`
            INNER JOIN 
                `accblty_conv`
            ON 
                `accblty_conv`.`ac_link_id` = `linking_master`.`lnk_id`
            INNER JOIN
                `employee_info`
            ON
                `employee_info`.`id` = `linking_master`.`lnk_linkee`
            INNER JOIN
                `lnk_focus`
            ON
                `lnk_focus`.`fc_id` = `accblty_conv`.`ac_focus`
            WHERE
                `accblty_conv`.`ac_com_id` = '{$id}'
        "))->first();

        return $as;
    }
}
