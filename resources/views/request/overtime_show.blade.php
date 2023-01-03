@extends('layouts.main')
@section('title')
Timekeeping | Overtime > View Overtime Application
@endsection
@section('head')
<style type="text/css">
@include('request.style');
</style>
@endsection
@section('breadcrumb')
Timekeeping <span>/</span> Overtime <span>></span> View Overtime
@endsection
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default m-0">
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
			<div class="panel panel-body m-0" id="print">
				<div class="row">
					<div class="main-logo">
						<img src="http://www.elink.com.ph/wp-content/uploads/2016/01/elink-logo-site.png" alt="eLink Systems & Concepts Corp."> 
						<strong>&nbsp;eLink Systems & Concepts Corp.</strong>
						<br />
						<br />
						<h3>OVERTIME APPLICATION REQUEST</h3>
						<br />
					</div>

					<div class="division"></div>
				</div>
		        <div class="row">
		            <div class="col-md-4">
						<br />
		                <label>Date filed:</label>
		                <p><?= slashedDate($overtime->created_at) ?></p>
		            </div>

		            <div class="col-md-8">
		                <table class="table table-bordered table-striped table-primary" id="table-list">
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
		                    ?>
		                        <tr>
		                            <td><?= date('F d, Y',strtotime($date)) ?></td>
		                            <td><?= $overtime->no_of_hours[$key] ?> hrs</td>
		                            <td><?= empty($overtime->time_in[$key]) ? '' : date('m/d/Y H:i A', strtotime($overtime->time_in[$key])) ?></td>
		                            <td><?= empty($overtime->time_out[$key]) ? '' : date('m/d/Y H:i A', strtotime($overtime->time_out[$key])) ?></td>
		                            <td><?= numberOfHours($overtime->time_in[$key], $overtime->time_out[$key], false, true) ?></td>
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
						<label>Total No. of Hours:</label>
						<p><?= array_sum($overtime->no_of_hours) ?></p>
					</div>
					<div class="col-md-4">
						<label>Contact Number:</label>
						<p><?= $overtime->contact_number ?></p>
					</div>
					<div class="col-md-12">&nbsp;</div>
					<div class="col-md-12">
						<label>Reason:</label>
						<p class="pre-line"><?= htmlentities($overtime->reason) ?></p>
					</div>
<?php
	if(!empty($overtime->reverted_reason)) {
?>
					<div class="col-md-12">&nbsp;</div>
					<div class="col-md-12">
						<label>Revert Reason:</label>
						<p class="pre-line"><?= htmlentities($overtime->reverted_reason) ?></p>
					</div>
<?php
	}
?>
					<div class="col-md-12">
						<br />
						<br />
					</div>
					<div class="col-md-4">
						<label>Recommending Approval:</label>
						<p class="m-0"><?= (empty($supervisor) ? 'NO SUPERVISOR' : $supervisor->first_name.' '.$supervisor->last_name.(($supervisor->id == Auth::user()->id) ? ' (You)' : '')) ?></p>
						<small <?= (empty($overtime->recommend_date) ? '' : ' class="text-success"') ?>><?= (empty($overtime->recommend_date) ? 'Not yet recommended' : 'Recommended last ' .  prettyDate($overtime->recommend_date)) ?></small>
						<br>
						<br>
					</div>
					<div class="col-md-4">
						<label>Approved by:</label>
						<p class="m-0"><?= (empty($manager) ? 'HR DEPARTMENT' : $manager->first_name.' '.$manager->last_name.(($manager->id == Auth::user()->id) ? ' (You)' : '')) ?></p>
						<?php
							if($overtime->status == 'DECLINED') {
						?>
							<small class="text-declined">Declined</small>
						<?php 
							} else if($overtime->status == 'COMPLETED') {
						?>
							<small class="text-success">Completed last <?= prettyDate($overtime->completed_date) ?></small>
						<?php
							}
							else {
						?>
							<small <?= (empty($overtime->approved_date) ? '' : ' class="text-success"') ?>><?= (empty($overtime->approved_date) ? 'Not yet approved' : 'Approved last ' .  prettyDate($overtime->approved_date)) ?></small>
						<?php
							}
						?>
						<br />
						<br />
					</div>
					<div class="col-md-4">
						<label>Approve Status:</label>
						<p><?= timekeepingApprovedStatus($overtime) ?></p>
						<br />
						<br />
					</div>
					<div class="division"></div>
					<div class="col-md-12 direction-right">
					<?php
					if((Auth::user()->isAdmin() || $overtime->employee_id == Auth::user()->id) && $overtime->status == 'APPROVED') {
					?>
						<a href="<?= url("overtime/timekeeping/{$overtime->id}") ?>" class="btn btn-info">Timekeeping</a>
					<?php
					}
					if($overtime->supervisor_id == Auth::user()->id && empty($overtime->recommend_date) && $overtime->status == 'PENDING') {
					?>
						<form action="<?= url('overtime/recommend') ?>" method="POST" class="d-inline-flex">
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
						<form action="<?= url('overtime/approve') ?>" method="POST" class="d-inline-flex">
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
						<form action="<?= url('overtime/complete') ?>" method="POST" class="d-inline-flex">
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
	</div>
</div>
@endsection
@section('scripts')
@include('request.js-script');
<div id="declinemodal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="fa fa-remove"></span></button>
                <h4 class="modal-title">Reason for declining</h4>
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
                            <textarea class="form-control" name="reason_for_disapproval" required></textarea>
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
<div id="revertmodal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="fa fa-remove"></span></button>
                <h4 class="modal-title">Reason for reverting</h4>
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
                            <textarea class="form-control" name="reason_for_reverting" required></textarea>
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
