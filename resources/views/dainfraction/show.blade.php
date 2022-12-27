@extends('layouts.main')
@section('title')
DA Infractions > View Infraction
@endsection
@section('head')
<style type="text/css">
@include('dainfraction.style');
</style>
@endsection
@section('breadcrumb')
DA Infractions <span>></span> View Infraction
@endsection
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default m-0">
			<div class="panel-heading">
				DA INFRACTION INFORMATION

				<a href="<?= url('dainfraction') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
			</div>
			<div class="panel panel-body m-0">
				<div class="row" id="printable">
					<h1><i><?= ($infraction->infraction_type == 'NOD') ? 'Notice of Decision' : 'Notice to Explain' ?></i> <span><?= $infraction->title ?></span></h1>

					<div class="division"></div>
					<br>
					<br>
					<div class="col-md-12">
						<object data="<?= $infraction->file ?>" type="application/pdf">
						<iframe src="https://docs.google.com/viewer?url=<?= $infraction->file ?>&embedded=true"></iframe>
						</object>
						<br>
						<br>
					</div>
					<div class="division"></div>
					<br>
	                <div class="col-md-4">
	                    <label>Date Filed:</label>
	                    <p><?= slashedDate($infraction->date) ?></p>
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
						<label>Contact Number:</label>
						<p><?= $employee->contact_number ?></p>
					</div>
					<div class="col-md-4">
						<label>Filed by:</label>
						<p><?= $filer->first_name.' '.$filer->last_name ?></p>
					</div>
					<?php
		            $status = 'Not Acknowledged';
		            switch($infraction->status) {
		                case 1:
		                $status = 'Acknowledged';
		                    break;
		                case 2:
		                $status = 'Acknowledged <small>(Pending Explanation)</small>';
		                    break;
		            }
					?>
					<div class="col-md-4">
						<label>Status:</label>
						<p><?= $status ?></p>
					</div>
<?php
	if(!empty($infraction->reason)) {
?>
					<div class="col-md-12">&nbsp;</div>
					<div class="col-md-12">
						<label>Explanation:</label>
						<p class="pre-line"><?= htmlentities($infraction->reason) ?></p>
						<br>
						<br>
					</div>
<?php
	}
?>
					<div class="division"></div>
					<div class="col-md-6"></div>
					<div class="col-md-6 direction-rtl">
						<?php
							if($infraction->status == 0) {
						?>
						<button class="btn btn-primary" data-target="#acknowledgemodal" data-toggle="modal">Acknowledge</button>
						<?php
							}
							if($infraction->status == 2) {
						?>
						<button class="btn btn-primary" data-target="#explanationmodal" data-toggle="modal">Please State Your Explanation</button>
						<?php
							}
							if(Auth::user()->isAdmin()) {
						?>
						<a href="<?= url("dainfraction/{$infraction->id}/edit") ?>" class="btn btn-info">Update</a>
						<?php
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
@include('dainfraction.script')
<div id="acknowledgemodal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0086CD;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: white !important;opacity: 1;">X</button>
                <h4 class="modal-title"><b style="color: white">Acknowledge Infraction</b></h4>
            </div>
            <div class="modal-body">
                <div clas="row">
                    <form action="<?= url('dainfraction/acknowledged') ?>" method="POST">
                        <div class="form-group">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="<?= $infraction->id ?>">
                            <p>By affixing your name, you have understood the content of this <?= $infraction->infraction_type ?>.</p>
                            <input type="text" class="form-control" name="affixed_name" placeholder="Affix Your Name" required>
                        </div>
                        <div class="col-md-12">
                            <br>
                            <button id="test" type="submit" class="btn btn-primary pull-right" style="margin-top: 5px;">Acknowledge</button>
                            <button type="button" class="btn btn-default pull-right" style="margin-top: 5px; margin-right: 5px;" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
<div id="explanationmodal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0086CD;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: white !important;opacity: 1;">X</button>
                <h4 class="modal-title"><b style="color: white">Please State your Explanation.</b></h4>
            </div>
            <div class="modal-body">
                <div clas="row">
                    <form action="<?= url('dainfraction/explanation') ?>" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <textarea class="form-control" name="reason" style="resize: vertical;min-height: 150px;" required></textarea>
                            <input type="hidden" name="id" value="<?= $infraction->id ?>">
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
