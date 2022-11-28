@extends('layouts.main')
@section('content')
<style type="text/css">
	h1 {
		font-size: 20px;
		font-weight: bold;
		text-align: center;
	}
	object{
		width:100%;
		height:400px;
	}
	iframe{
		width:100%;
		height:100%;
		border:0;
	}
	small{
		display: block;
		font-size: 75% !important;
	}
</style>
<div class="panel panel-default">
	<div class="panel-heading">
		DA INFRACTION INFORMATION

		<a href="<?= url('dainfraction') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
	</div>
	<div class="panel panel-body">
		<div class="row" id="printable">
			<h1><?= $infraction->title ?></h1>

			<div class="col-md-12" style="border-top: 1px solid rgba(0,0,0,.125); padding-top: 15px; margin-top: 15px; padding-left: 0px;"></div>
			<br>
			<br>
			<div class="col-md-12">
				<object data="<?= $infraction->file ?>" type="application/pdf">
				<iframe src="https://docs.google.com/viewer?url=<?= $infraction->file ?>&embedded=true"></iframe>
				</object>
				<br>
				<br>
			</div>
			<div class="col-md-12" style="border-top: 1px solid rgba(0,0,0,.125); padding-top: 15px; margin-top: 15px; padding-left: 0px;">
				<br>
			</div>
            <div class="row">
                <div class="col-md-4">
                    <label style="margin-left: 10px;">Date Filed:</label>
                    <p style="margin-left: 10px;"><?= slashedDate($infraction->date) ?></p>
                </div>

                <div class="col-md-8"></div>
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
			<div class="col-md-12">&nbsp;</div>
			<div class="col-md-12">
				<label>Explanation:</label>
				<p style="white-space: pre-line;"><?= htmlentities($infraction->reason) ?></p>
				<br>
				<br>
			</div>
			<div class="col-md-12" style="border-top: 1px solid rgba(0,0,0,.125); padding-top: 15px; margin-top: 0px; padding-left: 0px;">
			</div>
			<div class="col-md-6"></div>
			<div class="col-md-6" style="direction: rtl">
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
    activeMenu($('#menu-dainfraction'));

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
<div id="acknowledgemodal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0086CD;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: white !important;opacity: 1;">×</button>
                <h4 class="modal-title"><b style="color: white">Acknowledge Infraction</b></h4>
            </div>
            <div class="modal-body">
                <div clas="row">
                    <form action="<?= url('dainfraction/acknowledged') ?>" method="POST">
                        <div class="form-group">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="<?= $infraction->id ?>">
                            <p>By affixing your name, you have understood the content of this NTE.</p>
                        </div>
                        <div class="col-md-12">
                            <br>
                            <button type="submit" class="btn btn-primary pull-right" style="margin-top: 5px;">Acknowledge</button>
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
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: white !important;opacity: 1;">×</button>
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
