<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;
use DateTime;
use App\EmployeeDepartment;
use App\ElinkAccount;
use App\ElinkDivision;
use App\User;
use App\EmployeeInfoDetails;
use App\EmployeeDependents;
use App\Employee;
use App\EmployeeAttrition;
use App\LeaveRequest;
use App\TempDetails;
use App\MovementsTransfer;
use App\Mail\UpdateInfo;
use App\Mail\ApproveInformation;
use App\AdtlLinkee;
use Response;
use File;
use DB;
use Illuminate\Support\Facades\Validator;

class EmployeeInfoController extends Controller
{

	public function login(Request $request)
	{
		return $this->authModel->login($request);
	}

	public function loginAPIv2(Request $request)
	{
		return $this->authModel->loginAPIv2($request);
	}

	public function loginAPI(Request $request)
	{
		return $this->authModel->loginAPI($request);
	}

	public function session(Request $request)
	{
		return $this->authModel->session($request);
	}

	public function processLinkees(Request $req)
	{
		$validator = Validator::make($req->all(), ["adtl_linkee" => 'required']);

		if($validator->fails()) {
			return ['data' => false];
		}

		$adtl_linker = $req->get('adtl_linker');
		$adtl_linkee = $req->get('adtl_linkee');
		$adtl_row = $req->get('adtl_row');
		$adtl_added_by = Auth::user()->id;
		$adtl_date_added = date("Y-m-d H:i:s");

		$exist = AdtlLinkee::where('adtl_linker', $adtl_linker)->where('adtl_linkee', $adtl_linkee)->first();

		if(!$exist){
			$data['adtl_linker'] = $adtl_linker;
			$data['adtl_linkee'] = $adtl_linkee;
			$data['adtl_row'] = 1;
			$data['adtl_added_by'] = $adtl_added_by;
			$data['adtl_date_added'] = $adtl_date_added;
			$data['adtl_status'] = 1;

			$linkee = AdtlLinkee::create($data);

			$linkerInformation = User::where('id', $linkee->adtl_linker)->first();
			$linkeeInformation = User::where('id', $linkee->adtl_linkee)->first();
			$linkeeInformation->supervisor_id = $linkerInformation->id;
			$linkeeInformation->supervisor_name = $linkerInformation->fullname();
			// $linkeeInformation->save();
		}

		return ['data' => $linkeeInformation ?? false];
	}

	public function deleteLinkees(Request $request)
	{
		$validator = Validator::make($request->all(), ["adtl_linkee" => 'required']);

		if($validator->fails()){
			return ['data' => false];
		}

		$employee = User::where('id', $request->adtl_linkee)->first();

		DB::table('adtl_linkees')->where('adtl_linkee',$request->adtl_linkee)->where('adtl_linker', $request->adtl_linker)->delete();

		if(!empty($employee)) {
			if($employee->supervisor_id == $request->adtl_linker) {
				$employee->supervisor_id = 0;
				$employee->supervisor_name = '';
			}
			if($employee->manager_id == $request->adtl_linker) {
				$employee->manager_id = 0;
				$employee->manager_name = '';
			}
			$employee->save();
		}

		return ['data' => true];
	}

	public function index()
	{
		return redirect(url('employees'));
	}

	public function create()
	{
		$data['employees'] = User::whereNull('deleted_at')->where('status', 1)->where('id', '<>', 1)->orderBy('last_name')->get();
		$data['departments'] = EmployeeDepartment::all();
		$data['accounts'] = ElinkAccount::all();
		$data['positions'] = User::select('position_name')->where('id', '<>', 1)->groupBy('position_name')->get();

		return view('employee.create', $data);
	}

	public function store(Request $request)
	{
		return $this->model->store($request);
	}

	public function edit($id)
	{
		$employee = User::find($id);
		if(empty($employee)) {
			return abort(404);
		}

		$obj = EmployeeInfoDetails::where('employee_id',"=",$id)->get();
		if(count($obj) > 0) {
			$obj = $obj[0];
		} else {
			$obj['town_address'] = '';
			$obj['em_con_name'] = '';
			$obj['em_con_address'] = '';
			$obj['em_con_num'] = '';
			$obj['em_con_rel'] = '';
			$obj['resignation_date'] = '';
			$obj['avega_num'] = '';
		}

		$data['employee'] = $employee;
		$data['supervisors'] = User::whereNull('deleted_at')->where('status', 1)->where('id', '<>', 1)->orderBy('last_name')->get();
		$data['departments'] = EmployeeDepartment::all();
		$data['accounts'] = ElinkAccount::all();
		$data['details'] = $obj;
		$data['dependents'] = EmployeeDependents::where('employee_num', $id)->where('status',1)->get();
		$data['positions'] = User::select('position_name')->groupBy('position_name')->get();
		$data['linkees'] = $employee->getLinkees();
		$data['linkers'] = DB::select("select * from adtl_linkees where adtl_linker = {$id} and adtl_status = 1");

		return view('employee.edit', $data);
	}

	public function update(Request $request, $id)
	{
		return $this->model->updateEmployee($request, $id);
	}

	public function destroy($id)
	{
		$employee = User::find($id);
		$employee->delete();

		return redirect()->back()->with('success', "Successfully deleted employee record");
	}

	public function changepassword(Request $request, $id)
	{
		return $this->authModel->changepassword($request, $id);
	}

	public function savepassword(Request $request, $id)
	{
		return $this->authModel->savepassword($request, $id);
	}

	public function employees(Request $request)
	{
		app('App\Http\Controllers\EmailRemindersController')->index();

		return $this->model->employees($request);
	}

	public function searchMovements(Request $request)
	{
		return MovementsTransfer::where('mv_employee_no',$request->get("emp_no"))->leftJoin('employee_department','movements.mv_dept','=','employee_department.id')->orderBy('mv_transfer_date', 'DESC')->get();
	}

	public function saveMovements(Request $request)
	{
		$obj = new MovementsTransfer();
		$obj->mv_employee_no    = $request->post('mv_employee_no');
		$obj->mv_dept           = $request->post('mv_dept');
		$obj->mv_position       = $request->post('mv_position');
		$obj->mv_transfer_date  = date('Y-m-d', strtotime($request->post('mv_transfer_date')));

		$sql = DB::select("
			SELECT
				department_code
			FROM
				elink_employee_directory.employee_department
			WHERE
				id = $obj->mv_dept
			LIMIT 1;"
		);

		if(count($sql) > 0):
			$userarray['team_name'] = $request->post('dept_name');
			$userarray['dept_code'] = $sql[0]->department_code;
			$userarray['position_name'] = $obj->mv_position;
		endif;

		$affected = DB::table('employee_info')->where('id', $request->post('mv_employee_no'))->update($userarray);

		return ['status' => $obj->save(), 'User' => $affected];
	}

	public function downloadInactive(Request $request)
	{
		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$worksheet = $spreadsheet->getActiveSheet();
		//$employees = User::allExceptSuperAdmin()->get();
		$employees = $this->model->download_inactive($request);
		$COUNT = 0;
		$EID = 1;
		$LAST_NAME = 2;
		$FIRST_NAME = 3;
		$MIDDLE_NAME = 4;
		$FULLNAME = 5;
		$ROLE = 6;
		$SUPERVISOR = 7;
		$MANAGER = 8;
		$DIVISION = 9;
		$DEPT = 10;
		$DEPT_CODE = 11;
		$ACCOUNT = 12;
		$EXT = 13;
		$ALIAS = 14;
		$PROD_DATE = 15;
		$STATUS = 16;
		$HIRED_DATE = 17;
		$WAVE = 18;
		$EMAIL = 19;
		$GENDER = 20;
		$BDAY = 21;
		$CITYADD = 22;
		$HOMEADD = 23;
		$CIVILSTAT = 24;
		$CONTACTNUM = 25;
		$INCASECON = 26;
		$INCASEREL = 27;
		$INCASERELCON = 28;
		$INCASERELADD = 29;
		$TIN = 30;
		$SSS = 31;
		$PHILHEALTH = 32;
		$HMDF = 33;
		$RESIGNATIONDATE = 34;

		$worksheet->getCell(getNameFromNumber($COUNT + 1) . 1 )->setValue('Count'); 
		$worksheet->getCell(getNameFromNumber($EID + 1) . 1 )->setValue('EID');
		$worksheet->getCell(getNameFromNumber($LAST_NAME + 1) . 1 )->setValue('Last Name');
		$worksheet->getCell(getNameFromNumber($FIRST_NAME + 1) . 1 )->setValue('First Name');
		$worksheet->getCell(getNameFromNumber($MIDDLE_NAME + 1) . 1 )->setValue('Middle Name');
		$worksheet->getCell(getNameFromNumber($FULLNAME + 1) . 1 )->setValue('Name');
		$worksheet->getCell(getNameFromNumber($ROLE + 1) . 1 )->setValue('Role');
		$worksheet->getCell(getNameFromNumber($SUPERVISOR + 1) . 1 )->setValue('Supervisor');
		$worksheet->getCell(getNameFromNumber($MANAGER + 1) . 1 )->setValue('Manager');
		$worksheet->getCell(getNameFromNumber($DIVISION + 1) . 1 )->setValue('Division');
		$worksheet->getCell(getNameFromNumber($DEPT + 1) . 1 )->setValue('Dept');
		$worksheet->getCell(getNameFromNumber($DEPT_CODE + 1) . 1 )->setValue('Dept Code');
		$worksheet->getCell(getNameFromNumber($ACCOUNT + 1) . 1 )->setValue('Account');
		$worksheet->getCell(getNameFromNumber($EXT + 1) . 1 )->setValue('EXT');
		$worksheet->getCell(getNameFromNumber($ALIAS + 1) . 1 )->setValue('Phone/Pen Names');
		$worksheet->getCell(getNameFromNumber($PROD_DATE + 1) . 1 )->setValue('Prod Date');
		$worksheet->getCell(getNameFromNumber($STATUS + 1) . 1 )->setValue('Status');
		$worksheet->getCell(getNameFromNumber($HIRED_DATE + 1) . 1 )->setValue('Hire Date');
		$worksheet->getCell(getNameFromNumber($WAVE + 1) . 1 )->setValue('Wave');
		$worksheet->getCell(getNameFromNumber($EMAIL + 1) . 1 )->setValue('Email');
		$worksheet->getCell(getNameFromNumber($GENDER + 1 ) . 1 )->setValue('Gender');
		$worksheet->getCell(getNameFromNumber($BDAY + 1) . 1 )->setValue('Bday');
		$worksheet->getCell(getNameFromNumber($CITYADD + 1) . 1 )->setValue('City Address');
		$worksheet->getCell(getNameFromNumber($HOMEADD + 1) . 1 )->setValue('Home Address');
		$worksheet->getCell(getNameFromNumber($CIVILSTAT + 1) . 1 )->setValue('Civil Stat');
		$worksheet->getCell(getNameFromNumber($CONTACTNUM + 1) . 1 )->setValue('Number');
		$worksheet->getCell(getNameFromNumber($INCASECON + 1) . 1 )->setValue('Contact Person');
		$worksheet->getCell(getNameFromNumber($INCASEREL + 1) . 1 )->setValue('Relationship');
		$worksheet->getCell(getNameFromNumber($INCASERELCON + 1) . 1 )->setValue('Number');
		$worksheet->getCell(getNameFromNumber($INCASERELADD + 1) . 1 )->setValue('Address');
		$worksheet->getCell(getNameFromNumber($TIN + 1) . 1 )->setValue('TIN');
		$worksheet->getCell(getNameFromNumber($SSS + 1) . 1 )->setValue('SSS');
		$worksheet->getCell(getNameFromNumber($PHILHEALTH + 1) . 1 )->setValue('Philhealth');
		$worksheet->getCell(getNameFromNumber($HMDF + 1) . 1 )->setValue('HMDF');
		$worksheet->getCell(getNameFromNumber($RESIGNATIONDATE + 1) . 1 )->setValue('Resignation Date');

		$worksheet->getColumnDimension(getNameFromNumber($COUNT + 1))->setWidth(7);
		$worksheet->getColumnDimension(getNameFromNumber($EID + 1))->setWidth(20);
		$worksheet->getColumnDimension(getNameFromNumber($EXT + 1))->setWidth(5);
		$worksheet->getColumnDimension(getNameFromNumber($ALIAS + 1))->setWidth(30);
		$worksheet->getColumnDimension(getNameFromNumber($LAST_NAME + 1))->setWidth(20);
		$worksheet->getColumnDimension(getNameFromNumber($FIRST_NAME + 1))->setWidth(20);
		$worksheet->getColumnDimension(getNameFromNumber($MIDDLE_NAME + 1))->setWidth(20);
		$worksheet->getColumnDimension(getNameFromNumber($FULLNAME + 1))->setWidth(40);
		$worksheet->getColumnDimension(getNameFromNumber($SUPERVISOR + 1))->setWidth(30);
		$worksheet->getColumnDimension(getNameFromNumber($MANAGER + 1))->setWidth(30);
		$worksheet->getColumnDimension(getNameFromNumber($DEPT + 1))->setWidth(25);
		$worksheet->getColumnDimension(getNameFromNumber($DEPT_CODE + 1))->setWidth(15);
		$worksheet->getColumnDimension(getNameFromNumber($DIVISION + 1))->setWidth(15);
		$worksheet->getColumnDimension(getNameFromNumber($ROLE + 1))->setWidth(30);
		$worksheet->getColumnDimension(getNameFromNumber($ACCOUNT + 1))->setWidth(15);
		$worksheet->getColumnDimension(getNameFromNumber($PROD_DATE + 1))->setWidth(15);
		$worksheet->getColumnDimension(getNameFromNumber($STATUS + 1))->setWidth(10);
		$worksheet->getColumnDimension(getNameFromNumber($HIRED_DATE + 1))->setWidth(10);
		$worksheet->getColumnDimension(getNameFromNumber($WAVE + 1))->setWidth(8);
		$worksheet->getColumnDimension(getNameFromNumber($EMAIL + 1))->setWidth(30);
		$worksheet->getColumnDimension(getNameFromNumber($GENDER + 1))->setWidth(10);
		$worksheet->getColumnDimension(getNameFromNumber($BDAY + 1))->setWidth(10);

		$row = 2;
		foreach ($employees as $index => $value) {
			$worksheet->getCell(getNameFromNumber($COUNT + 1) . $row )->setValue($row-1);
			$worksheet->getCell(getNameFromNumber($EID + 1) . $row )->setValue($value->eid);
			$worksheet->getCell(getNameFromNumber($LAST_NAME + 1) . $row )->setValue($value->last_name);
			$worksheet->getCell(getNameFromNumber($FIRST_NAME + 1) . $row )->setValue($value->first_name);
			$worksheet->getCell(getNameFromNumber($MIDDLE_NAME + 1) . $row )->setValue($value->middle_name);
			$worksheet->getCell(getNameFromNumber($FULLNAME + 1) . $row )->setValue($value->first_name." ".$value->last_name);
			$worksheet->getCell(getNameFromNumber($ROLE + 1) . $row )->setValue($value->position_name);
			$worksheet->getCell(getNameFromNumber($SUPERVISOR + 1) . $row )->setValue($value->supervisor_name);
			$worksheet->getCell(getNameFromNumber($MANAGER + 1) . $row )->setValue($value->manager_name);
			$worksheet->getCell(getNameFromNumber($DIVISION + 1) . $row )->setValue($value->division_name);
			$worksheet->getCell(getNameFromNumber($DEPT + 1) . $row )->setValue($value->team_name);
			$worksheet->getCell(getNameFromNumber($DEPT_CODE + 1) . $row )->setValue($value->dept_code);

			$account = ElinkAccount::find($value->account_id);
			if ($account) {
				$worksheet->getCell(getNameFromNumber($ACCOUNT + 1) . $row )->setValue($account->account_name);
			}

			$civil_status = 'Divorced';
			switch($value->civil_status) {
				case 1:
				$civil_status = 'Single';
					break;
				case 2:
				$civil_status = 'Married';
					break;
				case 3:
				$civil_status = 'Separated';
					break;
				case 4:
				$civil_status = 'Anulled';
					break;
			}

			$worksheet->getCell(getNameFromNumber($EXT + 1) . $row )->setValue($value->ext);
			$worksheet->getCell(getNameFromNumber($ALIAS + 1) . $row )->setValue($value->alias);
			$worksheet->getCell(getNameFromNumber($PROD_DATE + 1) . $row )->setValue(date("F d, Y", strtotime($value->prod_date)));
			$worksheet->getCell(getNameFromNumber($STATUS + 1) . $row )->setValue($value->deleted_at == NULL && $value->status == 1 ? 'Active' : 'Inactive');
			$worksheet->getCell(getNameFromNumber($HIRED_DATE + 1) . $row )->setValue(date("F d, Y", strtotime($value->hired_date)));
			$worksheet->getCell(getNameFromNumber($WAVE + 1) . $row )->setValue($value->wave);
			$worksheet->getCell(getNameFromNumber($EMAIL + 1) . $row )->setValue($value->email);
			$worksheet->getCell(getNameFromNumber($GENDER + 1) . $row )->setValue(genderStringValue($value->gender));
			$worksheet->getCell(getNameFromNumber($BDAY + 1) . $row )->setValue(date("F d, Y", strtotime($value->birth_date)));
			$worksheet->getCell(getNameFromNumber($CITYADD + 1) . $row )->setValue($value->address);
			$worksheet->getCell(getNameFromNumber($HOMEADD + 1) . $row )->setValue($value->town_address);
			$worksheet->getCell(getNameFromNumber($CIVILSTAT + 1) . $row )->setValue($civil_status);
			$worksheet->getCell(getNameFromNumber($CONTACTNUM + 1) . $row )->setValue($value->contact_number);
			$worksheet->getCell(getNameFromNumber($INCASECON + 1) . $row )->setValue($value->em_con_name);
			$worksheet->getCell(getNameFromNumber($INCASEREL + 1) . $row )->setValue($value->em_con_rel);
			$worksheet->getCell(getNameFromNumber($INCASERELCON + 1) . $row )->setValue($value->em_con_num);
			$worksheet->getCell(getNameFromNumber($INCASERELADD + 1) . $row )->setValue($value->em_con_address);
			$worksheet->getCell(getNameFromNumber($TIN + 1) . $row )->setValue($value->tin);
			$worksheet->getCell(getNameFromNumber($SSS + 1) . $row )->setValue($value->sss);
			$worksheet->getCell(getNameFromNumber($PHILHEALTH + 1) . $row )->setValue($value->philhealth);
			$worksheet->getCell(getNameFromNumber($HMDF + 1) . $row )->setValue($value->pagibig);
			$worksheet->getCell(getNameFromNumber($RESIGNATIONDATE + 1) . $row )->setValue($value->deleted_at);

		$row++;
		}

		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
		$timestamp = date('m_d_Y_G_i');
		$writer->save("./public/excel/report/inactives-". $timestamp . ".xlsx");

		$file_name = 'inactives-'.$timestamp.'.xlsx';

		return redirect('public/excel/report/' . $file_name);
	}

	public function downloadFilter(Request $request)
	{
		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$worksheet = $spreadsheet->getActiveSheet();
		$employees = $this->model->download_filter($request);
		$COUNT = 0;
		$EID = 1;
		$LAST_NAME = 2;
		$FIRST_NAME = 3;
		$MIDDLE_NAME = 4;
		$FULLNAME = 5;
		$ROLE = 6;
		$SUPERVISOR = 7;
		$MANAGER = 8;
		$DIVISION = 9;
		$DEPT = 10;
		$DEPT_CODE = 11;
		$ACCOUNT = 12;
		$EXT = 13;
		$ALIAS = 14;
		$PROD_DATE = 15;
		$STATUS = 16;
		$HIRED_DATE = 17;
		$WAVE = 18;
		$EMAIL = 19;
		$GENDER = 20;
		$BDAY = 21;
		$CITYADD = 22;
		$HOMEADD = 23;
		$CIVILSTAT = 24;
		$CONTACTNUM = 25;
		$INCASECON = 26;
		$INCASEREL = 27;
		$INCASERELCON = 28;
		$INCASERELADD = 29;
		$TIN = 30;
		$SSS = 31;
		$PHILHEALTH = 32;
		$HMDF = 33;

		$worksheet->getCell(getNameFromNumber($COUNT + 1) . 1 )->setValue('Count'); 
		$worksheet->getCell(getNameFromNumber($EID + 1) . 1 )->setValue('EID');
		$worksheet->getCell(getNameFromNumber($LAST_NAME + 1) . 1 )->setValue('Last Name');
		$worksheet->getCell(getNameFromNumber($FIRST_NAME + 1) . 1 )->setValue('First Name');
		$worksheet->getCell(getNameFromNumber($MIDDLE_NAME + 1) . 1 )->setValue('Middle Name');
		$worksheet->getCell(getNameFromNumber($FULLNAME + 1) . 1 )->setValue('Name');
		$worksheet->getCell(getNameFromNumber($ROLE + 1) . 1 )->setValue('Role');
		$worksheet->getCell(getNameFromNumber($SUPERVISOR + 1) . 1 )->setValue('Supervisor');
		$worksheet->getCell(getNameFromNumber($MANAGER + 1) . 1 )->setValue('Manager');
		$worksheet->getCell(getNameFromNumber($DIVISION + 1) . 1 )->setValue('Division');
		$worksheet->getCell(getNameFromNumber($DEPT + 1) . 1 )->setValue('Dept');
		$worksheet->getCell(getNameFromNumber($DEPT_CODE + 1) . 1 )->setValue('Dept Code');
		$worksheet->getCell(getNameFromNumber($ACCOUNT + 1) . 1 )->setValue('Account');
		$worksheet->getCell(getNameFromNumber($EXT + 1) . 1 )->setValue('EXT');
		$worksheet->getCell(getNameFromNumber($ALIAS + 1) . 1 )->setValue('Phone/Pen Names');
		$worksheet->getCell(getNameFromNumber($PROD_DATE + 1) . 1 )->setValue('Prod Date');
		$worksheet->getCell(getNameFromNumber($STATUS + 1) . 1 )->setValue('Status');
		$worksheet->getCell(getNameFromNumber($HIRED_DATE + 1) . 1 )->setValue('Hire Date');
		$worksheet->getCell(getNameFromNumber($WAVE + 1) . 1 )->setValue('Wave');
		$worksheet->getCell(getNameFromNumber($EMAIL + 1) . 1 )->setValue('Email');
		$worksheet->getCell(getNameFromNumber($GENDER + 1 ) . 1 )->setValue('Gender');
		$worksheet->getCell(getNameFromNumber($BDAY + 1) . 1 )->setValue('Bday');
		$worksheet->getCell(getNameFromNumber($CITYADD + 1) . 1 )->setValue('City Address');
		$worksheet->getCell(getNameFromNumber($HOMEADD + 1) . 1 )->setValue('Home Address');
		$worksheet->getCell(getNameFromNumber($CIVILSTAT + 1) . 1 )->setValue('Civil Stat');
		$worksheet->getCell(getNameFromNumber($CONTACTNUM + 1) . 1 )->setValue('Number');
		$worksheet->getCell(getNameFromNumber($INCASECON + 1) . 1 )->setValue('Contact Person');
		$worksheet->getCell(getNameFromNumber($INCASEREL + 1) . 1 )->setValue('Relationship');
		$worksheet->getCell(getNameFromNumber($INCASERELCON + 1) . 1 )->setValue('Number');
		$worksheet->getCell(getNameFromNumber($INCASERELADD + 1) . 1 )->setValue('Address');
		$worksheet->getCell(getNameFromNumber($TIN + 1) . 1 )->setValue('TIN');
		$worksheet->getCell(getNameFromNumber($SSS + 1) . 1 )->setValue('SSS');
		$worksheet->getCell(getNameFromNumber($PHILHEALTH + 1) . 1 )->setValue('Philhealth');
		$worksheet->getCell(getNameFromNumber($HMDF + 1) . 1 )->setValue('HMDF');

		$worksheet->getColumnDimension(getNameFromNumber($COUNT + 1))->setWidth(7);
		$worksheet->getColumnDimension(getNameFromNumber($EID + 1))->setWidth(20);
		$worksheet->getColumnDimension(getNameFromNumber($EXT + 1))->setWidth(5);
		$worksheet->getColumnDimension(getNameFromNumber($ALIAS + 1))->setWidth(30);
		$worksheet->getColumnDimension(getNameFromNumber($LAST_NAME + 1))->setWidth(20);
		$worksheet->getColumnDimension(getNameFromNumber($FIRST_NAME + 1))->setWidth(20);
		$worksheet->getColumnDimension(getNameFromNumber($MIDDLE_NAME + 1))->setWidth(20);
		$worksheet->getColumnDimension(getNameFromNumber($FULLNAME + 1))->setWidth(40);
		$worksheet->getColumnDimension(getNameFromNumber($SUPERVISOR + 1))->setWidth(30);
		$worksheet->getColumnDimension(getNameFromNumber($MANAGER + 1))->setWidth(30);
		$worksheet->getColumnDimension(getNameFromNumber($DEPT + 1))->setWidth(25);
		$worksheet->getColumnDimension(getNameFromNumber($DEPT_CODE + 1))->setWidth(15);
		$worksheet->getColumnDimension(getNameFromNumber($DIVISION + 1))->setWidth(15);
		$worksheet->getColumnDimension(getNameFromNumber($ROLE + 1))->setWidth(30);
		$worksheet->getColumnDimension(getNameFromNumber($ACCOUNT + 1))->setWidth(15);
		$worksheet->getColumnDimension(getNameFromNumber($PROD_DATE + 1))->setWidth(15);
		$worksheet->getColumnDimension(getNameFromNumber($STATUS + 1))->setWidth(10);
		$worksheet->getColumnDimension(getNameFromNumber($HIRED_DATE + 1))->setWidth(10);
		$worksheet->getColumnDimension(getNameFromNumber($WAVE + 1))->setWidth(8);
		$worksheet->getColumnDimension(getNameFromNumber($EMAIL + 1))->setWidth(30);
		$worksheet->getColumnDimension(getNameFromNumber($GENDER + 1))->setWidth(10);
		$worksheet->getColumnDimension(getNameFromNumber($BDAY + 1))->setWidth(10);

		$row = 2;
		foreach ($employees as $index => $value) {
			$worksheet->getCell(getNameFromNumber($COUNT + 1) . $row )->setValue($row-1);
			$worksheet->getCell(getNameFromNumber($EID + 1) . $row )->setValue($value->eid);
			$worksheet->getCell(getNameFromNumber($LAST_NAME + 1) . $row )->setValue($value->last_name);
			$worksheet->getCell(getNameFromNumber($FIRST_NAME + 1) . $row )->setValue($value->first_name);
			$worksheet->getCell(getNameFromNumber($MIDDLE_NAME + 1) . $row )->setValue($value->middle_name);
			$worksheet->getCell(getNameFromNumber($FULLNAME + 1) . $row )->setValue($value->first_name." ".$value->last_name);
			$worksheet->getCell(getNameFromNumber($ROLE + 1) . $row )->setValue($value->position_name);
			$worksheet->getCell(getNameFromNumber($SUPERVISOR + 1) . $row )->setValue($value->supervisor_name);
			$worksheet->getCell(getNameFromNumber($MANAGER + 1) . $row )->setValue($value->manager_name);
			$worksheet->getCell(getNameFromNumber($DIVISION + 1) . $row )->setValue($value->division_name);
			$worksheet->getCell(getNameFromNumber($DEPT + 1) . $row )->setValue($value->team_name);
			$worksheet->getCell(getNameFromNumber($DEPT_CODE + 1) . $row )->setValue($value->dept_code);

			$account = ElinkAccount::find($value->account_id);
			if ($account) {
				$worksheet->getCell(getNameFromNumber($ACCOUNT + 1) . $row )->setValue($account->account_name);
			}

			$civil_status = 'Divorced';
			switch($value->civil_status) {
				case 1:
					$civil_status = 'Single';
				break;
				case 2:
					$civil_status = 'Married';
				break;
				case 3:
					$civil_status = 'Separated';
				break;
				case 4:
					$civil_status = 'Anulled';
				break;
			}

			$worksheet->getCell(getNameFromNumber($EXT + 1) . $row )->setValue($value->ext);
			$worksheet->getCell(getNameFromNumber($ALIAS + 1) . $row )->setValue($value->alias);
			$worksheet->getCell(getNameFromNumber($PROD_DATE + 1) . $row )->setValue(date("F d, Y", strtotime($value->prod_date)));
			$worksheet->getCell(getNameFromNumber($STATUS + 1) . $row )->setValue($value->deleted_at == NULL && $value->status == 1 ? 'Active' : 'Inactive');
			$worksheet->getCell(getNameFromNumber($HIRED_DATE + 1) . $row )->setValue(date("F d, Y", strtotime($value->hired_date)));
			$worksheet->getCell(getNameFromNumber($WAVE + 1) . $row )->setValue($value->wave);
			$worksheet->getCell(getNameFromNumber($EMAIL + 1) . $row )->setValue($value->email);
			$worksheet->getCell(getNameFromNumber($GENDER + 1) . $row )->setValue(genderStringValue($value->gender));
			$worksheet->getCell(getNameFromNumber($BDAY + 1) . $row )->setValue(date("F d, Y", strtotime($value->birth_date)));
			$worksheet->getCell(getNameFromNumber($CITYADD + 1) . $row )->setValue($value->address);
			$worksheet->getCell(getNameFromNumber($HOMEADD + 1) . $row )->setValue($value->town_address);
			$worksheet->getCell(getNameFromNumber($CIVILSTAT + 1) . $row )->setValue($civil_status);
			$worksheet->getCell(getNameFromNumber($CONTACTNUM + 1) . $row )->setValue($value->contact_number);
			$worksheet->getCell(getNameFromNumber($INCASECON + 1) . $row )->setValue($value->em_con_name);
			$worksheet->getCell(getNameFromNumber($INCASEREL + 1) . $row )->setValue($value->em_con_rel);
			$worksheet->getCell(getNameFromNumber($INCASERELCON + 1) . $row )->setValue($value->em_con_num);
			$worksheet->getCell(getNameFromNumber($INCASERELADD + 1) . $row )->setValue($value->em_con_address);
			$worksheet->getCell(getNameFromNumber($TIN + 1) . $row )->setValue($value->tin);
			$worksheet->getCell(getNameFromNumber($SSS + 1) . $row )->setValue($value->sss);
			$worksheet->getCell(getNameFromNumber($PHILHEALTH + 1) . $row )->setValue($value->philhealth);
			$worksheet->getCell(getNameFromNumber($HMDF + 1) . $row )->setValue($value->pagibig);

		$row++;
		}

		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
		$timestamp = date('m_d_Y_G_i');
		$writer->save("./public/excel/report/report". $timestamp . ".xlsx");

		$file_name = 'report'.$timestamp.'.xlsx';

		return redirect('public/excel/report/' . $file_name);
	}

	public function profile(Request $request, $id)
	{
		$data['employee'] = User::withTrashed()->find($id);
		$data['leave_requests'] = LeaveRequest::getLeave('separated', $id, 'list', 1);

		return view('auth.profile.view', $data);
	}

	public function show($id)
	{
		$employee = User::withTrashed()->find($id);

		if (isset($employee)) {
			$obj = EmployeeInfoDetails::where('employee_id',$id)->get();
			if(count($obj) > 0) {
				$details = $obj[0];
			} else {
				$details = (object)[
					'town_address' => '',
					'em_con_name'  => '',
					'em_con_rel'   => '',
					'em_con_num'   => ''
				];
			}

			$data['employee'] = $employee;

			if(Auth::user()->isAdmin() || Auth::user()->id == $id) {
				$data['linkees'] = $employee->getLinkees();
				$data['supervisors'] = User::whereNull('deleted_at')->where('status', 1)->where('id', '<>', 1)->orderBy('last_name')->get();
				$data['departments'] = EmployeeDepartment::all();
				$data['accounts'] = ElinkAccount::all();
				$data['details'] = $details;
				$data['dependents'] = EmployeeDependents::where('employee_num',$id)->where('status',1)->get();

				return view('employee.view-admin', $data);
			} else {
				$data['employee_details'] = $details;
				$data['employees'] = User::whereNull('deleted_at')->where('status', 1)->where('id', '<>', 1)->orderBy('last_name')->get();

				return view('employee.view', $data);
			}
		} else {
			return abort(404);
		}
	}

	public function myprofile(Request $request)
	{
		$obj = EmployeeInfoDetails::where('employee_id', Auth::user()->id)->get();
		if(count($obj) > 0) {
			$details = $obj[0];
		} else {
			$details = (object)[
				'town_address'  => '',
				'em_con_name'   => '',
				'em_con_rel'    => '',
				'em_con_num'    => ''
			];
		}

		$data['employee'] = Auth::user();
		$data['supervisors'] = User::whereNull('deleted_at')->where('status', 1)->where('id', '<>', 1)->orderBy('last_name')->get();
		$data['departments'] = EmployeeDepartment::all();
		$data['accounts'] = ElinkAccount::all();
		$data['details'] = $details;
		$data['linkees'] = Auth::user()->getLinkees();
		$data['dependents'] = EmployeeDependents::where('employee_num', Auth::user()->id)->where('status',1)->get();
		$data['myprofile'] = 1;

		return view('employee.view-admin', $data);
	}

	public function updateProfile(Request $request)
	{
		$emp_details = [
			'em_con_name'   => '',
			'em_con_rel'    => ''
			];
		$details = EmployeeInfoDetails::where('employee_id',Auth::user()->id)->get();

		if(count($details) > 0) {
			$emp_details = $details[0];
		}

		$data['employee'] = Auth::user();
		$data['details'] = $emp_details;

		return view('auth.profile.edit', $data);
	}

	public function saveProfile(Request $request)
	{
		$obj = [
			'id'                 => 0,
			'name'               => Auth::user()->first_name." ".Auth::user()->last_name,
			'employee_id'        => $request->post('employee_id'),
			'changedate'         => date('Y-m-d H:i:s'),
			'o_current_address'  => $request->post('o_current_address'),
			'n_current_address'  => $request->post('n_current_address'),
			'o_contact_num'      => $request->post('o_contact_num'),
			'n_contact_num'      => $request->post('n_contact_num'),
			'o_emergency'        => $request->post('o_emergency'),
			'n_emergency'        => $request->post('n_emergency'),
			'o_emergency_num'    => $request->post('o_emergency_num'),
			'n_emergency_num'    => $request->post('n_emergency_num'),
			'o_rel'              => $request->post('o_rel'),
			'n_rel'              => $request->post('n_rel'),
			'o_marital_stat'     => $request->post('o_marital_stat'),
			'n_marital_stat'     => $request->post('n_marital_stat'),
			'status'             => 2 
		];

		$temp = new TempDetails();
		$temp->employee_id         = $obj['employee_id'];
		$temp->changedate          = $obj['changedate'];
		$temp->o_current_address   = $obj['o_current_address'];
		$temp->n_current_address   = $obj['n_current_address'];
		$temp->o_contact_num       = $obj['o_contact_num'];
		$temp->n_contact_num       = $obj['n_contact_num'];
		$temp->o_emergency         = $obj['o_emergency'];
		$temp->n_emergency         = $obj['n_emergency'];
		$temp->o_emergency_num     = $obj['o_emergency_num'];
		$temp->n_emergency_num     = $obj['n_emergency_num'];
		$temp->o_rel               = $obj['o_rel'];
		$temp->n_rel               = $obj['n_rel'];
		$temp->o_marital_stat      = $obj['o_marital_stat'];
		$temp->n_marital_stat      = $obj['n_marital_stat'];
		$temp->status              = $obj['status'];
		$temp->save();

		$obj['id'] = $temp->id;
		$sup_obj = User::find(Auth::user()->supervisor_id);
		$mngr_obj = User::find(Auth::user()->manager_id);
		$emails = [];
		if($sup_obj && isset($sup_obj->email)) {
			array_push($emails,$sup_obj->email);
		}
		if($mngr_obj && isset($mngr_obj->email)) {
			array_push($emails,$mngr_obj->email);
		}
		array_push($emails,"hrd@elink.com.ph");

		Mail::to($emails)->queue(new UpdateInfo($obj));

		return view('employee.confirm');
	}

	public function approveChangeProfile(Request $request, $id)
	{
		$obj = TempDetails::find($id);
		$user = User::find($obj->employee_id);
		$first_name = $user->first_name;
		$last_name = $user->last_name;
		$info = "You have not enough rights to approve the recommended request of ".$first_name." ".$last_name.".";

		if(Auth::user()->id == 2810) {
			$info = "Recommended Update Profile Request Successfully Approved.";
			$obj = TempDetails::find($id);
			$obj->status = 3;
			$obj->save();

			$user_obj = User::find($obj->employee_id);
			$user_obj->civil_status   = $obj->n_marital_stat;
			$user_obj->contact_number = $obj->n_contact_num;
			$user_obj->address        = $obj->n_current_address;
			$user_obj->save();

			$details_obj = EmployeeInfoDetails::where("employee_id",$obj->employee_id)->get();
			if(count($details_obj) > 0) {
				$edit_obj = EmployeeInfoDetails::find($details_obj[0]->id);
				$edit_obj->em_con_name  = $obj->n_emergency;
				$edit_obj->em_con_rel   = $obj->n_rel;
				$edit_obj->em_con_num   = $obj->n_emergency_num;
				$edit_obj->save();
			} else {
				$details = new EmployeeInfoDetails();
				$details->employee_id = $obj->employee_id;
				$details->em_con_name = $obj->n_emergency;
				$details->em_con_rel  = $obj->n_rel;
				$details->em_con_num  = $obj->n_emergency_num;
				$details->status      = 1;
				$details->save();
			}

			Mail::to("hrd@elink.com.ph")->queue(new ApproveInformation($obj_det));
		}

		return $info;
	}

	public function import(Request $request)
	{
		return view('employee.import');
	}

	public function importsave(Request $request)
	{
		return $this->excelModel->importsave($request);
	}

	public function exportdownload() 
	{
		return $this->excelModel->exportdownload();
	}

	public function importbday(Request $request)
	{
		$num_inserts = 0;
		$num_updates = 0;
		$updates = array();
		$inserts = array();
		$employees = array();
		$invalid_emails = array();

		$COUNT = 0;
		$EID = 1;
		$BDAY = 7;

		if ($request->hasFile("dump_file")) {
			$path = $request->dump_file->storeAs('/public/temp/'.Auth::user()->id, 'dump_file.'. \File::extension($request->dump_file->getClientOriginalName()));
		}

		$address = './storage/app/'. $path;

		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load( $address );

		$worksheet = $spreadsheet->getActiveSheet();
		$rows = [];
		foreach($worksheet->getRowIterator() AS $row) {
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(FALSE); 
			$cells = [];

			foreach($cellIterator as $cell) {
				$cells[] = $cell->getValue();
			}
			$rows[] = $cells;
			if(count($rows) > 1) {
				$employee = User::where("eid", "LIKE", "%".$cells[$EID]."%");
				if($employee->count() == 1) {
					if($cells[$BDAY]) {
						if(is_numeric($cells[$BDAY])) {
							$UNIX_DATE = ($cells[$BDAY] - 25569) * 86400;
							$employee->update(['birth_date' => gmdate("Y-m-d H:i:s", (int) $UNIX_DATE)]);
						} else {
							$employee->update(['birth_date' => gmdate("Y-m-d H:i:s", strtotime(str_replace('-','/',$cells[$BDAY])))]);
						}
					$num_updates;
					}
				}
			}
		}

		return "num_updates: " . $num_updates;
	}

	public function checklatest()
	{
		$path = "/var/www/uploads/masterlist"; 
		$latest_ctime = 0;
		$latest_filename = '';    
		$d  = array_diff(scandir($path), array('.', '..'));
		foreach ($d as $entry) {
			$filepath = "{$path}/{$entry}";
			if (is_file($filepath) && filectime($filepath) > $latest_ctime) {
				$latest_ctime = filectime($filepath);
				$latest_filename = $entry;
			}
		}

		$num_inserts = 0;
		$num_updates = 0;
		$updates = array();
		$inserts = array();
		$employees = array();
		$invalid_emails = array();

		$COUNT = 0;
		$EID = 1;
		$EXT = 2;
		$ALIAS = 3;
		$LAST_NAME = 4;
		$FIRST_NAME = 5;
		$FULLNAME = 6;
		$SUPERVISOR = 7;
		$MANAGER = 8;
		$DEPT = 9;
		$DEPT_CODE = 10;
		$DIVISION = 11;
		$ROLE = 12;
		$ACCOUNT = 13;
		$PROD_DATE = 14;
		$STATUS = 15;
		$HIRED_DATE = 16;
		$WAVE = 17;
		$EMAIL = 18;
		$GENDER = 19;
		$BDAY = 20;

		$address = $filepath;
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load( $address );
		$worksheet = $spreadsheet->getActiveSheet();
		$rows = [];

		foreach($worksheet->getRowIterator() AS $row) {
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(FALSE); 
			$cells = [];

			foreach($cellIterator as $cell) {
				$cellValue = $cell->getValue();
				if($cell == "--"){
					$cellValue = "";
				}
				$cells[] = $cellValue;
			}
			$rows[] = $cells;

			if(count($rows) > 1) {
				$cells[$EMAIL] = trim($cells[$EMAIL]);
				$cells[$EID] = trim($cells[$EID]);
				$emp = User::withTrashed()->where('eid', 'LIKE', '%'.$cells[$EID].'%');

				if(!$cells[$EMAIL] || !filter_var($cells[$EMAIL], FILTER_VALIDATE_EMAIL)) {
					if($cells[$FULLNAME] != null){
						array_push($invalid_emails, $cells[$FIRST_NAME]." ".$cells[$LAST_NAME]);
					}

				continue;
				}

				if ($cells[$ACCOUNT]) {
					$account = ElinkAccount::where('account_name', 'LIKE', $cells[$ACCOUNT]);
					if ($account->count() == 0) {
						ElinkAccount::insert(['account_name' => $cells[$ACCOUNT]]);
					}
				}

				if ($cells[$DIVISION]) {
					$division = ElinkDivision::where('division_name','LIKE', $cells[$DIVISION]);
					if ($division->count() == 0) {
						ElinkDivision::insert(['division_name' => $cells[$DIVISION]]);
					}
				}

				if($cells[$DEPT]) {
					$department = EmployeeDepartment::where('department_name', 'LIKE', $cells[$DEPT]);
					if($department->count() == 0) {  
						if($cells[$ACCOUNT]) {
							$dept_account = ElinkAccount::where('account_name', 'LIKE', $cells[$ACCOUNT]);
							if ($dept_account->count() > 0) {
								if ($cells[$DIVISION]) {
									$dept_division = ElinkDivision::where('division_name','LIKE', $cells[$DIVISION]);
									if ($dept_division->count() > 0) {
										EmployeeDepartment::insert([
										'department_name' => $cells[$DEPT],
										'department_code' => $cells[$DEPT_CODE],
										'division_id' => $dept_division->first()->id,
										'account_id' => $dept_account->first()->id
										]);
									}
								}
							}
						}
					}
				}

				$account = ElinkAccount::where('account_name','LIKE', '%'.trim($cells[$ACCOUNT]).'%')->get();

				if($emp->count() >= 1) {
					$employee = array(
						'eid' => trim($cells[$EID]),
						'alias' => trim($cells[$ALIAS]),
						'last_name' => trim($cells[$LAST_NAME]),
						'first_name' => trim($cells[$FIRST_NAME]),
						'supervisor_name' =>  trim($cells[$SUPERVISOR]),
						'manager_name' => trim($cells[$MANAGER]),
						'team_name' => trim($cells[$DEPT]),
						'dept_code' => trim($cells[$DEPT_CODE]),
						'position_name' => trim($cells[$ROLE]),
						'gender' => genderValue(trim($cells[$GENDER])),
						'division_name' => trim($cells[$DIVISION]),
						'ext' => trim($cells[$EXT]),
						'wave' => trim($cells[$WAVE]),
					);

					if(count($account) > 0) {
						$employee['account_id'] = $account->first()->id;
					} else {
						$employee['account_id'] = 0;
					}

					if(strtolower($cells[$STATUS]) == strtolower('Active')) {
						$employee['status'] = 1;
					} else {
						$employee['status'] = 2;
					}

					if($cells[$HIRED_DATE]) {
						if (is_numeric($cells[$HIRED_DATE])) {
							$UNIX_DATE = ($cells[$HIRED_DATE] - 25569) * 86400;
							$employee['hired_date'] = gmdate("Y-m-d H:i:s", (int) $UNIX_DATE);
						}
					}

					if($cells[$BDAY]) {
						if (is_numeric($cells[$BDAY])) {
							$UNIX_DATE = ($cells[$BDAY] - 25569) * 86400;
							$employee['birth_date'] = gmdate("Y-m-d H:i:s", (int) $UNIX_DATE);
						}
					}

					if($cells[$PROD_DATE]) {
						if(is_numeric($cells[$PROD_DATE])) {
							$UNIX_DATE = ($cells[$PROD_DATE] - 25569) * 86400;
							$employee['prod_date'] = gmdate("Y-m-d H:i:s", (int) $UNIX_DATE);
						}
					}

					if($emp->update($employee)) {
						array_push($updates, $cells[$FIRST_NAME] . ' ' . $cells[$LAST_NAME]);
						$num_updates ++;
					}
				} else {
					$employee = new User; // USER : EMPLOYEE
					$employee->eid = trim($cells[$EID]);
					$employee->first_name = trim($cells[$FIRST_NAME]);
					$employee->middle_name = '';
					$employee->last_name = trim($cells[$LAST_NAME]);
					$employee->email = trim($cells[$EMAIL]);
					$employee->alias = trim($cells[$ALIAS]);
					$employee->team_name = trim($cells[$DEPT]);
					$employee->dept_code = trim($cells[$DEPT_CODE]);
					$employee->position_name = trim($cells[$ROLE]);
					$employee->supervisor_name = trim($cells[$SUPERVISOR]);
					$employee->gender = genderValue(trim($cells[$GENDER]));
					$employee->usertype = 1;
					$employee->manager_name = trim($cells[$MANAGER]);
					$employee->division_name = trim($cells[$DIVISION]);
					$employee->all_access = 1;
					$employee->ext = trim($cells[$EXT]);
					$employee->wave = trim($cells[$WAVE]);
					$employee->password = Hash::make(env('USER_DEFAULT_PASSWORD', 'qwe123!@#$'));

					$account = ElinkAccount::where('account_name','LIKE' , '%'.$cells[$ACCOUNT].'%')->get();

					if(count($account) > 0) {
						$employee->account_id = $account->first()->id;
					} else {
						$employee->account_id = 0;
					}

					if(strtolower($cells[$STATUS]) == strtolower('Active')) {
						$employee->status = 1;
					} else {
						$employee->status = 2;
					}

					if($cells[$HIRED_DATE]) {
						if (is_numeric($cells[$HIRED_DATE])) {
							$UNIX_DATE = ($cells[$HIRED_DATE] - 25569) * 86400;
							$employee->hired_date = gmdate("Y-m-d H:i:s", (int) $UNIX_DATE);
						}
					}

					if($cells[$BDAY]) {
						if (is_numeric($cells[$BDAY])) {
							$UNIX_DATE = ($cells[$BDAY] - 25569) * 86400;
							$employee->birth_date = gmdate("Y-m-d H:i:s", (int) $UNIX_DATE);
						}
					}

					if($cells[$PROD_DATE]) {
						if (is_numeric($cells[$PROD_DATE])) {
							$UNIX_DATE = ($cells[$PROD_DATE] - 25569) * 86400;
							$employee->prod_date = gmdate("Y-m-d H:i:s", (int)$UNIX_DATE);
						}
					}

					if($employee->gender == 1) {
						$employee->profile_img = asset('public/img/nobody_m.original.jpg');
					} else {
						$employee->profile_img = asset('public/img/nobody_f.original.jpg');
					}

					$employee->save();
					$num_inserts ++;

					array_push($inserts, $cells[$FIRST_NAME] . " " . $cells[$LAST_NAME]);
				}
			}
		}

		$result = json_encode(['Number of Inserts' => $num_inserts, 'Inserted' => $inserts, 'Number Of Updates' => $num_updates, 'Updated' => $updates, 'Invalid Entry' => $invalid_emails]);

		$bytes_written = File::put('./storage/logs/cron_masterlist.txt', $result);

		if ($bytes_written === false) {
			echo "Error writing to file";
		}
		return $result;
	}

	public function attrition(Request $request)
	{
		$path = "/var/www/uploads/attrition";
		$latest_ctime = 0;
		$latest_filename = '';
		$d = array_diff(scandir($path), array('.', '..'));
		foreach($d as $entry) {
			$filepath = "{$path}/{$entry}";
			if(is_file($filepath) && filectime($filepath) > $latest_ctime) {
				$latest_ctime = filectime($filepath);
				$latest_filename = $entry;
			}
		}

		$to_be_deleted = array();
		$num_inserts = 0;
		$num_updates = 0;
		$updates = array();
		$inserts = array();
		$employees = array();
		$invalid_emails = array();

		$COUNT = 0;
		$EID = 1;
		$FULLNAME = 2;
		$START_DATE = 3;
		$LAST_DATE = 4;
		$EMPLOYEE_TYPE = 5;
		$PARTICULARS = 6;
		$ALIAS = 7;
		$IT_STATUS = 8;
		$RA_STATUS = 9;

		$address = $filepath;

		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load( $address );
		$worksheet = $spreadsheet->getActiveSheet();
		$rows = [];

		foreach($worksheet->getRowIterator() AS $row) {
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(FALSE); 
			$cells = [];

			foreach($cellIterator as $cell) {
				$cells[] = $cell->getValue();
			}

			$rows[] = $cells;

			if(count($rows) > 2) {
				if($cells[$EID] && $cells[$EID] != "") {
					$employee = User::where("eid", "LIKE", "%".trim($cells[$EID])."%");

					if($employee->count() == 1) {
						$employee = $employee->first();
						$num_updates ++;

						array_push($to_be_deleted, ucwords(strtolower($cells[$FULLNAME])));

						$attrition = EmployeeAttrition::where('employee_id', '=', '%' . $cells[$EID] . '%');
						if($attrition->count() == 0) {
							$newAttrition = new EmployeeAttrition;
							$newAttrition->employee_id = $cells[$EID];
							$newAttrition->employee_name = ucwords(strtolower($cells[$FULLNAME]));
							$datetime = new DateTime();
							if($cells[$START_DATE] != "" && $cells[$START_DATE]) {
								if(is_numeric($cells[$START_DATE])) {
									$UNIX_DATE = ($cells[$START_DATE] - 25569) * 86400;
									$newAttrition->start_work_date = gmdate("Y-m-d H:i:s", (int) $UNIX_DATE);
								} else {
									$start_work_date = $datetime->createFromFormat('Y-m-d', $cells[$START_DATE])->format("Y-m-d H:i:s");
									$newAttrition->start_work_date = $start_work_date;
								}
							}

							if($cells[$LAST_DATE] != "" && $cells[$LAST_DATE]) {
								if(is_numeric($cells[$LAST_DATE])) {
									$UNIX_DATE = ($cells[$LAST_DATE] - 25569) * 86400;
									$employee->last_work_date = gmdate("Y-m-d H:i:s", (int) $UNIX_DATE);
								} else {
									 $last_work_date = $datetime->createFromFormat('Y-m-d', $cells[$LAST_DATE])->format("Y-m-d H:i:s");
									 $newAttrition->last_work_date = $last_work_date;
								}
							}

							$newAttrition->employee_type = $cells[$EMPLOYEE_TYPE];
							$newAttrition->particulars = $cells[$PARTICULARS];
							$newAttrition->alias = $cells[$ALIAS];
							$newAttrition->it_status = $cells[$IT_STATUS];
							$newAttrition->ra_status = $cells[$RA_STATUS];
							$newAttrition->save();

							$employee->status = 2;
							$employee->save();
						}

						$employee->delete();
					}
				}
			}
		}
		$result = json_encode(["deleted" => $to_be_deleted, "number_employees_deleted" =>  $num_updates]);
		$bytes_written = File::put('./storage/logs/cron_attrition.txt', $result);

		if ($bytes_written === false) {
			echo "Error writing to file";
		}
		return $result;
	}

	public function separatedEmployees(Request $request)
	{
		$employees = User::separatedEmployees();
		if ($request->has('keyword') && $request->get('keyword') != "") {
			$employees = $employees->where(function($query) use($request) {
				$query->where('first_name', 'LIKE', '%'.$request->get('keyword').'%')
				->orWhere('last_name', 'LIKE', '%'.$request->get('keyword').'%')
				->orWhere('middle_name', 'LIKE', '%'.$request->get('keyword').'%')
				->orWhere(DB::raw('CONCAT(first_name, " ", last_name)'), 'LIKE', '%'.$request->get('keyword').'%')
				->orWhere('email', 'LIKE', '%'.$request->get('keyword').'%')
				->orWhere('email2', 'LIKE', '%'.$request->get('keyword').'%')
				->orWhere('email3', 'LIKE', '%'.$request->get('keyword').'%')
				->orWhere('alias', 'LIKE', '%'.$request->get('keyword').'%')
				->orWhere('team_name', 'LIKE', '%'.$request->get('keyword').'%')
				->orWhere('dept_code', 'LIKE', '%'.$request->get('keyword').'%')
				->orWhere('position_name', 'LIKE', '%'.$request->get('keyword').'%')
				->orWhere('ext', 'LIKE', '%'.$request->get('keyword').'%');
			});
		}

		$data['employees'] = $employees->where('id', '<>', 1)->orderBy('last_name', 'ASC')->paginate(10);
		$data['request'] = $request;

		return view('employee.separated', $data);
	}

	public function reactivate(Request $request, $id){
		return $this->model->reactivateEmployee($request, $id);
	}

	public function recommendApproval($id)
	{
		$obj = TempDetails::find($id);
		$user = User::find($obj->employee_id);
		$first_name = $user->first_name;
		$last_name = $user->last_name;
		$info = "You have not enough rights to validate this request.";

		if(Auth::user()->id == $user->supervisor_id || Auth::user()->id == $user->manager_id) {
			$info = "Request Successfully Validated. Waiting for HR for the Final Approval";
			$obj = TempDetails::find($id);
			$obj->status = 2;
			$obj->save();
			$obj_det = [
				'id'                 => $id,
				'name'               => $first_name." ".$last_name,
				'employee_id'        => $obj->employee_id,
				'o_current_address'  => $obj->o_current_address,
				'n_current_address'  => $obj->n_current_address,
				'o_contact_num'      => $obj->o_contact_num,
				'n_contact_num'      => $obj->n_contact_num,
				'o_emergency'        => $obj->o_emergency,
				'n_emergency'        => $obj->n_emergency,
				'o_emergency_num'    => $obj->o_emergency_num,
				'n_emergency_num'    => $obj->n_emergency_num,
				'o_rel'              => $obj->o_rel,
				'n_rel'              => $obj->n_rel,
				'o_marital_stat'     => $obj->o_marital_stat,
				'n_marital_stat'     => $obj->n_marital_stat,
			];

			Mail::to("hrd@elink.com.ph")->queue(new ApproveInformation($obj_det));
		}

		return $info;
	}

	public function uploadInfo()
	{
		return view('employee.upload_info');
	}

	public function viewRecord($id)
	{
		$obj =DB::table('employee_info')->leftJoin('employee_info_details','employee_info.id','=','employee_info_details.employee_id')->get();

		return json_encode(['obj' => $obj]);
	}

	public function formAvega()
	{
		return view('employee.upload_avega');
	}

	public function processAvega(Request $req)
	{
		$file = [];
		$file['Original Filename'] = $req->file('dump_file')->getClientOriginalName();
		$path = str_replace("public","",$_SERVER['DOCUMENT_ROOT']);
		$file['path'] = $req->file('dump_file')->storeAs('/media/uploads/xls', $file['Original Filename']);

		$spreadsheet =IOFactory::load($path.'/storage/app/'.$file['path']);
		$worksheet = $spreadsheet->getSheet(0);

		$list = [];
		$i = 1;
		foreach($worksheet->getRowIterator() as $row) {
			if($i > 1) {
				$cellIterator = $row->getCellIterator();
				$cellIterator->setIterateOnlyExistingCells(FALSE);
				$ctr = 1;
				foreach($cellIterator as $col) {
					if($ctr == 1) {
						$eid =  trim($col->getFormattedValue());
						$obj = DB::select("select id from employee_info where eid = '$eid' limit 1");
						$id = count($obj) > 0 ? $obj[0]->id : 0;
					}

					if($ctr == 2) {
						$account = trim($col->getFormattedValue());
					}

					if($ctr == 3) {
						$last = trim($col->getFormattedValue());
					}

					if( $ctr == 4 ) {
						$first = trim($col->getFormattedValue());
						$name = $first." ".$last;
						$row = [
						'id'            => $id,
						'eid'           => $eid,
						'account'       => $account,
						'name'          => $name,
						'update_status' => 0
						];
						array_push($list,$row);
						if($row['eid'] && $row['account'] && $id) {
							$row['update_status'] = DB::update("update employee_info_details set avega_num = '$account' where employee_id = $id limit 1");
						}
					}
				$ctr++;
				}
			}
		$i++;
		}

		return ['FILE' => $file, 'LIST' => $list];
	}

	public function processUploadInfo(Request $req)
	{
		$file = [];
		$file['Original Filename'] = $req->file('dump_file')->getClientOriginalName();
		$path = str_replace("public","",$_SERVER['DOCUMENT_ROOT']);
		$file['path'] = $req->file('dump_file')->storeAs('/media/uploads/xls', $file['Original Filename']);

		$spreadsheet =IOFactory::load($path.'/storage/app/'.$file['path']);
		$worksheet = $spreadsheet->getSheet(0);

		$list = [];
		$i = 1;
		foreach($worksheet->getRowIterator() as $row) {
			if($i > 1) {
				$cellIterator = $row->getCellIterator();
				$cellIterator->setIterateOnlyExistingCells(FALSE);
				$ctr = 1;
				$row = [
					'flag'          => 0,
					'id'            => 0, 
					'status'        => '', 
					'last_name'     => '', 
					'first_name'    => '', 
					'middle_name'   => '', 
					'department'    => '', 
					'dept_code'     => '',
					'position'      => '',
					'supervisor'    => '',
					'sup_name'      => '',
					'manager'       => '',
					'mngr_name'     => '',
					'email'         => '',
					'start_date'    => '',
					'prod_date'     => '',
					'reg_date'      => '',
					'employee_type' => 0,
					'employee_cat'  => 0,
					'account'       => 0,
					'address'       => '',
					'mobile'        => '',
					'email2'        => '',
					'sex'           => 0,
					'civil_status'  => 0,
					'birthday'      => '',
					'home_address'  => '',
					'emergency_con' => '',
					'relationship'  => '',
					'emergency_rel' => '',
					'emer_contact'  => '',
					'sss'           => '',
					'phic'          => '',
					'hdmf'          => '',
					'tin'           => '',
					'main'          => [],
					'details'       => [],
					'stat_main'     => 0,
					'stat_details'  => 0,
					'obj'           => [],
				];

				$found = 0;
				foreach($cellIterator as $col) {
					if($ctr == 1) {
						$row['id'] = trim($col->getFormattedValue());
						$eid = $row['id']; 
						$obj = DB::select("select * from employee_info where eid = '$eid' and status = 1 and deleted_at is null");
						if(count($obj) > 0){
							$row['obj'] = $obj[0];
							$found = 1;
						}
					}

					if($found > 0) {
						$value = trim($col->getFormattedValue());
						if($ctr == 3) {
							$row['last_name']       = $value;
						} else if($ctr ==4) {
							$row['first_name']      = $value;
						} else if($ctr == 5) {
							$row['middle_name']     = $value;
						} else if($ctr == 7) {
							$row['department']      = $value;
						} else if($ctr == 8) {
							$row['dept_code']       = $value;
						} else if($ctr == 9) {
							$row['position']        = $value;
						} else if($ctr == 10) {
							$row['supervisor']      = $value;
							$sup = DB::select("SELECT concat(first_name,' ',last_name) as head_name FROM `employee_info` where id = $value limit 1;");
							if(count($sup) > 0) {
								$row['sup_name'] = $sup[0]->head_name;
							}
						} else if($ctr == 11) {
							$row['manager']         = $value;
							$sup = DB::select("SELECT concat(first_name,' ',last_name) as head_name FROM `employee_info` where id = $value limit 1;");
							if(count($sup) > 0) {
								$row['mngr_name'] = $sup[0]->head_name;
							}
						} else if($ctr == 12) {
							$row['email']           = $value;
						} else if($ctr == 13) {
							$row['start_date']      = date("Y-m-d", strtotime($value));
						} else if($ctr == 14) {
							$row['prod_date']       = date("Y-m-d", strtotime($value));
						} else if($ctr == 15) {
							$row['reg_date']        = date("Y-m-d", strtotime($value));
						} else if($ctr == 16) {
							$row['employee_type']   = $value;
						} else if($ctr == 17) {
							$row['employee_cat']    = $value;
						} else if($ctr == 18) {
							$row['account']         = $value;
						} else if($ctr == 19) {
							$row['address']         = $value;
						} else if($ctr == 20) {
							$row['mobile']          = $value;
						} else if($ctr == 21) {
							$row['email2']          = $value;
						} else if($ctr == 22) {
							$row['sex']             = $value;
						} else if($ctr == 23) {
							$row['civil_status']    = $value;
						} else if($ctr == 24) {
							$row['birthday']        = date("Y-m-d", strtotime($value));
						} else if($ctr == 25) {
							$row['home_address']    = $value;
						} else if($ctr == 26) {
							$row['emergency_con']   = $value;
						} else if($ctr == 27) {
							$row['relationship']    = $value;
						} else if($ctr == 28) {
							$row['emer_contact']    = $value;
						} else if($ctr == 31) {
							$row['sss']             = $value;
						} else if($ctr == 32) {
							$row['phic']            = $value;
						} else if($ctr == 33) {
							$row['hdmf']            = $value;
						} else if($ctr == 34) {
							$row['tin']             = $value;
							$row['flag']            = 1;
							$main = [
								'first_name'            => $row['first_name'] ? $row['first_name'] : $row['obj']->first_name,
								'middle_name'           => $row['middle_name'] ? $row['middle_name'] : $row['obj']->middle_name,
								'last_name'             => $row['last_name'] ? $row['last_name'] : $row['obj']->last_name,
								'email'                 => $row['email'] ? $row['email'] : $row['obj']->email,
								'email2'                => $row['email2'] ? $row['email2'] : $row['obj']->email2,
								'dept_code'             => $row['dept_code'] ? $row['dept_code'] : $row['obj']->dept_code,
								'position_name'         => $row['position'] ? $row['position'] : $row['obj']->position_name,
								'supervisor_id'         => $row['supervisor'] ? $row['supervisor'] : $row['obj']->supervisor_id,
								'supervisor_name'       => $row['sup_name'] ? $row['sup_name'] : $row['obj']->supervisor_name,
								'birth_date'            => $row['birthday'] ? $row['birthday'] : $row['obj']->birth_date,
								'hired_date'            => $row['start_date'] ? $row['start_date'] : $row['obj']->hired_date,
								'prod_date'             => $row['prod_date'] ? $row['prod_date'] : $row['obj']->prod_date,
								'regularization_date'   => $row['reg_date'] ? $row['reg_date'] : $row['obj']->regularization_date,
								'gender'                => $row['sex'] ? $row['sex'] : $row['obj']->gender,
								'civil_status'          => $row['civil_status'] ? $row['civil_status'] : $row['obj']->civil_status,
								'manager_id'            => $row['manager'] ? $row['manager'] : $row['obj']->manager_id,
								'manager_name'          => $row['mngr_name'] ? $row['mngr_name'] : $row['obj']->manager_name, 
								'account_id'            => $row['account'] ? $row['account'] : $row['obj']->account_id,
								'sss'                   => $row['sss'] ? $row['sss'] : $row['obj']->sss,
								'pagibig'               => $row['hdmf'] ? $row['hdmf'] : $row['obj']->pagibig,
								'philhealth'            => $row['phic'] ? $row['phic'] : $row['obj']->philhealth,
								'tin'                   => $row['tin'] ? $row['tin'] : $row['obj']->tin,
								'address'               => $row['address'] ? $row['address'] : $row['obj']->address,
								'contact_number'        => $row['mobile'] ? $row['mobile'] : $row['obj']->contact_number,
								'is_regular'            => $row['employee_type'] ? $row['employee_type'] : $row['obj']->is_regular,
								'employee_category'     => $row['employee_cat'] ? $row['employee_cat'] : $row['obj']->employee_category
							];

							$row['main']                = $main;
							$row['stat_main']           = User::where('id',$row['obj']->id)->update($main);
							$obj_det = EmployeeInfoDetails::where('employee_id',$row['obj']->id)->get();

							if(count($obj_det) > 0) {
								$det = $obj_det[0];
								$details = [
									'town_address'      => $row['home_address'] ? $row['home_address'] : $det->town_address,
									'em_con_name'       => $row['emergency_con'] ? $row['emergency_con'] : $det->em_con_name,
									'em_con_num'        => $row['emer_contact'] ? $row['emer_contact'] : $det->em_con_num,
									'em_con_rel'        => $row['relationship'] ? $row['relationship'] : $det->em_con_rel
								];
								$row['details']         = $details;
								$row['stat_details']    = EmployeeInfoDetails::where('employee_id',$row['obj']->id)->update($details);
							}

							array_push($list,$row);
						}
					}
				$ctr++;
				}
			}
		$i++;
		}

		return json_encode($list);
	}
}
