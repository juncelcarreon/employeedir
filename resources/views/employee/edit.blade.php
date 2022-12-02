@extends('layouts.main')
@section('title')
Employee > Edit Employee Profile
@endsection
@section('content')
<link rel="stylesheet" href="{{asset('./css/custom-bootstrap.css')}}">
<style type="text/css">
    .card-title{
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
    .employee-details-value{
        font-size: 16px;
        line-height: 21px;
        padding-bottom: 10px;
        color: black;
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
{{ Form::open(array('url' => 'employee_info/' . $employee->id,'files' => true ,'id' => 'edit_employee_form')) }}
{{ Form::hidden('_method', 'PUT') }}
{{ csrf_field() }}
<div class="col-md-3" style="padding-left: 0 !important; padding-right: 0 !important;">
    <div class="section-header">
        <h4>Profile Picture</h4>
    </div>
    <div class="panel panel-container">
        <div class="row no-padding">
            <div class="text-center">
                <img src="<?= $employee->profile_img ?>" alt="Profile Image" id="profile_image" class="img-circle" style="width: 150px;margin-top: 30px;"/>
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

        <a href="<?= url()->previous() ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
    </div>
    <div class="panel panel-body mb-0">
        @include('employee.fields.personal')
    </div>
    <div class="section-header section-subheading">
        <h4>Other Information</h4>
    </div>
    <div class="panel panel-body mb-0">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Father's Name</label>
                    <input class="form-control" name="fathers_name" value="<?= isset($details->fathers_name) ? $details->fathers_name : "" ?>" placeholder="Father's Name" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Father's Birthday</label>
                    <input class="form-control datetimepicker" name="fathers_bday" value="<?= $details->fathers_bday == '1970-01-01' ? '' : date("m/d/Y", strtotime($details->fathers_bday )) ?>" placeholder="MM/DD/YYYY" autocomplete="off" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Complete Mother's Maiden Name</label>
                    <input class="form-control" name="mothers_name" value="<?= isset($details->mothers_name) ? $details->mothers_name : "" ?>" placeholder="Mother's Maiden Name" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Mother's Birthday</label>
                    <input class="form-control datetimepicker" name="mothers_bday" value="<?= $details->mothers_bday == '1970-01-01' ? '' : date("m/d/Y", strtotime($details->mothers_bday )) ?>" placeholder="MM/DD/YYYY" autocomplete="off" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Spouse's Name</label>
                    <input class="form-control" name="spouse_name" value="<?= isset($details->spouse_name) ? $details->spouse_name : "" ?>" placeholder="Spouse's Name" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Spouse's Birthday</label>
                    <input class="form-control datetimepicker" name="spouse_bday" value="<?= $details->spouse_bday == '1970-01-01' ? '' : date("m/d/Y", strtotime($details->spouse_bday )) ?>" placeholder="MM/DD/YYYY" autocomplete="off" />
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
                    <input class="form-control" name="dependent_name[]" value="<?= count($dependents) > 0 ? $dependents[0]->dependent : "" ?>" placeholder="Dependent's Name" />
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <input class="form-control datetimepicker" name="dependent_bday[]" value="<?= count($dependents) > 0 ? ($dependents[0]->bday == '1970-01-01' ? '' : date("m/d/Y",strtotime($dependents[0]->bday))) : '' ?>" placeholder="MM/DD/YYYY" autocomplete="off" />
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <input class="form-control" name="generali_num[]" value="<?= count($dependents) > 0 ? $dependents[0]->generali_num : "" ?>" placeholder="xxxx-xxx-xxxx" autocomplete="off" />
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <button class="btn btn-primary add-dependent" style="width: 100%;"><span class="fa fa-plus"></span></button>
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
                    <input type="text" name="em_con_name" class="form-control" value="<?= @$details->em_con_name ?>" placeholder="Contact Name" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Relationship</label>
                    <input type="text" name="em_con_rel" class="form-control" value="<?= @$details->em_con_rel ?>" placeholder="Relationship" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Contact Number</label>
                    <input type="text" name="em_con_num" class="form-control" value="<?= @$details->em_con_num ?>" placeholder="xxxx-xxx-xxxx" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Address</label>
                    <textarea name="em_con_address" class="form-control" rows="4"><?= @$details->em_con_address ?></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="section-header section-subheading">
        <h4>User Access</h4>
    </div>
    <div class="panel panel-body mb-0">
        @include('employee.fields.user_access')
    </div>
    <div class="section-header section-subheading">
        <h4>Linkees</h4>
    </div>
    <div class="panel panel-body mb-0">
        <div class="row">
            <div class="col-md-12">
                <div class="my-2 d-flex gap-2 p-2" style="width: 100%;flex-wrap: wrap;" id="linkees">
                    <?php
                    foreach($linkees as $linkee) {
                    ?>
                        <div class="border border-success rounded-pill p-1" id="linkee-<?= $linkee->id ?>" style="font-size: 12px; min-width:100px;">
                            <input type="hidden" name="linkee-<?= $linkee->id ?>" value="<?= $linkee->id ?>">
                            <span class="ms-2"><?= $linkee->last_name ?>, <?= $linkee->first_name ?></span>
                            <button type="button" class="btn btn-sm" onclick="deleteNodeAndData(document.getElementById('linkee-<?= $linkee->id ?>'))">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </button>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="d-flex gap-2" style="max-width: 80%;">
                <?php
                if(Auth::user()->isAdmin() || Auth::user()->isHR()) {
                ?>
                    <select name="adtl_linkees" id="linkees_list" data-val="1" class="select2 process_linkee form-control">
                        <option value="">Select a Linkee</option>
                        <?php
                        foreach($supervisors as $s) {
                        ?>
                            <option value="<?= $s->id ?>"><?= $s->fullname() ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <div>
                        <button type="button" id="addLinkeeBtn" class="btn btn-primary ">Add a Linkee</button>
                    </div>
                <?php
                }
                ?>
                </div>
                <template id="linkee_template">
                    <div class="border border-success rounded-pill p-2" id="linkee-" style="font-size: 12px; min-width:100px;">
                        <input type="hidden" name="linkee-" value="">
                        <span></span>
                        <button type="button" class="btn btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                            </svg>
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </div>
    <div class="section-header section-subheading">
        <h4>Job Related</h4>
    </div>
    <div class="panel panel-body mb-0">
        @include('employee.fields.job_related')
    </div>
    <div class="section-header section-subheading">
        <h4>Government Numbers</h4>
    </div>
    <div class="panel panel-body mb-0">
        @include('employee.fields.government')
    </div>
    <div class="section-header section-subheading">
        <h4>Login Credentials</h4>
    </div>
    <div class="panel panel-body">
        @include('employee.fields.login')
        <div class="col-md-12">
            <br>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Save" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
<!-- Modal -->
<div class="modal fade" id="modalMovements" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Staff Position Movements</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body" style="max-height:500px; height: 450px; overflow: auto;">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th scope="col">Date of Transfer</th>
              <th scope="col">Department</th>
              <th scope="col">Position</th>
            </tr>
      
          </thead>
          <tr style="background-color: #fd9a47;">
              <td><input class="form-control datetimepicker" id="mv_transfer_date"></td>
              <td>
                  <select class="select2 form-control" id="department_name" style="width: 100%">
                    <option selected="" disabled="">Select</option>
                    @foreach($departments as $department)
                        <option <?php echo $department->department_name == @$employee->team_name ? "selected" : "";?> value="{{ $department->id }}"> {{$department->department_name}}</option>
                    @endforeach
                </select>
              </td>
              <td>
                <input class="form-control" id="mv_position" value="" list="positions" required>
                <datalist id="positions">
                    @foreach($positions as $position)
                        <option value="{{ $position->position_name }}">
                    @endforeach
                </datalist>
              </td>
          </tr>
          <tbody id="mdl_bodyMvmt">
          </tbody>
        </table>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="savingOption" type="button" class="btn btn-primary" data-dismiss="modal">Save changes</button>
        <input type="hidden" id="active-employee-id" value="{{ $employee->id }}">
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script id="tmpl_rowMvmt" type="text/template">
    <tr>
        <td scope="row">~mv_transfer_date~</td>
        <td>~department_name~</td>
        <td>~mv_position~</td>
    </tr>
</script>
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
            <input type="text" id="dep_generali_~id~" class="form-control" name="generali_num[]" placeholder="xxxx-xxx-xxxx" autocomplete="off" />
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <a href="javascript:;" class="btn btn-danger" data-id="~id~" onclick="removeThisDependent(this)" style="width: 100%;"><span class="fa fa-minus"></span></a>
        </div>
    </div>
</div>
</script>
<script id="tmpl_addLinkee" type="text/template">
    <div id="linkee_row_~id~" class="row">
        <div class="col-md-5">
            <div class="form-group">
                <select id="sl_linkee_~id~" data-val="~id~" name="adtl_linkees[]" class="select2 process_linkee form-control">
                    <option value="0">Select a Linkee</option>
                    <?php
                    foreach($supervisors as $s) {
                    ?>
                    <option value="<?= $s->id ?>"><?= $s->fullname() ?></option>
                    <?php
                    }
                    ?>
                </select>
                <input type="hidden" id="hidden_id_~id~" value="">
            </div>
        </div>
        <div class="col-md-1">
            <a href="#u_access-div" class="btn btn-danger" onclick="removeThisLinkee(~id~)">Remove Linkee</a>
        </div>
    </div>
</script>
<script type="text/javascript">
var changed = false;
var ctr = 1;
var emp_no = {{ @$employee->id }};
var csrf_token = $('meta[name="csrf-token"]').attr('content');
var ctr_linkee = 2;

$.ajaxPrefilter(function(options, originalOptions, jqXHR){
    if (options.type.toLowerCase() === "post") {
        options.data = options.data || "";
        options.data += options.data?"&":"";
        options.data += "_token=" + encodeURIComponent(csrf_token);
    }
});

window.onbeforeunload = function(){
    if(changed){
        return '';
    }
}

const createNodeUsingTemplate = ({data}) => {
    let cloneTemplate = document.getElementById('linkee_template').content.cloneNode(true)
    let app = document.getElementById('linkees');

    let div = cloneTemplate.querySelector('div');
    let span = cloneTemplate.querySelector('span');
    let button = cloneTemplate.querySelector('button');
    let input = cloneTemplate.querySelector('input');

    div.id = "linkee-"+data.id
    input.name = "linkee-"+data.id
    input.value = data.id
    span.innerText = data.last_name +" "+data.first_name
    app.appendChild(cloneTemplate)
    button.setAttribute("onclick",`deleteNodeAndData(document.getElementById('${div.id}'))`)
}

const deleteNodeAndData = async(node) => {
    let input = node.querySelector('input')

    let confirmmed = confirm('Are you sure you would like to remove this linkee?')
    if(confirmmed){
        let response = await fetch('{{route('remove-linkees')}}',{
            method: 'post',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                '_token': '{{csrf_token()}}',
                'adtl_linkee': input.value,
                'adtl_linker': '{{$employee->id}}'
            })
        });

        response = await response.json()
        if(response.data){
            node.remove();
        }
    }
}

document.getElementById('addLinkeeBtn').addEventListener('click', async(e) => {
    e.preventDefault();

    let linkee = document.getElementById('linkees_list').value;
    let response = await fetch('{{route('add-linkees')}}', {
        method: 'post',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            '_token': '{{csrf_token()}}',
            'adtl_linker': '{{$employee->id}}',
            'adtl_linkee': linkee,
            'adtl_row': '1',
        })
    });

    response = await response.json()
    if(response.data){
        createNodeUsingTemplate(response)
    }
});

function removeThisLinkee(id){
    console.log(id);
}

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
    $("#dep_bday_" + ctr).datetimepicker({
        format: 'MM/DD/YYYY',
        useCurrent: false
    });
    ctr++;
}
$(function(){
    activeMenu($('#menu-active-employees'));

<?php
    if(count($dependents) > 1) {
        for($i = 1; $i < count($dependents); $i++) {
        ?>
        addDep();
        $("#dep_name_" + <?= $i ?>).val("<?= $dependents[$i]->dependent ?>");
        $("#dep_bday_" + <?= $i ?>).val("<?= $dependents[$i]->bday == '1970-01-01' ? '' : date("m/d/Y",strtotime($dependents[$i]->bday)) ?>");
        $("#dep_generali_" + <?= $i ?>).val("<?= $dependents[$i]->generali_num ?>");
        <?php
        }
    }
?>

    $("#_team_name").change(function(){
        var val = $(this).find(':selected').data('_dept_code');
        $("#_dept_code").val(val);
    });

    $("#btnViewMovments").click(function(x){
        x.preventDefault();
        $.get('/browse-transfer',{emp_no  : emp_no},function(data){
            var template = document.getElementById("tmpl_rowMvmt").innerHTML;
            var js_tmpl = "";
            $.each(data,function(key,val){
                js_tmpl += template
                    .replace(/~mv_transfer_date~/g,val.mv_transfer_date)
                    .replace(/~department_name~/g,val.department_name)
                    .replace(/~mv_position~/g,val.mv_position);
            });
            $("#mdl_bodyMvmt").html(js_tmpl);
        },'json');
    });

    $("#savingOption").click(function(x){
        x.preventDefault();
        var obj = {
            mv_employee_no      : emp_no,
            mv_transfer_date    : $("#mv_transfer_date").val(),
            mv_dept             : $("#department_name").val(),
            dept_name           : $("#department_name option:selected").text(),
            mv_position         : $("#mv_position").val()
        };
        console.log(obj);
        $.post("/save-transfer",obj,function(x){
            location.reload();
        },'json');
    });

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

    $(".datetimepicker").datetimepicker({
        format: 'MM/DD/YYYY',
        useCurrent: false
    });

    $(".is_reg_event").change(function(){
        var val = $(this).val();
        if(parseInt(val) == 1)
            $(".reg_div_").show();
        else
            $(".reg_div_").hide();
    });

    $(".reg_div_").hide();
});
</script>
@endsection
