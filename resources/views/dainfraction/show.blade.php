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
		            $date = "";
		            if(!empty($infraction->acknowledged_date)) {
		            	$date = ' ('.date('Y-m-d', strtotime($infraction->acknowledged_date)).')';
		            }
		            switch($infraction->status) {
		                case 1:
		                $status = "Acknowledged{$date}";
		                    break;
		                case 2:
		                $status = "Acknowledged{$date} <small>(Pending Explanation)</small>";
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
					</div>
<?php
	}
	if(!empty($infraction->hr_notes)) {
?>
					<div class="col-md-12">&nbsp;</div>
					<div class="col-md-12">
						<label>HR Notes:</label>
						<p class="pre-line"><?= htmlentities($infraction->hr_notes) ?></p>
					</div>
<?php
	}
?>
					<div class="col-md-12">
						<br>
						<br>
					</div>
					<div class="col-md-4">
						<label>Recommending Approval:</label>
						<p><?= (!empty($supervisor) ? strtoupper($supervisor->first_name.' '.$supervisor->last_name).' '.(($supervisor->id == Auth::user()->id) ? '(You)' : '') : 'NO SUPERVISOR') ?></p>
						<small <?= ((!empty($infraction->recommend_date)) ? 'class="text-success"' : '') ?>><?= ((!empty($infraction->recommend_date)) ? 'Recommended last ' .  prettyDate($infraction->recommend_date) : 'Not yet recommended') ?></small>
					</div>
					<div class="col-md-4">
						<label>Approved by:</label>
						<p><?= (!empty($manager) ? strtoupper($manager->first_name.' '.$manager->last_name).' '.(($manager->manager_id == Auth::user()->id) ? '(You)' : '') : 'HR DEPARTMENT') ?></p>
						<small <?= ((!empty($infraction->approved_date)) ? 'class="text-success"' : '') ?>><?= ((!empty($infraction->approved_date)) ? 'Approved last ' .  prettyDate($infraction->approved_date) : 'Not yet approved') ?></small>
					</div>
					<div class="col-md-4">
					<?php
						$txt = '<span class="fa fa-refresh"></span>&nbsp; Waiting for response';

						switch($infraction->approved_status) {
							case 'APPROVED':
								$txt = '<span class="fa fa-check text-success"></span> Approved';
								break;
							case 'RECOMMENDED':
								$txt = '<span class="fa fa-thumbs-up text-primary"></span> Recommended';
								break;
						}
					?>
						<label>Approve Status:</label>
						<p><?= nl2br($txt) ?>
					</div>
					<div class="division"></div>
					<div class="col-md-6"></div>
					<div class="col-md-6 direction-rtl">
						<?php
							if($infraction->employee_id == Auth::user()->id && $infraction->status == 0) {
						?>
						<button class="btn btn-primary" data-target="#acknowledgemodal" data-toggle="modal">Acknowledge</button>
						<?php
							}
							if($infraction->employee_id == Auth::user()->id && $infraction->status == 2) {
						?>
						<button class="btn btn-primary" data-target="#explanationmodal" data-toggle="modal">Please State Your Explanation</button>
						<?php
							}
							if(Auth::user()->isAdmin()) {
						?>
						<button class="btn btn-primary" data-target="#hrnotesmodal" data-toggle="modal">HR Notes</button>
						<a href="<?= url("dainfraction/{$infraction->id}/edit") ?>" class="btn btn-info">Update</a>
						<?php
								if(!empty($infraction->reason)) {
						?>
						<button class="btn btn-success" id="btn-print">Print</button>
						<?php
								}
							}
							if($infraction->infraction_type == 'NTE' && $infraction->approved_status != 'APPROVED' && ((!empty($manager) && $manager->id == Auth::user()->id) || (Auth::user()->isAdmin()))) {
						?>
						    <form action="<?= url('dainfraction/approved') ?>" method="POST" style="display: inline-block;">
						        {{ csrf_field() }}
						        <input type="hidden" name="id" value="<?= $infraction->id ?>">
						        <button type="submit" class="btn btn-primary">Approved</button>
						    </form>
						<?php
							}
							if($infraction->infraction_type == 'NTE' && $infraction->approved_status == 'NONE' && !empty($supervisor) && $supervisor->id == Auth::user()->id) {
						?>
						    <form action="<?= url('dainfraction/recommend') ?>" method="POST" style="display: inline-block;">
						        {{ csrf_field() }}
						        <input type="hidden" name="id" value="<?= $infraction->id ?>">
						        <button type="submit" class="btn btn-primary">Recommend</button>
						    </form>
						<?php
							}
						?>
					</div>
				</div>
	    		<div style="background:#525659;padding:10px;text-align:center;display: none;" id="divImage">
<?php
	for($x = 1; $x <= $pages; $x++) {
?>
					<canvas id="pdf-canvas<?= $x ?>" style="width: 200px;"></canvas>
<?php
	}
?>
				</div>
			</div>
			<div class="panel panel-body" id="html" style="display: none;">
				<p style="font-size:10px;height:10px;margin:0;">Printed Date: <?= date('F d, Y') ?></p>
				<i style="display: block;font-size: 20px;text-align: center;margin:0;"><?= ($infraction->infraction_type == 'NOD') ? 'Notice of Decision' : 'Notice to Explain' ?></i>
				<span style="font-size: 30px;font-weight:bold;text-align: center;margin:0;"> <?= $infraction->title ?></span>
				<div style="width:100%;text-align:center;">
					<img id="image" style="width:750px;">
				</div>
				<table data-pdfmake="{'widths':[50,'*','auto']}">
<?php
	if(!empty($infraction->reason)) {
?>
				  <tr>
				    <td colspan="3" style="border:0;"><b>Reason:</b></td>
				  </tr>
				  <tr>
				    <td colspan="3" style="border:0;white-space:pre-line;"><?= htmlentities($infraction->reason) ?></td>
				  </tr>
				  <tr>
				    <td colspan="3" style="height:40px;border:0;">&nbsp;</td>
				  </tr>
<?php
	}
?>
				  <tr>
				    <td colspan="3" style="text-align: right;border:0;"><b>Affixed Name:</b></td>
				  </tr>
				  <tr>
				    <td style="border:0;">&nbsp;</td>
				    <td style="border:0;">&nbsp;</td>
				    <td style="text-align: right;border:0;"><i><?= $infraction->affixed_name ?></i></td>
				  </tr>
				  <tr>
				    <td style="border:0;">&nbsp;</td>
				    <td style="border:0;">&nbsp;</td>
				    <td style="text-align: right;border:0;"><?= date('Y-m-d', strtotime($infraction->acknowledged_date)) ?></td>
				  </tr>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
@include('dainfraction.script')
<script src='https://cdn.jsdelivr.net/npm/pdfmake@latest/build/pdfmake.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/pdfmake@latest/build/vfs_fonts.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/html-to-pdfmake/browser.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.2.228/pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.js"></script>
<script type="text/javascript">
var _PDF_DOC,
    _CURRENT_PAGE,
    _TOTAL_PAGES,
    _PAGE_RENDERING_IN_PROGRESS = 0,
<?php
    for($x = 1;$x <= $pages; $x++) {
?>
    _CANVAS<?= $x ?> = document.querySelector('#pdf-canvas<?= $x ?>'),
<?php
	}
?>
    _CANVAS_URL = '';

<?php
    for($x = 1;$x <= $pages; $x++) {
?>
async function showPDF<?= $x ?>(pdf_url) {
    try {
        _PDF_DOC = await pdfjsLib.getDocument({ url: pdf_url });
    }
    catch(error) {
        alert(error.message);
    }

    showPage<?= $x ?>(<?= $x ?>);
}
<?php
	}

	for($x = 1;$x <= $pages; $x++) {
?>
	async function showPage<?= $x ?>(page_no) {
	    _PAGE_RENDERING_IN_PROGRESS = 1;
	    _CURRENT_PAGE = page_no;

	    document.querySelector("#pdf-canvas<?= $x ?>").style.display = 'none';

	    try {
	        var page = await _PDF_DOC.getPage(page_no);
	    }
	    catch(error) {
	        alert(error.message);
	    }

	    var pdf_original_width = page.getViewport(1).width;
	    var scale_required = 200 / pdf_original_width;
	    var viewport = page.getViewport(scale_required);

	    _CANVAS<?= $x ?>.width = viewport.width;
	    _CANVAS<?= $x ?>.height = viewport.height;

	    var render_context = {
	        canvasContext: _CANVAS<?= $x ?>.getContext('2d'),
	        viewport: viewport
	    };

	    try {
	        await page.render(render_context);
	    }
	    catch(error) {
	        alert(error.message);
	    }

	    _PAGE_RENDERING_IN_PROGRESS = 0;

	    document.querySelector("#pdf-canvas<?= $x ?>").style.display = 'inline-block';

		$('body').removeAttr('style');
	}
<?php
	}
?>

$(function(){
	$('body').css({'pointer-events':'none'});

<?php
	for($x = 1;$x <= $pages; $x++) {
?>
	showPDF<?= $x ?>('<?= $infraction->file ?>');
<?php
	}
?>

	$('#btn-print').click(function(e){
		e.preventDefault();	

		var obj = $(this);
		var html = $('#html').html();
		var element = document.querySelector("#divImage");

		obj.text('Processing');
		obj.attr('disabled', true);

		html2canvas(element, {
		    onclone: function (clonedDoc) {
		        clonedDoc.getElementById('divImage').style.display = 'block';
		    }
		}).then((canvas)=>{
		    $('#image').attr('src', canvas.toDataURL("image/png"));
			obj.text('Print');
			obj.attr('disabled', false);

			var ret = htmlToPdfmake(html, {
			  tableAutoSize:true,
			  imagesByReference:true
			});

			ret.images.img_ref_0 = canvas.toDataURL("image/png");

			var dd = {
			  content:ret.content,
			  images:ret.images
			}

			pdfMake.createPdf(dd).download("infraction-<?= $infraction->id ?>.pdf");
		});
	});
});
</script>
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
<div id="hrnotesmodal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0086CD;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: white !important;opacity: 1;">X</button>
                <h4 class="modal-title"><b style="color: white">HR Notes.</b></h4>
            </div>
            <div class="modal-body">
                <div clas="row">
                    <form action="<?= url('dainfraction/noted') ?>" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <textarea class="form-control" name="notes" style="resize: vertical;min-height: 150px;" required></textarea>
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
