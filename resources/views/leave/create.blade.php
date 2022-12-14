@extends('layouts.main')
@section('title')
Leave > File a Leave
@endsection
@section('head')
<style type="text/css">
@include('leave.style');
</style>
@endsection
@section('breadcrumb')
Leave <span>></span> File a Leave
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <form action="<?= url('leave') ?>" method="post" id="leave_form" autocomplete="off">
            {{ csrf_field() }}
            <div class="panel panel-default mb-0">
                <div class="panel-heading">
                    LEAVE APPLICATION FORM

                    <a href="<?= url('leave') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
                </div>
                <div class="panel-body timeline-container mb-0">
                    <div class="flex-center position-ref full-height">
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                $pto_forwarded = $credits->past_credit - $credits->conversion_credit;
                                $pto_accrue = $credits->current_credit;
                                $loa = abs($credits->loa);
                                $use_jan_jun = $credits->used_jan_to_jun;
                                $pto_expired = $credits->expired_credit;
                                $balance = $pto_forwarded + $pto_accrue - $loa - $use_jan_jun - $pto_expired;
                                ?>
                                <table class="table table-striped" id="leave_credits_table">
                                    <thead>
                                        <tr>
                                            <th><?= date('Y') - 1 ?> PTO<br>Forwarded</th>
                                            <th><?= date('Y') ?> PTO<br>Monthly Accrual</th>
                                            <th>Used PTO<br>(Jan-Jun)</th>
                                            <th>Used PTO<br>(Jul-Dec)</th>
                                            <th>Current PTO Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?= number_format($credits->past_credit - $credits->conversion_credit,2) ?></td>
                                            <td><?= number_format($credits->monthly_accrual,2) ?></td>
                                            <td><?= number_format($credits->used_jan_to_jun,2) ?></td>
                                            <td><?= number_format($credits->used_jul_to_dec,2) ?></td>
                                            <td class="td-total">
                                                <?= $credits->is_regular == 1 ? number_format($credits->current_credit, 2) : '0.00' ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Name: </strong>
                                    <?php
                                        if(Auth::user()->isAdmin()) {
                                    ?>
                                    <select name="employee_id" class="form-control select2" <?= Auth::user()->isAdmin() ? '' : 'readonly' ?>>
                                        <?php
                                        foreach($employees as $employee) {
                                        ?>
                                            <option value="<?= $employee->id ?>" data-position="<?= $employee->position_name ?>" data-department="<?= $employee->team_name ?>" <?= Auth::user()->id == $employee->id ? ' selected' : '' ?>><?= $employee->fullName2() ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <?php
                                        } else {
                                    ?>
                                    <input type="hidden" name="employee_id" value="<?= Auth::user()->id ?>">
                                    <input type="text" name="employee_name" class="form-control" placeholder="Employee Name" value="<?= Auth::user()->fullName2() ?>" readonly>
                                    <?php
                                        }
                                    ?>
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Position: </strong>
                                    <input type="text" name="position" class="form-control" placeholder="Position" value="<?= Auth::user()->position_name ?>" readonly>
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Department: </strong>
                                    <input type="text" name="department" class="form-control" placeholder="Dept/Section" value="<?= Auth::user()->team_name ?>" readonly>
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Date Filed: </strong>
                                    <input type="text" value="<?= date('m/d/Y') ?>" name="date_filed" class="form-control" placeholder="Date Filed" readonly>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-heading panel-subheading">
                    LEAVE DATES

                    <input type="text" name="number_of_days" value="1" class="form-control _numOfDaysField" list="leave_days" id="number_of_days" placeholder="No. of Days" readonly>
                </div>
                <div class="panel-body timeline-container">
                    <div class="flex-center position-ref full-height">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <strong>Leave Date: </strong>
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Length: </strong>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>With/Without Pay: </strong>
                                </div>
                            </div>
                        </div>
                        <div class="entry-content">
                            <div class="row entry-row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input id="main_date_picker" type="text" name="leave_date[]" class="form-control _datesFiled" placeholder="Leave Date" required>
                                    </div> 
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select name="length[]" class="form-control _lengthDaySel">
                                            <option value="1">Whole Day</option>
                                            <option value="0.5">Half Day</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select id="mainPayType" name="pay_type[]" class="form-control _thisPayType<?= ($credits->is_regular == 1) ? ((floor($credits->current_credit) > 0) ? '' : ' non_reg') : ' non_reg' ?>">
                                            <option value="0">Without Pay</option>
                                            <option value="1">With Pay</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary width-100" id="_addLeaveItem">
                                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="_date_form"></div>
                    </div>
                </div>
                <div class="panel-heading panel-subheading">
                    LEAVE TYPE
                </div>
                <div class="panel-body timeline-container">
                    <div class="flex-center position-ref full-height">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <strong>Leave Category: </strong>
                                    <select name="pay_type_id" class="form-control _leaveCategory">
                                        <option value="1">Planned</option>
                                        <option value="2">Unplanned</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <strong>Type of Leave: </strong>
                                    <ul class="list-group list-group-flush">
                                    <?php
                                    foreach($leave_types as $lv) {
                                        if($lv->status == 1) {
                                    ?>
                                        <li class="list-group-item _planned">
                                            <label class="switch float-left">
                                                <input type="checkbox" name="<?= ($lv->id == 8) ? 'leave_cto' : 'leave_type_id' ?>" value="<?= $lv->id ?>" id="progress<?= $lv->id ?>" class="primary" <?= $lv->id == 5 ? ' checked' : '' ?>>
                                                <span class="slider"></span>
                                            </label>&nbsp;
                                            <span><?= $lv->leave_type_name ?></span>
                                        </li>
                                    <?php
                                        } else {
                                    ?>
                                        <li class="list-group-item _unplanned">
                                            <label class="switch float-left">
                                                <input type="checkbox" name="leave_type_id" value="<?= $lv->id ?>" id="progress<?= $lv->id  ?>" tabIndex="1" class="primary" onClick="ckChange(this)"<?= $lv->id == 5 ? ' checked' : '' ?>>
                                                <span class="slider"></span>
                                            </label>&nbsp;
                                            <span><?= $lv->leave_type_name ?></span>
                                        </li>
                                    <?php
                                        }
                                    }
                                    ?>
                                    </ul>
                                </div>
                            </div>
                            <?php
                            if($is_leader > 0) {
                            ?>
                            <div class="col-md-4" id="cto-data">
                                <div class="form-group cto-dates">
                                    <strong>CTO Dates: </strong>
                                    <input type="text" name="cto_date[]" class="form-control cto_datepicker" placeholder="CTO Date">
                                    <button type="button" class="btn btn-primary" id="_addCTODay">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    </button>
                                </div>
                                <div id="cto-dates"></div>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="panel-heading panel-subheading">
                    OTHER INFORMATION
                </div>
                <div class="panel-body timeline-container">
                    <div class="flex-center position-ref full-height">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="report-date-box">
                                    <q>I will report for work on 
                                    <input type="text" name="report_date" class="datepicker" placeholder="date" required>
                                    If i fail to do so on the said date without any justifiable cause.
                                    I can considered to have abandoned my employment. I understand that any misrepresentation I make on this request is a serious offense and shall be a valid ground for disciplinary action against me.</q>
                                </div>
                            </div>
                        </div>
                        <div class="division"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Reason: </strong>
                                <textarea name="reason" class="form-control" rows="4" required></textarea>
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Contact Number: </strong>
                                <input type="text" name="contact_number" class="form-control" required>
                            </div> 
                        </div>
                        <div class="form-group">
                            <input type="submit" id="register-button" class="btn btn-primary" value="Submit">
                            <input type="reset" class="btn btn-default" value="Reset">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script id="tmpl_addLeaveDay" type="text/template">
<div id="row_~~id~~" class="row">
    <div class="col-md-4">
        <div class="form-group">
            <input id="date_picker_~~id~~"  type="text" name="leave_date[]" class="form-control _datesFiled" placeholder="Leave Date" required>
        </div> 
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <select id="sel_ctr_~~id~~" name="length[]" class="form-control _lengthDaySel" onchange="computeTotalField()">
                <option value="1">Whole Day</option>
                <option value="0.5">Half Day</option>
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <select id="Pay_~~id~~_" name="pay_type[]" class="form-control _thisPayType<?= ($credits->is_regular == 1) ? ((floor($credits->current_credit) > 0) ? '' : ' non_reg') : ' non_reg' ?>" onchange="computeLeaveCredits(this);">
                <option value="0">Without Pay</option>
                <option value="1">With Pay</option>
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <button type="button" data-id="~~id~~" class="btn btn-danger width-100" onclick="removeThisLeave(this)">
                <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
            </button>
        </div>
    </div>
</div>
</script>
<script id="tmpl_addCTODay" type="text/template">
<div class="form-group cto-dates" id="cto_~~id~~">
    <input type="text" name="cto_date[]" class="form-control cto_datepicker" placeholder="CTO Date">
    <button type="button" class="btn btn-danger" data-id="~~id~~" onclick="removeCTO(this)">
        <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
    </button>
</div>
</script>
<script type="text/javascript">
var leave_credits = Math.floor({{ $credits->current_credit }});
var usePay = 0;
var locked_days = [<?php foreach($blocked_dates as $b) { echo '"'.$b.'"'.","; } ?>];
var ctr = 1;

function computeLeaveCredits(obj){
    var val = $(obj).val();

    if(val == 1){
        usePay = 1;
        leave_credits -= 1;
    }
    else{
        if(usePay){
            leave_credits += 1;
            usePay = 0;
        }
    }
    console.log('val: ' + val);
    console.log('leave_credits: ' + leave_credits);
}  

function computeTotalField(){
    var total = 0;
    var val = 0;
    $("._lengthDaySel").each(function(){
        val = $(this).val();
        total += parseFloat(val);
    });
    $("._numOfDaysField").val(total);
    return total;
}

function removeThisLeave(obj){
    var id = $(obj).data('id');
    $("#row_" + id).remove();
    computeTotalField();
}

function removeCTO(obj){
    var id = $(obj).data('id');
    $("#cto_" + id).remove();
}

function ckChange(ckType){
    var ckName = document.getElementsByName(ckType.name);
    var checked = document.getElementById(ckType.id);

    if (checked.checked) {
        for(var i=0; i < ckName.length; i++){

            if(ckName[i] != checked){
                $(ckName[i]).prop('checked', false);
            }
        } 
    }    
}

function lockDateInit(){
    $('._datesFiled').datepicker("destroy").datepicker({
        beforeShowDay   : function(d){
            var tar = jQuery.datepicker.formatDate('mm/dd/yy',d);
            tar = tar.toString();
            var info = [];
            if($.inArray(tar,locked_days) >= 0){
                info = [false, "", "Locked Date"];
            }else
                info = [true, "", "Available"];

            return info;
        },
        minDate         : +14
    });  
}

function freeDateInit(){
    $('._datesFiled').datepicker("destroy").datepicker({}); 
}

$(function(){
    $('#cto-data').hide();

    activeMenu($('#menu-leaves'));

    $('.select2').select2({ sorter: data => data.sort((a, b) => a.text.localeCompare(b.text)), });

    $('.select2').change(function() {
        var obj = $(this),
            position = $(obj).find(":selected").data('position'),
            department = $(obj).find(":selected").data('department');

        $('input[name="position"]').val(position);
        $('input[name="department"]').val(department);
    });

    $("._unplanned").hide();

    $('#main_date_picker').datepicker({
        beforeShowDay   : function(d){
            var tar = jQuery.datepicker.formatDate('mm/dd/yy',d);
            tar = tar.toString();
            var info = [];
            if($.inArray(tar,locked_days) >= 0){
                info = [false, "", "Locked Date"];
            }else
                info = [true, "", "Available"];

            return info;
        },
        minDate         : +14
    });

    $('.cto_datepicker').datepicker();

    if(leave_credits <= 0) {
        $("#mainPayType").attr("disabled",true);
    }

    $("#mainPayType").on("change",function(){
        computeLeaveCredits(this);
    });

    $("#_addLeaveItem").click(function(){
        var template = document.getElementById("tmpl_addLeaveDay").innerHTML;
        var js_tmpl = "";
        var cat =  $("._leaveCategory").val();
        js_tmpl = template.replace(/~~id~~/g,ctr);
        $("#_date_form").append(js_tmpl); 
        if(cat == 1)
            $('#date_picker_' + ctr).datepicker({
                beforeShowDay   : function(d){
                    var tar = jQuery.datepicker.formatDate('mm/dd/yy',d);
                    tar = tar.toString();
                    var info = [];
                    if($.inArray(tar,locked_days) >= 0){
                        info = [false, "", "Locked Date"];
                    }else
                        info = [true, "", "Available"];

                    return info;
                },
                minDate         : +14
            });
        else
            $('#date_picker_' + ctr).datepicker({});
          if(leave_credits <= 0)
            $("#Pay_" + ctr + "_").attr("disabled",true);
        ctr++;
        computeTotalField();
        if($('#progress1').prop('checked'))
            $('select[name="pay_type[]"]').removeAttr('disabled');
    });

    $("#_addCTODay").click(function(){
        var template = document.getElementById("tmpl_addCTODay").innerHTML;
        var js_tmpl = "";
        js_tmpl = template.replace(/~~id~~/g,ctr);
        $("#cto-dates").append(js_tmpl); 
        $('.cto_datepicker').datepicker();
        ctr++;
    });

    $("._lengthDaySel").on("change",function(){
        console.log("change has come");
        console.log(computeTotalField());
    });

    $("._leaveCategory").change(function(){
        var val = $(this).val();
        $('input:checkbox').removeAttr('checked');
        $("._datesFiled").val("");
        $('#cto-data').css({'display':'none'});
        $('select.non_reg').attr('disabled', true);
        $('select.non_reg').val(0);
        if(val == 1){
            lockDateInit();
            $("._unplanned").hide();
            $("._planned").show();
        }else{
            freeDateInit();
            $("._unplanned").show();
            $("._planned").hide();
        }
    });

    $('input[type="submit"]').click(function(e) {
        e.preventDefault();

        var obj = $(this),
            form = obj.closest('form'),
            result = true;

        form.find('input[required], textarea[required], select[required]').each(function(e) {
            if($(this).val() == ''){
                $(this).focus();
                $(this).css({'border':'1px solid #ff0000'});

                result = false;

                return false;
            }
            $(this).removeAttr('style');
        });

        if(result) {

            if($('input[name="leave_type_id"]:checked').length == 0 && $('input[name="leave_cto"]:checked').length == 0){
                alert('Please Select Leave Type');

                return false;
            }

            if($('input[name="leave_cto"]:checked').length > 0 && $('select[name="pay_type_id"]').val()){
                var cto = 0;
                $('.cto-dates').each(function() {
                    if($(this).find('input').val() !== '') { cto++; }
                });

                if(cto == 0) {
                    alert('Please Select CTO Dates');

                    return false;
                }
            }

            $('body').css({'pointer-events':'none'});
            obj.attr('disabled', true);
            obj.val('Please wait');
            $("._thisPayType").attr("disabled",false);
            $("._thisPayType").attr("readonly",true);
            form.submit();
        }
    });

    $('input[type="checkbox"]').change(function() {
        $('select.non_reg').attr('disabled', true);
        $('select.non_reg').val(0);
        $('#cto-data').hide();
        if($('#progress1').prop('checked')) {
            $('select[name="pay_type[]"]').removeAttr('disabled');
        }

        if($('#progress8').prop('checked')) {
            $('#cto-data').show();
        }
    });
});
</script>
@endsection
