@extends('layouts.main')
@section('title')
Employee > View Profile
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
#linkees{
    width: 100%;
    flex-wrap: wrap;
}
#linkees .linkee{
    font-size: 12px;
    padding: 5px;
}
</style>
{{ Form::open(array('url' => 'employee_info/' . $employee->id,'files' => true ,'id' => 'edit_employee_form')) }}
{{ Form::hidden('_method', 'PUT') }}
{{ csrf_field() }}
<div class="col-md-3 p-0">
    <div class="section-header">
        <h4>Profile Picture</h4>
    </div>
    <div class="panel panel-container">
        <div class="row no-padding">
            <div class="text-center">
                <div class="emp-image">
                    <img src="<?= $employee->profile_img ?>" alt="image" />
                </div>
                <br>
                <h4 class="card-title m-t-10"><?= $employee->fullname() ?></h4>
                <h6 class="card-subtitle"><?= $employee->position_name ?></h6>
                <h6 class="card-subtitle"><?= $employee->team_name ?></h6>
                <hr>
            </div>
            <span class="pull-left label-profile">date hired: <i><?= $employee->prettydatehired() ?></i></span>
            <br>
            <br>
        </div>
    </div>
</div>
<div class="col-md-9">
    <div class="section-header">
        <h4>Employee Information</h4>
<?php
    if(empty($myprofile)) {
?>
        <a href="<?= url('employees') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
<?php
    }
?>
    </div>
    <div class="panel panel-body mb-0">
        @include('employee.fields.personalv')
    </div>
<?php
    if(isset($details->fathers_name) || $details->fathers_bday != '1970-01-01' || isset($details->mothers_name) || $details->mothers_bday != '1970-01-01' || isset($details->spouse_name) || $details->spouse_bday != '1970-01-01') {
?>
    <div class="section-header section-subheading">
        <h4>Other Information</h4>
    </div>
    <div class="panel panel-body mb-0">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Father's Name</label>
                    <input class="form-control" name="fathers_name" value="<?= isset($details->fathers_name) ? $details->fathers_name : "" ?>" readonly />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Father's Birthday</label>
                    <input class="form-control" name="fathers_bday" value="<?= $details->fathers_bday == '1970-01-01' ? '' : date("m/d/Y", strtotime($details->fathers_bday )) ?>" autocomplete="off" readonly />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Complete Mother's Maiden Name</label>
                    <input class="form-control" name="mothers_name" value="<?= isset($details->mothers_name) ? $details->mothers_name : "" ?>" readonly />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Mother's Birthday</label>
                    <input class="form-control" name="mothers_bday" value="<?= $details->mothers_bday == '1970-01-01' ? '' : date("m/d/Y", strtotime($details->mothers_bday )) ?>" autocomplete="off" readonly />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Spouse's Name</label>
                    <input class="form-control" name="spouse_name" value="<?= isset($details->spouse_name) ? $details->spouse_name : "" ?>" readonly />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Spouse's Birthday</label>
                    <input class="form-control" name="spouse_bday" value="<?= $details->spouse_bday == '1970-01-01' ? '' : date("m/d/Y", strtotime($details->spouse_bday )) ?>" autocomplete="off" readonly />
                </div>
            </div>
        </div>
    </div>
<?php
    }
    if(!empty($dependents[0]->dependent)) {
?>
    <div class="section-header section-subheading">
        <h4>Dependents Information</h4>
    </div>
    <div class="panel panel-body mb-0">
        <div class="row text-center">
            <div class="col-md-4">
                <div class="form-group">
                    <strong>Dependent's Name</strong>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <strong>Birthday</strong>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <strong>Generali Number</strong>
                </div>
            </div>
        </div>
    <?php
        for($i=0;$i<count($dependents);$i++) {
    ?>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <input class="form-control" name="dependent_name[]" value="<?= $dependents[$i]->dependent ?>" readonly />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input class="form-control" name="dependent_bday[]" value="<?= $dependents[$i]->bday == '1970-01-01' ? '' : date("m/d/Y", strtotime($dependents[$i]->bday)) ?>" autocomplete="off" readonly />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input class="form-control" name="generali_num[]" value="<?= $dependents[$i]->generali_num ?>" autocomplete="off" readonly />
                </div>
            </div>
        </div>
    <?php
        }
    ?>
    </div>
<?php
    }
    if(@$details->em_con_name != '' || @$details->em_con_rel != '' || @$details->em_con_num != '' || @$details->em_con_address != '') {
?>
    <div class="section-header section-subheading">
        <h4>In Case of Emergency</h4>
    </div>
    <div class="panel panel-body mb-0">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>In case of emergency please contact.</label>
                    <input type="text" name="em_con_name" class="form-control" value="<?= @$details->em_con_name ?>" readonly />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Relationship</label>
                    <input type="text" name="em_con_rel" class="form-control" value="<?= @$details->em_con_rel ?>" readonly />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Contact Number</label>
                    <input type="text" name="em_con_num" class="form-control" value="<?= @$details->em_con_num ?>" readonly />
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Address</label>
                    <textarea name="em_con_address" class="form-control" rows="4" readonly><?= @$details->em_con_address ?></textarea>
                </div>
            </div>
        </div>
    </div>
<?php
    }
?>
    <div class="section-header section-subheading">
        <h4>User Access</h4>
    </div>
    <div class="panel panel-body mb-0">
        @include('employee.fields.user_accessv')
    </div>
<?php
    if(count($linkees) > 0) {
?>
    <div class="section-header section-subheading">
        <h4>Linkees</h4>
    </div>
    <div class="panel panel-body mb-0">
        <div class="row">
            <div class="col-md-12">
                <div class="my-2 d-flex gap-2 p-2" id="linkees">
                <?php
                    foreach($linkees as $linkee) {
                ?>
                    <div class="border border-success rounded-pill linkee" id="linkee-<?= $linkee->id ?>">
                        <span><?= $linkee->last_name ?>, <?= $linkee->first_name ?></span>
                    </div>
                <?php
                    }
                ?>
                </div>
            </div>
        </div>
    </div>
<?php
    }
?>
    <div class="section-header section-subheading">
        <h4>Job Related</h4>
    </div>
    <div class="panel panel-body mb-0">
        @include('employee.fields.job_relatedv')
    </div>
<?php
    if(@$employee->sss != '' || @$employee->pagibig != '' || @$employee->philhealth != '' || @$employee->tin != '') {
?>
    <div class="section-header section-subheading">
        <h4>Government Numbers</h4>
    </div>
    <div class="panel panel-body mb-0">
        @include('employee.fields.governmentv')
    </div>
<?php
    }
?>
    <div class="section-header section-subheading">
        <h4>Login Credentials</h4>
    </div>
    <div class="panel panel-body">
        @include('employee.fields.loginv')
        <div class="col-md-12">
        @auth
        @if(Auth::user()->id == $employee->id && !empty($myprofile))
            <br>
            <div class="row">
                <div class="col-md-3 d-flex">
                    <a type="button" class="btn btn-default" href="<?= url("employee/{$employee->id}/changepassword") ?>">Change Password</a>
                    &nbsp;
                    <a class="btn btn-primary" href="<?= url('update-profile') ?>">Update Selected Information</a>
                </div>
            </div>
        @endif
        @if(Auth::user()->isAdmin() && empty($myprofile))
            <br>
            <div class="row">
                <div class="col-md-12">
                    <a type="button" class="btn btn-default" href="<?= url("employee/{$employee->id}/changepassword") ?>">Change Password</a>
                    @if($employee->isActive())
                    <a class="btn btn-primary" href="<?= url("employee_info/{$employee->id}/edit") ?>">Update Profile</a>
                    <a href="#" class="pull-right btn btn-danger delete_btn" data-toggle="modal" data-target="#messageModal" data-id="<?= $employee->id ?>">Deactivate Employee</a>
                    @else
                    <a class="btn btn-primary" href="<?= url("employees/{$employee->id}/reactivate") ?>">Reactivate Employee</a>
                    @endif
                </div>
            </div>
        @endif
        @endauth
        </div>
    </div>
</div>
{{ Form::close() }}
<div id="messageModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Deactivate Employee</h4>
            </div>
            <div class="modal-body">
                <p id="message">Are you sure to deactivate this employee?</p>
            </div>
            <div class="modal-footer">
                {{ Form::open(array('url' => 'employee_info/'. $employee->id, 'class' => ' delete_form' )) }}
                {{ Form::hidden('_method', 'DELETE') }}
                {{ Form::submit('Yes', array('class' => 'btn btn-danger')) }}
                {{ Form::close() }}
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script id="tmpl_addDependents" type="text/template">
<div id="dep_~id~" class="row">
    <div class="col-md-4">
        <div class="form-group">
            <input type="text" id="dep_name_~id~" class="form-control" name="dependent_name[]" readonly />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <input type="text" id="dep_bday_~id~" class="form-control datetimepicker" name="dependent_bday[]" readonly />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <input type="text" id="dep_generali_~id~" class="form-control" name="generali_num[]" readonly />
        </div>
    </div>
</div>
</script>
<script type="text/javascript">
var changed = false;
var ctr = 1;

$(function(){
<?php
    if(count($dependents) > 1):
        for($i = 1; $i < count($dependents); $i++):
?>
            addDep();
            $("#dep_name_" + <?php echo $i ?>).val("<?php echo $dependents[$i]->dependent ?>");
            $("#dep_bday_" + <?= $i ?>).val("<?= $dependents[$i]->bday == '1970-01-01' ? '' : date("m/d/Y",strtotime($dependents[$i]->bday)) ?>");
            $("#dep_generali_" + <?= $i ?>).val("<?= $dependents[$i]->generali_num ?>");
<?php
        endfor;
    endif;
?>
});

<?php
    if(empty($myprofile)) {
?>
    activeMenu($('#menu-active-employees'));
<?php
    }
?>

    $('#edit_employee_form').validate({
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

    $('#image_uploader').change(function(){
        changed = true;
    });

     $('input').change(function(){
        changed = true;
     });

     $('select').change(function(){
        changed = true;
     });

     $('#edit_employee_form').submit(function(){
        changed = false;
     });

    window.onbeforeunload = function(){
        if(changed){
            return '';
        }
    }

    $(".is_reg_event").change(function(){
        var val = $(this).val();
        console.log('type event triggered ' + val);
        if(parseInt(val) == 1)
            $(".reg_div_").show();
        else
            $(".reg_div_").hide();
    });

    if($(".is_reg_event").val() == 1)    
        $(".reg_div_").show();
    else
        $(".reg_div_").hide();

    $(".add-dependent").click(function(e){
        e.preventDefault();
        console.log(ctr);
        addDep();
    });

    $(".datepicker").datepicker({
        changeYear  : true,
        changeMonth : true,
        yearRange   : "1930:<?php echo date("Y") ?>"
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

    function removeThisDependent(obj){
        var id = $(obj).data('id');
        $("#dep_" + id).remove();
    }

    function addDep(){
        var template = document.getElementById("tmpl_addDependents").innerHTML;
        var js_tmpl = "";
        js_tmpl = template.replace(/~id~/g,ctr);
        $("#dependentsDiv").append(js_tmpl);
        console.log('You Clicked Here');
        $("#dep_bday_" + ctr).datepicker({
            changeYear  : true,
            changeMonth : true,
            yearRange   : "1930:<?php echo date("Y") ?>"
        });
        ctr++;
    }
</script>
@endsection