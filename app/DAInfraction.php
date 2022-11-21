<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class DAInfraction extends Model
{
    use SoftDeletes;

    protected $table = 'da_infraction';

    public static function getInfractions($in_status = null, $in_id = null){
        $query = '';
        if(isset($in_status)) { 
            $query = " AND `da_infraction`.`status` = {$in_status}";
        }

        if(isset($in_id)) {
            $query .= " AND `da_infraction`.`employee_id` = {$in_id}";
        }

        $data = DB::select("
            SELECT
                `da_infraction`.*,
                `employee_info`.`last_name`,
                `employee_info`.`first_name`,
                `employee_info`.`email`,
                `employee_info`.`supervisor_id`,
                `employee_info`.`manager_id`,
                `employee_info`.`contact_number`,
                `employee_info`.`position_name`,
                `employee_info`.`team_name`
            FROM
                `da_infraction`
            INNER JOIN 
                `employee_info`
            ON 
                `da_infraction`.`employee_id` = `employee_info`.`id`
            WHERE
                `employee_info`.`deleted_at` IS NULL AND
                `employee_info`.`status` = 1 {$query}
            ORDER BY 
                `da_infraction`.`created_at` 
            DESC
        ");

        return $data;
    }
}
