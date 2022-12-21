<?php

namespace App;

use App\LeaveRequestDetails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Valuestore\Valuestore;
use Illuminate\Support\Facades\DB;

class LeaveRequest extends Model
{
    protected $table = 'leave_request';

    public function employee()
    {
    	return $this->belongsTo('App\User', 'employee_id');
    }

    public function leave_type()
    {
    	return $this->belongsTo('App\LeaveType');
    }

    public function pay_type()
    {
    	return $this->belongsTo('App\PayType');
    }

    public function leave_details_from()
    {
        return $this->hasMany('App\LeaveRequestDetails',"leave_id")->orderBy("date","asc")->take(1);

    }

    public function leave_details_to()
    {
        return $this->hasMany('App\LeaveRequestDetails',"leave_id")->orderBy("date","desc")->take(1);
    }

    public function leave_details()
    {
        return $this->hasMany('App\LeaveRequestDetails',"leave_id");
    }

    public function scopeUnapproved($query)
    {
        return $query->where('approve_status_id', '=', 0)->orWhereNull('approve_status_id');
    }

    public function recipients()
    {
        $settings = Valuestore::make(storage_path('app/settings.json'));

        $main_recipients = json_decode($settings->get('leave_email_main_recipients'));
        $business_leaders = json_decode($settings->get('business_leaders'));

        $email_recipients = [];
        $business_leader_emails = [];

        if ($main_recipients != NULL){
            foreach ($main_recipients as $key => $email) {
                array_push($email_recipients, $email->value);
            }
        }
        if ($business_leaders != NULL){
            foreach ($business_leaders as $key => $email) {
                array_push($business_leader_emails, $email->value);
            }
        }

        // GET SUPERVISOR AND MANAGER EMAILS
        $supervisor_recipient = $this->employee->supervisor_email();
        $manager_recipient = $this->employee->manager_email();

        if ($this->employee->isManager() || $this->employee->isBusinessLeader()){
            array_push($email_recipients, $this->employee->generalManager()->email);
        } else if ($this->employee->isSupervisor()) {
            array_push($email_recipients, $this->employee->generalManager()->email);
            array_push($email_recipients, $manager_recipient);
        } else if ($this->employee->isRankAndFile()){
            array_push($email_recipients, $supervisor_recipient);
            array_push($email_recipients, $manager_recipient);
        } 
        return array_values(array_filter(array_unique($email_recipients)));
    }

    public function scopeManagedBy($query, $user)
    {
        $id = $user->id;
        return $query->whereHas('employee', function($q) use ($id){
            $q->where('supervisor_id', '=',$id);
        })->orWhereHas('employee', function($q) use ($id){
            $q->where('manager_id', '=',$id);
        });
    }

    public function scopeMyLeaves($query,$user)
    {
        $id = $user->id;
        return $query->where('employee_id','=',$id);
    }

    public function scopeStatus()
    {
        if($this->approve_status == 1){
            return "Approved";
        } else if($this->approved_by_signed_date != NULL){
            return "Approved";
        } else if($this->noted_by_signed_date != NULL){
            return "Approved";
        } else if($this->recommending_approval_by_signed_date != NULL){
            return "Recommended";
        } else {
            return "Not yet approved";
        }
    }

    public function getApprovalStatus()
    {
        if($this->approve_status_id == 0){
            return '<span class="fa fa-refresh"></span> Waiting for response';
        } else if($this->approve_status_id == 1){
            return '<span class="fa fa-check" style="color: green"></span> Approved';
        } else if($this->approve_status_id == 2){
            return '<span class="fa fa-thumbs-down" style="color: darkred"></span> Declined<br>Reason for disapproval: ' . $this->reason_for_disapproval;
        }
        return 'Waiting for response';
    }

    public function scopeLeaveDays()
    {
        if($this->number_of_days == 0.5){
            return "half day";
        } else if($this->number_of_days % 1 == 0.5){
            if((int)$this->number_of_days == 1){
                return (int)$this->number_of_days . ' day and a half days';
            }
            return (int)$this->number_of_days . ' days and a half days';
        } else if((int)$this->number_of_days == 1){
            return (int)$this->number_of_days . ' day';
        }
        else {
            return (int)$this->number_of_days . ' days';
        }
    }

    public function scopeIsForRecommend()
    {
        return Auth::user()->id == $this->employee->supervisor_id && $this->recommending_approval_by_signed_date == NULL && $this->approve_status_id != 2;
    }

    public function scopeIsForApproval()
    {
        return Auth::user()->id == $this->employee->manager_id && $this->approved_by_signed_date == NULL && $this->approve_status_id != 2;
    }

    public function scopeIsForNoted()
    {
        return Auth::user()->isHR() && ($this->noted_by_signed_date == NULL && $this->approve_status_id != 2);
    }

    public function scopeCanBeDeclined()
    {
        return ($this->isForRecommend() || $this->isForApproval() || $this->isForNoted()) && $this->approve_status_id != 2;
    }

    public function getEmployeeName($id)
    {
        return DB::table('employee_info')->where('id', $id)->get();
    }

    public static function getBlockedDates($dept)
    {
        if(Auth::user()->isManager())
            DB::select("
                SELECT 
                    d.date AS cwd
                FROM
                    leave_request_details AS d
                        LEFT JOIN
                    leave_request AS l ON l.id = d.leave_id
                        LEFT JOIN
                    employee_info AS e ON l.employee_id = e.id
                WHERE
                    (e.team_name = '$dept' or e.usertype = 3 )
                        AND d.date >= CURDATE()
                        AND l.approve_status_id <> 2
                        AND d.pay_type <> 3
                        AND d.status = 1
                ORDER BY d.date ASC
            ");
        else
            return DB::select("
                SELECT 
                    d.date AS cwd
                FROM
                    leave_request_details AS d
                        LEFT JOIN
                    leave_request AS l ON l.id = d.leave_id
                        LEFT JOIN
                    employee_info AS e ON l.employee_id = e.id
                WHERE
                    e.team_name = '$dept'
                        AND d.date >= CURDATE()
                        AND l.approve_status_id <> 2
                        AND d.pay_type <> 3
                        AND d.status = 1
                ORDER BY d.date ASC
            ");
    }

    public static function getCWD()
    {
        return DB::select("
            SELECT 
                DATE_FORMAT(start_date, '%Y-%m-%d') AS cwd
            FROM
                events
            WHERE
                start_date >= CURDATE();"
        );
    }

    public static function getLeave($leave_type = 'pending', $id = null, $type = 'list', $is_separated = null)
    {
        $query = "";
        switch ($leave_type) {
            case 'approve':
                $query = "`leave_request`.`approve_status_id` = 1 ";
                break;
            case 'cancelled':
                $query = "`leave_request`.`approve_status_id` = 2 ";
                break;
            case 'separated':
                $query = "`leave_request`.`approve_status_id` IS NOT NULL ";
                break;
            default:
                $query = "(`leave_request`.`approve_status_id` = 0 OR `leave_request`.`approve_status_id` = 3) ";
                break;
        }

        if(!empty($id) && $type == 'list') {
            $query .= "AND `leave_request`.`employee_id`={$id}";
        }

        if(!empty($id) && $type == 'team') {
            $query .= "AND (`employee_info`.`manager_id`={$id} OR `employee_info`.`supervisor_id`={$id})";
        }

        $query2 = "1";
        if(empty($is_separated)) {
            $query2 = "`employee_info`.`deleted_at` IS NULL AND `employee_info`.`status` = 1";
        }

        $data = DB::select("
            SELECT
                `leave_request`.*,
                `employee_info`.`supervisor_id`,
                `employee_info`.`manager_id`,
                `employee_info`.`last_name`,
                `employee_info`.`first_name`
            FROM
                `leave_request`
            LEFT JOIN 
                `employee_info`
            ON 
                `leave_request`.`employee_id` = `employee_info`.`id`
            WHERE
                {$query} AND
                `leave_request`.`status` = 1 AND
                {$query2}
            ORDER BY 
                `leave_request`.`date_filed` 
            DESC
        ");

        $leave_details  = [];
        foreach($data as $key=>$value) {
            $details = DB::select("SELECT * FROM `leave_request_details` WHERE `leave_request_details`.`leave_id` = {$value->id} AND `leave_request_details`.`status` != 0 AND `leave_request_details`.`pay_type` != 3 ORDER BY `leave_request_details`.`date`");

            if(!empty($details)) {
                $leave_details[$key] = $value;
                $leave_details[$key]->leave_details = $details;
            }
        }

        return $leave_details;
    }

    // public static function getLeave2($request, $columns, $leave_type = 'pending', $id = null, $type = 'list', $is_separated = null)
    // {
    //     $limit = '';

    //     if ( isset($request['start']) && $request['length'] != -1 ) {
    //         $limit = "LIMIT ".intval($request['start']).", ".intval($request['length']);
    //     }

    //     $query = "";
    //     switch ($leave_type) {
    //         case 'approve':
    //             $query = "`leave_request`.`approve_status_id` = 1 ";
    //             break;
    //         case 'cancelled':
    //             $query = "`leave_request`.`approve_status_id` = 2 ";
    //             break;
    //         case 'separated':
    //             $query = "`leave_request`.`approve_status_id` IS NOT NULL ";
    //             break;
    //         default:
    //             $query = "(`leave_request`.`approve_status_id` = 0 OR `leave_request`.`approve_status_id` = 3) ";
    //             break;
    //     }

    //     if(!empty($id) && $type == 'list') {
    //         $query .= "AND `leave_request`.`employee_id`={$id}";
    //     }

    //     if(!empty($id) && $type == 'team') {
    //         $query .= "AND (`employee_info`.`manager_id`={$id} OR `employee_info`.`supervisor_id`={$id})";
    //     }

    //     $query2 = "1";
    //     if(empty($is_separated)) {
    //         $query2 = "`employee_info`.`deleted_at` IS NULL AND `employee_info`.`status` = 1";
    //     }

    //     $data = DB::select("
    //         SELECT
    //             `leave_request`.*,
    //             `employee_info`.`supervisor_id`,
    //             `employee_info`.`manager_id`,
    //             `employee_info`.`last_name`,
    //             `employee_info`.`first_name`
    //         FROM
    //             `leave_request`
    //         LEFT JOIN 
    //             `employee_info`
    //         ON 
    //             `leave_request`.`employee_id` = `employee_info`.`id`
    //         WHERE
    //             {$query} AND
    //             `leave_request`.`status` = 1 AND
    //             {$query2}
    //         ORDER BY 
    //             `leave_request`.`date_filed` 
    //         DESC
    //         {$limit}
    //     ");

    //     $leave_details  = [];
    //     foreach($data as $key=>$value) {
    //         $details = DB::select("SELECT * FROM `leave_request_details` WHERE `leave_request_details`.`leave_id` = {$value->id} AND `leave_request_details`.`status` != 0 AND `leave_request_details`.`pay_type` != 3 ORDER BY `leave_request_details`.`date`");

    //         if(!empty($details)) {
    //             $leave_details[$key] = $value;
    //             $leave_details[$key]->leave_details = $details;
    //         }
    //     }

    //     $data = [];
    //     $no = 1;
    //     foreach($leave_details as $i=>$request) {
    //         $reason = "";
    //         $num_days = 0;
    //         $dates = [];
    //         $pay_status = [];
    //         foreach($request->leave_details as $detail):
    //             array_push($dates, date('M d, Y', strtotime($detail->date)));
    //             array_push($pay_status, (($detail->pay_type) ? 'With Pay' : 'Without Pay'));
    //             $num_days += $detail->length;
    //         endforeach;

    //         $leave_status = "Pending <br> <small>(Recommendation / Approval)</small>";
    //         switch($request->approve_status_id) {
    //             case 1:
    //                 $leave_status = 'Approved';
    //                 break;
    //             case 2:
    //                 $leave_status = 'Not Approved';
    //                 break;
    //             case 3:
    //                 $leave_status = "Pending <br> <small>(Approval)</small>";
    //                 break;
    //         }

    //         $reason = $request->pay_type_id == 1 ? "Planned - " : "Unplanned - ";
    //         $reason .= (strlen($request->reason) > 80) ? substr($request->reason, 0, 80)." ..." : $request->reason;

    //         $data[$i][0] = $no;
    //         $data[$i][1] = $request->first_name. " " .$request->last_name;
    //         $data[$i][2] = $reason;
    //         $data[$i][3] = '<span>'.strtotime($dates[0]).'</span>'.implode('<br>', $dates);
    //         $data[$i][4] = implode('<br>', $pay_status);
    //         $data[$i][5] = (float) $num_days;
    //         $data[$i][6] = $leave_status;
    //         $data[$i][7] = '<span>'.strtotime($request->date_filed).'</span>'.date("M d, Y",strtotime($request->date_filed));
    //         $data[$i][8] = '<a href="'.url("leave/{$request->id}").'" title="View" class="btn_view"><span class="fa fa-eye"></span></a>';

    //     $no++;
    //     }

    //     return array(
    //         "draw"            => isset ( $request['draw'] ) ?
    //             intval( $request['draw'] ) :
    //             0,
    //         "recordsTotal"    => intval( $recordsTotal ),
    //         "recordsFiltered" => intval( $recordsFiltered ),
    //         "data"            => self::data_output( $columns, $data )
    //     );

    //     return $data;
    // }

}
