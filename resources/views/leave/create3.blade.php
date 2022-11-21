@extends('layouts.main')
@section('title')
    Request | Leaves > Create
@endsection
@section('content')
<style>
@include('leave.leave-style');
</style>
<form action="<?= url('leave') ?>" method="post" id="leave_form">
    {{ csrf_field() }}
    <div class="panel panel-default">
        <div class="panel-heading">
            LEAVE APPLICATION FORM

            <a href="<?= url('leave') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
        </div>
        <div class="panel-body timeline-container">
            <div class="flex-center position-ref full-height">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong><p>Leave Credits Summary: </p></strong>
                            <?php
                            $pto_forwarded = $credits->past_credit - $credits->conversion_credit;
                            $pto_accrue = $credits->current_credit;
                            $loa = abs($credits->loa);
                            $use_jan_jun = $credits->used_jan_to_jun;
                            $pto_expired = $credits->expired_credit;
                            $balance = $pto_forwarded + $pto_accrue - $loa - $use_jan_jun - $pto_expired;
                            ?>
                        </div>
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
                                    <td><?= number_format($credits->past_credit - $credits->conversion_credit,1) ?></td>
				                    <td><?= number_format($credits->monthly_accrual,2) ?></td>
                                    <td><?= number_format($credits->used_jan_to_jun,2) ?></td>
                                    <td><?= number_format($credits->used_jul_to_dec,2) ?></td>
                                    <td style="text-align:center;font-weight:bold;color:#0000FF;background-color:yellow;">
                                        <?= $credits->is_regular == 1 ? number_format($credits->current_credit, 2) : '0.00' ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8"></div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong>Date Filed: </strong>
                            <input type="text" value="<?= date('m/d/Y') ?>" name="date_filed" class="form-control" placeholder="Date Filed" readonly autocomplete="off">
                        </div> 
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong>Name: </strong>
                            <?php
                                if(Auth::user()->dept_code == 'HR01') {
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong>Position: </strong>
                            <input type="text" name="position" class="form-control" placeholder="Position" value="<?= Auth::user()->position_name ?>" readonly>
                        </div> 
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong>Department: </strong>
                            <input type="text" name="department" class="form-control" placeholder="Dept/Section" value="<?= Auth::user()->team_name ?>" readonly>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-heading panel-subheading">
            LEAVE DATES
        </div>
        <div class="panel-body timeline-container">
            <div class="flex-center position-ref full-height">
                <div class="entry-content">
                    <div class="row entry-row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Leave Date: </strong>
                                <input type="text" name="leave_date[]" class="form-control leave_date" placeholder="Leave Date" autocomplete="off" required>
                            </div> 
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <strong>Length: </strong>
                                <select name="length[]" class="form-control _lengthDaySel">
                                    <option value="1">Whole Day</option>
                                    <option value="0.5">Half Day</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <strong>With/Without Pay: </strong>
                                <select id="mainPayType" name="pay_type[]" class="form-control _thisPayType<?= ($credits->is_regular == 1) ? ((floor($credits->current_credit) > 0) ? '' : ' non_reg') : ' non_reg' ?>"<?= ($credits->is_regular == 1) ? ((floor($credits->current_credit) > 0) ? '' : ' disabled') : ' disabled' ?>>
                                    <option value="0">Without Pay</option>
                                    <option value="1">With Pay</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <strong>&nbsp; </strong>
                                <button href="javascript:;" class="btn btn-primary btn-add" style="width:100%;">&nbsp;<span class="fa fa-plus"></span>&nbsp;</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="_date_form"></div>
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
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong>Total Number of Days: </strong>
                            <input type="text" name="number_of_days" value="1" class="form-control _numOfDaysField" list="leave_days" placeholder="No. of Days" autocomplete="off" readonly>                
                        </div>
                    </div>
                </div>
                <!-- TYPE OF LEAVE -->
                <div class="row">
                    <div class="col-md-12" style="border-top: 1px solid rgba(0,0,0,.125); padding-top: 15px; margin-top: 25px">
                        <strong>Type of Leave: </strong>
                    </div>
                </div>
                <div class="row" style="padding-bottom: 25px; margin-bottom: 25px;">
                    <div class="col-md-3" style="border-right: 1px solid rgba(0,0,0,.125);">
                        <div class="form-group">
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
                        <?php
                        if($is_leader > 0) {
                        ?>
                        <div id="cto-data" style="display: none;">
                            <div class="form-group cto-dates">
                                <input type="text" name="cto_date[]" class="form-control cto_datepicker" placeholder="CTO Date" autocomplete="off">
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
                    <div class="col-md-9">
                        <div class="report-date-box" style="padding-top: 25%">
                            I will report for work on 
                            <input type="text" name="report_date" class="datepicker" placeholder="date" autocomplete="off" required>
                            If i fail to do so on the said date without any justifiable cause.
                            I can considered to have abandoned my employment. I understand that any misrepresentation I make on this request is a serious offense and shall be a valid ground for disciplinary action against me.
                        </div>
                    </div>
                </div>
                <!-- END TYPE OF LEAVE -->
                <!-- REASON -->
                <div class="col-md-12" style="border-top: 1px solid rgba(0,0,0,.125); padding-top: 15px; margin-top: 25px"></div>
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
<script id="tmpl_addLeaveDay" type="text/template">
<div id="row_~~id~~" class="row">
    <div class="col-md-4">
        <div class="form-group">
            <strong>Leave Date: </strong>
            <input id="date_picker_~~id~~"  type="text" name="leave_date[]" class="form-control _datesFiled" placeholder="Leave Date" autocomplete="off" required>
        </div> 
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <strong>Length: </strong>
            <select id="sel_ctr_~~id~~" name="length[]" class="form-control _lengthDaySel" onchange="computeTotalField()">
                <option value="1">Whole Day</option>
                <option value="0.5">Half Day</option>
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <strong>With/Without Pay: </strong>
            <select id="Pay_~~id~~_" name="pay_type[]" class="form-control _thisPayType<?= ($credits->is_regular == 1) ? ((floor($credits->current_credit) > 0) ? '' : ' non_reg') : ' non_reg' ?>" onchange="computeLeaveCredits(this);"<?= ($credits->is_regular == 1) ? ((floor($credits->current_credit) > 0) ? '' : ' disabled') : ' disabled' ?>>
                <option value="0">Without Pay</option>
                <option value="1">With Pay</option>
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <strong>Remove this leave: </strong>
            <button type="button" data-id="~~id~~" class="btn btn-danger" onclick="removeThisLeave(this)">
                <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
            </button>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>
</script>
<script id="tmpl_addCTODay" type="text/template">
<div class="form-group cto-dates" id="cto_~~id~~">
    <input type="text" name="cto_date[]" class="form-control cto_datepicker" placeholder="CTO Date" autocomplete="off">
    <button type="button" class="btn btn-danger" data-id="~~id~~" onclick="removeCTO(this)">
        <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
    </button>
</div>
</script>
@endsection
@section('scripts')
<!-- <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea', forced_root_block : 'p' });</script> -->
<script type="text/javascript">
$(function(){
    activeMenu($('#menu-leaves'));

    $('.leave_date').datepicker();

    $('.btn-add').click(function(e) {
        e.preventDefault();

        var obj = $(this),
            parent = obj.closest('.entry-content'),
            entry = parent.find('.entry-row:first'),
            entry_last = parent.find('.entry-row:last'),
            cat =  $("._leaveCategory").val();

        var new_entry = entry.clone().insertAfter(entry_last);
            new_entry.find('.btn-add').html('<span class="fa fa-minus"></span>');
            new_entry.find('.btn-add').removeClass('btn-primary').addClass('btn-danger');
            new_entry.find('.btn-add').removeClass('btn-add').addClass('btn-remove');
            new_entry.find('.leave_date').val('');
            new_entry.find('.select').val('');
            new_entry.find('.btn-remove').click(function(e) {
                e.preventDefault();
                $(this).closest('.entry-row').remove();
            });

        if(cat == 1) {
            new_entry.find('.leave_date').removeAttr('id').removeClass('hasDatepicker').removeData('datepicker').unbind().datepicker({ 
                minDate: +14 
            });
        } else {
            new_entry.find('.leave_date').datepicker();
        }
    });
});
</script>
@endsection
