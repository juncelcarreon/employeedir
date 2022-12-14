@extends('layouts.main')
@section('title')
Leave > Edit
@endsection
@section('content')
<style type="text/css">
@include('leave.leave-style');
</style>
<form action="<?= url('leave/update') ?>" method="post" id="leave_form" autocomplete="off">
    {{ csrf_field() }}
    <div class="panel panel-default">
        <div class="panel-heading">
            LEAVE APPLICATION FORM

            <a href="<?= url("leave/{$leave_request->id}") ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
        </div>
        <div class="panel-body timeline-container">
            <div class="flex-center position-ref full-height">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <strong>Remaining Leave Credits: </strong>
                            <?php
                            $pto_forwarded = $credits->past_credit - $credits->conversion_credit;
                            $pto_accrue = $credits->current_credit;
                            $loa = abs($credits->loa);
                            $use_jan_jun = $credits->used_jan_to_jun;
                            $pto_expired = $credits->expired_credit;
                            $balance = $pto_forwarded + $pto_accrue - $loa - $use_jan_jun - $pto_expired;
                            ?>
                            <p id="p_leave_credits">PTO Balance: <b><?= $credits->is_regular == 1 ? number_format($credits->current_credit,2) : "0.00" ?></b></p>
                        </div> 
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong>Date Filed: </strong>
                            <p><?= date('m/d/Y',strtotime($leave_request->date_filed)) ?></p>
                            <input type="hidden" value="<?= date('m/d/Y',strtotime($leave_request->date_filed)) ?>" name="date_filed" class="form-control" placeholder="Date Filed" readonly>
                        </div> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong>Name: </strong>
                            <p><?= $leave_request->employee->fullName2() ?></p>
                            <input type="hidden" name="employee_id" value="<?= $leave_request->employee->id ?>">
                            <input type="hidden" name="id" value="<?= $leave_request->id ?>">
                        </div> 
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong>Position: </strong>
                            <p><?= $leave_request->employee->position_name ?></p>
                            <input type="hidden" id="txtPhone" name="position" class="form-control" placeholder="Position" value="<?= $leave_request->employee->position_name ?>" readonly>
                        </div> 
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong>Department: </strong>
                            <p><?= $leave_request->employee->team_name ?></p>
                            <input type="hidden" name="department" class="form-control" placeholder="Dept/Section" value="<?= $leave_request->employee->team_name ?>" readonly>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-heading panel-subheading">
            LEAVE DATES

            <input type="text" name="number_of_days" value="<?= $leave_request->number_of_days ?>" class="form-control _numOfDaysField" list="leave_days" id="number_of_days" placeholder="No. of Days" readonly>
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
                            <input type="text" name="leave_date[]" class="form-control _leaveDate" placeholder="Date Filed" value="<?= date('m/d/Y', strtotime($leave->date)) ?>" required>
                            </div> 
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="length[]" class="form-control _lengthDaySel">
                                    <option value="1"<?= $leave->length == 1 ? " selected" : "" ?>>Whole Day</option>
                                    <option value="0.5"<?= $leave->length == 0.5 ? " selected" : "" ?>>Half Day</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="pay_type[]" class="form-control">
                                    <option value="0"<?= $leave->pay_type == 0 ? " selected" : "" ?>>Without Pay</option>
                                    <option value="1"<?= $leave->pay_type == 1 ? " selected" : "" ?>>With Pay</option>
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
                        <input type="hidden" name="field_id[]" value="<?= $leave->id ?>">
                    </div>
                </div>
                <div id="_date_form">
                <?php
                for($i = 1; $i < count($filed_days); $i++) {
                ?>
                    <div id="main_row_<?= $filed_days[$i]->id ?>" class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="leave_date[]" class="form-control _leaveDate" placeholder="Date Filed" value="<?= date('m/d/Y', strtotime($filed_days[$i]->date)) ?>" required>
                            </div> 
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="length[]" class="form-control _lengthDaySel">
                                    <option value="1"<?= $filed_days[$i]->length == 1 ? " selected" : "" ?>>Whole Day</option>
                                    <option value="0.5"<?= $filed_days[$i]->length == 0.5 ? " selected" : "" ?>>Half Day</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="pay_type[]" class="form-control">
                                    <option value="0"<?= $filed_days[$i]->pay_type == 0 ? " selected" : "" ?>>Without Pay</option>
                                    <option value="1"<?= $filed_days[$i]->pay_type == 1 ? " selected" : "" ?>>With Pay</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="button" data-type="main" data-id="<?= $filed_days[$i]->id ?>" class="btn btn-danger width-100" onclick="removeThisLeave(this)">
                                    <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="field_id[]" value="<?= $filed_days[$i]->id ?>">
                    </div>
                <?php
                }
                ?>
                </div>
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
                                <option value="1"<?= $leave_request->pay_type_id == 1 ? " selected" : "" ?>>Planned</option>
                                <option value="2"<?= $leave_request->pay_type_id == 2 ? " selected" : "" ?>>Unplanned</option>
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
                                        <input type="checkbox" name="<?= ($lv->id == 8) ? 'leave_cto' : 'leave_type_id' ?>" value="<?= $lv->id ?>" id="progress<?= $lv->id  ?>" class="primary" <?= ($leave_request->leave_type_id == $lv->id || $leave_request->leave_type_id == 99) ? 'checked' : '' ?>>
                                        <span class="slider"></span>
                                    </label>&nbsp;
                                    <span><?= $lv->leave_type_name ?></span>
                                </li>
                            <?php
                                } else {
                            ?>
                                <li class="list-group-item _unplanned">
                                    <label class="switch float-left">
                                        <input type="checkbox" name="leave_type_id" value="<?= $lv->id ?>" id="progress<?= $lv->id  ?>" tabIndex="1" class="primary" onClick="ckChange(this)" <?= $leave_request->leave_type_id == $lv->id ? 'checked' : '' ?>>
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
                            <input type="text" name="cto_date[]" class="form-control cto_datepicker" placeholder="CTO Date" value="<?= (count($cto_dates) > 0) ? date('m/d/Y', strtotime($cto_row->date)) : '' ?>">
                            <button type="button" class="btn btn-primary" id="_addCTODay">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </button>
                        </div>
                        <div id="cto-dates">
                            <?php
                            for($i = 1; $i < count($cto_dates); $i++) {
                            ?>
                            <div class="form-group cto-dates" id="cto_<?= $cto_dates[$i]->id ?>">
                                <input type="text" name="cto_date[]" class="form-control cto_datepicker" placeholder="CTO Date" value="<?= date('m/d/Y', strtotime($cto_dates[$i]->date)) ?>">
                                <button type="button" class="btn btn-danger" data-id="<?= $cto_dates[$i]->id ?>" onclick="removeCTO(this)">
                                    <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                                </button>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
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
                            <input type="text" name="report_date" class="datepicker" placeholder="date" value="<?= date('m/d/Y',strtotime($leave_request->report_date)) ?>" required>
                            If i fail to do so on the said date without any justifiable cause.
                            I can considered to have abandoned my employment. I understand that any misrepresentation I make on this request is a serious offense and shall be a valid ground for disciplinary action against me.</q>
                        </div>
                    </div>
                </div>
                <div class="division"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        <strong>Reason: </strong>
                        <textarea name="reason" class="form-control" rows="4" required><?= $leave_request->reason ?></textarea>
                    </div> 
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <strong>Contact Number: </strong>
                        <input type="text" name="contact_number" class="form-control" value="<?= $leave_request->contact_number ?>" required>
                    </div> 
                </div>
                <div class="form-group">
                    <input type="submit" id="register-button" class="btn btn-primary" value="Update">
                    <input type="reset" class="btn btn-default" value="Reset">
                </div>
            </div>
        </div>
    </div>
</form>
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
            <select id="Pay_~~id~~_" name="pay_type[]" class="form-control _thisPayType" onchange="computeLeaveCredits(this);">
                <option value="0">Without Pay</option>
                <option value="1">With Pay</option>
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <button type="button" data-type="sub" data-id="~~id~~" class="btn btn-danger width-100" onclick="removeThisLeave(this)">
                <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
            </button>
        </div>
    </div>
    <div class="col-md-2"><input type="hidden" name="field_id[]" value="0"></div>
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
@endsection
@section('scripts')
<script type="text/javascript">
var ctr = 1;
var locked_days = [<?php foreach($blocked_dates as $b) { echo '"'.$b.'"'.","; } ?>];

function checkCategory(){
    var val = $("._leaveCategory").val();
    
    if(val == 1){
        $("._unplanned").hide();
        $("._planned").show();
    }else{
        $("._unplanned").show();
        $("._planned").hide();
    }
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
    var type = $(obj).data('type');
    if(type == "sub")
        $("#row_" + id).remove();
    else{
        $("#main_row_" + id).remove();
    }
    computeTotalField();
    if(type == "main")
        $.post('/leave/rack',{id : id, total : $("._numOfDaysField").val(), leave : {{ $filed_days[0]->leave_id }}},function(e){
            console.log(e);
        },'json');
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

$(function(){
    activeMenu($('#menu-leaves'));

<?php
    if(count($cto_dates) > 0) {
?>
    $('#cto-data').show();
<?php
    } else {
?>
    $('#cto-data').hide();
<?php
    }
?>

    checkCategory();

    $('._leaveDate').datepicker({
        beforeShowDay   : function(d){
            var tar = jQuery.datepicker.formatDate('mm/dd/yy',d);
            tar = tar.toString();
            console.log(tar);
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

    $('.datepicker').datepicker({
        uiLibrary: 'bootstrap4'
    });

    $("._leaveCategory").change(function(){
        var val = $(this).val();
        $('input:checkbox').removeAttr('checked');
        $('#cto-data').css({'display':'none'});
        checkCategory();
    });

    $("#_addLeaveItem").click(function(){
        var template = document.getElementById("tmpl_addLeaveDay").innerHTML;
        var js_tmpl = "";
        js_tmpl = template.replace(/~~id~~/g,ctr);
        $("#_date_form").append(js_tmpl);
        $('#date_picker_' + ctr).datepicker({
            beforeShowDay   : function(d){
                var tar = jQuery.datepicker.formatDate('mm/dd/yy',d);
                tar = tar.toString();
                console.log(tar);
                var info = [];
                if($.inArray(tar,locked_days) >= 0){
                    info = [false, "", "Locked Date"];
                }else
                    info = [true, "", "Available"];

                return info;
            },
            minDate         : +14
        });
        
        ctr++;
        computeTotalField();
    });

    $("#_addCTODay").click(function(){
        var template = document.getElementById("tmpl_addCTODay").innerHTML;
        var js_tmpl = "";
        js_tmpl = template.replace(/~~id~~/g,ctr);
        $("#cto-dates").append(js_tmpl); 
        $('.cto_datepicker').datepicker();
        ctr++;
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

    $("._lengthDaySel").on("change",function(){
        console.log("change has come");
        console.log(computeTotalField());
    });

    $('input[type="checkbox"]').change(function() {
        $('select.non_reg').attr('readonly', true).css({'pointer-events':'none'});
        $('select.non_reg').val(0);
        $('#cto-data').css({'display' : 'none'});
        if($('#progress1').prop('checked')) {
            $('select[name="pay_type[]"]').removeAttr('readonly').removeAttr('style');
        }

        if($('#progress8').prop('checked')) {
            $('#cto-data').css({'display' : 'block'});
        }
    });

<?php
    if($leave_request->leave_type_id == 1) {
?>
    $('select.non_reg').removeAttr('readonly');
<?php
    }
?>
});
</script>
@endsection