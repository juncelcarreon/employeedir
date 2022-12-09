<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Valuestore\Valuestore;
use Illuminate\Support\Facades\DB;

class SkillsDevelopment extends Model
{
    protected $table = 'sda';

    protected $primaryKey = 'sda_com_id';
    
    protected $fillable = [
        'sda_lnk_id', 'sda_com_id', 'sda_type', 'sda_date_call', 'sda_call_sel', 'sda_www_u_said', 'sda_www_i_said', 
        'sda_wcm_u_said', 'sda_wcm_i_said', 'sda_take_away', 'sda_timeframe', 'sda_comments', 'sda_feedback'
    ];

    public static function getSDA($id, $admin, $all = null)
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
                `sda`.*,
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
                `sda`
            ON 
                `sda`.`sda_lnk_id` = `linking_master`.`lnk_id`
            INNER JOIN
                `employee_info`
            ON
                `employee_info`.`id` = `linking_master`.{$column1}
            WHERE
                `linking_master`.`lnk_type` = 4 AND
                `linking_master`.{$column2} = {$id}
                {$acknowledged}
        ");

        foreach($data as $sda) {
            $sda_type_desc = '';
            switch($sda->sda_type) {
                case 1: $sda_type_desc = 'Call Listening Session'; break;
                case 2: $sda_type_desc = 'Mock Calls'; break;
                case 3: $sda_type_desc = 'Calibration Sessions'; break;
            }

            $sda->sda_type_desc = $sda_type_desc;
        }

        return $data;
    }

    public static function getSession($id)
    {
        $sda = collect(\DB::select("
            SELECT
                `sda`.*,
                `employee_info`.`first_name`,
                `employee_info`.`last_name`,
                `linking_master`.`lnk_date`,
                `linking_master`.`lnk_linker`,
                `linking_master`.`lnk_linkee`
            FROM
                `linking_master`
            INNER JOIN 
                `sda`
            ON 
                `sda`.`sda_lnk_id` = `linking_master`.`lnk_id`
            INNER JOIN
                `employee_info`
            ON
                `employee_info`.`id` = `linking_master`.`lnk_linkee`
            WHERE
                `sda`.`sda_com_id` = '{$id}'
        "))->first();

        if(!empty($sda)) {
            $sda_type_desc = '';
            switch($sda->sda_type) {
                case 1: $sda_type_desc = 'Call Listening Session'; break;
                case 2: $sda_type_desc = 'Mock Calls'; break;
                case 3: $sda_type_desc = 'Calibration Sessions'; break;
            }

            $sda->sda_type_desc = $sda_type_desc;
        }

        return $sda;
    } 
}
