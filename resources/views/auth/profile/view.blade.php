@extends('layouts.main')
@section('title')
Employees > Separated Employees > View Profile
@endsection
@section('head')
<link rel="stylesheet" href="{{asset('public/css/custom-bootstrap.css')}}">
<style type="text/css">
@include('employee.style');
</style>
@endsection
@section('breadcrumb')
Employees <span>/</span> Separated Employee <span>></span> View Profile
@endsection
@section('content')
<div id="view_profile" class="row">
    <div class="col-md-3 pr-0">
        <div class="section-header">
            <h4>Profile Picture</h4>
        </div>
        <div class="panel panel-container">
            <div class="row no-padding">
                <div class="text-center">
                    <div class="emp-profile-img">
                        <img src="<?= $employee->profile_img ?>" alt="image" />
                    </div>
                    <br>
                    <h4 class="card-title"><?= $employee->fullname() ?></h4>
                    <h6 class="card-subtitle"><?= $employee->position_name ?></h6>
                    <h6 class="card-subtitle"><?= $employee->team_name ?></h6>
                    <hr>
                </div>
                <span class="pull-left label-profile">Production Date: <i><?= $employee->prettyproddate() ?></i></span>
                <br>
                <br>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="section-header">
            <h4>Employee Information</h4>

            <a href="<?= url('employees/separated') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
        </div>
        <div class="panel panel-body mb-0">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>First Name</label>
                        <p class="employee-details-value name-format"><?= $employee->first_name ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Middle Name</label>
                         <p class="employee-details-value name-format"><?= empty($employee->middle_name) ? '-' : $employee->middle_name ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Last Name</label>
                        <p class="employee-details-value name-format"><?= $employee->last_name ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Employee ID</label>
                        <p class="employee-details-value"><?= $employee->eid ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Phone Name</label>
                        <p class="employee-details-value name-format"><?= empty($employee->alias) ? '-' : $employee->alias ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Birthdate</label>
                        <p class="employee-details-value"><?= $employee->prettybirthdate() ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-header section-subheading">
            <h4>Job Information</h4>
        </div>
        <div class="panel panel-body mb-0">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Position</label>
                        <p class="employee-details-value"><?= $employee->position_name ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Account</label>
                        <p class="employee-details-value"><?= empty(@$employee->account->account_name) ? '-' : @$employee->account->account_name ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Team/Department</label>
                        <p class="employee-details-value"><?= $employee->team_name ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Supervisor</label>
                        <p class="employee-details-value name-format"><?= $employee->supervisor_name ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Manager</label>
                        <p class="employee-details-value name-format"><?= $employee->manager_name ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Employee Type</label>
                        <?php
                        $type = 'Probationary';
                        switch($employee->is_regular) {
                            case 1: $type = 'Regular'; break;
                            case 2: $type = 'Project Based'; break;
                        }
                        ?>
                        <p class="employee-details-value name-format"><?= $type ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Hire Date</label>
                        <p class="employee-details-value"><?= $employee->prettydatehired() ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Production date</label>
                        <p class="employee-details-value"><?= @$employee->prettyproddate() ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Resignation date</label>
                        <p class="employee-details-value"><?= date('M d, Y', strtotime(@$employee->deleted_at)) ?></p>
                    </div>
                </div>
                <?php
                if(isset($employee->ext)) {
                ?>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Phone Extension</label>
                        <p class="employee-details-value"><?= @$employee->ext ?></p>
                    </div>
                </div>
                <?php
                }
                if(isset($employee->wave)) {
                ?>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Wave Number</label>
                        <p class="employee-details-value"><?= $employee->wave == "" ? "--" : $employee->wave ?></p>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="section-header section-subheading">
            <h4>Emails</h4>
        </div>
        <div class="panel panel-body mb-0">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Company Email</label>
                        <p class="employee-email"><?= $employee->email ?></p>
                    </div>
                </div>
                <?php
                if(!empty($employee->email2)) {
                ?>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Personal Email</label>
                        <p class="employee-email"><?= $employee->email2 ?></p>
                    </div>
                </div>
                <?php
                } 
                if(!empty($employee->email3)) {
                ?>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Secondary Email</label>
                        <p class="employee-email"><?= $employee->email3 ?></p>
                    </div>
                </div>
                <?php
                }
                ?> 
            </div>
        </div>
        <?php
        if(count($leave_requests) > 0) {
        ?>
        <div class="section-header section-subheading">
            <h4>Leave History</h4>
        </div>
        <div class="panel panel-body mb-0">
            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Leave Dates</th>
                                <th>No. Of Days</th>
                                <th>Status</th>
                                <th>Date Requested</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($leave_requests as $no=>$request) {
                            $num_days = 0;
                            $dates = [];
                            foreach($request->leave_details as $detail):
                                array_push($dates, date('M d, Y', strtotime($detail->date)));
                                $num_days += $detail->length;
                            endforeach;

                            $leave_status = "Pending <br> <small>(Recommendation / Approval)</small>";
                            switch($request->approve_status_id) {
                                case 1:
                                    $leave_status = 'Approved';
                                    break;
                                case 2:
                                    $leave_status = 'Not Approved';
                                    break;
                                case 3:
                                    $leave_status = "Pending <br> <small>(Approval)</small>";
                                    break;
                            }
                        ?>
                            <tr>
                                <td><?= ++$no ?></td>
                                <td><span><?= strtotime($dates[0]) ?></span> <?php echo implode('<br>', $dates); ?></td>
                                <td><?= (float) $num_days ?></td>
                                <td><?= $leave_status ?></td>
                                <td><span><?= strtotime($request->date_filed) ?></span> <?= date("M d, Y",strtotime($request->date_filed)) ?></td>
                                <td class="td-option text-center">
                                    <a href="<?= url("leave/{$request->id}") ?>" title="View" class="btn_view">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
    activeMenu($('#menu-separated-employees'));
});
</script>
@endsection
