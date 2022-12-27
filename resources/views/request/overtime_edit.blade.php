@extends('layouts.main')
@section('title')
Timekeeping | Overtime > Edit Overtime Application
@endsection
@section('head')
<style type="text/css">
@include('request.style');
</style>
@endsection
@section('breadcrumb')
Timekeeping <span>/</span> Overtime <span>></span> Edit Overtime
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <form action="<?= url('overtime/update') ?>" method="post">
        {{ csrf_field() }}
            <input type="hidden" name="id" value="<?= $overtime->id ?>" />
            <div class="panel panel-default m-0">
                <div class="panel-heading">
                    OVERTIME REQUEST FORM

                    <a href="<?= url("overtime/{$overtime->id}") ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
                </div>
                <div class="panel-body timeline-container">
                    <div class="flex-center position-ref full-height">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Name:</strong>
                                    <p><?= $overtime->first_name.' '.$overtime->last_name ?></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Position:</strong>
                                    <p><?= $overtime->position_name ?></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <strong>Department:</strong>
                                    <p><?= $overtime->team_name ?></p>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <strong>Date Filed:</strong>
                                    <p><?= date('m/d/Y',strtotime($overtime->created_at)) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-heading panel-subheading">
                    OVERTIME INFORMATION
                </div>
                <div class="panel-body timeline-container">
                    <div class="flex-center position-ref full-height">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <strong class="asterisk-required">Overtime Date:</strong>
                                </div> 
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <strong class="asterisk-required">Estimated No. of Hours:</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <strong>&nbsp;</strong>
                                </div>
                            </div>
                        </div>
                        <div class="entry-content">
                        <?php
                        foreach($overtime->dates as $key=>$date) {
                        ?>
                            <input type="hidden" name="time_in[]" value="<?= $overtime->time_in[$key] ?>" />
                            <input type="hidden" name="time_out[]" value="<?= $overtime->time_out[$key] ?>" />
                            <div class="row row-entry">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" name="date[]" class="form-control overtime_date" placeholder="MM/DD/YYYY" value="<?= date('m/d/Y',strtotime($date)) ?>" autocomplete="off" onkeydown="return false" required />
                                    </div> 
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="number" name="no_of_hours[]" class="form-control" value="<?= $overtime->no_of_hours[$key] ?>" min="1" required />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <button class="btn btn-<?= ($key == 0) ? 'primary' : 'danger' ?> btn-<?= ($key == 0) ? 'add' : 'remove' ?>">
                                            <span class="fa fa-<?= ($key == 0) ? 'plus' : 'minus' ?>"></span>
                                        </button>
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
                                    <strong class="asterisk-required">Reason:</strong>
                                    <textarea name="reason" class="form-control" rows="4" required><?= $overtime->reason ?></textarea>
                                </div> 
                            </div>
                        </div>
                        <div class="division"></div>
                        <div class="form-group pull-right">
                            <input type="submit" class="btn btn-primary" value="Update">
                            <input type="reset" class="btn btn-default" value="Reset">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
$(function(){
    activeMenu($('#menu-overtime'));

    $('.overtime_date').datepicker();

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
            new_entry.find('.overtime_date').removeAttr('id').removeClass('hasDatepicker').removeData('datepicker').unbind().datepicker();
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
            if($(this).attr('type') == 'number') {
                $(this).val('1.00');
            }
        });
    });
});
</script>
@endsection