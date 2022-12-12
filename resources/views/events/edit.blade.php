@extends('layouts.main')
@section('title')
Blog Posts > Events > Edit Event
@endsection
@section('breadcrumb')
Blog Posts <span>/</span> Events <span>></span> Edit Event
@endsection
@section('head')
    <link href="<?= asset('./css/spectrum.css') ?>" rel="stylesheet">

    <script src='<?= asset('./js/spectrum.js') ?>'></script>
@endsection
@section('content')
<style>
@include('events.style');
</style>
<div class="panel panel-default">
    <div class="panel-heading">
        Edit Event

        <a href="<?= url()->previous() ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
    </div>
    <div class="panel-body timeline-container">
        <div class="flex-center position-ref full-height">
            {{ Form::open(array('url' => 'events/' . $event->id, 'files' => false ,'id' => 'edit_events')) }}
            {{ Form::hidden('_method', 'PUT') }}
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Event Name</label>
                            <input class="form-control" name="event_name" value="<?= $event->event_name ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Event Description</label>
                            <input class="form-control" name="event_description" value="<?= $event->event_description ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Start Date</label>
                            <input class="form-control" name="start_date" id="start_date" value="<?= timeDate($event->start_date) ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>End Date</label>
                            <input class="form-control" name="end_date" id="end_date" value="<?= timeDate($event->end_date) ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Event Color</label>
                            <input type="text" id="event_color" name="event_color" value="<?= $event->event_color ?>"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="border-top: 1px solid rgba(0,0,0,.125); padding-top: 15px; margin-top: 15px"></div>
                <div class="form-group pull-right">
                    <input type="submit" class="btn btn-primary btn_submit" value="Update">
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
$(function() {
    activeMenu($('#menu-events'));

    $('#start_date').datetimepicker({
        maxDate: new Date('<?= $event->end_date ?>')
    });
    $('#end_date').datetimepicker({
        minDate: new Date('<?= $event->start_date ?>'),
        useCurrent: false //Important! See issue #1075
    });
    $("#start_date").on("dp.change", function (e) {
        $('#end_date').data("DateTimePicker").minDate(e.date);
    });
    $("#end_date").on("dp.change", function (e) {
        $('#start_date').data("DateTimePicker").maxDate(e.date);
    });

    var pallettes = [
        ["#ffffff", "#000000", "#efefe7", "#184a7b", "#4a84bd", "#c6524a", "#9cbd5a", "#8463a5", "#4aadc6", "#f79442"],
        ["#f7f7f7", "#7b7b7b", "#dedec6", "#c6def7", "#dee7f7", "#f7dede", "#eff7de", "#e7e7ef", "#deeff7", "#ffefde"],
        ["#dedede", "#5a5a5a", "#c6bd94", "#8cb5e7", "#bdcee7", "#e7bdb5", "#d6e7bd", "#cec6de", "#b5deef", "#ffd6b5"],
        ["#bdbdbd", "#393939", "#948c52", "#528cd6", "#94b5d6", "#de9494", "#c6d69c", "#b5a5c6", "#94cede", "#ffc68c"],
        ["#a5a5a5", "#212121", "#4a4229", "#10315a", "#316394", "#943131", "#739439", "#5a4a7b", "#31849c", "#e76b08"],
        ["#848484", "#080808", "#181810", "#082139", "#214263", "#632121", "#4a6329", "#393152", "#215a63", "#944a00"],
        ["#c60000", "#ff0000", "#ffc600", "#ffff00", "#94d652", "#00b552", "#00b5f7", "#0073c6", "#002163", "#7331a5"],

    ];

    $("#event_color").spectrum({
        color: '{{ $event->event_color }}',
        hideAfterPaletteSelect:true,
        showPalette: true,
        showSelectionPalette: true, // true by default
        palette: pallettes
    });
    $("#event_color").show();
    $("#event_color").attr('type', 'hidden');
});
</script>
@endsection