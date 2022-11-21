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
        OVERTIME REQUEST FORM

        <a href="<?= url("overtime/{$overtime->id}") ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
    </div>
    <div class="panel-body timeline-container ">
        <div class="flex-center position-ref full-height">
            <form action="<?= url('overtime/update') ?>" method="post">
            {{ csrf_field() }}
                <input type="hidden" name="id" value="<?= $overtime->id ?>">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <strong>Name: </strong>
                            <input type="text" name="name" class="form-control" placeholder="Position" value="<?= $overtime->first_name.' '.$overtime->last_name ?>" readonly>
                        </div> 
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <strong>Position: </strong>
                            <input type="text" name="position" class="form-control" placeholder="Position" value="<?= $overtime->position_name ?>" readonly>
                        </div> 
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <strong>Department: </strong>
                            <input type="text" name="department" class="form-control" placeholder="Dept/Section" value="<?= $overtime->team_name ?>" readonly>
                        </div> 
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <strong>Date Filed: </strong>
                            <input type="text" value="<?= date('m/d/Y',strtotime($overtime->created_at)) ?>" name="date_filed" class="form-control" placeholder="Date Filed" readonly autocomplete="off">
                        </div> 
                    </div>
                </div>
                <div class="entry-content">
                <?php
                foreach($overtime->dates as $key=>$date) {
                ?>
                    <div class="row row-entry">
                        <div class="col-md-4">
                            <input type="hidden" name="time_in[]" value="<?= $overtime->time_in[$key] ?>">
                            <input type="hidden" name="time_out[]" value="<?= $overtime->time_out[$key] ?>">
                            <div class="form-group">
                                <strong>Overtime Date: </strong>
                                <input type="text" name="date[]" class="form-control overtime_date" placeholder="MM/DD/YYYY" value="<?= date('m/d/Y',strtotime($date)) ?>" autocomplete="off" required>
                            </div> 
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Number of Hours: </strong>
                                <input type="number" name="no_of_hours[]" class="form-control" value="<?= $overtime->no_of_hours[$key] ?>" min="1" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>&nbsp; </strong>
                                <button class="btn btn-<?= ($key == 0) ? 'primary' : 'danger' ?> btn-<?= ($key == 0) ? 'add' : 'remove' ?>"><span class="fa fa-<?= ($key == 0) ? 'plus' : 'minus' ?>"></span></button>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>Reason: </strong>
                            <textarea name="reason" class="form-control" rows="4" required><?= $overtime->reason ?></textarea>
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
    activeMenu($('#menu-overtime'));

    $('.overtime_date').datepicker({
        minDate: 0
    });

    $('.btn-add').click(function(e) {
        e.preventDefault();

        var obj = $(this),
            parent = obj.closest('.entry-content'),
            entry = parent.find('.row-entry:first'),
            entry_last = parent.find('.row-entry:last');

        var new_entry = entry.clone().insertAfter(entry_last);
            new_entry.find('.btn-add').html('<span class="fa fa-minus"></span>');
            new_entry.find('.btn-add').removeClass('btn-primary').addClass('btn-danger');
            new_entry.find('.btn-add').removeClass('btn-add').addClass('btn-remove')
            new_entry.find('.overtime_date').removeAttr('id').removeClass('hasDatepicker').removeData('datepicker').unbind().datepicker({ 
                minDate: 0 
            });
            new_entry.find('.overtime_date').val('');
            new_entry.find('input[type="number"]').val('1.00');
            new_entry.find('input[type="hidden"]').val('');
            new_entry.find('.btn-remove').click(function(e) {
                e.preventDefault();
                $(this).closest('.row-entry').remove();
            });
    });

    $('.btn-remove').click(function(e) {
        e.preventDefault();
        $(this).closest('.row-entry').remove();
    });

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

    $('input[type="reset"]').click(function(e) {
        e.preventDefault();

        var obj = $(this),
            form = obj.closest('form');

        form.find('input[required], textarea[required]').each(function() {
            $(this).val('');
        });
    });
});
</script>
@endsection