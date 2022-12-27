@extends('layouts.main')
@section('title')
Timekeeping | Overtime > Create
@endsection
@section('head')
<style type="text/css">
@include('request.style');
</style>
@endsection
@section('breadcrumb')
Timekeeping <span>/</span> Overtime <span>></span> File Overtime
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <form action="<?= url('overtime') ?>" method="post">
        {{ csrf_field() }}
            <div class="panel panel-default m-0">
                <div class="panel-heading">
                    OVERTIME REQUEST FORM

                    <a href="<?= url('overtime') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
                </div>
                <div class="panel-body timeline-container">
                    <div class="flex-center position-ref full-height">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Name:</strong>
                                    <p><?= Auth::user()->fullname2() ?></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Position:</strong>
                                    <p><?= Auth::user()->position_name ?></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <strong>Department:</strong>
                                    <p><?= Auth::user()->team_name ?></p>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <strong>Date Filed:</strong>
                                    <p><?= date('m/d/Y') ?></p>
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
                            <div class="row row-entry">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" name="date[]" class="form-control overtime_date" placeholder="MM/DD/YYYY" autocomplete="off" onkeydown="return false" required />
                                    </div> 
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="number" name="no_of_hours[]" class="form-control" value="1.00" min="1" required />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-add">
                                            <span class="fa fa-plus"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <strong class="asterisk-required">Reason:</strong>
                                    <textarea name="reason" class="form-control" rows="4" required></textarea>
                                </div> 
                            </div>
                        </div>
                        <div class="division"></div>
                        <div class="form-group pull-right">
                            <input type="submit" class="btn btn-primary btn_submit" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
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
            new_entry.find('.btn-remove').click(function(e) {
                e.preventDefault();
                $(this).closest('.row-entry').remove();
            });
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
