@extends('layouts.main')
@section('title')
Employees > Separated Employees > Profile
@endsection
<style type="text/css">
    .card-title {
        font-size: 16px;
        line-height: 21px;
        margin-top: 15px;
        font-weight: 400;
        color: black;
    }
    .card-subtitle{
        font-size: 12px;
        color: #878;
    }
    .label-profile{
        padding-left: 15px; padding-right: 15px;
    }
    .employee-details-value{
        font-size: 16px;
        line-height: 21px;
        padding-bottom: 10px;
        color: black;
    }
    .form-group label{
        font-weight: 600;
        color: #878;
    }
    .col-md-9 hr{
        margin: 0px;
    }
    .section-header h4{
        display: inline-block;
    }
</style>
@section('content')
<br>
<div class="col-md-3" style="padding-left: 0px !important; padding-right: 0px;">
    <div class="section-header">
        <h4>Profile Picture</h4>
    </div>
    <div class="panel panel-container">
        <div class="row no-padding">
            <div class="text-center">
                <img alt="image" class="img-circle" style="width: 150px; height: 150px; margin-top: 30px;" src="<?= $employee->profile_img ?>">
                <br>
                <h4 class="card-title m-t-10" style="font-size: 16px;line-height: 21px;margin-top: 15px;font-weight: 400;color: black;"><?= $employee->fullname() ?></h4>
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
    <div class="panel panel-container">
        <div class="panel-body">
            <label>Personal Information</label>
            <hr style="border-top: 1px dashed #dadada; margin-top: 1px; margin-bottom: 10px;">
            <br>
            <div class="col-md-12">
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
                             <p class="employee-details-value name-format"><?= $employee->middle_name ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Last Name</label>
                            <p class="employee-details-value name-format"><?= $employee->last_name ?></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Employee ID</label>
                            <p class="employee-details-value"><?= $employee->eid ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Phone Name</label>
                            <p class="employee-details-value name-format"><?= $employee->alias ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Birthdate</label>
                            <p class="employee-details-value"><?= $employee->prettybirthdate() ?></p>
                        </div>
                    </div>
                </div>
                <br>
            </div>
            <label>Job Information</label>
            <hr style="border-top: 1px dashed #dadada; margin-top: 1px; margin-bottom: 10px;">
            <br>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Position</label>
                            <p class="employee-details-value"><?= $employee->position_name ?></p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Supervisor</label>
                            <p class="employee-details-value name-format"><?= $employee->supervisor_name ?></p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Manager</label>
                            <p class="employee-details-value name-format"><?= $employee->manager_name ?></p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Team/Department</label>
                            <p class="employee-details-value"><?= $employee->team_name ?></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Hire Date</label>
                            <p class="employee-details-value"><?= $employee->prettydatehired() ?></p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Status</label>
                            <p class="employee-details-value"><?= $employee->status() ?></p>
                        </div>
                    </div>
                    <?php
                    if(isset($employee->account->account_name)) {
                    ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Account</label>
                            <p class="employee-details-value"><?= $employee->account->account_name ?></p>
                        </div>
                    </div>
                    <?php
                    }
                    if(isset($employee->ext)) {
                    ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Phone Extension</label>
                            <p class="employee-details-value"><?= @$employee->ext ?></p>
                        </div>
                    </div>
                    <?php
                    }
                    if(isset($employee->prod_date)) {
                    ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Production date</label>
                            <p class="employee-details-value"><?= @$employee->prettyproddate() ?></p>
                        </div>
                    </div>
                    <?php
                    }
                    if(isset($employee->wave)) {
                    ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Wave Number</label>
                            <p class="employee-details-value"><?= $employee->wave == "" ? "--" : $employee->wave ?></p>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
                <br>
            </div>
            <br>
            <label>Login Credentials</label>
            <hr style="border-top: 1px dashed #dadada; margin-top: 1px; margin-bottom: 10px;">
            <br>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Email</label>
                            <br>
                            <a href="mailto:<?= $employee->email ?>"><span class="employee-details-value"><?= $employee->email ?></span></a>
                        </div>
                    </div>
                    <?php
                    if(isset($employee->email2) && $employee->email2 != "") {
                    ?>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Email 2</label>
                            <br>
                            <a href="mailto:<?= $employee->email2 ?>">
                                <span class="employee-details-value"><?= $employee->email2 ?></span>
                            </a>
                        </div>
                    </div>
                    <?php
                    }
                    if(isset($employee->email3) && $employee->email3 != "") {
                    ?>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Email 3</label>
                            <br>
                            <a href="mailto:<?= $employee->email3 ?>">
                                <span class="employee-details-value"><?= $employee->email3 ?></span>
                            </a>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
                <br>
            </div>
        </div>
    </div>
    <?php
    if(count($leave_requests) > 0) {
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Leave History</div>
                <div class="pane-body panel">
                    <br>
                    <br>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Leave Dates</th>
                                <th>No. Of Days</th>
                                <th>Status</th>
                                <th>Date Requested</th>
                                <th width="100px">Options</th>
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
                                <td><?php echo implode('<br>', $dates); ?></td>
                                <td><?= (float) $num_days ?></td>
                                <td><?= $leave_status ?></td>
                                <td><span style="display: none;"><?= strtotime($request->date_filed) ?></span> <?= date("M d, Y",strtotime($request->date_filed)) ?></td>
                                <td class="td-option">
                                    <a href="<?= url("leave/{$request->id}") ?>" title="View" class="btn_view">
                                        <span class="fa fa-eye"></span>
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
    </div>
    <?php
    }
    ?>
</div>
<script type="text/javascript">
$(document).ready(function(){
    activeMenu($('#menu-separated-employees'));
});
</script>
@endsection