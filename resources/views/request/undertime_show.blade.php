@extends('layouts.main')
@section('title')
Timekeeping | Undertime > View Undertime Application
@endsection
@section('head')
<style type="text/css">
@include('request.style');
</style>
@endsection
@section('breadcrumb')
Timekeeping <span>/</span> Undertime <span>></span> View Undertime
@endsection
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default m-0">
			<div class="panel-heading">
				UNDERTIME REQUEST INFORMATION

				<?php
				$url = url('undertime');
				$status = strtolower($undertime->status);
				if($status != 'pending') {
					$url = url("undertime?status={$status}");
				}
				?>
				<a href="<?= $url ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
			</div>
			<div class="panel panel-body m-0">
				<div class="row">
					<div class="main-logo">
						<img src="http://www.elink.com.ph/wp-content/uploads/2016/01/elink-logo-site.png" alt="eLink Systems & Concepts Corp."> 
						<strong>&nbsp;eLink Systems & Concepts Corp.</strong>
						<br />
						<br />
						<h3>UNDERTIME APPLICATION REQUEST</h3>
						<br />
					</div>

					<div class="division"></div>
				</div>
		        <div class="row">
		            <div class="col-md-4">
						<br />
		                <label>Date filed:</label>
		                <p><?= slashedDate($undertime->created_at) ?></p>
		            </div>

		            <div class="col-md-8">
		                <table class="table table-bordered table-striped table-primary" id="table-list">
		                    <thead>
		                        <tr>
		                            <th>Date</th>
		                            <th>From</th>
		                            <th>To</th>
		                            <th>No. of Hours</th>
		                        </tr>
		                    </thead>
		                    <tbody>
		                        <tr>
		                            <td><?= date('F d, Y',strtotime($undertime->date)) ?></td>
		                            <td><?= empty($undertime->time_in) ? '' : date('m/d/Y H:i A', strtotime($undertime->time_in)) ?></td>
		                            <td><?= empty($undertime->time_out) ? '' : date('m/d/Y H:i A', strtotime($undertime->time_out)) ?></td>
		                            <td><?= numberOfHours($undertime->time_in, $undertime->time_out, true, true) ?></td>
		                        </tr>
		                    </tbody>
		                </table>
		            </div>
		        </div>
		        <div class="row">
					<div class="col-md-12">&nbsp;</div>
					<div class="col-md-4">
						<label>Name: </label>
						<p><?= $undertime->first_name.' '.$undertime->last_name ?></p>
					</div>
					<div class="col-md-4">
						<label>Position: </label>
						<p><?= $undertime->position_name ?></p>
					</div>
					<div class="col-md-4">
						<label>Dept/Section: </label>
						<p><?= $undertime->team_name ?></p>
					</div>
					<div class="col-md-12">&nbsp;</div>
					<div class="col-md-8">
						<label>Reason:</label>
						<p class="pre-line"><?= htmlentities($undertime->reason) ?></p>
					</div>
					<div class="col-md-4">
						<label>Contact Number: </label>
						<p><?= $undertime->contact_number ?></p>
					</div>
					<div class="col-md-12">
						<br />
						<br />
					</div>
					<div class="col-md-4">
						<label>Recommending Approval:</label>
						<p class="m-0"><?= (empty($supervisor) ? 'NO SUPERVISOR' : $supervisor->first_name.' '.$supervisor->last_name.(($supervisor->id == Auth::user()->id) ? ' (You)' : '')) ?></p>
						<small <?= (empty($undertime->recommend_date) ? '' : ' class="text-success"') ?>><?= (empty($undertime->recommend_date) ? 'Not yet recommended' : 'Recommended last ' .  prettyDate($undertime->recommend_date)) ?></small>
						<br>
						<br>
					</div>
					<div class="col-md-4">
						<label>Approved by:</label>
						<p class="m-0"><?= (empty($manager) ? 'HR DEPARTMENT' : $manager->first_name.' '.$manager->last_name.(($manager->id == Auth::user()->id) ? ' (You)' : '')) ?></p>
						<?php
							if($undertime->status == 'DECLINED') {
						?>
						<small class="text-declined">Declined</small>
						<?php 
							} else {
						?>
						<small <?= (empty($undertime->approved_date) ? '' : ' class="text-success"') ?>><?= (empty($undertime->approved_date) ? 'Not yet approved' : 'Approved last ' .  prettyDate($undertime->approved_date)) ?></small>
						<?php
							}
						?>
						<br>
						<br>
					</div>
					<div class="col-md-4">
						<label>Approve Status:</label>
						<p><?= timekeepingApprovedStatus($undertime) ?></p>
						<br />
						<br />
					</div>
					<div class="division"></div>
					<div class="col-md-12 direction-right">
		            <?php
		        	if($undertime->supervisor_id == Auth::user()->id && empty($undertime->recommend_date) && $undertime->status == 'PENDING') {
		            ?>
						    <form action="<?= url('undertime/recommend') ?>" method="POST" class="d-inline-flex">
						        {{ csrf_field() }}
						        <input type="hidden" name="id" value="<?= $undertime->id ?>">
						        <button type="submit" class="btn btn-primary">Recommend</button>
						    </form>
				    <?php
		        	}
					if(Auth::user()->isAdmin() || Auth::user()->usertype == 3) {
						if($undertime->status != 'DECLINED') {
					?>
							<button class="btn btn-danger" data-target="#declinemodal" data-toggle="modal">Decline/Cancel</button>
					<?php
						}

						if((Auth::user()->usertype == 3 && $undertime->status != 'PENDING') || Auth::user()->isAdmin()) {
					?>
							<a href="<?= url("undertime/{$undertime->id}/edit") ?>" class="btn btn-info">Update</a>
					<?php
						}

						if($undertime->status != 'APPROVED') {
					?>
							<form action="<?= url('undertime/approve') ?>" method="POST" class="d-inline-flex">
							{{ csrf_field() }}
								<input type="hidden" name="id" value="<?= $undertime->id ?>">
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
                    <form action="<?= url('undertime/decline') ?>" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="<?= $undertime->id ?>">
                        <div class="form-group">
                            <p>You are about to decline an undertime request. You may write a reason why.</p>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="reason_for_disapproval"></textarea>
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