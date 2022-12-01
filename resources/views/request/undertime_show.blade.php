@extends('layouts.main')
@section('title')
Request | Undertime > View
@endsection
@section('content')
<style>
@include('request.style');
</style>
<div class="panel panel-default">
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
	<div class="panel panel-body">
		<div class="row">
			<div class="text-center">
				<img src="http://www.elink.com.ph/wp-content/uploads/2016/01/elink-logo-site.png" style="width: 80px; height: 80px;"> 
				<b style="font-size: 18px;">&nbsp;eLink Systems & Concepts Corp.</b>
				<br />
				<b style="font-size: 20px;">UNDERTIME APPLICATION REQUEST</b>
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
                <p><?= slashedDate($undertime->created_at) ?></p>
            </div>

            <div class="col-md-8">
                <table class="table table-bordered table-striped table-primary">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time In</th>
                            <th>Time Out</th>
                            <th>No. of Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    	$no_of_hours = '';
                    	if(!empty($undertime->time_in) && !empty($undertime->time_out)) {
							$start = new DateTime($undertime->time_in);
							$end = $start->diff(new DateTime($undertime->time_out));
							$end->d = $end->d * 24;
							$end->h = ($end->h - 1) + $end->d;

							$no_of_hours = "{$end->h} hrs";
							if($end->i > 0) { $no_of_hours.= " {$end->i} mins"; }
						}
                    ?>
                        <tr>
                            <td><?= date('F d, Y',strtotime($undertime->date)) ?></td>
                            <td><?= empty($undertime->time_in) ? '' : date('m/d/Y H:i A', strtotime($undertime->time_in)) ?></td>
                            <td><?= empty($undertime->time_out) ? '' : date('m/d/Y H:i A', strtotime($undertime->time_out)) ?></td>
                            <td><?= $no_of_hours ?></td>
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
				<p style="white-space: pre-line;"><?= htmlentities($undertime->reason) ?></p>
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
				<p><?= (empty($supervisor) ? 'NO SUPERVISOR' : $supervisor->first_name.' '.$supervisor->last_name.(($supervisor->id == Auth::user()->id) ? ' (You)' : '')) ?></p>
				<small<?= (empty($undertime->recommend_date) ? '' : ' class=leave-success') ?>><?= (empty($undertime->recommend_date) ? 'Not yet recommended' : 'Recommended last ' .  prettyDate($undertime->recommend_date)) ?></small>
				<br>
				<br>
			</div>
			<div class="col-md-4">
				<label>Approved by:</label>
				<p><?= (empty($manager) ? 'HR DEPARTMENT' : $manager->first_name.' '.$manager->last_name.(($manager->id == Auth::user()->id) ? ' (You)' : '')) ?></p>
				<?php
					if($undertime->status == 'DECLINED') {
				?>
				<small style="color: darkred">Declined</small>
				<?php 
					} else {
				?>
				<small<?= (empty($undertime->approved_date) ? '' : ' class=leave-success') ?>><?= (empty($undertime->approved_date) ? 'Not yet approved' : 'Approved last ' .  prettyDate($undertime->approved_date)) ?></small>
				<?php
					}
				?>
				<br>
				<br>
			</div>
			<div class="col-md-4">
				<label>Approve Status:</label>
				<?php
			        $txt = '<span class="fa fa-refresh"></span> Waiting for response';
			        switch($undertime->status) {
			            case 'APPROVED':
			        	$txt = '<span class="fa fa-check" style="color: green"></span> Approved';
			                break;
			            case 'DECLINED':
			        	$txt = '<span class="fa fa-thumbs-down" style="color: darkred"></span> Declined <br>Reason for disapproval <br>'.htmlentities($undertime->declined_reason);
			                break;
			        }
				?>
				<p><?= nl2br($txt) ?></p>
				<br />
				<br />
			</div>
			<div class="division"></div>
			<div class="col-md-12" style="direction: rtl">
            <?php
        	if($undertime->supervisor_id == Auth::user()->id && empty($undertime->recommend_date) && $undertime->status == 'PENDING') {
            ?>
				    <form action="<?= url('undertime/recommend') ?>" method="POST" style="display: inline-flex;">
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
					<form action="<?= url('undertime/approve') ?>" method="POST" style="display: inline-flex;">
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
    activeMenu($('#menu-undertime'));

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
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: white !important;opacity: 1;">×</button>
                <h4 class="modal-title"><b style="color: white">Reason for declining</b></h4>
            </div>
            <div class="modal-body">
                <div clas="row">
                    <form action="<?= url('undertime/decline') ?>" method="POST">
                        <div class="form-group">
                            {{ csrf_field() }}
                            <p>You are about to decline an undertime request. You may write a reason why.</p>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="reason_for_disapproval" style="resize: vertical;"></textarea>
                            <input type="hidden" name="id" value="<?= $undertime->id ?>">
                        </div>
                        <div class="col-md-12">
                            <br>
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