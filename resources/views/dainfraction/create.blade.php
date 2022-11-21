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

        <a href="<?= url('dainfraction') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
    </div>
    <div class="panel-body timeline-container">
        <div class="flex-center position-ref full-height">
            <form enctype="multipart/form-data" action="<?= url('dainfraction') ?>" method="post">
            {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <strong>Recipient: </strong>
                            <select name="employee_id" class="form-control select2" <?= Auth::user()->isAdmin() ? '' : 'readonly' ?>>
                                @foreach($employees as $employee)
                                    <option value="<?= $employee->id ?>" data-position="<?= $employee->position_name ?>" data-department="<?= $employee->team_name ?>" <?= Auth::user()->id == $employee->id ? ' selected' : '' ?>><?= $employee->fullName2() ?></option>
                                @endforeach
                            </select>
                        </div> 
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <strong>Position: </strong>
                            <input type="text" name="position" class="form-control" placeholder="Position" value="<?= Auth::user()->position_name ?>" readonly>
                        </div> 
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <strong>Department: </strong>
                            <input type="text" name="department" class="form-control" placeholder="Dept/Section" value="<?= Auth::user()->team_name ?>" readonly>
                        </div> 
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <strong>Date Filed: </strong>
                            <input type="text" value="<?= date('m/d/Y') ?>" name="date_filed" class="form-control" placeholder="Date Filed" readonly autocomplete="off">
                        </div> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <strong>Title: </strong>
                            <input type="text" name="title" class="form-control" maxlength="200" placeholder="Title..." required>
                        </div> 
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <strong>Date </strong>
                            <input type="text" name="date" class="form-control datepicker" placeholder="MM/DD/YYYY" placeholder="Date" autocomplete="off" required>
                        </div> 
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <strong>File </strong>
                            <input type="file" name="file" class="form-control" accept="application/pdf" required>
                        </div> 
                    </div>
                </div>
                <div class="col-md-12" style="border-top: 1px solid rgba(0,0,0,.125); padding-top: 15px; margin-top: 15px"></div>
                <div class="form-group pull-right">
                    <input type="submit" id="register-button" class="btn btn-primary" value="Submit">
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

    $('.select2').change(function() {
        var obj = $(this),
            position = $(obj).find(":selected").data('position'),
            department = $(obj).find(":selected").data('department');

        $('input[name="position"]').val(position);
        $('input[name="department"]').val(department);
    });

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
