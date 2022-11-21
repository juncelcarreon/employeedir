@extends('layouts.main')
@section('title')
View Profile
@endsection
@section('pagetitle')
Employee Information
@endsection
@section('content')
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
                <center>
                    <img alt="Profile" style="width: 150px; margin-top: 30px;" src="{{ $employee->profile_img }}">
                    <br>
                    <h4 class="card-title m-t-10 name-format" style="font-size: 16px;line-height: 21px;margin-top: 15px;font-weight: 400;color: #000;">{{ $employee->fullname() }}</h4>
                    <h6 class="card-subtitle name-format">{{ $employee->position_name }}</h6>
                    <h6 class="card-subtitle name-format">{{ $employee->team_name }}</h6>
                    <hr>
                </center>
                <span class="pull-left label-profile">Production Date: <i>{{ $employee->prettyproddate() }}</i></span>
                <br>
                <br>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="{{ $class }}">
        <div class="section-header">
            <h4>Employee Information</h4>
            <span class="text-muted pull-right" style="margin-top: -25px;font-size: 12px">{{ $employee->active_state()}}</span>
        </div>
        <div class="panel panel-container">
            <div class="panel-body">
                <label>Personal Information</label>
                <br>
                <br>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>First Name</label>
                                <p class="employee-details-value name-format">
                                    {{ $employee->first_name}} 
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Middle Name</label>
                                <p class="employee-details-value name-format">{{ $employee->middle_name != "--" ?$employee->middle_name : '' }}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Last Name</label>
                                <p class="employee-details-value name-format">{{ $employee->last_name}}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Birthdate</label>
                                <p class="employee-details-value">{{ $employee->prettybirthdate()}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Gender</label>
                                <p class="employee-details-value">{{ $employee->gender()}}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <p class="employee-email">{{ $employee->email }}</p>
                                @if(!empty($employee->email2))
                                <p class="employee-email">{{ $employee->email2 }}</p>
                                @endif 
                                @if(!empty($employee->email3))
                                <p class="employee-email">{{ $employee->email3 }}</p>
                                @endif 
                            </div>
                        </div>
                        <div class="col-md-3">
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
                                <address class="employee-details-value" style="white-space: pre-line;">{{ $employee->address }}</address>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Home Town Address</label>
                                <address class="employee-details-value" style="white-space: pre-line;">{{ $employee_details->town_address }}</address>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
                <label>Job Information</label>
                <hr style="border-top: 1px dashed #dadada; margin-top: 1px; margin-bottom: 10px;">
                <div class="col-md-12">
                    <br>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Position</label>
                                <p class="employee-details-value">{{ $employee->position_name}}</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Account</label>
                                <p class="employee-details-value">{{ @$employee->account->account_name}}</p>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Team/Department</label>
                                <p class="employee-details-value">{{ $employee->team_name}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Manager/Head</label>
                                <p class="employee-details-value name-format">{{ isset($employee->manager) ? $employee->manager->fullname() : $employee->manager_name }}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Immediate Superior</label>
                                <p class="employee-details-value name-format">{{ isset($employee->supervisor) ? $employee->supervisor->fullname() : $employee->supervisor_name }}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Hire Date</label>
                                <p class="employee-details-value">{{ $employee->prettydatehired()}}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Production Date</label>
                                <p class="employee-details-value">{{ $employee->prettyproddate()}}</p>
                            </div>
                        </div>
                    </div>
                </div>
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