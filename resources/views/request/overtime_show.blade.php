@extends('layouts.main')
@section('title')
Request | Overtime > View
@endsection
@section('content')
<style>
@include('request.style');
</style>
<div class="panel panel-default">
	<div class="panel-heading">
		OVERTIME REQUEST INFORMATION

		<?php
		$url = url('overtime');
		$status = strtolower($overtime->status);
		if($status != 'pending') {
			$url = url("overtime?status={$status}");
		}
		?>
		<a href="<?= $url ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
	</div>
	<div class="panel panel-body">
		<div class="row">
			<div class="text-center">
				<img src="http://www.elink.com.ph/wp-content/uploads/2016/01/elink-logo-site.png" style="width: 80px; height: 80px;"> 
				<b style="font-size: 18px;">&nbsp;eLink Systems & Concepts Corp.</b>
				<br />
				<b style="font-size: 20px;">OVERTIME APPLICATION REQUEST</b>
				<br />
				<br />
			</div>

			<div class="division"></div>
		</div>
        <div class="row" style="margin-top:-30px;">
            <div class="col-md-4">
				<br />
				<br />
                <label>Date filed:</label>
                <p><?= slashedDate($overtime->created_at) ?></p>
            </div>

            <div class="col-md-8">
                <table class="table table-bordered table-striped table-primary">
                    <thead>
                        <tr>
                            <th>Overtime Date</th>
                            <th>No. of Hours <br />(Estimated)</th>
                            <th>Time In</th>
                            <th>Time Out</th>
                            <th>No. of Hours <br />(Actual)</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($overtime->dates as $key=>$date){
                    	$no_of_hours = '';
                    	if(!empty($overtime->time_in[$key]) && !empty($overtime->time_out[$key])) {
							$start = new DateTime($overtime->time_in[$key]);
							$end = $start->diff(new DateTime($overtime->time_out[$key]));

							$no_of_hours = "{$end->h} hrs";
							if($end->i > 0) { $no_of_hours.= " {$end->i} mins"; }
						}
                    ?>
                        <tr>
                            <td><?= date('F d, Y',strtotime($date)) ?></td>
                            <td><?= $overtime->no_of_hours[$key] ?> hrs</td>
                            <td><?= empty($overtime->time_in[$key]) ? '' : date('m/d/Y H:i A', strtotime($overtime->time_in[$key])) ?></td>
                            <td><?= empty($overtime->time_out[$key]) ? '' : date('m/d/Y H:i A', strtotime($overtime->time_out[$key])) ?></td>
                            <td><?= $no_of_hours ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
			<div class="col-md-12">&nbsp;</div>
			<div class="col-md-4">
				<label>Name: </label>
				<p><?= $overtime->first_name.' '.$overtime->last_name ?></p>
			</div>
			<div class="col-md-4">
				<label>Position: </label>
				<p><?= $overtime->position_name ?></p>
			</div>
			<div class="col-md-4">
				<label>Dept/Section: </label>
				<p><?= $overtime->team_name ?></p>
			</div>
			<div class="col-md-12">&nbsp;</div>
			<div class="col-md-4">
				<label>Total No. of Days: </label>
				<p><?= count($overtime->dates) ?></p>
			</div>
			<div class="col-md-4">
				<label>Total No. of Hours:</label>
				<p><?= array_sum($overtime->no_of_hours) ?></p>
			</div>
			<div class="col-md-4">
				<label>Contact Number:</label>
				<p><?= $overtime->contact_number ?></p>
			</div>
			<div class="col-md-12">&nbsp;</div>
			<div class="col-md-8">
				<label>Reason:</label>
				<p style="white-space: pre-line;"><?= htmlentities($overtime->reason) ?></p>
			</div>
			<div class="col-md-12">
				<br />
				<br />
			</div>
			<div class="col-md-4">
				<label>Recommending Approval:</label>
				<p><?= (empty($supervisor) ? 'NO SUPERVISOR' : $supervisor->first_name.' '.$supervisor->last_name.(($supervisor->id == Auth::user()->id) ? ' (You)' : '')) ?></p>
				<small<?= (empty($overtime->recommend_date) ? '' : ' class=leave-success') ?>><?= (empty($overtime->recommend_date) ? 'Not yet recommended' : 'Recommended last ' .  prettyDate($overtime->recommend_date)) ?></small>
				<br>
				<br>
			</div>
			<div class="col-md-4">
				<label>Approved by:</label>
				<p><?= (empty($manager) ? 'HR DEPARTMENT' : $manager->first_name.' '.$manager->last_name.(($manager->id == Auth::user()->id) ? ' (You)' : '')) ?></p>
				<?php
					if($overtime->status == 'DECLINED') {
				?>
					<small style="color: darkred">Declined</small>
				<?php 
					} else if($overtime->status == 'COMPLETED') {
				?>
					<small class="leave-success">Completed last <?= prettyDate($overtime->completed_date) ?></small>
				<?php
					}
					else {
				?>
					<small<?= (empty($overtime->approved_date) ? '' : ' class="leave-success"') ?>><?= (empty($overtime->approved_date) ? 'Not yet approved' : 'Approved last ' .  prettyDate($overtime->approved_date)) ?></small>
				<?php
					}
				?>
				<br />
				<br />
			</div>
			<div class="col-md-4">
				<label>Approve Status:</label>
				<?php
			        $txt = '<span class="fa fa-refresh"></span> Waiting for response';
			        switch($overtime->status) {
			            case 'APPROVED':
			        		$txt = '<span class="fa fa-clock-o" style="color: green"></span> Timekeeping';
				        	if(!empty($overtime->approved_reason)) {
				        		$txt = '<span class="fa fa-undo" style="color: darkred"></span> Reverted <br>Reason for incompletion <br>'.htmlentities($overtime->approved_reason);
				        	}
			                break;
			            case 'DECLINED':
			        		$txt = '<span class="fa fa-thumbs-down" style="color: darkred"></span> Declined <br>Reason for disapproval <br>'.htmlentities($overtime->declined_reason);
			                break;
			            case 'VERIFYING':
			        		$txt = '<span class="fa fa-spinner" style="color: blue"></span> Verifying';
			                break;
			            case 'COMPLETED':
			        		$txt = '<span class="fa fa-check" style="color: green"></span> Completed';
			        }
				?>
				<p><?= nl2br($txt) ?></p>
				<br />
				<br />
			</div>
			<div class="division"></div>
			<div class="col-md-12" style="direction: rtl">
			<?php
			if((Auth::user()->isAdmin() || $overtime->employee_id == Auth::user()->id) && $overtime->status == 'APPROVED') {
			?>
				<a href="<?= url("overtime/timekeeping/{$overtime->id}") ?>" class="btn btn-info">Timekeeping</a>
			<?php
			}
			if($overtime->supervisor_id == Auth::user()->id && empty($overtime->recommend_date) && $overtime->status == 'PENDING') {
			?>
				<form action="<?= url('overtime/recommend') ?>" method="POST" style="display: inline-flex;">
					{{ csrf_field() }}
					<input type="hidden" name="id" value="<?= $overtime->id ?>" />
					<button type="submit" class="btn btn-primary">Recommend</button>
				</form>
			<?php
			}
			if(Auth::user()->isAdmin() || Auth::user()->usertype == 3) {
				if($overtime->status == 'PENDING' || $overtime->status == 'APPROVED') {
			?>
				<button class="btn btn-danger" data-target="#declinemodal" data-toggle="modal">Decline/Cancel</button>
			<?php
				}
			?>
				<a href="<?= url("overtime/{$overtime->id}/edit") ?>" class="btn btn-info">Update</a>
			<?php
				if(($overtime->status == 'PENDING' || $overtime->status == 'DECLINED') && (Auth::user()->isAdmin() || Auth::user()->id == $overtime->manager_id)) {
			?>
				<form action="<?= url('overtime/approve') ?>" method="POST" style="display: inline-flex;">
				{{ csrf_field() }}
					<input type="hidden" name="id" value="<?= $overtime->id ?>" />
					<button type="submit" class="btn btn-primary">Approve</button>
				</form>
			<?php
				}

				if($overtime->status == 'VERIFYING' || $overtime->status == 'COMPLETED') {
			?>
				<button class="btn btn-danger" data-target="#revertmodal" data-toggle="modal">Revert</button>
			<?php
				}

				if($overtime->status == 'VERIFYING') {
			?>
				<form action="<?= url('overtime/complete') ?>" method="POST" style="display: inline-flex;">
				{{ csrf_field() }}
					<input type="hidden" name="id" value="<?= $overtime->id ?>" />
					<button type="submit" class="btn btn-primary">Complete</button>
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
	"searching" :   false
});
$(function() {
    activeMenu($('#menu-overtime'));

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
            <div class="modal-header" style="background-color: #0086CD;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: white !important;opacity: 1;"><span class="fa fa-remove"></span></button>
                <h4 class="modal-title"><b style="color: white">Reason for declining</b></h4>
            </div>
            <div class="modal-body">
                <div clas="row">
                    <form action="<?= url('overtime/decline') ?>" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="<?= $overtime->id ?>" />
                        <div class="form-group">
                            <p>You are about to decline an overtime request. You may write a reason why.</p>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="reason_for_disapproval" style="resize: vertical;" required></textarea>
                        </div>
                        <div class="col-md-12">
                            <br />
                            <button type="submit" class="btn btn-primary pull-right" style="margin-top: 5px;">Submit</button>
                            <button type="button" class="btn btn-default pull-right" style="margin-top: 5px; margin-right: 5px;" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
<div id="revertmodal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0086CD;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: white !important;opacity: 1;"><span class="fa fa-remove"></span></button>
                <h4 class="modal-title"><b style="color: white">Reason for reverting</b></h4>
            </div>
            <div class="modal-body">
                <div clas="row">
                    <form action="<?= url('overtime/revert') ?>" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="<?= $overtime->id ?>" />
                        <div class="form-group">
                            <p>You are about to revert an overtime request. You may write a reason why.</p>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="reason_for_reverting" style="resize: vertical;" required></textarea>
                        </div>
                        <div class="col-md-12">
                            <br />
                            <button type="submit" class="btn btn-primary pull-right" style="margin-top: 5px;">Submit</button>
                            <button type="button" class="btn btn-default pull-right" style="margin-top: 5px; margin-right: 5px;" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
@endsection
