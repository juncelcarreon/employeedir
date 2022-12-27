@extends('layouts.main')
@section('title')
Timekeeping | Undertime > Create
@endsection
@section('head')
<style type="text/css">
@include('request.style');
</style>
@endsection
@section('breadcrumb')
Timekeeping <span>/</span> Undertime <span>></span> File Undertime
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <form action="<?= url('undertime') ?>" method="post">
        {{ csrf_field() }}
            <div class="panel panel-default m-0">
                <div class="panel-heading">
                    UNDERTIME REQUEST FORM

                    <a href="<?= url('undertime') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
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
                    UNDERTIME INFORMATION
                </div>
                <div class="panel-body timeline-container">
                    <div class="flex-center position-ref full-height">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <strong class="asterisk-required">Undertime Date:</strong>
                                    <input type="text" name="date" class="form-control undertime_date" placeholder="MM/DD/YYYY" autocomplete="off" required>
                                </div> 
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <strong class="asterisk-required">Time In:</strong>
                                    <div class="input-group datetimepicker time_in">
                                        <input type="text" name="time_in" class="form-control" onkeydown="return false" placeholder="MM/DD/YYYY 00:00 AM" autocomplete="off" required />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <strong class="asterisk-required">Time Out:</strong>
                                    <div class="input-group datetimepicker time_out">
                                        <input type="text" name="time_out" class="form-control" onkeydown="return false" placeholder="MM/DD/YYYY 00:00 AM" autocomplete="off" required />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
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
                            <input type="submit" class="btn btn-primary btn_submit" value="Submit">
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
    activeMenu($('#menu-undertime'));

    $('.datetimepicker').datetimepicker({ useCurrent: false });

    $('.undertime_date').datepicker();

    $(".time_in").on("dp.change", function (e) {
        $('.time_out').data("DateTimePicker").minDate(e.date);
    });

    $(".time_out").on("dp.change", function (e) {
        $('.time_in').data("DateTimePicker").maxDate(e.date);
    });

    $('input[type="reset"]').click(function(e) {
        e.preventDefault();

        var obj = $(this),
            form = obj.closest('form');

        form.find('input[required], textarea[required]').each(function() {
            $(this).val('');
            $(this).removeAttr('style');
        });
    });
});
</script>
@endsection
