<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Routing\Redirector;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\User;
use App\LinkingMaster;
use App\LinkingTypes;
use App\LinkingFocus;
use App\QuickLink;
use App\CementingExpectations;
use App\AccountabilitySession;
use App\SkillsDevelopment;
use App\SkillBuilding;
use App\GoalSetting;
use App\GettingToKnowYou;
use App\Mail\QuickLinkNotification;
use App\Mail\CEMailNotification;
use App\Mail\SDAMailNotification;
use App\Mail\PendingLIMailNotification;
use App\Mail\ACCMailNotification;
use App\Mail\SkillBuildingNotification;
use App\Mail\GTKYMailNotification;
use App\Mail\GoalSettingNotification;

class CoachingController extends Controller
{

    private $active_user;

    public function mainCoaching(Request $req)
    {
        if($req->post("lnk_type") && $req->post("lnk_linkee")) {
            return $this->processLinking($req);
        } else {
            if($this->isManagement()) {
                return $this->viewManagement();
            } else {
                return $this->viewStaff();
            }
        }
    }

    /* Management Pending */
    public function forAcknowledgement()
    {
        $data['pending'] = LinkingMaster::getPending(Auth::user()->id);
        $data['management'] = $this->isManagement();
        $data['pending_menu'] = 1;

        return view("coaching.pending", $data);
    }
    /* End Management Pending */

    public function thisLink()
    {
        if($this->isManagement()) {
            $data['my_links'] = LinkingMaster::getPersonal($this->getActiveUser());
            $data['management'] = $this->isManagement();
            $data['personal'] = 1;

            return view("coaching.own_linking", $data);
        }

        return "No access for thisLink()";
    }

    public function downloadLinking()
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
        $sheet->getStyle('A1:I1')->applyFromArray($styleArray);
        $sheet->getStyle('A1:I1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $sheet->getColumnDimension('A')->setWidth('20');
        $sheet->getColumnDimension('B')->setWidth('30');
        $sheet->getColumnDimension('C')->setWidth('30');
        $sheet->getColumnDimension('D')->setWidth('25');
        $sheet->getColumnDimension('E')->setWidth('25');
        $sheet->getColumnDimension('F')->setWidth('30');
        $sheet->getColumnDimension('G')->setWidth('100');
        $sheet->getColumnDimension('H')->setWidth('20');
        $sheet->getColumnDimension('I')->setWidth('40');
        $i = 1;
        $header = array("Date", "Employee Number", "Linkee","Linking Type","Linker","Focus", "Comments","Status","Link");
        $sheet->fromArray([$header], NULL, 'A'.$i);
        $list = LinkingMaster::getReport($this->getActiveUser());
        if(Auth::user()->isAdmin()) {
            $list = LinkingMaster::getReport();
        }

        $i++;
        foreach($list as $lk) {
            $body = [
                date("F d, Y", strtotime($lk->lnk_date)),
                $lk->linkee_number,
                $lk->linkee,
                $lk->lt_desc,
                $lk->linker,
                $lk->focus,
                $lk->comments,
                $lk->status,
                $lk->link
            ];
            $sheet->fromArray([$body], NULL, 'A'.$i); 
            $sheet->setCellValue("I{$i}", $lk->link);
            $sheet->getStyle("G{$i}")->getAlignment()->setWrapText(true);
            $sheet->getStyle("A{$i}:I{$i}")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $i++;
        }

        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="linking-report-'.date('mdY-His').'.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->setPreCalculateFormulas(false);
        $writer->setOffice2003Compatibility(true);
        $writer->save('php://output');
    }

    /* Quick Links */
        public function addQL(Request $req)
        {
            $emp_name = strtoupper($req->post("lnk_linkee_name"));
            $data['emp_name'] = $emp_name;
            $data['leaders_name'] = Auth::user()->first_name." ".Auth::user()->last_name;

            $lm = new LinkingMaster();
            $lm->lnk_date = date("Y-m-d", strtotime($req->post("lnk_date")));
            $lm->lnk_linker = Auth::user()->id;
            $lm->lnk_linkee = $req->post("lnk_linkee");
            $lm->lnk_type = 1;
            $lm->lnk_acknw = 0;
            $lm->save();

            $ql = new QuickLink();
            $ql->rf_lnk_id = $lm->lnk_id;
            $ql->rf_focus = $req->post("rf_focus");
            $ql->rf_comments = $req->post("rf_comments");
            $ql->save();

            $data['id'] = $lm->lnk_id;

            // Mail::to($req->post("lnk_linkee_email"))->send(new QuickLinkNotification($data));

            return redirect(url('linkee-pending'))->with('success', "Quick Link Session for {$emp_name} Successfully Sent!!");
        }

        public function editQL($id)
        {
            $ql = QuickLink::getSession($id);
            if(empty($ql)) {
                return redirect(url('404'));
            }

            $data['obj'] = $ql;
            $data['management'] = $this->isManagement();
            $data['sel_focus'] = LinkingFocus::where('fc_status', 1)->orderBy('fc_id')->get();
            $data['pending_menu'] = 1;
            $data['history'] = QuickLink::getQL($ql->lnk_linkee, 0, 1);
            $data['linker'] = User::find($ql->lnk_linker);
            $data['linkee'] = User::withTrashed()->find($ql->lnk_linkee);

            return view('coaching.ql_edit', $data);
        }

        public function updateQL(Request $req)
        {
            $ql = QuickLink::where('rf_lnk_id', $req->rf_lnk_id)->first();
            $ql->rf_focus = $req->post("rf_focus");
            $ql->rf_comments = $req->post("rf_comments");
            $ql->save();

            return back()->with('success', "Session Updated!!");
        }

        public function acknowledgeQL($id)
        {
            $ql = QuickLink::getSession($id);
            if(empty($ql)) {
                return redirect(url('404'));
            }

            $data['obj'] = $ql;
            $data['management'] = $this->isManagement();
            $data['pending_menu'] = 1;
            $data['linker'] = User::find($ql->lnk_linker);
            $data['linkee'] = User::withTrashed()->find($ql->lnk_linkee);

            return view('coaching.ql_acknowledge', $data);
        }

        public function acknowledgedQL(Request $req)
        {
            $lm = LinkingMaster::find($req->rf_lnk_id);
            $lm->lnk_acknw = 1;
            $lm->save();

            $ql = QuickLink::where('rf_lnk_id', $req->rf_lnk_id)->first();
            $ql->rf_feedback = $req->post("rf_feedback");
            $ql->save();

            return redirect(url('quick-link-list'))->with('success', "Session Acknowledged!!");
        }

        public function listQLs()
        {
            $data['linking'] = QuickLink::getQL($this->getActiveUser(), $this->isManagement());
            $data['management'] = ($this->isManagement()) ? 1 : 0;
            $data['label'] = ($this->isManagement()) ? 'Linkee' : 'Linker';
            $data['ql'] = 1;

            return view('coaching.ql_list', $data);
        }

        public function viewQL($id)
        {
            $ql = QuickLink::getSession($id);
            if(empty($ql)) {
                return redirect(url('404'));
            }

            $data['obj'] = $ql;
            $data['management'] = $this->isManagement();
            $data['ql'] = 1;
            $data['linker'] = User::withTrashed()->find($ql->lnk_linker);
            $data['linkee'] = User::withTrashed()->find($ql->lnk_linkee);

            return view('coaching.ql_view', $data);
        }
    /* End Quick Links */

    /* Cementing Expectations */
        public function addCE(Request $req)
        {
            $emp_name = strtoupper($req->post("lnk_linkee_name"));
            $data['emp_name'] = $emp_name;
            $data['leaders_name'] = Auth::user()->first_name." ".Auth::user()->last_name;

            $lm = new LinkingMaster();
            $lm->lnk_date = date("Y-m-d", strtotime($req->post("lnk_date")));
            $lm->lnk_linker = Auth::user()->id;
            $lm->lnk_linkee = $req->post("lnk_linkee");
            $lm->lnk_type = 2;
            $lm->lnk_acknw = 0;
            $lm->save();

            $cm = new CementingExpectations();
            $cm->se_com_id = sha1($lm->lnk_id);
            $cm->se_link_id = $lm->lnk_id;
            $cm->se_focus = $req->post("se_focus");
            $cm->se_skill = $req->post("se_skill");
            $cm->se_when_use = $req->post("se_when_use");
            $cm->se_how_use = $req->post("se_how_use");
            $cm->se_why_use = $req->post("se_why_use");
            $cm->se_expectations = $req->post("se_expectations");
            $cm->se_timeframe = "N\A";
            $cm->se_comments = $req->post("se_comments");
            $cm->save();

            $data['id'] = sha1($lm->lnk_id);

            // Mail::to($req->post("lnk_linkee_email"))->send(new CEMailNotification($data));

            return redirect(url('linkee-pending'))->with('success', "Cementing Expectations Session for {$emp_name} Successfully Sent!!");
        }

        public function editCE($id)
        {
            $ce = CementingExpectations::getSession($id);
            if(empty($ce)) {
                return redirect(url('404'));
            }

            $data['obj'] = $ce;
            $data['management'] = $this->isManagement();
            $data['sel_focus'] = LinkingFocus::where('fc_status', 1)->orderBy('fc_id')->get();
            $data['pending_menu'] = 1;
            $data['history'] = CementingExpectations::getCE($ce->lnk_linkee, 0, 1);
            $data['linker'] = User::find($ce->lnk_linker);
            $data['linkee'] = User::withTrashed()->find($ce->lnk_linkee);

            return view('coaching.ce_edit', $data);
        }

        public function updateCE(Request $req)
        {
            $ce = CementingExpectations::where('se_com_id', $req->se_com_id)->first();
            $ce->se_focus = $req->post("se_focus");
            $ce->se_skill = $req->post("se_skill");
            $ce->se_when_use = $req->post("se_when_use");
            $ce->se_how_use = $req->post("se_how_use");
            $ce->se_why_use = $req->post("se_why_use");
            $ce->se_expectations = $req->post("se_expectations");
            $ce->se_comments = $req->post("se_comments");
            $ce->save();

            return back()->with('success', "Session Updated!!");
        }

        public function acknowledgeCE($id)
        {
            $ce = CementingExpectations::getSession($id);
            if(empty($ce)) {
                return redirect(url('404'));
            }

            $data['obj'] = $ce;
            $data['management'] = $this->isManagement();
            $data['pending_menu'] = 1;
            $data['linker'] = User::withTrashed()->find($ce->lnk_linker);
            $data['linkee'] = User::withTrashed()->find($ce->lnk_linkee);

            return view('coaching.ce_acknowledge', $data);
        }

        public function acknowledgedCE(Request $req)
        {
            $lm = LinkingMaster::find($req->se_link_id);
            $lm->lnk_acknw = 1;
            $lm->save();

            $ql = CementingExpectations::where('se_com_id', $req->se_com_id)->first();
            $ql->se_feedback = $req->post("se_feedback");
            $ql->save();

            return redirect(url('ce-expectation-list'))->with('success', "Session Acknowledged!!");
        }

        public function listCEs()
        {
            $data['linking'] = CementingExpectations::getCE($this->getActiveUser(), $this->isManagement());
            $data['management'] = ($this->isManagement()) ? 1 : 0;
            $data['label'] = ($this->isManagement()) ? 'Linkee' : 'Linker';
            $data['ce'] = 1;

            return view('coaching.ce_list', $data);
        }

        public function viewCE($id)
        {
            $ce = CementingExpectations::getSession($id);
            if(empty($ce)) {
                return redirect(url('404'));
            }

            $data['obj'] = $ce;
            $data['linker'] = User::withTrashed()->find($ce->lnk_linker);
            $data['linkee'] = User::withTrashed()->find($ce->lnk_linkee);
            $data['management'] = $this->isManagement();
            $data['ce'] = 1;

            return view('coaching.ce_view', $data);
        }
    /* End Cementing Expectations */

    /* Accountability Setting */
        public function addAS(Request $req)
        {
            $emp_name = strtoupper($req->post("lnk_linkee_name"));
            $data['emp_name'] = $emp_name;
            $data['leaders_name'] = Auth::user()->first_name." ".Auth::user()->last_name;

            $lm = new LinkingMaster();
            $lm->lnk_date = date("Y-m-d", strtotime($req->post("lnk_date")));
            $lm->lnk_linker = Auth::user()->id;
            $lm->lnk_linkee = $req->post("lnk_linkee");
            $lm->lnk_type = 3;
            $lm->lnk_acknw = 0;
            $lm->save();

            $acc = new AccountabilitySession();
            $acc->ac_link_id = $lm->lnk_id;
            $acc->ac_com_id = sha1($lm->lnk_id);
            $acc->ac_focus = $req->post("ac_focus");
            $acc->ac_skill = $req->post("ac_skill");
            $acc->ac_when_use = $req->post("ac_when_use");
            $acc->ac_why_use = $req->post("ac_why_use");
            $acc->ac_how_use = $req->post("ac_how_use");
            $acc->ac_expectations = $req->post("ac_expectations");
            $acc->ac_expectation_date = date("Y-m-d", strtotime($req->post("ac_expectation_date")));
            $acc->ac_comments = $req->post("ac_comments");
            $acc->save();

            $data['id'] = sha1($lm->lnk_id);

            // Mail::to($req->post("lnk_linkee_email"))->send(new ACCMailNotification($data));

            return redirect(url('linkee-pending'))->with('success', "Accountability Setting Session for {$emp_name} Successfully Sent!!");
        }

        public function editAS($id)
        {
            $as = AccountabilitySession::getSession($id);
            if(empty($as)) {
                return redirect(url('404'));
            }

            $data['obj'] = $as;
            $data['management'] = $this->isManagement();
            $data['sel_focus'] = LinkingFocus::where('fc_status', 1)->orderBy('fc_id')->get();
            $data['pending_menu'] = 1;
            $data['history'] = AccountabilitySession::getAS($as->lnk_linkee, 0, 1);
            $data['linker'] = User::find($as->lnk_linker);
            $data['linkee'] = User::withTrashed()->find($as->lnk_linkee);

            return view('coaching.as_edit', $data);
        }

        public function updateAS(Request $req)
        {
            $ql = AccountabilitySession::where('ac_com_id', $req->ac_com_id)->first();
            $ql->ac_focus = $req->post("ac_focus");
            $ql->ac_skill = $req->post("ac_skill");
            $ql->ac_when_use = $req->post("ac_when_use");
            $ql->ac_how_use = $req->post("ac_how_use");
            $ql->ac_why_use = $req->post("ac_why_use");
            $ql->ac_expectations = $req->post("ac_expectations");
            $ql->ac_expectation_date = date('Y-m-d', strtotime($req->post("ac_expectation_date")));
            $ql->ac_comments = $req->post("ac_comments");
            $ql->save();

            return back()->with('success', "Session Updated!!");
        }

        public function acknowledgeAS($id)
        {
            $as = AccountabilitySession::getSession($id);
            if(empty($as)) {
                return redirect(url('404'));
            }

            $data['obj'] = $as;
            $data['management'] = $this->isManagement();
            $data['pending_menu'] = 1;
            $data['linker'] = User::withTrashed()->find($as->lnk_linker);
            $data['linkee'] = User::withTrashed()->find($as->lnk_linkee);

            return view('coaching.as_acknowledge', $data);
        }

        public function acknowledgedAS(Request $req)
        {
            $lm = LinkingMaster::find($req->ac_link_id);
            $lm->lnk_acknw = 1;
            $lm->save();

            $ql = AccountabilitySession::where('ac_link_id', $req->ac_link_id)->first();
            $ql->ac_feedback = $req->post("ac_feedback");
            $ql->save();

            return redirect(url('acc-set-list'))->with('success', "Session Acknowledged!!");
        }

        public function listASs()
        {
            $data['linking'] = AccountabilitySession::getAS($this->getActiveUser(), $this->isManagement());
            $data['management'] = ($this->isManagement()) ? 1 : 0;
            $data['label'] = ($this->isManagement()) ? 'Linkee' : 'Linker';
            $data['as'] = 1;

            return view('coaching.as_list', $data);
        }

        public function viewAS(Request $req, $id)
        {
            $as = AccountabilitySession::getSession($id);
            if(empty($as)) {
                return redirect(url('404'));
            }

            $data['obj'] = $as;
            $data['linker'] = User::withTrashed()->find($as->lnk_linker);
            $data['linkee'] = User::withTrashed()->find($as->lnk_linkee);
            $data['management'] = $this->isManagement();
            $data['as'] = 1;

            return view('coaching.as_view', $data);
        }
    /* End Accountability Setting */

    /* Skill Development Expectations */
        public function addSDA(Request $req)
        {
            $emp_name = strtoupper($req->post("lnk_linkee_name"));
            $data['emp_name'] = $emp_name;
            $data['leaders_name'] = Auth::user()->first_name." ".Auth::user()->last_name;

            $lm = new LinkingMaster();
            $lm->lnk_date = date("Y-m-d", strtotime($req->post("lnk_date")));
            $lm->lnk_linker = Auth::user()->id;
            $lm->lnk_linkee = $req->post("lnk_linkee");
            $lm->lnk_type = 4;
            $lm->lnk_acknw = 0;
            $lm->save();

            $sda = new SkillsDevelopment();
            $sda->sda_lnk_id      = $lm->lnk_id;
            $sda->sda_com_id      = sha1($lm->lnk_id);
            $sda->sda_type        = $req->post("sda_type");
            $sda->sda_date_call   = date("Y-m-d", strtotime($req->post("sda_date_call")));
            $sda->sda_call_sel    = $req->post("sda_call_sel");
            $sda->sda_www_u_said  = $req->post("sda_www_u_said");
            $sda->sda_www_i_said  = $req->post("sda_www_i_said");
            $sda->sda_wcm_u_said  = $req->post("sda_wcm_u_said");
            $sda->sda_wcm_i_said  = $req->post("sda_wcm_i_said");
            $sda->sda_comments    = $req->post("sda_comments");
            $sda->save();

            $data['id'] = sha1($lm->lnk_id);

            // Mail::to($req->post("lnk_linkee_email"))->send(new SDAMailNotification($data));

            return redirect(url('linkee-pending'))->with('success', "Skill Development Activities Session for {$emp_name} Successfully Sent!!");
        }

        public function editSDA($id)
        {
            $sda = SkillsDevelopment::getSession($id);
            if(empty($sda)) {
                return redirect(url('404'));
            }

            $data['obj'] = $sda;
            $data['management'] = $this->isManagement();
            $data['pending_menu'] = 1;
            $data['history'] = SkillsDevelopment::getSDA($sda->lnk_linkee, 0, 1);
            $data['linker'] = User::find($sda->lnk_linker);
            $data['linkee'] = User::withTrashed()->find($sda->lnk_linkee);

            return view('coaching.sda_edit', $data);
        }

        public function updateSDA(Request $req)
        {
            $ql = SkillsDevelopment::where('sda_com_id', $req->sda_com_id)->first();
            $ql->sda_type = $req->post("sda_type");
            $ql->sda_date_call = date('Y-m-d', strtotime($req->post("sda_date_call")));
            $ql->sda_call_sel = $req->post("sda_call_sel");
            $ql->sda_www_u_said = $req->post("sda_www_u_said");
            $ql->sda_www_i_said = $req->post("sda_www_i_said");
            $ql->sda_wcm_u_said = $req->post("sda_wcm_u_said");
            $ql->sda_wcm_i_said = $req->post("sda_wcm_i_said");
            $ql->sda_comments = $req->post("sda_comments");
            $ql->save();

            return back()->with('success', "Session Updated!!");
        }

        public function acknowledgeSDA($id)
        {
            $sda = SkillsDevelopment::getSession($id);
            if(empty($sda)) {
                return redirect(url('404'));
            }

            $data['obj'] = $sda;
            $data['management'] = $this->isManagement();
            $data['pending_menu'] = 1;
            $data['linker'] = User::withTrashed()->find($sda->lnk_linker);
            $data['linkee'] = User::withTrashed()->find($sda->lnk_linkee);

            return view('coaching.sda_acknowledge', $data);
        }

        public function acknowledgedSDA(Request $req)
        {
            $lm = LinkingMaster::find($req->sda_lnk_id);
            $lm->lnk_acknw = 1;
            $lm->save();

            $ql = SkillsDevelopment::where('sda_com_id', $req->sda_com_id)->first();
            $ql->sda_feedback = $req->post("sda_feedback");
            $ql->save();

            return redirect(url('skill-dev-act-list'))->with('success', "Session Acknowledged!!");
        }

        public function listSDAs()
        {
            $data['linking'] = SkillsDevelopment::getSDA($this->getActiveUser(), $this->isManagement());
            $data['management'] = ($this->isManagement()) ? 1 : 0;
            $data['label'] = ($this->isManagement()) ? 'Linkee' : 'Linker';
            $data['sda'] = 1;

            return view('coaching.sda_list', $data);
        }

        public function viewSDA(Request $req, $id)
        {
            $sda = SkillsDevelopment::getSession($id);
            if(empty($sda)) {
                return redirect(url('404'));
            }

            $data['obj'] = $sda;
            $data['linker'] = User::withTrashed()->find($sda->lnk_linker);
            $data['linkee'] = User::withTrashed()->find($sda->lnk_linkee);
            $data['management'] = $this->isManagement();
            $data['sda'] = 1;

            return view('coaching.sda_view', $data);
        }
    /* End Skill Development Expectations */

    /* Getting To Know You */
        public function addGTKY(Request $req)
        {
            $email = $req->post("lnk_linkee_email");
            $emp_name = strtoupper($req->post("lnk_linkee_name"));
            $data['emp_name'] = $emp_name;
            $data['leaders_name'] = Auth::user()->first_name." ".Auth::user()->last_name;

            $lm = new LinkingMaster();
            $lm->lnk_date = date("Y-m-d", strtotime($req->post("lnk_date")));
            $lm->lnk_linker = Auth::user()->id;
            $lm->lnk_linkee = $req->post("lnk_linkee");
            $lm->lnk_type = 5;
            $lm->lnk_acknw = 0;
            $lm->save();

            $gtky = new GettingToKnowYou();
            $gtky->gtk_link_id = $lm->lnk_id;
            $gtky->gtk_com_num = sha1($lm->lnk_id);
            $gtky->gtk_address = $req->post("gtk_address");
            $gtky->gtk_bday = date("Y-m-d", strtotime($req->post("gtk_bday")));
            $gtky->gtk_bplace = $req->post("gtk_bplace");
            $gtky->gtk_mobile = $req->post("gtk_mobile");
            $gtky->gtk_email = $req->post("gtk_email");
            $gtky->gtk_civil_stat = $req->post("gtk_civil_stat");
            $gtky->gtk_fav_thing = $req->post("gtk_fav_thing");
            $gtky->gtk_fav_color = $req->post("gtk_fav_color");
            $gtky->gtk_fav_movie = $req->post("gtk_fav_movie");
            $gtky->gtk_fav_song = $req->post("gtk_fav_song");
            $gtky->gtk_fav_food = $req->post("gtk_fav_food");
            $gtky->gtk_allergic_food = $req->post("gtk_allergic_food");
            $gtky->gtk_allergic_med = $req->post("gtk_allergic_med");
            $gtky->gtk_learn_style = $req->post("gtk_learn_style");
            $gtky->gtk_social_style = $req->post("gtk_social_style");
            $gtky->gtk_motivation = $req->post("gtk_motivation");
            $gtky->gtk_how_coached = $req->post("gtk_how_coached");
            $gtky->gtk_strength = $req->post("gtk_strength");
            $gtky->gtk_improvement = $req->post("gtk_improvement");
            $gtky->gtk_goals = $req->post("gtk_goals");
            $gtky->gtk_others = '';
            $gtky->save();

            $data['id'] = sha1($lm->lnk_id);

            // Mail::to($req->post("lnk_linkee_email"))->send(new GTKYMailNotification($data));

            return redirect(url('linkee-pending'))->with('success', "Getting To Know You Session for {$emp_name} Successfully Sent!!");
        }

        public function editGTKY($id)
        {
            $gtky = GettingToKnowYou::getSession($id);
            if(empty($gtky)) {
                return redirect(url('404'));
            }

            $data['obj'] = $gtky;
            $data['management'] = $this->isManagement();
            $data['pending_menu'] = 1;
            $data['history'] = GettingToKnowYou::getGTKY($gtky->lnk_linkee, 0, 1);
            $data['linker'] = User::find($gtky->lnk_linker);
            $data['linkee'] = User::withTrashed()->find($gtky->lnk_linkee);

            return view('coaching.gtky_edit', $data);
        }

        public function updateGTKY(Request $req)
        {
            $gtky = GettingToKnowYou::where('gtk_com_num', $req->post("gtk_com_num"))->first();
            $gtky->gtk_address = $req->post("gtk_address");
            $gtky->gtk_bday = date("Y-m-d", strtotime($req->post("gtk_bday")));
            $gtky->gtk_bplace = $req->post("gtk_bplace");
            $gtky->gtk_mobile = $req->post("gtk_mobile");
            $gtky->gtk_email = $req->post("gtk_email");
            $gtky->gtk_civil_stat = $req->post("gtk_civil_stat");
            $gtky->gtk_fav_thing = $req->post("gtk_fav_thing");
            $gtky->gtk_fav_color = $req->post("gtk_fav_color");
            $gtky->gtk_fav_movie = $req->post("gtk_fav_movie");
            $gtky->gtk_fav_song = $req->post("gtk_fav_song");
            $gtky->gtk_fav_food = $req->post("gtk_fav_food");
            $gtky->gtk_allergic_food = $req->post("gtk_allergic_food");
            $gtky->gtk_allergic_med = $req->post("gtk_allergic_med");
            $gtky->gtk_learn_style = $req->post("gtk_learn_style");
            $gtky->gtk_social_style = $req->post("gtk_social_style");
            $gtky->gtk_motivation = $req->post("gtk_motivation");
            $gtky->gtk_how_coached = $req->post("gtk_how_coached");
            $gtky->gtk_strength = $req->post("gtk_strength");
            $gtky->gtk_improvement = $req->post("gtk_improvement");
            $gtky->gtk_goals = $req->post("gtk_goals");
            $gtky->gtk_others = '';
            $gtky->save();

            return back()->with('success', "Session Updated!!");
        }

        public function acknowledgeGTKY($id)
        {
            $gtky = GettingToKnowYou::getSession($id);
            if(empty($gtky)) {
                return redirect(url('404'));
            }

            $data['obj'] = $gtky;
            $data['management'] = $this->isManagement();
            $data['pending_menu'] = 1;
            $data['linker'] = User::withTrashed()->find($gtky->lnk_linker);
            $data['linkee'] = User::withTrashed()->find($gtky->lnk_linkee);

            return view('coaching.gtky_acknowledge', $data);
        }

        public function acknowledgedGTKY(Request $req)
        {
            $lm = LinkingMaster::find($req->gtk_link_id);
            $lm->lnk_acknw = 1;
            $lm->save();

            $ql = GettingToKnowYou::where('gtk_com_num', $req->gtk_com_num)->first();
            $ql->gtk_others = $req->post("gtk_others");
            $ql->save();

            return redirect(url('gtky-list'))->with('success', "Session Acknowledged!!");
        }

        public function listGTKYs()
        {
            $data['linking'] = GettingToKnowYou::getGTKY($this->getActiveUser(), $this->isManagement());
            $data['management'] = ($this->isManagement()) ? 1 : 0;
            $data['label'] = ($this->isManagement()) ? 'Linkee' : 'Linker';
            $data['gtky'] = 1;

            return view('coaching.gtky_list', $data);
        }

        public function viewGTKY(Request $req,$id)
        {
            $gtky = GettingToKnowYou::getSession($id);
            if(empty($gtky)) {
                return redirect(url('404'));
            }

            $data['obj'] = $gtky;
            $data['linker'] = User::withTrashed()->find($gtky->lnk_linker);
            $data['linkee'] = User::withTrashed()->find($gtky->lnk_linkee);
            $data['management'] = $this->isManagement();
            $data['gtky'] = 1;

            return view('coaching.gtky_view', $data);
        }
    /* End Getting To Know You */

    /* Skill Building */
        public function addSB(Request $req)
        {
            $emp_name = strtoupper($req->post("lnk_linkee_name"));
            $data['emp_name'] = $emp_name;
            $data['leaders_name'] = Auth::user()->first_name." ".Auth::user()->last_name;

            $lm = new LinkingMaster();
            $lm->lnk_date = date("Y-m-d", strtotime($req->post("lnk_date")));
            $lm->lnk_linker = Auth::user()->id;
            $lm->lnk_linkee = $req->post("lnk_linkee");
            $lm->lnk_type = 6;
            $lm->lnk_acknw = 0;
            $lm->save();

            $sb = new SkillBuilding();
            $sb->sb_link_id = $lm->lnk_id;
            $sb->sb_com_num = sha1($lm->lnk_id);
            $sb->sb_focus = $req->post("sb_focus");
            $sb->sb_skill = $req->post("sb_skill");
            $sb->sb_when_skill = $req->post("sb_when_skill");
            $sb->sb_why_skill = $req->post("sb_why_skill");
            $sb->sb_how_skill = $req->post("sb_how_skill");
            $sb->sb_takeaway = $req->post("sb_takeaway");
            $sb->sb_timeframe = $req->post("sb_timeframe");
            $sb->save();

            $data['id'] = sha1($lm->lnk_id);

            // Mail::to($req->post("lnk_linkee_email"))->send(new SkillBuildingNotification($data));

            return redirect(url('linkee-pending'))->with('success', "Skill Building Session for {$emp_name} Successfully Sent!!");
        }

        public function editSB($id)
        {
            $as = SkillBuilding::getSession($id);
            if(empty($as)) {
                return redirect(url('404'));
            }

            $data['obj'] = $as;
            $data['management'] = $this->isManagement();
            $data['sel_focus'] = LinkingFocus::where('fc_status', 1)->orderBy('fc_id')->get();
            $data['pending_menu'] = 1;
            $data['history'] = SkillBuilding::getSB($as->lnk_linkee, 0, 1);
            $data['linker'] = User::find($as->lnk_linker);
            $data['linkee'] = User::withTrashed()->find($as->lnk_linkee);

            return view('coaching.sb_edit', $data);
        }

        public function updateSB(Request $req)
        {
            $sb = SkillBuilding::where('sb_com_num', $req->sb_com_num)->first();
            $sb->sb_focus = $req->post("sb_focus");
            $sb->sb_skill = $req->post("sb_skill");
            $sb->sb_when_skill = $req->post("sb_when_skill");
            $sb->sb_why_skill = $req->post("sb_why_skill");
            $sb->sb_how_skill = $req->post("sb_how_skill");
            $sb->sb_takeaway = $req->post("sb_takeaway");
            $sb->sb_timeframe = $req->post("sb_timeframe");
            $sb->save();

            return back()->with('success', "Session Updated!!");
        }

        public function acknowledgeSB($id)
        {
            $sb = SkillBuilding::getSession($id);
            if(empty($sb)) {
                return redirect(url('404'));
            }

            $data['obj'] = $sb;
            $data['management'] = $this->isManagement();
            $data['pending_menu'] = 1;
            $data['linker'] = User::withTrashed()->find($sb->lnk_linker);
            $data['linkee'] = User::withTrashed()->find($sb->lnk_linkee);

            return view('coaching.sb_acknowledge', $data);
        }

        public function acknowledgedSB(Request $req)
        {
            $lm = LinkingMaster::find($req->sb_link_id);
            $lm->lnk_acknw = 1;
            $lm->save();

            $ql = SkillBuilding::where('sb_com_num', $req->sb_com_num)->first();
            $ql->sb_feedback = $req->post("sb_feedback");
            $ql->save();

            return redirect(url('skill-building-list'))->with('success', "Session Acknowledged!!");
        }

        public function listSBs()
        {
            $data['linking'] = SkillBuilding::getSB($this->getActiveUser(), $this->isManagement());
            $data['management'] = ($this->isManagement()) ? 1 : 0;
            $data['label'] = ($this->isManagement()) ? 'Linkee' : 'Linker';
            $data['sb'] = 1;

            return view('coaching.sb_list', $data);
        }

        public function viewSB(Request $req, $id)
        {
            $sb = SkillBuilding::getSession($id);
            if(empty($sb)) {
                return redirect(url('404'));
            }

            $data['obj'] = $sb;
            $data['linker'] = User::withTrashed()->find($sb->lnk_linker);
            $data['linkee'] = User::withTrashed()->find($sb->lnk_linkee);
            $data['management'] = $this->isManagement();
            $data['sb'] = 1;

            return view('coaching.sb_view', $data);
        }
    /* End Skill Building */

    /* Goal Setting */
        public function addGS(Request $req)
        {
            $emp_name = strtoupper($req->post("lnk_linkee_name"));
            $data['emp_name'] = $emp_name;
            $data['leaders_name'] = Auth::user()->first_name." ".Auth::user()->last_name;

            $lm = new LinkingMaster();
            $lm->lnk_date = date("Y-m-d", strtotime($req->post("lnk_date")));
            $lm->lnk_linker = Auth::user()->id;
            $lm->lnk_linkee = $req->post("lnk_linkee");
            $lm->lnk_type = 7;
            $lm->lnk_acknw = 0;
            $lm->save();

            $gs = new GoalSetting();
            $gs->gs_link_id = $lm->lnk_id;
            $gs->gs_com_id = sha1($lm->lnk_id);
            $gs->gs_accmpl = $req->post("gs_accmpl");
            $gs->gs_metric_01 = $req->post("gs_metric_01");
            $gs->gs_metric_02 = $req->post("gs_metric_02");
            $gs->gs_metric_03 = $req->post("gs_metric_03");
            $gs->gs_metric_04 = $req->post("gs_metric_04");
            $gs->gs_metric_05 = $req->post("gs_metric_05");
            $gs->gs_metric_06 = $req->post("gs_metric_06");
            $gs->gs_metric_07 = $req->post("gs_metric_07");
            $gs->gs_target_01 = $req->post("gs_target_01");
            $gs->gs_target_02 = $req->post("gs_target_02");
            $gs->gs_target_03 = $req->post("gs_target_03");
            $gs->gs_target_04 = $req->post("gs_target_04");
            $gs->gs_target_05 = $req->post("gs_target_05");
            $gs->gs_target_06 = $req->post("gs_target_06");
            $gs->gs_target_07 = $req->post("gs_target_07");
            $gs->gs_prev_01 = $req->post("gs_prev_01");
            $gs->gs_prev_02 = $req->post("gs_prev_02");
            $gs->gs_prev_03 = $req->post("gs_prev_03");
            $gs->gs_prev_04 = $req->post("gs_prev_04");
            $gs->gs_prev_05 = $req->post("gs_prev_05");
            $gs->gs_prev_06 = $req->post("gs_prev_06");
            $gs->gs_prev_07 = $req->post("gs_prev_07");
            $gs->gs_curr_01 = $req->post("gs_curr_01");
            $gs->gs_curr_02 = $req->post("gs_curr_02");
            $gs->gs_curr_03 = $req->post("gs_curr_03");
            $gs->gs_curr_04 = $req->post("gs_curr_04");
            $gs->gs_curr_05 = $req->post("gs_curr_05");
            $gs->gs_curr_06 = $req->post("gs_curr_06");
            $gs->gs_curr_07 = $req->post("gs_curr_07");
            $gs->gs_tip = $req->post("gs_tip");
            $gs->gs_com = $req->post("gs_com");
            $gs->save();

            $data['id'] = sha1($lm->lnk_id);

            // Mail::to($req->post("lnk_linkee_email"))->send(new GoalSettingNotification($data));

            return redirect(url('linkee-pending'))->with('success', "Goal Setting Session for {$emp_name} Successfully Sent!!");
        }

        public function editGS($id)
        {
            $gs = GoalSetting::getSession($id);
            if(empty($gs)) {
                return redirect(url('404'));
            }

            $data['obj'] = $gs;
            $data['management'] = $this->isManagement();
            $data['pending_menu'] = 1;
            $data['history'] = GoalSetting::getGS($gs->lnk_linkee, 0, 1);
            $data['linker'] = User::find($gs->lnk_linker);
            $data['linkee'] = User::withTrashed()->find($gs->lnk_linkee);

            return view('coaching.gs_edit', $data);
        }

        public function updateGS(Request $req)
        {
            $gs = GoalSetting::where('gs_com_id', $req->post("gs_com_id"))->first();
            $gs->gs_accmpl = $req->post("gs_accmpl");
            $gs->gs_metric_01 = $req->post("gs_metric_01");
            $gs->gs_metric_02 = $req->post("gs_metric_02");
            $gs->gs_metric_03 = $req->post("gs_metric_03");
            $gs->gs_metric_04 = $req->post("gs_metric_04");
            $gs->gs_metric_05 = $req->post("gs_metric_05");
            $gs->gs_metric_06 = $req->post("gs_metric_06");
            $gs->gs_metric_07 = $req->post("gs_metric_07");
            $gs->gs_target_01 = $req->post("gs_target_01");
            $gs->gs_target_02 = $req->post("gs_target_02");
            $gs->gs_target_03 = $req->post("gs_target_03");
            $gs->gs_target_04 = $req->post("gs_target_04");
            $gs->gs_target_05 = $req->post("gs_target_05");
            $gs->gs_target_06 = $req->post("gs_target_06");
            $gs->gs_target_07 = $req->post("gs_target_07");
            $gs->gs_prev_01 = $req->post("gs_prev_01");
            $gs->gs_prev_02 = $req->post("gs_prev_02");
            $gs->gs_prev_03 = $req->post("gs_prev_03");
            $gs->gs_prev_04 = $req->post("gs_prev_04");
            $gs->gs_prev_05 = $req->post("gs_prev_05");
            $gs->gs_prev_06 = $req->post("gs_prev_06");
            $gs->gs_prev_07 = $req->post("gs_prev_07");
            $gs->gs_curr_01 = $req->post("gs_curr_01");
            $gs->gs_curr_02 = $req->post("gs_curr_02");
            $gs->gs_curr_03 = $req->post("gs_curr_03");
            $gs->gs_curr_04 = $req->post("gs_curr_04");
            $gs->gs_curr_05 = $req->post("gs_curr_05");
            $gs->gs_curr_06 = $req->post("gs_curr_06");
            $gs->gs_curr_07 = $req->post("gs_curr_07");
            $gs->gs_tip = $req->post("gs_tip");
            $gs->gs_com = $req->post("gs_com");
            $gs->save();

            return back()->with('success', "Session Updated!!");
        }

        public function acknowledgeGS($id)
        {
            $gs = GoalSetting::getSession($id);
            if(empty($gs)) {
                return redirect(url('404'));
            }

            $data['obj'] = $gs;
            $data['management'] = $this->isManagement();
            $data['pending_menu'] = 1;
            $data['linker'] = User::withTrashed()->find($gs->lnk_linker);
            $data['linkee'] = User::withTrashed()->find($gs->lnk_linkee);

            return view('coaching.gs_acknowledge', $data);
        }

        public function acknowledgedGS(Request $req)
        {
            $lm = LinkingMaster::find($req->gs_link_id);
            $lm->lnk_acknw = 1;
            $lm->save();

            $ql = GoalSetting::where('gs_com_id', $req->gs_com_id)->first();
            $ql->gs_feedback = $req->post("gs_feedback");
            $ql->save();

            return redirect(url('goal-setting-list'))->with('success', "Session Acknowledged!!");
        }

        public function listGSs()
        {
            $data['linking'] = GoalSetting::getGS($this->getActiveUser(), $this->isManagement());
            $data['management'] = ($this->isManagement()) ? 1 : 0;
            $data['label'] = ($this->isManagement()) ? 'Linkee' : 'Linker';
            $data['gs'] = 1;

            return view('coaching.gs_list', $data);
        }

        public function viewGS(Request $req, $id)
        {
            $gs = GoalSetting::getSession($id);
            if(empty($gs)) {
                return redirect(url('404'));
            }

            $data['obj'] = $gs;
            $data['linker'] = User::withTrashed()->find($gs->lnk_linker);
            $data['linkee'] = User::withTrashed()->find($gs->lnk_linkee);
            $data['management'] = $this->isManagement();
            $data['gs'] = 1;

            return view('coaching.gs_view', $data);
        }
    /* End Goal Setting */

    /* Private Functions */
        private function getActiveUser()
        {
            if(!$this->active_user) {
                $this->active_user = Auth::user()->id;
            }

            return $this->active_user;
        }

        private function isManagement()
        {
            $id = $this->getActiveUser();
            $linkees = Auth::user()->getLinkees();
            $is_leader = DB::select("SELECT id FROM `employee_info` WHERE `employee_info`.`deleted_at` IS NULL AND `employee_info`.`status` = 1 AND (`employee_info`.`manager_id`={$id} OR `employee_info`.`supervisor_id`={$id})");
            $allowedUsers = [ 3655 ];

            if (count($is_leader) > 0 || count($linkees) > 0 || in_array(Auth::user()->id, $allowedUsers)) {
                return 1;
            }

            return 0;
        }

        private function viewManagement()
        {
            $data['management'] = $this->isManagement();
            $data['names'] = Auth::user()->getLinkees();
            $data['new'] = 1;
            $data['lt_types'] = LinkingTypes::where('lt_status', 1)->orderBy('lt_order')->get();

            return view('coaching.supervisor', $data);
        }

        private function viewStaff()
        {
            $data['linking'] = LinkingMaster::getUnacknowledged(Auth::user()->id);
            $data['management'] = $this->isManagement();
            $data['pending_menu'] = 1;

            return view('coaching.staff', $data);
        }

        private function processLinking($req)
        {
            $obj['lnk_date'] = $req->post("lnk_date");
            $obj['lnk_linkee'] = $req->post("lnk_linkee");
            $obj['lnk_linkee_name'] = $req->post("lnk_linkee_name");
            $obj['lnk_linkee_email'] = $req->post("lnk_linkee_email");
            $obj['lnk_linker'] = $req->post("lnk_linker");
            $obj['sel_focus'] = LinkingFocus::where('fc_status', 1)->get();

            $data['management'] = $this->isManagement();
            $data['new'] = 1;
            $data['obj'] = $obj;

            switch(intval($req->post('lnk_type'))) {
                case 1: 
                    $data['history'] = QuickLink::getQL($req->lnk_linkee, 0, 1);

                    return view('coaching.ql_create', $data);
                break;
                case 2:
                    $data['history'] = CementingExpectations::getCE($req->lnk_linkee, 0, 1);

                    return view('coaching.ce_create', $data);
                break;
                case 3: 
                    $data['history'] = AccountabilitySession::getAS($req->lnk_linkee, 0, 1);

                    return view('coaching.as_create', $data);
                break;
                case 4: 
                    $data['history'] = SkillsDevelopment::getSDA($req->lnk_linkee, 0, 1);

                    return view('coaching.sda_create', $data);
                break;
                case 5:
                    $data['history'] = GettingToKnowYou::getGTKY($req->lnk_linkee, 0, 1);

                    return view('coaching.gtky_create', $data);
                break;
                case 6:
                    $data['history'] = SkillBuilding::getSB($req->lnk_linkee, 0, 1);

                    return view('coaching.sb_create', $data);
                break;
                case 7:
                    $data['history'] = GoalSetting::getGS($req->lnk_linkee, 0, 1);

                    return view('coaching.gs_create', $data);
                break;

                default: 
                    return "We Are Still Working In This Linking Session Type.";
                break;
            }
        }
    /* End Private Functions */
}
