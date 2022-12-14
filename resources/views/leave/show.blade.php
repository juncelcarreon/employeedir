@extends('layouts.main')
@section('title')
Leave > View
@endsection
@section('content')
<style type="text/css">
@include('leave.leave-style');
</style>
<div class="panel panel-default">
	<div class="panel-heading">
		LEAVE REQUEST INFORMATION

		<?php
			$url = url('leave');
			if(!empty($employee->deleted_at)) {
				$url = url("profile/{$employee->id}");
			}
		?>
		<a href="<?= $url ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
	</div>
	<div class="panel panel-body">
		<div class="row" id="printable">
			<div class="print-title">
				<img src="http://www.elink.com.ph/wp-content/uploads/2016/01/elink-logo-site.png" alt="eLink Systems & Concepts Corp."> 
				<h4>&nbsp;eLink Systems & Concepts Corp.</h4>
				<br>
				<br>
				<h3>LEAVE APPLICATION REQUEST</h3>
			</div>

			<div class="division"></div>
			<br>

            <div class="row">
                <div class="col-md-4">
                    <label class="ml-10">Date filed:</label>
                    <p class="ml-10"><?= slashedDate($leave_request->date_filed) ?></p>
                </div>

                <div class="col-md-8">
                    <table class="table table-bordered table-striped table-primary">
                        <thead>
                            <tr>
                                <th>Leave Date</th>
                                <th>Length</th>
                                <th>Pay Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($details as $info) {
                        ?>
                            <tr>
                                <td><?= date('F d, Y',strtotime($info->date)) ?></td>
                                <td><?= (($info->length == 1) ? "Whole Day" : "Half Day") ?></td>
                                <td><?= (($info->pay_type == 1) ? "With Pay" : "Without Pay") ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
			<div class="col-md-12">&nbsp;</div>
			<div class="col-md-4">
				<label>Name: </label>
				<p><?= $employee->first_name.' '.$employee->last_name ?></p>
			</div>
			<div class="col-md-4">
				<label>Position: </label>
				<p><?= $employee->position_name ?></p>
			</div>
			<div class="col-md-4">
				<label>Dept/Section: </label>
				<p><?= $employee->team_name ?></p>
			</div>
			<div class="col-md-12">&nbsp;</div>
			<div class="col-md-4">
				<label>No. of Days: </label>
				<p><?= $leave_request->number_of_days ?></p>
			</div>
			<div class="col-md-4 type_of_leave">
				<label>Type of Leave:</label>
				<p><?= (($leave_request->leave_type_id == 99) ? 'Vacation + CTO Leave' : $leave_request->leave_type->leave_type_name) ?></p>
				<?php
				foreach($cto_dates as $cto):
				?>
					<small><?= date('F d, Y',strtotime($cto->date)) ?></small>
				<?php
				endforeach;
				?>
			</div>
			<div class="col-md-4">
				<label>Contact Number:</label>
				<p><?= $employee->contact_number ?></p>
			</div>
			<div class="col-md-12">&nbsp;</div>
			<div class="col-md-4">
				<label>Report Date:</label>
				<p><?= prettyDate($leave_request->report_date) ?></p>
			</div>
			<div class="col-md-8">
				<label>Reason:</label>
				<p><?= nl2br($leave_request->reason) ?></p>
			</div>
			<div class="col-md-12">
				<br>
				<br>
			</div>
			<div class="col-md-4">
				<label>Recommending Approval:</label>
				<p><?= (!empty($employee->supervisor) ? strtoupper($employee->supervisor).' '.(($employee->supervisor_id == Auth::user()->id) ? '(You)' : '') : 'NO SUPERVISOR') ?></p>
				<small<?= ((!empty($leave_request->recommending_approval_by_signed_date)) ? ' class=leave-success' : '') ?>><?= ((!empty($leave_request->recommending_approval_by_signed_date)) ? 'Recommended last ' .  prettyDate($leave_request->recommending_approval_by_signed_date) : 'Not yet recommended') ?></small>
				<br>
				<br>
			</div>
			<div class="col-md-4">
				<label>Approved by:</label>
				<p><?= (!empty($employee->manager) ? strtoupper($employee->manager).' '.(($employee->manager_id == Auth::user()->id) ? '(You)' : '') : 'HR DEPARTMENT') ?></p>
				<?php
					if($leave_request->approve_status_id == 2) {
				?>
				<small class="leave-danger">Declined</small>
				<?php 
					} else {
				?>
				<small<?= ((!empty($leave_request->approved_by_signed_date)) ? ' class=leave-success' : '') ?>><?= ((!empty($leave_request->approved_by_signed_date)) ? 'Approved last ' .  prettyDate($leave_request->approved_by_signed_date) : 'Not yet approved') ?></small>
				<?php
					}
				?>
				<br>
				<br>
			</div>
			<div class="col-md-4">
				<label>Approve Status:</label>
				<p><?= $leave_request->getApprovalStatus() ?></p>
				<br>
				<br>
			</div>
			<div class="division"></div>
            <div class="col-md-6">
                <label><?= strtoupper($employee->first_name) ?>'s Remaining Leave Credits:</label>
                <?php
                $pto_forwarded = $credits->past_credit - $credits->conversion_credit;
                $pto_accrue = $credits->current_credit;
                $loa = abs($credits->loa);
                $use_jan_jun = $credits->used_jan_to_jun;
                $pto_expired = $credits->expired_credit;
                $balance = $pto_forwarded + $pto_accrue - $loa - $use_jan_jun - $pto_expired;
                ?>
                <p>PTO Balance: <b><?= (($credits->is_regular == 1) ? number_format($credits->current_credit,2) : '0.00') ?></b></p>
            </div>
			<div class="col-md-6 form-direction">
            <?php
        	if($employee->supervisor_id == Auth::user()->id && empty($leave_request->recommending_approval_by_signed_date) && $leave_request->approve_status_id == 0) {
            ?>
				    <form action="<?= url('leave/recommend') ?>" method="POST">
				        {{ csrf_field() }}
				        <input type="hidden" name="leave_id" value="<?= $leave_request->id ?>">
				        <button type="submit" class="btn btn-primary">Recommend</button>
				    </form>
		    <?php
			}
			if($leave_request->isForNoted() && ($leave_request->approve_status_id == 0 || $leave_request->approve_status_id == 3)) {
			?>
                    <form action="<?= url('leave/noted') ?>" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="leave_id" value="<?= $leave_request->id ?>">
                        <button type="submit" class="btn btn-primary">Noted</button>
                    </form>
		    <?php
			}
			if(Auth::user()->isAdmin() || Auth::user()->usertype == 3) {
				if($leave_request->approve_status_id != 2) {
			?>
					<button class="btn btn-danger" data-target="#declinemodal" data-toggle="modal">Decline/Cancel</button>
			<?php
				}
				if((Auth::user()->usertype == 3 && $leave_request->approve_status_id != 1) || Auth::user()->isAdmin()) {
			?>
					<a href="<?= url("leave/{$leave_request->id}/edit") ?>" class="btn btn-info">Update</a>
			<?php
				}
				if($leave_request->approve_status_id != 1) {
			?>
					<form action="<?= url('leave/approve') ?>" method="POST">
					{{ csrf_field() }}
						<input type="hidden" name="leave_id" value="<?= $leave_request->id ?>">
						<button type="submit" class="btn btn-primary">Approve</button>
					</form>
            <?php
            	}
        	}
            ?>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
$('.table').DataTable({
	"paging"    :   false,
	"ordering"  :   false,
	"info"      :   false,
	searching   :   false
});
$(function() {
    activeMenu($('#menu-leaves'));

    $('button[type="submit"]').click(function(e) {
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
	        $('body').css({'pointer-events':'none'});
	        obj.attr('disabled', true);
	        obj.text('Please wait');
            form.submit();
        }
    });
})
</script>
<div id="declinemodal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title">Reason for declining</h4>
            </div>
            <div class="modal-body">
                <div clas="row">
                    <form action="<?= url('leave/decline') ?>" method="POST">
                        <div class="form-group">
                            {{ csrf_field() }}
                            <p>You are about to decline a leave request. You may write a reason why.</p>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="reason_for_disapproval" required></textarea>
                            <input type="hidden" name="leave_id" value="<?= $leave_request->id ?>">
                        </div>
                        <div class="col-md-12">
                            <br>
                            <button type="submit" class="btn btn-primary pull-right">Submit</button>
                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
@endsection