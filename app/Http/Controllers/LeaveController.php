<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Events;
use App\LeaveRequest;
use App\LeaveRequestDetails;
use App\EmployeeInfoDetails;
use App\Helpers\DateHelper;
use App\LeaveCredits;
use App\LeaveType;
use App\PayType;
use App\User;
use App\SentEmailArchives;
use DateTime;
use App\Mail\LeaveNotification;
use App\Mail\LeaveApproved;
use App\Mail\LeaveDeclined;
use App\Mail\LeaveSelfNotification;
use App\Mail\LeaveRecommended;
use App\Mail\LeaveReminder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Spatie\Valuestore\Valuestore;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class LeaveController extends Controller
{
	public $settings;

	public function __construct()
	{
		$this->settings = Valuestore::make(storage_path('app/settings.json'));
	}

	public function index()
	{
		app('App\Http\Controllers\EmailRemindersController')->reminderApproval();

		$id = Auth::user()->id;

		$data['leave_requests'] = LeaveRequest::getLeave('pending', Auth::user()->id);
		$data['type'] = 'pending';
		$data['is_leader'] = count(DB::select("SELECT id FROM `employee_info` WHERE `employee_info`.`deleted_at` IS NULL AND `employee_info`.`status` = 1 AND (`employee_info`.`manager_id`={$id} OR `employee_info`.`supervisor_id`={$id})"));

		if(Auth::user()->isAdmin()){ $data['leave_requests'] = LeaveRequest::getLeave(); }

		return view('leave.index', $data);
	}

	public function approveLeaves()
	{
		$id = Auth::user()->id;

		$data['leave_requests'] = LeaveRequest::getLeave('approve', Auth::user()->id);
		$data['type'] = 'approve';
		$data['is_leader'] = count(DB::select("SELECT id FROM `employee_info` WHERE `employee_info`.`deleted_at` IS NULL AND `employee_info`.`status` = 1 AND (`employee_info`.`manager_id`={$id} OR `employee_info`.`supervisor_id`={$id})"));

		if(Auth::user()->isAdmin()){ $data['leave_requests'] = LeaveRequest::getLeave('approve'); }

		return view('leave.index', $data);
	}

	public function cancelledLeaves()
	{
		$id = Auth::user()->id;

		$data['leave_requests'] = LeaveRequest::getLeave('cancelled', Auth::user()->id);
		$data['type'] = 'cancelled';
		$data['is_leader'] = count(DB::select("SELECT id FROM `employee_info` WHERE `employee_info`.`deleted_at` IS NULL AND `employee_info`.`status` = 1 AND (`employee_info`.`manager_id`={$id} OR `employee_info`.`supervisor_id`={$id})"));

		if(Auth::user()->isAdmin()){ $data['leave_requests'] = LeaveRequest::getLeave('cancelled'); }

		return view('leave.index', $data);
	}

	public function forApproval()
	{
		$data['leave_requests'] = LeaveRequest::getLeave('pending', Auth::user()->id, 'team');
		$data['type'] = 'pending';

		return view('leave.approve', $data);
	}

	public function teamApproves()
	{
		$data['leave_requests'] = LeaveRequest::getLeave('approve', Auth::user()->id, 'team');
		$data['type'] = 'approve';

		return view('leave.approve', $data);
	}

	public function teamCancelled()
	{
		$data['leave_requests'] = LeaveRequest::getLeave('cancelled', Auth::user()->id, 'team');
		$data['type'] = 'cancelled';

		return view('leave.approve', $data);
	}

	public function approveLists()
	{
		$data['leave_requests'] = LeaveRequest::getLeave('approve');

		return view('leave.list', $data);
	}

	public function apiLeaveList()
	{
		return json_encode(['obj' => DB::table('leave_request')->leftJoin('employee_info','leave_request.employee_id','=','employee_info.id')->get()]);
	}

	public function create()
	{
		$id_obj = Auth::user()->id;
		$obj = DB::select($this->newQuery($id_obj));
		$year = date('Y');
		$employees = DB::select("SELECT id FROM `employee_info` WHERE `employee_info`.`deleted_at` IS NULL AND `employee_info`.`status` = 1 AND (`employee_info`.`manager_id`={$id_obj} OR `employee_info`.`supervisor_id`={$id_obj})");
		$credits = (object) [
		    'past_credit'       => 0,
		    'current_credit'    => 0,
		    'used_credit'       => 0,
		    'total_credits'     => 0
		];

		if(count($obj) > 0) {
			$credits = $obj[0];

			switch ($credits->employee_category) {
				case 1:
					$div = 20;
				break;
				case 2:
					$div = 14;
				break;
				case 3:
					$div = 10;
				break;
				case 4:
					$div = 10;
				break;
			}

			$different_in_months = DateHelper::getDifferentMonths($credits->hired_date);
			$monthly_accrual = (($div / 12) * $different_in_months) + $credits->monthly_accrual;
			$credits->monthly_accrual = $monthly_accrual;
			$credits->current_credit = ($monthly_accrual + $credits->past_credit) - ($credits->used_jan_to_jun + $credits->used_jul_to_dec);
		}

		$data['employees'] = User::AllExceptSuperAdmin()->get();
		$data['leave_types'] = (count($employees) > 0) ? LeaveType::where('status' , '<>', 3)->get() : LeaveType::where('status' , '<>', 3)->where('id', '<>', 8)->get();
		$data['blocked_dates'] = $this->getBlockedDates();
		$data['credits'] = $credits;
		$data['is_leader'] = count($employees);

		return view('leave.create', $data);
	}

	public function getLeaveDates($id)
	{
		return DB::table('leave_request_details')->select(DB::raw('id, leave_id, date_format(date,"%b %e, %Y") as date, length, pay_type'))->where("leave_id",$id)->where("status",1)->where("pay_type",'<>',3)->get();
	}

	public function reports()
	{
		return view('leave.reports');
	}

	public function filterTest()
	{
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="myfile.xlsx"');
		header('Cache-Control: max-age=0');

		$writesheet = new Spreadsheet();
		$writer = IOFactory::createWriter($writesheet, "Xlsx");
		$sheet = $writesheet->getActiveSheet();
		$header = array("Customer Number", "Customer Name", "Address", "City", "State", "Zip");
		$sheet->fromArray([$header], NULL, 'A1');  
		$writer->save('php://output');
	}

	public function processSave(Request $req)
	{
		$file = [];
		$file['Original Filename'] = $req->file('prev_leave_credits')->getClientOriginalName();
		$path = str_replace("public","",$_SERVER['DOCUMENT_ROOT']);
		$file['path'] = $req->file('prev_leave_credits')->storeAs('/media/uploads/xls', $file['Original Filename']);

		$spreadsheet =IOFactory::load($path.'/storage/app/'.$file['path']);
		$worksheet = $spreadsheet->getSheet(0);

		$list = [];
		foreach($worksheet->getRowIterator() as $obj_row) {
			$cellIterator = $obj_row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(FALSE);
			$ctr = 1;
			$row = ['num' => 0, 'id' => 0, 'name' => '', 'past_credits' => 0, 'current_credits' => 0, 'used_credits' => 0, 'obj' => [], 'status' => 0];
			foreach($cellIterator as $col) {
				if($ctr == 1) {
					$row['num'] = $col->getValue();
				}

				if($ctr == 2) {
					$row['id'] = $col->getValue();
					$obj = User::where('eid',$row['id'])->get();
					if(count($obj) > 0){
						$row['obj'] = $obj[0];
					}
				}

				if($ctr == 5) {
					$row['name'] = $col->getValue();
				}

				if($ctr == 6) {
					$row['past_credits'] = $col->getValue();
					if(isset($row['obj']->id)) {
						$year = date('Y') - 1;
						$row['status'] = LeaveCredits::where('employee_id',"=",$row['obj']->id)->where('type',"=",2)->where('year',"=",$year)->update(['credit' => $row['past_credits']]);
						if($row['status'] == 0){
							$details = new LeaveCredits();
							$details->employee_id = $row['obj']->id;
							$details->credit = $row['past_credits'];
							$details->year = $year;
							$details->type = 2;
							$details->save();
						}
					}
				}

				if($ctr == 7) {
					$row['current_credits'] = $col->getCalculatedValue();
					if(isset($row['obj']->id)){
						$year = date('Y');
						$details = new LeaveCredits();
						$details->employee_id = $row['obj']->id;
						$details->credit = $row['current_credits'];
						$details->year = $year;
						$details->month = 2;
						$details->type = 1;
						$details->save();
					}
				}

				if($ctr == 8) {
					$row['used_credits'] = $col->getValue();
					if(isset($row['obj']->id)){
						$year = date('Y');
						$details = new LeaveCredits();
						$details->employee_id = $row['obj']->id;
						$details->credit = $row['used_credits'];
						$details->year = $year;
						$details->month = 2;
						$details->type = 5;
						$details->save();
					}
					array_push($list,$row);
				}

			$ctr++;
			}
		}

		return json_encode($list);
	}

	public function uploadCredits()
	{
		return view('leave/upload');
	}

	public function store(Request $request)
	{
		ini_set('memory_limit', '-1');
		$obj = [
			'leave_date' => $request->leave_date,
			'length'     => $request->length,
			'pay_type'   => $request->pay_type
		];

		$leave = new LeaveRequest();
		$datetime = new DateTime();
		$employee = User::withTrashed()->find($request->employee_id);
		$report_date = $datetime->createFromFormat('m/d/Y', $request->report_date)->format("Y-m-d H:i:s");
		$date_filed = $datetime->createFromFormat('m/d/Y', $request->date_filed)->format("Y-m-d H:i:s");
		$leave_type_id = empty($request->leave_type_id) ? $request->leave_cto : $request->leave_type_id;
		if(!empty($request->leave_cto)) {
			if(!empty($request->leave_type_id) && $request->leave_type_id == 5) {
				$leave_type_id = 99; // CTO & VL
			}

			if(count($request->cto_date) == count($request->leave_date)) {
				$leave_type_id = $request->leave_cto; //JUST CTO
			} else {
				$leave_type_id = 99; // CTO & VL
			}
		}

		$leave_data = LeaveRequest::where('employee_id', $request->employee_id)->where('filed_by_id', Auth::user()->id)->where('recommending_approval_by_id', $employee->supervisor_id)->where('approved_by_id', $employee->manager_id)->where('number_of_days', $request->number_of_days)->whereRaw("DATE(report_date) = '".date('Y-m-d', strtotime($report_date))."'")->where('reason', $request->reason)->where('contact_number', $request->contact_number)->where('pay_type_id', $request->pay_type_id)->whereRaw("DATE(date_filed) = '".date('Y-m-d', strtotime($date_filed))."'")->where('leave_type_id', $leave_type_id)->first();
		if(!empty($leave_data)) {
			return redirect("leave" . '/' . $leave_data->id)->with('success', 'Leave Request Successfully Submitted!!');
		}

		$leave->employee_id = $request->employee_id;
		$leave->filed_by_id = Auth::user()->id;
		$leave->recommending_approval_by_id = $employee->supervisor_id;
		$leave->approved_by_id = $employee->manager_id;
		$leave->number_of_days = $request->number_of_days;
		$leave->report_date = $report_date;
		$leave->reason = $request->reason;
		$leave->contact_number = $request->contact_number;
		$leave->pay_type_id = $request->pay_type_id;
		$leave->date_filed = $date_filed;
		$leave->leave_type_id = $leave_type_id;
		$leave->save();
		$leave_id = $leave->id;

		if(!empty($request->leave_cto)) {
			for($i = 0; $i < count($request->cto_date); $i++) {
				if(!empty($request->cto_date[$i]) && ($leave->leave_type_id == 99 || $leave->leave_type_id == 8)) {
					$details = [
						'leave_id'      => $leave_id,
						'date'          => date('Y-m-d', strtotime($request->cto_date[$i])),
						'length'        => 1,
						'pay_type'      => 3 //CTO
					];

					LeaveRequestDetails::create($details);
				}
			}
		}

		for($i = 0; $i < count($obj['leave_date']); $i++) {
			$details = [
				'leave_id'      => $leave_id,
				'date'          => date("Y-m-d",strtotime($obj['leave_date'][$i])) == '1970-01-01'? now()->format('Y-m-d') : date("Y-m-d",strtotime($obj['leave_date'][$i])) ,
				'length'        => $obj['length'][$i],
				'pay_type'      => (($employee->is_regular == 0 || empty($obj['pay_type'][$i])) ? 0 : $obj['pay_type'][$i])
			];

			LeaveRequestDetails::create($details);
		}

		$data = [
			'requester_name' => strtoupper($employee->fullname()),
			'type'           => (($request->pay_type_id == 1) ? 'PLANNED' : 'UNPLANNED'),
			'id'             => $leave_id,
			'details'        => $obj
		];

		// Mail::to($employee->email)->send(new LeaveSelfNotification(['emp_name' => strtoupper($employee->first_name)]));

		$supervisor = User::find($employee->supervisor_id);
		if(!empty($supervisor->id)) {
			$data['emp_name'] = strtoupper($supervisor->first_name);
			// Mail::to($supervisor->email)->send(new LeaveNotification($data));
		}

		$manager = User::find($employee->manager_id);
		if(!empty($manager->id)) {
			$data['emp_name'] = strtoupper($manager->first_name);
			// Mail::to($manager->email)->send(new LeaveNotification($data));
		}

		return redirect("leave" . '/' . $leave_id)->with('success', 'Leave Request Successfully Submitted!!');
	}

	public function show($id)
	{
		$leave_request = LeaveRequest::find($id);
		$employee = DB::select("SELECT `employee_info`.*, (SELECT CONCAT(`supervisor`.`first_name`, ' ', `supervisor`.`last_name`) FROM `employee_info` AS `supervisor` WHERE `supervisor`.`id`=`employee_info`.`supervisor_id` AND `supervisor`.`deleted_at` IS NULL AND `supervisor`.`status` = 1) AS `supervisor`, (SELECT CONCAT(`manager`.`first_name`, ' ', `manager`.`last_name`) FROM `employee_info` AS `manager` WHERE `manager`.`id`=`employee_info`.`manager_id` AND `manager`.`deleted_at` IS NULL AND `manager`.`status` = 1) AS `manager` FROM `employee_info` WHERE `employee_info`.`id`={$leave_request->employee_id}");
		$obj = DB::select($this->newQuery($leave_request->employee_id));
		$credits = (object) [
			'past_credit'       => 0,
			'current_credit'    => 0,
			'used_credit'       => 0,
			'conversion_credit' => 0,
			'expired_credit'    => 0,
			'loa'               => 0,
			'used_jan_to_jun'   => 0,
			'is_regular'        => 0,
			'monthly_accrual'   => 0,
			'total_credits'     => 0
		];

		if(count($obj) > 0) { 
			$credits = $obj[0];

			switch ($credits->employee_category) {
				case 1:
					$div = 20;
				break;
				case 2:
					$div = 14;
				break;
				case 3:
					$div = 10;
				break;
				case 4:
					$div = 10;
				break;
			}

			$different_in_months = DateHelper::getDifferentMonths($credits->hired_date);
			$monthly_accrual = (($div / 12) * $different_in_months) + $credits->monthly_accrual;
			$credits->monthly_accrual = $monthly_accrual;
			$credits->current_credit = ($monthly_accrual + $credits->past_credit) - ($credits->used_jan_to_jun + $credits->used_jul_to_dec);
		}

		$leaveDetails = LeaveRequestDetails::where("leave_id",$id)->where('status','<>',0)->where('pay_type','<>',3)->orderBy('date')->get();
		$ctoDetails = LeaveRequestDetails::where("leave_id",$id)->where('status','<>',0)->where('pay_type',3)->orderBy('date')->get();

		$data['leave_request'] = $leave_request;
		$data['details'] = $leaveDetails;
		$data['leave_types'] = LeaveType::where('status' , '<>', 3)->get();
		$data['pay_types'] = PayType::all();
		$data['credits'] = $credits;
		$data['employee'] = $employee[0];
		$data['cto_dates'] = $ctoDetails;

		return view('leave.show', $data);
	}

	public function edit($id)
	{
		$row = [
			'leave_id'  => $id,
			'date'      => '',
			'length'    => 1,
			'pay_type'  => 0
		];
		$cto_row = [
			'leave_id'  => $id,
			'date'      => '',
			'length'    => 1,
			'pay_type'  => 0
		];
		$leave_request = LeaveRequest::with('employee')->find($id);
		$obj_credits = DB::select($this->newQuery($leave_request->employee_id));
		$employees = DB::select("SELECT id FROM `employee_info` WHERE `employee_info`.`deleted_at` IS NULL AND `employee_info`.`status` = 1 AND (`employee_info`.`manager_id`={$leave_request->employee_id} OR `employee_info`.`supervisor_id`={$leave_request->employee_id})");
		$credits = (object) [
		'past_credit'       => 0,
		'current_credit'    => 0,
		'used_credit'       => 0,
		'total_credits'     => 0
		];
		if(count($obj_credits) > 0) {
			$credits = $obj_credits[0];
			switch ($credits->employee_category) {
				case 1:
					$div = 20;
				break;
				case 2:
					$div = 14;
				break;
				case 3:
					$div = 10;
				break;
				case 4:
					$div = 10;
				break;
			}

			$different_in_months = DateHelper::getDifferentMonths($credits->hired_date);
			$monthly_accrual = (($div / 12) * $different_in_months) + $credits->monthly_accrual;
			$credits->monthly_accrual = $monthly_accrual;
			$credits->current_credit = ($monthly_accrual + $credits->past_credit) - ($credits->used_jan_to_jun + $credits->used_jul_to_dec);
		}

		$obj = LeaveRequestDetails::where('leave_id',$id)->where('status','<>',0)->where('pay_type','<>',3)->get();
		$cto = LeaveRequestDetails::where('leave_id',$id)->where('status','<>',0)->where('pay_type',3)->get();
		if(count($obj) > 0) { $row = $obj[0]; }
		if(count($cto) > 0) { $cto_row = $cto[0]; }

		$data['leave_request'] = $leave_request;
		$data['leave_types'] = (count($employees) > 0) ? LeaveType::where('status' , '<>', 3)->get() : LeaveType::where('status' , '<>', 3)->where('id', '<>', 8)->get();
		$data['pay_types'] = PayType::all();
		$data['filed_days'] = $obj;
		$data['leave'] = $row;
		$data['cto_dates'] = $cto;
		$data['cto_row'] = $cto_row;
		$data['credits'] = $credits;
		$data['blocked_dates'] = $this->getBlockedDates();
		$data['is_leader'] = count($employees);

		return view('leave.edit', $data);
	}

	public function update(Request $request, $id)
	{
	}

	public function displayReport(Request $r)
	{
		$tar = [
			'from'  => date("Y-m-d", strtotime($r->get('from'))),
			'to'    => date("Y-m-d", strtotime($r->get('to'))),
			'type'  => $r->get('type')
		];
		$from = $tar['from'];
		$to = $tar['to'];
		$type = $tar['type'] == 'weekly' ? " = 4" : "<> 4";

		$obj = DB::select("
			SELECT 
				lr.employee_id,
				lr.leave_type_id,
				lr.pay_type_id,
				lr.reason,
				lr.date_filed,
				lrd.id,
				lrd.leave_id,
				lrd.date,
				lrd.length,
				lrd.pay_type,
				ei.eid,
				concat(ei.first_name,' ',ei.last_name) as emp_name,
				ei.employee_category,
				lr.approve_status_id as status
			FROM
				elink_employee_directory.leave_request_details AS lrd
			INNER JOIN
				leave_request AS lr ON lr.id = lrd.leave_id
			INNER JOIN
				employee_info AS ei ON ei.id = lr.employee_id
			WHERE
				lrd.date >= '$from'
				AND lrd.date <= '$to'
				AND ei.employee_category $type
				AND ei.deleted_at IS NULL
				AND ei.status = 1
				AND lrd.status = 1
				AND lr.approve_status_id = 1; 
		");

		return view("leave.reports",["obj" => $obj, "target" => $tar]);
	}

	public function downloadReport(Request $r)
	{
		$tar = [
			'from'      => date("Y-m-d", strtotime($r->get('from'))),
			'to'        => date("Y-m-d", strtotime($r->get('to'))),
			'type'      => $r->get('type')
		];
		$from = $tar['from'];
		$to = $tar['to'];
		$type = $tar['type'] == 'weekly' ? " = 4" : "<> 4";

		$obj = DB::select("
			SELECT 
				lr.employee_id,
				lr.leave_type_id,
				lr.pay_type_id,
				lr.reason,
				lr.date_filed,
				lrd.id,
				lrd.leave_id,
				lrd.date,
				lrd.length,
				lrd.pay_type,
				ei.eid,
				concat(ei.first_name,' ',ei.last_name) as emp_name,
				ei.employee_category,
				lr.approve_status_id as status
			FROM
				elink_employee_directory.leave_request_details AS lrd
			LEFT JOIN
				leave_request AS lr ON lr.id = lrd.leave_id
			LEFT JOIN
				employee_info AS ei ON ei.id = lr.employee_id
			WHERE
				lrd.date >= '$from'
				AND lrd.date <= '$to'
				AND ei.employee_category $type
				AND ei.deleted_at IS NULL
				AND ei.status = 1
				AND lrd.status = 1
				AND lr.approve_status_id = 1;
		");
		$writesheet = new Spreadsheet();
		$writer = IOFactory::createWriter($writesheet, "Xlsx");
		$sheet = $writesheet->getActiveSheet();
		$i = 1;
		$past = date('Y') - 1;
		$header = array("Leave ID", "EE Number", "EE Name", "Start", "End", "VL", "SL", "EL", "CTO", "BL", "PL", "VLWOP", "SLWOP", "ELWOP", "BLWOP", "PLWOP");
		$sheet->fromArray([$header], NULL, 'A'.$i);

		$styleArray = [
			'font' => [
				'bold' => true,
				'size' => 14
			],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			],
			'borders' => [
				'bottom' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
				],
			],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'rotation' => 90,
				'startColor' => [
					'argb' => '3a75fb',
				],
				'endColor' => [
					'argb' => '3a75fb',
				],
			],
		];

		$sheet->getStyle('A1:P1')->applyFromArray($styleArray);
		$sheet->getStyle('A1:P1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

		$sheet->getColumnDimension('A')->setWidth('10');
		$sheet->getColumnDimension('B')->setWidth('20');
		$sheet->getColumnDimension('C')->setWidth('35');
		$sheet->getColumnDimension('D')->setWidth('20');
		$sheet->getColumnDimension('E')->setWidth('20');
		$sheet->getColumnDimension('F')->setWidth('10');
		$sheet->getColumnDimension('G')->setWidth('10');
		$sheet->getColumnDimension('H')->setWidth('10');
		$sheet->getColumnDimension('I')->setWidth('10');
		$sheet->getColumnDimension('J')->setWidth('10');
		$sheet->getColumnDimension('K')->setWidth('10');
		$sheet->getColumnDimension('L')->setWidth('10');
		$sheet->getColumnDimension('M')->setWidth('10');
		$sheet->getColumnDimension('N')->setWidth('10');
		$sheet->getColumnDimension('O')->setWidth('10');
		$sheet->getColumnDimension('P')->setWidth('10');

		$i++;
		$leave_id = isset($obj[0]) ? $obj[0]->leave_id : 0;
		$ename = isset($obj[0]) ? $obj[0]->emp_name : '';
		$eid = isset($obj[0]) ? $obj[0]->eid : 0;
		$l_id = isset($obj[0]) ? $obj[0]->leave_id : '';
		$date_filed = isset($obj[0]) ? $obj[0]->date_filed : '';
		$start = isset($obj[0]) ? $obj[0]->date : '';
		$stop = isset($obj[0]) ? $obj[0]->date : '';
		$track = 0;
		$vl = 0;
		$sl = 0;
		$el = 0;
		$cto = 0;
		$bl = 0;
		$pl = 0;
		$vlwop = 0;
		$slwop = 0;
		$elwop = 0;
		$blwop = 0;
		$plwop = 0;
		foreach($obj as $o){
			if($leave_id != $o->leave_id) {
				$body = [
					str_pad($l_id,5,"0",STR_PAD_LEFT),
					$eid,
					$ename,
					date("F d, Y", strtotime($start)),
					date("F d, Y", strtotime($stop)),
					$vl,
					$sl,
					$el,
					$cto,
					$bl,
					$pl,
					$blwop,
					$plwop,
					$vlwop,
					$slwop,
					$elwop
				];
				$sheet->fromArray([$body], NULL, "A{$i}", true);
				$sheet->getStyle("F{$i}:P{$i}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				if($vl > 0) { $sheet->getStyle("F{$i}")->getFont()->setBold(true); }
				if($sl > 0) { $sheet->getStyle("G{$i}")->getFont()->setBold(true); }
				if($el > 0) { $sheet->getStyle("H{$i}")->getFont()->setBold(true); }
				if($cto > 0) { $sheet->getStyle("I{$i}")->getFont()->setBold(true); }
				if($bl > 0) { $sheet->getStyle("J{$i}")->getFont()->setBold(true); }
				if($pl > 0) { $sheet->getStyle("K{$i}")->getFont()->setBold(true); }
				if($blwop > 0) { $sheet->getStyle("L{$i}")->getFont()->setBold(true); }
				if($plwop > 0) { $sheet->getStyle("M{$i}")->getFont()->setBold(true); }
				if($vlwop > 0) { $sheet->getStyle("N{$i}")->getFont()->setBold(true); }
				if($slwop > 0) { $sheet->getStyle("O{$i}")->getFont()->setBold(true); }
				if($elwop > 0) { $sheet->getStyle("P{$i}")->getFont()->setBold(true); }

				$i++;
				$vl = 0;
				$sl = 0;
				$el = 0;
				$cto = 0;
				$bl = 0;
				$pl = 0;
				$vlwop = 0;
				$slwop = 0;
				$elwop = 0;
				$blwop = 0;
				$plwop = 0;
				$leave_id = $o->leave_id;
				$ename = $o->emp_name;
				$eid = $o->eid;
				$l_id = $o->leave_id;
				$date_filed = $o->date_filed;
				$start = $o->date;
			}
			switch($o->leave_type_id) {
				case 1: $o->pay_type == 1 ? $bl+=$o->length : $blwop+=$o->length; break;
				case 2: $o->pay_type == 1 ? $pl+=$o->length : $plwop+=$o->length; break;
				case 4: $o->pay_type == 1 ? $sl+=$o->length : $slwop+=$o->length; break;
				case 5: $o->pay_type == 1 ? $vl+=$o->length : $vlwop+=$o->length; break;
				case 6: $o->pay_type == 1 ? $el+=$o->length : $elwop+=$o->length; break;
				default: $cto+=$o->length; break;
			}
			$stop = $o->date;
		}
		if($l_id){
			$body = [
				str_pad($l_id,5,"0",STR_PAD_LEFT),
				$eid,
				$ename,
				date("F d, Y", strtotime($start)),
				date("F d, Y", strtotime($stop)),
				$vl,
				$sl,
				$el,
				$cto,
				$bl,
				$pl,
				$blwop,
				$plwop,
				$vlwop,
				$slwop,
				$elwop
			];
			$sheet->fromArray([$body], NULL, "A{$i}", true);
			$sheet->getStyle("F{$i}:P{$i}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			if($vl > 0) { $sheet->getStyle("F{$i}")->getFont()->setBold(true); }
			if($sl > 0) { $sheet->getStyle("G{$i}")->getFont()->setBold(true); }
			if($el > 0) { $sheet->getStyle("H{$i}")->getFont()->setBold(true); }
			if($cto > 0) { $sheet->getStyle("I{$i}")->getFont()->setBold(true); }
			if($bl > 0) { $sheet->getStyle("J{$i}")->getFont()->setBold(true); }
			if($pl > 0) { $sheet->getStyle("K{$i}")->getFont()->setBold(true); }
			if($blwop > 0) { $sheet->getStyle("L{$i}")->getFont()->setBold(true); }
			if($plwop > 0) { $sheet->getStyle("M{$i}")->getFont()->setBold(true); }
			if($vlwop > 0) { $sheet->getStyle("N{$i}")->getFont()->setBold(true); }
			if($slwop > 0) { $sheet->getStyle("O{$i}")->getFont()->setBold(true); }
			if($elwop > 0) { $sheet->getStyle("P{$i}")->getFont()->setBold(true); }
		}

		ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="leave-report-'.date('mdY-His').'.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->setPreCalculateFormulas(false);
		$writer->setOffice2003Compatibility(true);
		$writer->save('php://output');
	}

	public function updateLeaveEntry(Request $request)
	{
		$leave = LeaveRequest::find($request->id);

		$obj = [
			'leave_date'    => $request->leave_date,
			'length'        => $request->length,
			'pay_type'      => $request->pay_type,
			'field_id'      => $request->field_id
		];

		$datetime = new DateTime();
		$report_date = $datetime->createFromFormat('m/d/Y', $request->report_date)->format("Y-m-d H:i:s");
		$date_filed = $datetime->createFromFormat('m/d/Y', $request->date_filed)->format("Y-m-d H:i:s");

		$leave->employee_id = $request->employee_id;
		$leave->filed_by_id = Auth::user()->id;
		$leave->recommending_approval_by_id = Auth::user()->supervisor_id;
		$leave->approved_by_id = Auth::user()->manager_id;
		$leave->number_of_days = $request->number_of_days;
		$leave->report_date = $report_date;
		$leave->reason = $request->reason;
		$leave->contact_number = $request->contact_number;
		$leave->pay_type_id = $request->pay_type_id;
		$leave->date_filed = $date_filed;
		$leave->leave_type_id = (empty($request->leave_type_id) ? $request->leave_cto : $request->leave_type_id);
		if(!empty($request->leave_cto)) {
			if(!empty($request->leave_type_id) && $request->leave_type_id == 5) {
				$leave->leave_type_id = 99; // CTO & VL
			}

			if(count($request->cto_date) == count($request->leave_date)) {
				$leave->leave_type_id = $request->leave_cto; //JUST CTO
			} else {
				$leave->leave_type_id = 99; // CTO & VL
			}
		}
        $leave->save();

        for($i = 0; $i < count($obj['field_id']); $i++) {
			if($obj['field_id'][$i] > 0) {
				LeaveRequestDetails::where('id',"=",$obj['field_id'][$i])
				->update([
					'date'      => date("Y-m-d",strtotime($obj['leave_date'][$i])),
					'length'    => $obj['length'][$i],
					'pay_type'  => $obj['pay_type'][$i],
				]);
			} else {
				$details = [
					'leave_id'      => $request->id,
					'date'          => date("Y-m-d",strtotime($obj['leave_date'][$i])),
					'length'        => $obj['length'][$i],
					'pay_type'      => $obj['pay_type'][$i]
				];
				LeaveRequestDetails::create($details);
			}
        }

		LeaveRequestDetails::where('leave_id', $request->id)->where('pay_type', 3)->delete();

		if(!empty($request->cto_date)) {
			for($i = 0; $i < count($request->cto_date); $i++) {
				if(!empty($request->cto_date[$i]) && ($leave->leave_type_id == 99 || $leave->leave_type_id == 8)) {
					$details = [
						'leave_id'      => $request->id,
						'date'          => date('Y-m-d', strtotime($request->cto_date[$i])),
						'length'        => 1,
						'pay_type'      => 3 //CTO
					];

					LeaveRequestDetails::create($details);
				}
			}
		}

		return redirect("leave" . '/' . $request->id)->with('success', 'Leave Request Successfully Updated!!');
	}

	public function deleteLeaveDate(Request $request)
	{
		LeaveRequest::where('id',$request->leave)->update(['number_of_days' => $request->total]);

		return LeaveRequestDetails::where('id',"=",$request->id)->update(['status' => 0]);
	}

	public function uploadLastCredit(Request $request)
	{
	}

	public function destroy($id)
	{
	}

	public function recommend(Request $request)
	{
		$leave_request = LeaveRequest::find($request->leave_id);
		if($leave_request->approve_status_id == 1) {
			return back()->with('error', 'Already approved.');
		}
		$leave_request->recommending_approval_by_id = Auth::user()->id;
		$leave_request->recommending_approval_by_signed_date = date('Y-m-d H:i:s');
		$leave_request->approve_status_id = 3;

		$employee = User::withTrashed()->find($leave_request->employee_id);
		$manager = User::withTrashed()->find($employee->manager_id);

		if($leave_request->save()) {
			$data = [
				'emp_name' => strtoupper($employee->last_name .', '. $employee->first_name),
				'id'       => $request->leave_id
			];

			if(empty($manager)) {
				$data['leader_name'] = 'HR DEPARTMENT';

				// Mail::to('hrd@elink.com.ph')->send(new LeaveReminder($data));
			} else {
				$data['leader_name'] = strtoupper($manager->first_name); 

				// Mail::to($manager->email)->send(new LeaveReminder($data));
			}

			return back()->with('success', 'Leave request successfully recommended for approval.');
		} else {
			return back()->with('error', 'Something went wrong.');
		}
	}

	public function approve(Request $request)
	{
		$leave_request = LeaveRequest::find($request->leave_id);
		$leave_request->approved_by_id = Auth::user()->id;
		$leave_request->approved_by_signed_date = date('Y-m-d H:i:s');
		$leave_request->approve_status_id = 1;

		$req_det_obj = DB::select("select * from leave_request_details where leave_id = {$request->leave_id} and pay_type != 3 AND status = 1 order by date ASC;");
		$cto_dates = DB::select("select * from leave_request_details where leave_id = {$request->leave_id} and pay_type = 3 AND status = 1 order by date ASC;");
		$employee = User::withTrashed()->find($leave_request->employee_id);
		$obj = DB::select($this->newQuery($employee->id));
		$credits = (object) [
			'past_credit'       => 0,
			'current_credit'    => 0,
			'used_credit'       => 0,
			'total_credits'     => 0
		];

		if(count($obj) > 0) {
			$credits = $obj[0];
			switch ($credits->employee_category) {
				case 1:
					$div = 20;
				break;
				case 2:
					$div = 14;
				break;
				case 3:
					$div = 10;
				break;
				case 4:
					$div = 10;
				break;
			}

			$different_in_months = DateHelper::getDifferentMonths($credits->hired_date);
			$monthly_accrual = (($div / 12) * $different_in_months) + $credits->monthly_accrual;
			$credits->monthly_accrual = $monthly_accrual;
			$credits->current_credit = ($monthly_accrual + $credits->past_credit) - ($credits->used_jan_to_jun + $credits->used_jul_to_dec);
		}

		// Count With Pay
		$with_pay = 0;
		if(count($req_det_obj) > 0) {
			foreach($req_det_obj as $det) {
				$with_pay += $det->pay_type == 1 ? 1 : 0;
			}
		}

		// Count CTO Dates and remove from with pay
		if(!empty($cto_dates)) {
			$with_pay = $with_pay - count($cto_dates);
			for($i=0;$i<count($cto_dates);$i++) {
				LeaveRequestDetails::where('id', $cto_dates[$i]->id)->update(['status' => 3]);
			}
		}

		// For Bereavement Leave
		if($leave_request->leave_type_id == 1) {
			$with_pay = $with_pay - 3;
			for($i=0;$i<3;$i++) {
				LeaveRequestDetails::where('id', $req_det_obj[$i]->id)->update(['status' => 3]);
			}

			LeaveRequestDetails::where('leave_id', $leave_request->id)->where('status', 1)->update(['pay_type' => 0]);
			if($employee->is_regular == 0) {
				$with_pay = 0;
			} else {
				if(floor($credits->current_credit) >= $with_pay) {
					LeaveRequestDetails::where('leave_id', $leave_request->id)->where('status', 1)->where('pay_type', 0)->update(['pay_type' => 1]);
				} else {
					$with_pay = floor($credits->current_credit);
					$without_pay_data = DB::select("select * from leave_request_details where leave_id = {$request->leave_id} and status = 1 and pay_type = 0 order by date ASC;");

					if(floor($credits->current_credit) > 0) {
						for($i=0;$i<floor($credits->current_credit);$i++) {
							LeaveRequestDetails::where('id', $without_pay_data[$i]->id)->update(['pay_type' => 1]);
						}
					} else {
						$with_pay = 0;
					}
				}
			}
		} else {
			LeaveRequestDetails::where('leave_id', $leave_request->id)->where('status', 1)->update(['pay_type' => 0]);
			if($employee->is_regular == 0) {
				$with_pay = 0;
			} else {
				if(floor($credits->current_credit) >= $with_pay) {
					LeaveRequestDetails::where('leave_id', $leave_request->id)->where('status', 1)->where('pay_type', 0)->update(['pay_type' => 1]);
				} else {
					$with_pay = floor($credits->current_credit);
					$without_pay_data = DB::select("select * from leave_request_details where leave_id = {$request->leave_id} and status = 1 and pay_type = 0 order by date ASC;");

					if(floor($credits->current_credit) > 0) {
						for($i=0;$i<floor($credits->current_credit);$i++) {
							LeaveRequestDetails::where('id', $without_pay_data[$i]->id)->update(['pay_type' => 1]);
						}
					} else {
						$with_pay = 0;
					}
				}
			}
		}

		// Save Leave Credit Deduction
		if($with_pay > 0 && count($req_det_obj)) {
			$lc_obj = DB::select("select * from leave_credits where leave_id = {$request->leave_id};");
			if(count($lc_obj) == 0 ) {
				$lc = new LeaveCredits();
				$lc->employee_id = $leave_request->employee_id;
				$lc->credit = $with_pay;
				$lc->type = 5;
				$lc->month = date("m");
				$lc->year = date("Y");
				$lc->leave_id = $request->leave_id;
				$lc->status = 1;
				$lc->save();
			}
		}

		$data = [
			'emp_name' => strtoupper($employee->first_name),
			'date'     => $req_det_obj[0]->date
		];

		if($leave_request->save()){
			// Mail::to($employee->email)->send(new LeaveApproved($data));

			return back()->with('success', 'Leave request successfully approved. . .');
		} else {
			return back()->with('error', 'Something went wrong. . .');
		}
	}

	public function noted(Request $request)
	{
		$leave_request = LeaveRequest::find($request->leave_id);
		$leave_request->noted_by_id = Auth::user()->id;
		$leave_request->noted_by_signed_date = date('Y-m-d H:i:s');
		// $leave_request->approve_status_id = 1;

		if($leave_request->save()){
			return back()->with('success', 'Leave request successfully approved.');
		} else {
			return back()->with('error', 'Something went wrong.');
		}
	}

	public function decline(Request $request)
	{
		$leave_request = LeaveRequest::find($request->leave_id);
		$leave_request->reason_for_disapproval = $request->reason_for_disapproval;
		$leave_request->approve_status_id = 2;

		LeaveCredits::where('leave_id', $request->leave_id)->delete();
		LeaveRequestDetails::where('leave_id',$request->leave_id)->where('status',3)->update(['status'=>1]);

		$employee = User::where('id', $leave_request->employee_id)->first();
		$details = LeaveRequestDetails::where('leave_id', $leave_request->id)->orderBy('date')->first();
		$data = [
			'emp_name' => strtoupper($employee->first_name),
			'date'     => $details->date
		];

		if($leave_request->save()){
			// Mail::to($employee->email)->send(new LeaveDeclined($data));

			return back()->with('success', 'Leave request successfully declined.');
		} else {
			return back()->with('error', 'Something went wrong.');
		}
	}

	public function creditIncrementVer2($month)
	{
		$obj = DB::select("
			SELECT 
				*
			FROM
				employee_info
			WHERE
				status = 1 AND deleted_at IS NULL
				AND eid LIKE 'ESCC-%';
		");

		foreach($obj as $e) {
			$id = $e->id;
			$det = DB::select("
				SELECT 
					id
				FROM
					leave_credits
				WHERE
					employee_id = $id AND type = 1
					AND month = $month
					AND year = YEAR(NOW());
			");
			if(count($det) == 0){
				$div = 0;
				switch($e->employee_category) {
					case 1: $div = 20; break;
					case 2: $div = 14; break;
					case 3: $div = 10; break;
					case 4: $div = 10; break;
				}
				$credit = new LeaveCredits();
				$credit->employee_id = $id;
				$credit->credit = $div / 12;
				$credit->type = 1;
				$credit->month = $month;
				$credit->year = date("Y");
				$credit->save();
			}
		}

		return "done";
	}

	public function creditIncrement()
	{
		$obj = DB::select("
			SELECT
				*
			FROM
				employee_info
			WHERE
				status = 1 AND deleted_at IS NULL
				AND eid LIKE 'ESCC-%';
		");

		foreach($obj as $e) {
			$id = $e->id;
			$det = DB::select("
				SELECT
					id
				FROM
					leave_credits
				WHERE
					employee_id = $id AND type = 1
					AND month = MONTH(NOW())
					AND year = YEAR(NOW());
			");
			if(count($det) == 0) {
				$div = 0;
				switch($e->employee_category) {
					case 1: $div = 20; break;
					case 2: $div = 14; break;
					case 3: $div = 10; break;
					case 4: $div = 10; break;
				}
				$credit = new LeaveCredits();
				$credit->employee_id = $id;
				$credit->credit = $div / 12;
				$credit->type = 1;
				$credit->month = date("n");
				$credit->year = date("Y");
				$credit->save();
			}
		}

		return "done";
	}

	public function credits()
	{
		$data['employees'] = DB::select($this->newQuery());

		return view('leave.credits', $data);
	}

	public function leaveCredits()
	{
		$data['employees'] = DB::select($this->newQuery());

		return view('leave.expanded-credits', $data);
	}

	public function leaveTracker()
	{
		$data['employees'] = DB::select($this->newQuery());

		return view('leave.expanded-tracker', $data);
	}

	public function pastCredits()
	{
		$data['employees'] = DB::select($this->pastQuery());

		return view('leave.past-credits', $data);
	}

	public function editcredits(Request $request, $employee_id)
	{
		$employee = User::find($employee_id);
		$credit = DB::select($this->newQuery($employee->id));
		if(count($credit) > 0){
			$credits = (object) $credit[0];
		}

		switch ($credits->employee_category) {
			case 1:
				$div = 20;
			break;
			case 2:
				$div = 14;
			break;
			case 3:
				$div = 10;
			break;
			case 4:
				$div = 10;
			break;
		}
		$different_in_months = DateHelper::getDifferentMonths($employee->hired_date);
		$monthly_accrual = (($div / 12) * $different_in_months) + $credits->monthly_accrual;
		$credits->monthly_accrual = $monthly_accrual;
		$credits->current_credit = ($monthly_accrual + $credits->past_credit) - ($credits->used_jan_to_jun + $credits->used_jul_to_dec);

		return view('leave.editcredits', compact('employee', 'credits'));
	}

	public function updatecredits(Request $request)
	{
		if($request->monthly_accrual == 0 && $request->pto_forwarded == 0) {
			return back()->withErrors(['fail' => 'Value zero on both monthly accrual and pto forwarded are not valid']);
		}
		$employee = User::find($request->employee_id);

		if($request->monthly_accrual != 0) {
			$leave = LeaveCredits::create([
				'employee_id' => $employee->id,
				'credit' => $request->monthly_accrual,
				'type' => 7,
				'month' => now()->month,
				'year' => now()->year,
				'leave_id' => 0,
				'status' => 1
			]);

			LeaveCredits::create([
				'employee_id' => $employee->id,
				'credit' => $request->monthly_accrual,
				'type' => 1,
				'month' => now()->month,
				'year' => now()->year,
				'leave_id' => 0,
				'status' => 1
			]);
		}

		if ($request->pto_forwarded != 0) {
			LeaveCredits::create([
				'employee_id' => $employee->id,
				'credit' => $request->pto_forwarded ?? 0,
				'type' => 2,
				'month' => now()->month,
				'year' => now()->subYear()->format('Y'),
				'leave_id' => 0,
				'status' => 1
			]);
		}

		return back()->with('success', 'Successfully updated leave credits!');
	}

	private function getBlockedDates()
	{
		$blocked_dates = [];
		$obj = LeaveRequest::getBlockedDates(Auth::user()->team_name);
		$events = LeaveRequest::getCWD();
		if(count($obj) > 0) {
			foreach($obj as $e) {
				$tar_date = date("m/d/Y", strtotime($e->cwd));
				if(!in_array($tar_date,$blocked_dates)) {
					array_push($blocked_dates,$tar_date);
				}
			}
		}
		if(count($events) > 0) {
			foreach($events as $e) {
				$tar_date = date("m/d/Y", strtotime($e->cwd));
				if(!in_array($tar_date,$blocked_dates)) {
					array_push($blocked_dates,$tar_date);
				}
			}
		}

		return $blocked_dates;
	}

	public function conversion()
	{
		$data['employees'] = DB::select($this->newQuery());

		return view('leave.credits-conversion', $data);
	}

	public function saveConversion(Request $r)
	{
		$conversion = $r->post('con');
		$id = $r->post('id');
		$lc = new LeaveCredits();
		$lc->employee_id = $id;
		$lc->credit = $conversion;
		$lc->type = 3;
		$lc->month = date('m');
		$lc->year = date('Y');
		$lc->leave_id = 0;
		$lc->status = 1;
		$lc->save();
	}

	public function xlsCredits()
	{ 
		$styleArray = [
			'font' => [
				'bold' => true,
				'size' => 14
			],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			],
			'borders' => [
				'bottom' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
				],
			],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'rotation' => 90,
				'startColor' => [
					'argb' => '3a75fb',
				],
				'endColor' => [
					'argb' => '3a75fb',
				],
			],
		];

		$writesheet = new Spreadsheet();
		$writer = IOFactory::createWriter($writesheet, "Xlsx");
		$sheet = $writesheet->getActiveSheet();
		$sheet->getStyle('A1:H1')->applyFromArray($styleArray);
		$sheet->getStyle('A1:H1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
		$sheet->getColumnDimension('A')->setWidth('15');
		$sheet->getColumnDimension('B')->setWidth('40');
		$sheet->getColumnDimension('C')->setWidth('40');
		$sheet->getColumnDimension('D')->setWidth('30');
		$sheet->getColumnDimension('E')->setWidth('15');
		$sheet->getColumnDimension('F')->setWidth('15');
		$sheet->getColumnDimension('G')->setWidth('15');
		$sheet->getColumnDimension('H')->setWidth('15');
		$i = 1;
		$present = date('Y');
		$past = date('Y') - 1;
		$header = array("Employee ID", "Employee Name", "Position", "{$past} PTO for Conversion", "{$past} PTO", "{$present} PTO", "Used PTO", "PTO Balance");
		$sheet->fromArray([$header], NULL, 'A'.$i);
		$obj = DB::select($this->newQuery());

		$i++;
		foreach($obj as $employee) {
			$div = 0;
			switch($employee->employee_category):
				case 1: $div = 20; break;
				case 2: $div = 14; break;
				case 3: $div = 10; break;
				case 4: $div = 10; break;
			endswitch;
			$different_in_months = DateHelper::getDifferentMonths($employee->hired_date);
			$monthly_accrual = (($div / 12) * $different_in_months) + $employee->monthly_accrual;
			$employee->monthly_accrual = $monthly_accrual;
			$employee->current_credit = ($monthly_accrual + $employee->past_credit) - ($employee->used_jan_to_jun + $employee->used_jul_to_dec);

			$pto_forwarded = $employee->past_credit - $employee->conversion_credit;
			$pto_accrue = $employee->current_credit;
			$loa = abs($employee->loa);
			$use_jan_jun = $employee->used_jan_to_jun;
			$pto_expired = $employee->expired_credit;
			$balance = $pto_forwarded + $pto_accrue - $loa - $use_jan_jun - $pto_expired;

			$body = [
				$employee->eid,
				strtoupper($employee->employee_name),
				$employee->position_name,
				number_format($employee->conversion_credit),
				number_format($employee->past_credit,2),
				number_format($monthly_accrual,2),
				number_format($employee->used_jan_to_jun + $employee->used_jul_to_dec, 2),
				(($employee->is_regular == 1) ? number_format($employee->current_credit,2) : '0.00')
			];

			$color = 'eea236';
			if($employee->is_regular == 1) {
				if($employee->current_credit > 0) { $color = '8ad919'; }
				if($employee->current_credit < 0) { $color = 'f9243f'; }
			}

			$balanceStyle = [
				'font' => [
					'bold' => true
				],
				'fill' => [
					'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
					'rotation' => 90,
					'startColor' => [
						'argb' => $color,
					],
					'endColor' => [
						'argb' => $color,
					],
				],
			];

			$sheet->fromArray([$body], NULL, 'A'.$i);
			$sheet->getStyle("C{$i}")->getAlignment()->setWrapText(true);
			$sheet->getStyle("D{$i}:H{$i}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle("D{$i}:H{$i}")->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle("H{$i}")->applyFromArray($balanceStyle);
			$sheet->getStyle("H{$i}")->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
		$i++;
		}

		ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="leave-credits-'.date('mdY-His').'.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->setPreCalculateFormulas(false);
		$writer->setOffice2003Compatibility(true);
		$writer->save('php://output');
	}

	public function xlsCreditsVer2()
	{
		$writesheet = new Spreadsheet();
		$writer = IOFactory::createWriter($writesheet, "Xlsx");
		$sheet = $writesheet->getActiveSheet();
		$i = 1;
		$past = date('Y') - 1;
		$header = array("ID", "Employee ID", "Employee Name", "Date Started", "Position", $past." PTO for Conversion", $past." PTO", date('Y')." PTO", "Used PTO", "PTO Balance");
		$sheet->fromArray([$header], NULL, 'A'.$i); 
		$i++;
		$obj = DB::select($this->newQuery());
		foreach($obj as $employee) {
			$body = [
				$employee->id,
				$employee->eid,
				strtoupper($employee->employee_name),
				$employee->prod_date,
				$employee->position_name,
				number_format($employee->conversion_credit,1),
				number_format($employee->past_credit - $employee->conversion_credit,1),
				number_format($employee->current_credit,1),
				number_format($employee->used_credit,1),
				number_format($employee->total_credits,1)
			];
			$sheet->fromArray([$body], NULL, 'A'.$i); 
		$i++;
		}
		ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="leave-credits-'.date('mdY-His').'.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->setPreCalculateFormulas(false);
		$writer->setOffice2003Compatibility(true);
		$writer->save('php://output');
	}

	public function patchCredits()
	{
		$obj = DB::select("select id from employee_info");
		$list=[];
		foreach($obj as $employee) {
			$id = $employee->id;
			$obj2 = DB::select("select id from leave_credits where employee_id = $id and month = 4 and year = 2020");
			if(count($obj2) > 1) {
				$lc = LeaveCredits::find($obj2[1]->id);
				$lc->status = 0;
				$lc->save();
				array_push($list,$lc->id);
			}
		}

		return json_encode(['obj' => $list, 'status' => 'patch successful']);
	}

	private function newQuery($id = NULL)
	{
		$today = now();
		$today->month = 1;
		$today->day = 1;
		$firstHalfYearStart = $today->format('Y-m-d');

		$today->month = 6;
		$today->day = 30;
		$firstHalfYearEnd = $today->format('Y-m-d');

		$today->month = 7;
		$today->day = 1;
		$lastHalfYearStart = $today->format('Y-m-d');

		$today->month = 12;
		$today->day = 31;
		$lastHalfYearEnd = $today->format('Y-m-d');

		$sql = "
			SELECT
				`employee_info`.`id`,
				`employee_info`.`eid`,
				CONCAT(`employee_info`.`first_name`, ' ', `employee_info`.`last_name`) AS `employee_name`,
				`employee_info`.`employee_category`,
				`employee_info`.`hired_date`,
				`employee_info`.`prod_date`,
				`employee_info`.`position_name`,
				`employee_info`.`is_regular`,
				0 as `used_credit`,
				0 as `total_credits`,
				IFNULL((SELECT 
						sum(`leave_credits`.`credit`)
					FROM
						`leave_credits`
					WHERE
						`leave_credits`.`year` = YEAR(NOW()) AND 
						`leave_credits`.`type` = 6 AND 
						`leave_credits`.`employee_id` = `employee_info`.`id` AND
						`leave_credits`.`status` = 1
					LIMIT 1),
				0) AS `expired_credit`,
				IFNULL((SELECT 
						sum(`leave_credits`.`credit`)
					FROM
						`leave_credits`
					WHERE
						`leave_credits`.`year` = YEAR(NOW()) - 1 AND 
						`leave_credits`.`type` = 2 AND 
						`leave_credits`.`employee_id` = `employee_info`.`id` AND
						`leave_credits`.`status` = 1
					LIMIT 1),
				0) AS `past_credit`,
				IFNULL((SELECT 
						`leave_credits`.`credit`
					FROM
						`leave_credits`
					WHERE
						`leave_credits`.`year` = YEAR(NOW()) AND 
						`leave_credits`.`type` = 3 AND 
						`leave_credits`.`employee_id` = `employee_info`.`id` AND
						`leave_credits`.`status` = 1
					LIMIT 1),
				0) AS `conversion_credit`,
				IFNULL((SELECT 
						`leave_credits`.`credit`
					FROM
						`leave_credits`
					WHERE
						`leave_credits`.`year` = YEAR(NOW()) AND 
						`leave_credits`.`type` = 4 AND 
						`leave_credits`.`employee_id` = `employee_info`.`id` AND
						`leave_credits`.`status` = 1
					LIMIT 1),
				0) AS `loa`,
				IFNULL((SELECT 
						sum(`leave_credits`.`credit`)
					FROM
						`leave_credits`
					WHERE
						`leave_credits`.`year` = YEAR(NOW()) AND 
						`leave_credits`.`type` = 7 AND 
						`leave_credits`.`employee_id` = `employee_info`.`id` AND
						`leave_credits`.`status` = 1
					LIMIT 1),
				0) AS `monthly_accrual`,
				IFNULL((SELECT 
						sum(`leave_credits`.`credit`)
					FROM
						`leave_credits`
					WHERE
						`leave_credits`.`year` = YEAR(NOW()) AND 
						`leave_credits`.`type` = 1 AND 
						`leave_credits`.`employee_id` = `employee_info`.`id` AND
						`leave_credits`.`status` = 1
					LIMIT 1),
				0) AS `current_credit`,
				IFNULL((SELECT 
						sum(`leave_request_details`.`length`)
					FROM
						`leave_request`
					LEFT JOIN
						`leave_request_details`
					ON
						`leave_request_details`.`leave_id` = `leave_request`.`id`
					WHERE
						`leave_request`.`employee_id` = `employee_info`.`id` AND
						`leave_request_details`.`date` >= '{$firstHalfYearStart}' AND 
						`leave_request_details`.`date` <= '{$firstHalfYearEnd}' AND 
						`leave_request_details`.`pay_type` = 1 AND 
						`leave_request_details`.`status` = 1 AND 
						`leave_request`.`approve_status_id` = 1
					LIMIT 1),
				0) AS `used_jan_to_jun`,
				IFNULL((SELECT 
						sum(`leave_request_details`.`length`)
					FROM
						`leave_request`
					LEFT JOIN
						`leave_request_details`
					ON
						`leave_request_details`.`leave_id` = `leave_request`.`id`
					WHERE
						`leave_request`.`employee_id` = `employee_info`.`id` AND
						`leave_request_details`.`date` >= '{$lastHalfYearStart}' AND 
						`leave_request_details`.`date` <= '{$lastHalfYearEnd}' AND 
						`leave_request_details`.`pay_type` = 1 AND 
						`leave_request_details`.`status` = 1 AND 
						`leave_request`.`approve_status_id` = 1
					LIMIT 1),
				0) AS `used_jul_to_dec`
			FROM
				`employee_info`
			WHERE
				`employee_info`.`status` = 1 AND 
				`employee_info`.`deleted_at` IS NULL AND 
				`employee_info`.`eid` LIKE 'ESCC-%'
			ORDER BY
				`employee_info`.`eid`";

		if($id) {
			$sql.=" AND `employee_info`.`id` = {$id}";
		}

		return $sql;
	}

	private function pastQuery($id = NULL)
	{
		$sql = "
			SELECT
				eid,
				id,
				CONCAT(e.first_name, ' ', e.last_name) AS employee_name,
				e.prod_date,
				e.position_name,
				0 as used_credit,
				0 as total_credits,
				IFNULL((SELECT
						sum(credit)
					FROM
						leave_credits
					WHERE
						year = 2020 AND type = 6
						AND employee_id = e.id
						AND leave_credits.status = 1
					LIMIT 1),
				0) AS expired_credit,
				IFNULL((SELECT
						credit
					FROM
						leave_credits
					WHERE
						year = 2020 - 1 AND type = 2
						AND employee_id = e.id
						AND leave_credits.status = 1
					LIMIT 1),
				0) AS past_credit,
				IFNULL((SELECT
						credit
					FROM
						leave_credits
					WHERE
						year = 2020 AND type = 3
						AND employee_id = e.id
						AND leave_credits.status = 1
					LIMIT 1),
				0) AS conversion_credit,
				IFNULL((SELECT
						credit
					FROM
						leave_credits
					WHERE
						year = 2020 AND type = 4
						AND employee_id = e.id
						AND leave_credits.status = 1
					LIMIT 1),
				0) AS loa,
				IFNULL((SELECT
						SUM(credit)
					FROM
						leave_credits
					WHERE
						year = 2020 AND type = 1
						AND leave_credits.status = 1
						AND employee_id = e.id),
				0) AS current_credit,
				IFNULL((SELECT
						SUM(lrd.length)
					FROM
						elink_employee_directory.leave_request AS lr
					LEFT JOIN
						leave_request_details AS lrd ON lrd.leave_id = lr.id
					WHERE
						lr.employee_id = e.id
						AND lrd.date >= '2020-01-01'
						AND date <= '2020-06-30'
						AND lrd.pay_type = 1
						AND lrd.status = 1
						AND lr.approve_status_id = 1),
				0) AS used_jan_to_jun,
				IFNULL((SELECT
						SUM(lrd.length)
					FROM
						elink_employee_directory.leave_request AS lr
					LEFT JOIN
						leave_request_details AS lrd ON lrd.leave_id = lr.id
					WHERE
						lr.employee_id = e.id
						AND lrd.date >= '2020-07-01'
						AND date <= '2020-12-31'
						AND lrd.pay_type = 1
						AND lrd.status = 1
						AND lr.approve_status_id = 1),
				0) AS used_jul_to_dec
			FROM
				elink_employee_directory.employee_info AS e
			WHERE
				e.status = 1
				AND e.deleted_at IS NULL
				AND eid LIKE 'ESCC-%'";

		if($id) {
			$sql.=" and e.id = ".$id;
		}

		return $sql;
	}

	private function newQuery2($id = NULL)
	{
		$sql = "
			SELECT 
				eid,
				id,
				CONCAT(e.first_name, ' ', e.last_name) AS employee_name,
				e.prod_date,
				e.position_name,
				@past:=IFNULL((SELECT
						credit
					FROM
						leave_credits
					WHERE
						year = YEAR(NOW()) - 1 AND type = 2
						AND employee_id = e.id AND leave_credits.status = 1
					LIMIT 1),
				0) AS past_credit,
				@conversion:=IFNULL((SELECT
						credit
					FROM
						leave_credits
					WHERE
						year = YEAR(NOW()) AND type = 3
						AND employee_id = e.id AND leave_credits.status = 1
					LIMIT 1),
				0) AS conversion_credit,
				IFNULL((SELECT
						credit
					FROM
						leave_credits
					WHERE
						year = YEAR(NOW()) AND type = 4
						AND employee_id = e.id AND leave_credits.status = 1
					LIMIT 1),
				0) AS loa,
				@current:=IFNULL((SELECT
						SUM(credit)
					FROM
						leave_credits
					WHERE
						year = YEAR(NOW()) AND type = 1 AND leave_credits.status = 1
						AND employee_id = e.id),
				0) AS current_credit,
				@used:=IFNULL((SELECT
						SUM(credit)
					FROM
						leave_credits
					WHERE
						year = YEAR(NOW()) AND type = 5 AND leave_credits.status = 1
						AND employee_id = e.id),
				0) AS used_credit,
				@totalpto:=@past + @current - @used - @conversion AS total_credits
			FROM
				elink_employee_directory.employee_info AS e
			WHERE
				e.status = 1
				AND e.deleted_at IS NULL
				AND eid LIKE 'ESCC-%'";

		if($id) {
			$sql.=" and e.id = ".$id;
		}

		return $sql;
	}

	// public function test(Request $request)
	// {
	// 	$columns = array(
	// 		array('dt' => 0 ),
	// 		array('dt' => 1 ),
	// 		array('dt' => 2 ),
	// 		array('dt' => 3 ),
	// 		array('dt' => 4 ),
	// 		array('dt' => 5 ),
	// 		array('dt' => 6 ),
	// 		array('dt' => 7 ),
	// 		array('dt' => 8 )
	// 	);

	// 	echo json_encode(LeaveRequest::getLeave2($request, $columns));
	// }
}
