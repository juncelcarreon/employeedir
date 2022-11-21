@extends('layouts.main')
@section('content')
<style>
.form-group strong {
    display: block;
    margin-bottom: 10px;
}
.form-group button {
    display: block;
    width: 100%;
}
</style>
<div class="panel panel-default">
    <div class="panel-heading">
        DA INFRACTION FORM

        <a href="<?= url("dainfraction/{$infraction->id}") ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
    </div>
    <div class="panel-body timeline-container">
        <div class="flex-center position-ref full-height">
            <form enctype="multipart/form-data" action="<?= url('dainfraction/update') ?>" method="post">
            {{ csrf_field() }}
                <input type="hidden" name="id" value="<?= $infraction->id ?>">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <strong>Recipient: </strong>
                            <input type="text" name="name" class="form-control" placeholder="Position" value="<?= $employee->first_name.' '.$employee->last_name ?>" readonly>
                        </div> 
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <strong>Position: </strong>
                            <input type="text" name="position" class="form-control" placeholder="Position" value="<?= $employee->position_name ?>" readonly>
                        </div> 
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <strong>Department: </strong>
                            <input type="text" name="department" class="form-control" placeholder="Dept/Section" value="<?= $employee->team_name ?>" readonly>
                        </div> 
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <strong>Date Filed: </strong>
                            <input type="text" value="<?= date('m/d/Y', strtotime($infraction->created_at)) ?>" name="date_filed" class="form-control" placeholder="Date Filed" readonly autocomplete="off">
                        </div> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <strong>Title: </strong>
                            <input type="text" name="title" class="form-control" maxlength="200" placeholder="Title..." value="<?= $infraction->title ?>" required>
                        </div> 
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <strong>Date </strong>
                            <input type="text" name="date" class="form-control datepicker" placeholder="MM/DD/YYYY" placeholder="Date" autocomplete="off" value="<?= date('m/d/Y', strtotime($infraction->date)) ?>" required>
                        </div> 
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <strong>File </strong>
                            <input type="file" name="file" class="form-control" accept="application/pdf">
                        </div> 
                    </div>
                </div>
                <div class="col-md-12" style="border-top: 1px solid rgba(0,0,0,.125); padding-top: 15px; margin-top: 15px"></div>
                <div class="form-group pull-right">
                    <input type="submit" id="register-button" class="btn btn-primary" value="Update">
                    <input type="reset" class="btn btn-default" value="Reset">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<!-- <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea', forced_root_block : 'p' });</script> -->
<script type="text/javascript">
$(function(){
    activeMenu($('#menu-dainfraction'));

    $('.datepicker').datepicker();

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
            $('body').css({'pointer-events':'none'});
            obj.attr('disabled', true);
            obj.val('Please wait');
            form.submit();
        }
    });
});
</script>
@endsection
