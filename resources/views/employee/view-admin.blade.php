@extends('layouts.main')
@section('title')
Employee > View Profile
@endsection
@section('content')
<style type="text/css">
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
    .employee-details-value{
        font-size: 16px;
        line-height: 21px;
        padding-bottom: 10px;
        color: #000;
    }
    .label-profile{
        padding-left: 15px; 
        padding-right: 15px;
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
</style>
<br>
{{ Form::open(array('url' => 'employee_info/' . $employee->id,'files' => true ,'id' => 'edit_employee_form')) }}
{{ Form::hidden('_method', 'PUT') }}
{{ csrf_field() }}
    <div class="col-md-3" style="padding-left: 10px !important; padding-right: 10px;">
        <div class="section-header">
            <h4>Profile Picture</h4>
        </div>
        <div class="panel panel-container">
            <div class="row no-padding">
                <div class="text-center">
                    <img alt="Profile Image" id="profile_image" style="width: 150px;margin-top: 30px;" src="<?= $employee->profile_img ?>">
                    <br> 
                    <br>
                    <label id="bb" class="btn btn-default" style="margin:0 auto;"> Upload Photo
                        <input id="image_uploader" type="file" class="btn btn-small" value="" onchange="previewFile()"  name="profile_image"/>
                    </label>    
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
        </div>
        <div class="panel panel-body mb-0">
            @include('employee.fields.personalv')
        </div>
        <div class="section-header section-subheading">
            <h4>Other Information</h4>
        </div>
        <div class="panel panel-body mb-0">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Father's Name</label>
                        <input class="form-control" name="fathers_name" value="<?= isset($details->fathers_name) ? $details->fathers_name : "" ?>" readonly="1">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Father's Birthday</label>
                        <input class="form-control" readonly="1" name="fathers_bday" value="<?= isset($details->fathers_bday) ? date("m/d/Y", strtotime($details->fathers_bday )) : "" ?>" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Complete Mother's Maiden Name</label>
                        <input class="form-control" name="mothers_name" value="<?= isset($details->mothers_name) ? $details->mothers_name : "" ?>" readonly="1">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Mother's Birthday</label>
                        <input class="form-control" readonly="1" name="mothers_bday" value="<?= isset($details->mothers_bday) ? date("m/d/Y", strtotime($details->mothers_bday )) : "" ?>" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Spouse's Name</label>
                        <input class="form-control" placeholder="Spouse's Name" name="spouse_name" value="<?= isset($details->spouse_name) ? $details->spouse_name : "" ?>" readonly="1">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Spouse's Birthday</label>
                        <input class="form-control" placeholder="Spouse's Birthday" readonly="1" name="spouse_bday" value="<?= $details->spouse_bday == '1970-01-01' ? '' : date("m/d/Y", strtotime($details->spouse_bday )) ?>" autocomplete="off">
                    </div>
                </div>
            </div>
        </div>
<?php
    if(!empty($dependents[0]->dependent)) {
?>
        <div class="section-header section-subheading">
            <h4>Dependents Information</h4>
        </div>
        <div class="panel panel-body mb-0">
        <?php
            for($i=0;$i<count($dependents);$i++) {
        ?>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Dependent's Name</label>
                        <input class="form-control" readonly="1" name="dependent_name[]" value="<?= $dependents[$i]->dependent ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Birthday</label>
                        <input class="form-control" readonly="1" name="dependent_bday[]" value="<?= date("m/d/Y",strtotime($dependents[$i]->bday)) ?>" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Generali Number</label>
                        <input class="form-control" name="generali_num[]" value="<?= $dependents[$i]->generali_num ?>" autocomplete="off" readonly="1">
                    </div>
                </div>
            </div>
        <?php
            }
        ?>
        </div>
<?php
    }
?>
        <div class="section-header section-subheading">
            <h4>In Case of Emergency</h4>
        </div>
        <div class="panel panel-body mb-0">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>In case of emergency please contact.</label>
                        <input type="text" name="em_con_name" readonly="1" class="form-control" value="<?= @$details->em_con_name ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Relationship</label>
                        <input type="text" name="em_con_rel" readonly="1" class="form-control" value="<?= @$details->em_con_rel ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Contact Number</label>
                        <input type="text" name="em_con_num" readonly="1" class="form-control" value="<?= @$details->em_con_num ?>">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Address</label>
                        <textarea name="em_con_address" readonly="1" class="form-control" rows="4"><?= @$details->em_con_address ?></textarea>
                    </div>
                </div>
            </div>
        </div>
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
                    <div class="my-2 d-flex gap-2  p-2" style="width: 100%;flex-wrap: wrap;" id="linkees">
                    <?php
                        foreach($linkees as $linkee) {
                    ?>
                        <div class="border border-success rounded-pill p-2" id="linkee-<?= $linkee->id ?>"
                            style="font-size: 12px; min-width:100px;">
                            <input type="hidden" name="linkee-<?= $linkee->id ?>" value="<?= $linkee->id ?>">
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
        <div class="section-header section-subheading">
            <h4>Government Numbers</h4>
        </div>
        <div class="panel panel-body mb-0">
            @include('employee.fields.governmentv')
        </div>
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
                    <div class="col-md-3" style="display: flex;">
                        <a type="button" class="btn btn-default" href="{{url('employee/'. $employee->id .'/changepassword')}}">Change Password</a>
                        &nbsp;
                        <a class="btn btn-primary" href="/update-profile">Update Selected Information</a>
                    </div>
                </div>
            @endif
            @if(Auth::user()->isAdmin() && empty($myprofile))
                <br>
                <div class="row">
                    <div class="col-md-12" >
                        <a type="button" class="btn btn-default" href="{{url('employee/'. $employee->id .'/changepassword')}}">Change Password</a>
                        @if($employee->isActive())
                        <a class="btn btn-primary" href="{{url('employee_info/' . $employee->id . '/edit')}}">Update Profile</a>
                        <a href="#"  class="pull-right btn btn-primary delete_btn" data-toggle="modal" data-target="#messageModal"  data-id="{{$employee->id}}" style="background: red !important; border-color: red !important;">Deactivate Employee</a>
                        @else
                        <a class="btn btn-primary" href="{{url('employees/' . $employee->id . '/reactivate')}}">Reactivate Employee</a>
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
    <div class="col-md-4 form-group">
        <label>Dependent's Name</label>
        <br>
        <input readonly="1" id="dep_name_~id~" class="form-control" name="dependent_name[]" value="">
    </div>
    <div class="col-md-4 form-group">
        <label>Birthday</label>
        <br>
        <input id="dep_bday_~id~" readonly="1" class="form-control" name="dependent_bday[]" value="" autocomplete="off">
    </div>
    <div class="col-md-3 form-group">
        <label>Generali Number</label>
        <br>
        <input class="form-control" name="generali_num[]" value="<?php echo count($dependents) > 0 ? $dependents[0]->generali_num : "" ?>" autocomplete="off" readonly="1">
    </div>
    <div class="col-md-4 form-group" style="vertical-align: middle;">
        <br>
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
            $("#dep_bday_" + <?php echo $i ?>).val("<?php echo date("m/d/Y",strtotime($dependents[$i]->bday)) ?>")
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
//  $('input[name=employee_type]').change(function(){
//     switch($(this).val()){
//         case '2':
//              $('select[name=supervisor_id]').parent().parent().show();
//              $('select[name=manager_id]').parent().parent().show();
//              $('input[name=all_access]').parent().parent().show();
//         break;
//         case '3':
//             console.log('sulod');
//             $('select[name=supervisor_id]').parent().parent().hide();
//              $('input[name=all_access]').parent().parent().show();
//         break;
//         case '4':
//              $('select[name=supervisor_id]').parent().parent().hide();
//              $('select[name=manager_id]').parent().parent().hide();
//              $('input[name=all_access]').parent().parent().show();
//         break;
//         case '1':
//              $('select[name=supervisor_id]').parent().parent().show();
//              $('select[name=manager_id]').parent().parent().show();
//              $('input[name=all_access]').parent().parent().hide();
//         break;
//     }
// });
// $('input[name=employee_type]').trigger('change');

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