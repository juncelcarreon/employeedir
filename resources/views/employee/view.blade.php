@extends('layouts.main')
@section('title')
Employee > View Profile
@endsection
@section('breadcrumb')
Employee <span>></span> View Profile
@endsection
@section('content')
<link rel="stylesheet" href="{{asset('./css/custom-bootstrap.css')}}">
<style type="text/css">
#view_profile .card-subtitle{
    font-size: 12px;
    color: #878;
}
.label-profile{
    padding-left: 15px;
    padding-right: 15px;
}
.employee-details-value{
    font-size: 14px;
    line-height: 21px;
    color: #000;
}
.employee-email{
    font-size: 14px;
    line-height: 21px;
    color: #0c59a2;
    word-break: break-all;
    margin: 0;
}
.employee-email:last-child{
    margin: 0 0 10px;
}
.form-group label{
    font-weight: 600;
    color: #878;
    margin: 0;
}
.col-md-9 hr{
    margin: 0px;
}
.section-header h4 {
    display: inline-block;
}
.section-subheading{
    background: #5bc0de !important;
}
address{
    margin-bottom: 10px;
    white-space: pre-line;
}
@include('employee.style');
</style>
<div id="view_profile">
    <?php
    $class = "col-md-12";
    if(Auth::user()->id != $employee->id){
        $class="col-md-9";
    ?>
    <div class="col-md-3" style="padding-left: 0px !important; padding-right: 0px;">
        <div class="section-header">
            <h4>Profile Picture</h4>
        </div>
        <div class="panel panel-container">
            <div class="row no-padding">
                <div class="text-center">
                    <img src="{{ $employee->profile_img }}" alt="Profile" class="img-circle" style="width: 150px; margin-top: 30px;" />
                    <br>
                    <h4 class="card-title m-t-10 name-format" style="font-size: 16px;line-height: 21px;margin-top: 15px;font-weight: 400;color: #000;">{{ $employee->fullname() }}</h4>
                    <h6 class="card-subtitle name-format">{{ $employee->position_name }}</h6>
                    <h6 class="card-subtitle name-format">{{ $employee->team_name }}</h6>
                    <hr>
                </div>
                <span class="pull-left label-profile">Production Date: <i>{{ $employee->prettyproddate() }}</i></span>
                <br>
                <br>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="{{ $class }}">
        <div class="section-header">
            <h4>Employee Information <span class="text-muted pull-right" style="margin-top: -25px;font-size: 12px">{{ $employee->active_state()}}</span></h4>

            <a href="<?= url('employees') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
        </div>
        <div class="panel panel-body mb-0">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>First Name</label>
                        <p class="employee-details-value name-format">
                            {{ $employee->first_name}} 
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Middle Name</label>
                        <p class="employee-details-value name-format">{{ empty($employee->middle_name) ? '-' : $employee->middle_name }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Last Name</label>
                        <p class="employee-details-value name-format">{{ $employee->last_name}}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Birthdate</label>
                        <p class="employee-details-value">{{ $employee->prettybirthdate()}}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Gender</label>
                        <p class="employee-details-value">{{ $employee->gender()}}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Contact Number</label>
                        <p class="employee-details-value" style="word-break: break-all;">{{ $employee->contact_number }}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>City Address</label>
                        <address class="employee-details-value">{{ $employee->address == "" ? '-' : $employee->address }}</address>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Home Town Address</label>
                        <address class="employee-details-value">{{ $employee_details->town_address == "" ? '-' : $employee_details->town_address }}</address>
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
                        <p class="employee-details-value">{{ $employee->position_name}}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Account</label>
                        <p class="employee-details-value">{{ @$employee->account->account_name}}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Team/Department</label>
                        <p class="employee-details-value">{{ $employee->team_name}}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Manager</label>
                        <?php
                        $manager_name = '-';
                        foreach($employees as $emp) {
                            if($emp->id == $employee->manager_id) {
                                $manager_name = $emp->fullname();
                            }
                        }
                        ?>
                        <p class="employee-details-value name-format">{{ $manager_name }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Immediate Superior / Supervisor</label>
                        <?php
                        $supervisor_name = '-';
                        foreach($employees as $emp) {
                            if($emp->id == $employee->supervisor_id) {
                                $supervisor_name = $emp->fullname();
                            }
                        }
                        ?>
                        <p class="employee-details-value name-format">{{ $supervisor_name }}</p>
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
                        <p class="employee-details-value name-format">{{ $type }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Hire Date</label>
                        <p class="employee-details-value">{{ $employee->prettydatehired()}}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Production Date</label>
                        <p class="employee-details-value">{{ $employee->prettyproddate()}}</p>
                    </div>
                </div>
                @if(isset($employee->ext))
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Ext</label>
                        <p class="employee-details-value">{{ $employee->ext}}</p>
                    </div>
                </div>
                @endif 
                @if(isset($employee->wave))
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Wave</label>
                        <p class="employee-details-value">{{ $employee->wave}}</p>
                    </div>
                </div>
                @endif 
            </div>
        </div>
        <div class="section-header section-subheading">
            <h4>Emails</h4>
        </div>
        <div class="panel panel-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Company Email</label>
                        <p class="employee-email">{{ $employee->email }}</p>
                    </div>
                </div>
                @if(!empty($employee->email2))
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Personal Email</label>
                        <p class="employee-email">{{ $employee->email2 }}</p>
                    </div>
                </div>
                @endif 
                @if(!empty($employee->email3))
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Secondary Email</label>
                        <p class="employee-email">{{ $employee->email3 }}</p>
                    </div>
                </div>
                @endif 
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(function() {
    activeMenu($('#menu-active-employees'));
});
</script>
@endsection