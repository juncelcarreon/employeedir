@extends('layouts.main')
@section('title')
Employee > Add Employee
@endsection
@section('content') 
<link rel="stylesheet" href="{{asset('./css/custom-bootstrap.css')}}">
<style type="text/css">
.emp-image{
    width: 150px;
    height: 150px;
    position: relative;
    overflow: hidden;
    border-radius: 50%;
    margin: 30px auto 0;
}
.emp-image img{
    width: 100%;
    height: 100%;
    object-fit: cover;
}
#bb{
    margin: 0 auto;
}
.card-title{
    font-size: 16px;
    line-height: 21px;
    margin-top: 15px;
    font-weight: 400;
    color: #000;
}
.card-subtitle{
    font-size: 12px;
    color: #878;
}
.label-profile{
    padding-left: 15px; 
    padding-right: 15px;
}
.section-header h4 {
    display: inline-block;
}
.section-subheading{
    background: #5bc0de !important;
}
#dependentsDiv .btn{
    width: 100%;
}
pre{
    border: 0px solid transparent;
    border-radius: 0px !important;
    margin-top: -3px;
}
</style>
<br>
<form id="create_employee_form" role="form" method="POST" action="{{ route('employee_info.store')}}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="col-md-3 p-0">
        <div class="section-header">
            <h4>Profile Picture </h4>
        </div>
        <div class="panel panel-container">
            <div class="row no-padding">
                <div class="text-center">
                    <div class="emp-image">
                        <img src="<?= asset('public/img/nobody_m.original.jpg') ?>" id="profile_image" alt="image" />
                    </div>
                    <br>
                     <label id="bb" class="btn btn-default"> Upload Photo
                        <input type="file" id="image_uploader" class="btn btn-small" name="profile_image" />
                    </label> 
                    <h4 class="card-title m-t-10"></h4>
                    <h6 class="card-subtitle"></h6>
                    <h6 class="card-subtitle"></h6>
                </div>
                <br>
                <br>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="section-header">
            <h4>Employee Information</h4>
        </div>
        <div class="panel panel-body mb-0">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">First Name</label>
                        <input type="text" class="form-control" name="first_name" placeholder="First Name" required />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Middle Name</label>
                        <input type="text" class="form-control" name="middle_name" placeholder="Middle Name" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">Last Name</label>
                        <input type="text" class="form-control" name="last_name" placeholder="Last Name" required />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">Employee ID</label>
                        <input type="text" class="form-control" name="eid" placeholder="ESCC-xxxxxxx" required />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Phone Name</label>
                        <input type="text" class="form-control" name="alias" placeholder="Phone Name" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">Birthdate</label>
                        <input type="text" class="form-control datetimepicker" name="birth_date" placeholder="MM/DD/YYYY" autocomplete="off" required />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Contact Number</label>
                        <input type="text" class="form-control" name="contact_number" placeholder="xxxx-xxx-xxxx" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Gender</label><br>
                        <input type="radio" id="male" name="gender_id" value="1" checked />
                        <label class="radio-label" for="male">Male</label>
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        <input type="radio" id="female" name="gender_id" value="2" />
                        <label class="radio-label" for="female">Female</label>
                    </div>
                </div>  
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Civil Status</label>
                        <select name="civil_status" class="form-control select2">
                            <option value="1">Single</option>
                            <option value="2">Married</option>
                            <option value="3">Separated</option>
                            <option value="4">Anulled</option>
                            <option value="5">Divorced</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Avega Number</label>
                        <input type="text" class="form-control" name="avega_num" placeholder="xx-xx-xxxxx-xxxxx-xx" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>City Address</label>
                        <textarea name="address" class="form-control" rows="4"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Home Town Address</label>
                        <textarea name="town_address" class="form-control" rows="4"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-header section-subheading">
            <h4>Other Information</h4>
        </div>
        <div class="panel panel-body mb-0">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Father's Name</label>
                        <input type="text" class="form-control" name="fathers_name" placeholder="Father's Name" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Father's Birthday</label>
                        <input type="text" class="form-control datetimepicker" name="fathers_bday" placeholder="MM/DD/YYYY" autocomplete="off" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Complete Mother's Maiden Name</label>
                        <input type="text" class="form-control" name="mothers_name" placeholder="Mother's Maiden Name" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Mother's Birthday</label>
                        <input type="text" class="form-control datetimepicker" name="mothers_bday" placeholder="MM/DD/YYYY" autocomplete="off" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Spouse's Name</label>
                        <input type="text" class="form-control" name="spouse_name" placeholder="Spouse's Name" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Spouse's Birthday</label>
                        <input type="text" class="form-control datetimepicker" name="spouse_bday" placeholder="MM/DD/YYYY" autocomplete="off" />
                    </div>
                </div>
            </div>
        </div>
        <div class="section-header section-subheading">
            <h4>Dependents Information</h4>
        </div>
        <div class="panel panel-body mb-0" id="dependentsDiv">
            <div class="row text-center">
                <div class="col-md-4">
                    <div class="form-group">
                        <strong>Dependent's Name</strong>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <strong>Birthday</strong>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <strong>Generali Number</strong>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" class="form-control" name="dependent_name[]" placeholder="Dependent's Name" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="text" class="form-control datetimepicker" name="dependent_bday[]" placeholder="MM/DD/YYYY" autocomplete="off" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="text" class="form-control" name="generali_num[]" placeholder="xxxx-xxx-xxxx" autocomplete="off" />
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <button class="btn btn-primary add-dependent">
                            <span class="fa fa-plus"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-header section-subheading">
            <h4>In Case of Emergency</h4>
        </div>
        <div class="panel panel-body mb-0">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>In case of emergency please contact.</label>
                        <input type="text" name="em_con_name" class="form-control" placeholder="Contact Name" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Relationship</label>
                        <input type="text" name="em_con_rel" class="form-control" placeholder="Relationship" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Contact Number</label>
                        <input type="text" name="em_con_num" class="form-control" placeholder="xxxx-xxx-xxxx" />
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Address</label>
                        <textarea name="em_con_address" class="form-control" rows="4"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-header section-subheading">
            <h4>User Access</h4>
        </div>
        <div class="panel panel-body mb-0">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="radio" id="employee" name="employee_type" value="1" checked required />
                        <label class="radio-label" for="employee">Employee</label>
                        &nbsp;
                        &nbsp;
                        <input type="radio" id="supervisor" name="employee_type" value="2" required />
                        <label class="radio-label" for="supervisor">Supervisor</label>
                        &nbsp;
                        &nbsp;
                        <input type="radio" id="manager" name="employee_type" value="3" required />
                        <label class="radio-label" for="manager">Manager</label>
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        |
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        <input type="checkbox" id="admin" name="is_admin" />
                        <label class="radio-label" for="admin">WebsiteAdmin</label>
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        <input type="checkbox"  id="hr" name="is_hr" />
                        <label class="radio-label" for="hr">HR</label>
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        <input type="checkbox" id="erp" name="is_erp" />
                        <label class="radio-label" for="erp">ERP</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-header section-subheading">
            <h4>Job Related</h4>
        </div>
        <div class="panel panel-body mb-0">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">Position</label>
                        <input type="text" class="form-control" name="position_name" placeholder="Position" list="positions" required />
                        <datalist id="positions">
                            <?php
                            foreach($positions as $position) {
                            ?>
                            <option value="<?= $position->position_name ?>"><?= $position->position_name ?></option>
                            <?php
                            }
                            ?>
                        </datalist>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">Account</label>
                        <select class="select2 form-control" name="account_id" required>
                            <option selected disabled>Select</option>
                            <?php
                            foreach($accounts as $account) {
                            ?>
                            <option value="<?= $account->id ?>"><?= $account->account_name ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">Team/Department</label>
                        <select class="select2 form-control" id="_team_name" name="team_name" required>
                            <option selected disabled>Select</option>
                            <?php
                            foreach($departments as $department) {
                            ?>
                            <option data-_dept_code="<?= $department->department_code ?>" value="<?= $department->department_name ?>"><?= $department->department_name ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <input type="hidden" id="_dept_code" name="dept_code" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Manager</label>
                        <select class="select2 form-control" name="manager_id">
                        <option value="0" selected>Select</option>
                        <?php
                        foreach($employees as $employee) {
                        ?>
                        <option value="<?= $employee->id ?>"><?= $employee->fullname() ?></option>
                        <?php
                        }
                        ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Immediate Superior / Supervisor</label>
                        <select class="select2 form-control" name="supervisor_id">
                            <option value="0" selected>Select</option>
                            <?php
                            foreach($employees as $employee) {
                            ?>
                            <option value="<?= $employee->id ?>"><?= $employee->fullname() ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Employee Type</label>
                        <select name="is_regular" class="select2 is_reg_event form-control">
                            <option value="0" selected>Probationary</option>
                            <option value="1">Regular</option>
                            <option value="2">Project Based</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Employee Category</label>
                        <select name="employee_category" class="select2 form-control">
                            <option value="0">Employee Category</option>
                            <option value="1">Manager</option>
                            <option value="2">Supervisor</option>
                            <option value="3">Support</option>
                            <option value="4" selected>Rank</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Hire Date</label>
                        <input type="text" class="form-control datetimepicker" placeholder="MM/DD/YYYY" name="hired_date" autocomplete="off" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Production Date</label>
                        <input type="text" class="form-control datetimepicker" placeholder="MM/DD/YYYY" name="prod_date" autocomplete="off" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Regularization Date</label>
                        <input type="text" type="text" name="regularization_date" class="form-control datetimepicker" placeholder="MM/DD/YYYY" autocomplete="off" />
                    </div>
                </div>
                <input type="hidden" name="status_id" value="1" />
                <div class="col-md-4">
                    <div class="form-group">
                        <label>EXT</label>
                        <input type="text" class="form-control" placeholder="Ext" name="ext" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Wave</label>
                        <input type="text" class="form-control" placeholder="Wave" name="wave" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Rehirable</label>
                        <select class="select2 form-control" name="rehirable">
                            <option disabled>Select</option>
                            <option value="1" selected>Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Reason</label>
                        <input type="text" name="rehire_reason" class="form-control" placeholder="State your reason..." />
                    </div>
                </div> 
                <div class="col-md-12 hidden">
                    <div class="form-group">
                        <input type="checkbox" name="all_access" />&nbsp;
                        <span for="all_access">can view information from other account ?</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-header section-subheading">
            <h4>Government Numbers</h4>
        </div>
        <div class="panel panel-body mb-0">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>SSS Number</label>
                        <input type="text" class="form-control" name="sss" placeholder="xx-xxxxxxx-x" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Pag-ibig/HDMF</label>
                        <input type="text" class="form-control" name="pagibig" placeholder="xxxx-xxxx-xxxx" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Philhealth Number</label>
                        <input type="text" class="form-control" name="philhealth" placeholder="xx-xxxxxxxxx-x" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>TIN ID</label>
                        <input type="text" class="form-control" name="tin" placeholder="xxx-xxx-xxx" />
                    </div>
                </div>
            </div>
        </div>
        <div class="section-header section-subheading">
            <h4>Login Credentials</h4>
        </div>
        <div class="panel panel-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">Company Email</label>
                        <input type="email" class="form-control" name="email" placeholder="email@elink.com.ph" required />
                    </div>
                </div>
                 <div class="col-md-4">
                    <div class="form-group">
                        <label>Personal Email</label>
                        <input type="email" class="form-control" name="email2" placeholder="personal@email.com" />
                    </div>
                </div>
                 <div class="col-md-4">
                    <div class="form-group">
                        <label>Secondary Email</label>
                        <input type="email" class="form-control" name="email3" placeholder="secondary@email.com" />
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <p>
                            <pre><i class="fa fa-info-circle">&nbsp;</i> Password will be generated automatically once saved.</pre>
                        </p>
                    </div>
                </div>
            </div>
             <div class="col-md-12">
                <br>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <button class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section('scripts')
<script id="tmpl_addDependents" type="text/template">
<div id="dep_~id~" class="row">
    <div class="col-md-4">
        <div class="form-group">
            <input type="text" id="dep_name_~id~" class="form-control" name="dependent_name[]" placeholder="Dependent's Name" />
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <input type="text" id="dep_bday_~id~" class="form-control datetimepicker" name="dependent_bday[]" placeholder="MM/DD/YYYY" autocomplete="off" />
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <input type="text" class="form-control" name="generali_num[]" placeholder="xxxx-xxx-xxxx" autocomplete="off" />
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <a href="javascript:;" class="btn btn-danger" data-id="~id~" onclick="removeThisDependent(this)">
                <span class="fa fa-minus"></span>
            </a>
        </div>
    </div>
</div>
</script>
<script type="text/javascript">
var ctr = 1;
function removeThisDependent(obj) {
    var id = $(obj).data('id');
    $("#dep_" + id).remove();
}
$(function() {
    activeMenu($('#menu-active-employees'));

    $('#create_employee_form').validate({
        ignore: [], 
        rules : {
            first_name: {
                maxlength: 50
            },
            middle_name: {
                maxlength: 50
            },
            last_name: {
                maxlength: 50
            },
            alias:{
                maxlength: 100
            },
            position_name: {
                maxlength: 50
            }
        }
    });

    $("#_team_name").change(function(){
        var val = $(this).find(':selected').data('_dept_code');
        $("#_dept_code").val(val);
    });

    $(".add-dependent").click(function(e){
        e.preventDefault();
        console.log(ctr);
        var template = document.getElementById("tmpl_addDependents").innerHTML;
        var js_tmpl = "";
        js_tmpl = template.replace(/~id~/g,ctr);
        $("#dependentsDiv").append(js_tmpl);
        console.log('You Clicked Here');
        $("#dep_bday_" + ctr).datetimepicker({
            format: 'MM/DD/YYYY',
            useCurrent: false
        });

        ctr++;
    });

    $(".datepicker").datepicker({
        changeYear  : true,
        changeMonth : true,
        yearRange   : "1930:<?php echo date("Y") ?>"
    });

    $(".datetimepicker").datetimepicker({
        format: 'MM/DD/YYYY',
        useCurrent: false
    });

    $(".is_reg_event").change(function(){
        var val = $(this).val();
        console.log('type event triggered ' + val);
        if(parseInt(val) == 1)
            $(".reg_div_").show();
        else
            $(".reg_div_").hide();
    });

    $(".reg_div_").hide();
});
</script>
@endsection