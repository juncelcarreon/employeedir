@extends('layouts.main')
@section('title')
    Blog Posts | Events > Calendar
@endsection
@section('head')
    <link href='<?= asset('./css/fullcalendar/main.min.css') ?>' rel='stylesheet' />
    <link href='<?= asset('./css/fullcalendar/daygrid.min.css') ?>' rel='stylesheet' />
    <link href='<?= asset('./css/fullcalendar/list.min.css') ?>' rel='stylesheet' />
    <link href='<?= asset('./css/fullcalendar/timegrid.min.css') ?>' rel='stylesheet' />

    <script src='<?= asset('./js/fullcalendar/main.min.js') ?>'></script>
    <script src='<?= asset('./js/fullcalendar/list.min.js') ?>'></script>
    <script src='<?= asset('./js/fullcalendar/daygrid.min.js') ?>'></script>
    <script src='<?= asset('./js/fullcalendar/timegrid.min.js') ?>'></script>
    <script src='<?= asset('./js/fullcalendar/interaction.min.js') ?>'></script>
@endsection
@section('content')
<style>
    #events_calendar{
        width: 1000px;
        margin: 0 auto;
    }
    .fc-scroller {
        overflow-y: hidden !important;
    }
    .fc-view table{
        background: white;
    }
    span.event-tooltip {
        display: block;
        background: #22222266;
        border-radius: 5px;
        padding: 6px;
        position: absolute;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div id="events_calendar" class="text-right">
        <br>
        <?php
            if(Auth::check() && Auth::user()->isAdmin()) {
        ?>
            <a href="<?= url('events') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
            <a class="btn btn-primary pull-right" href="<?= url('events/create') ?>" style="margin-right: 5px;"><i class="fa fa-plus"></i>&nbsp; Add Event</a>
        <?php
            }
        ?>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
let events = [];
document.addEventListener('DOMContentLoaded', function() {
    $.get("<?= url('events/lists') ?>", function(data){

        for(let i=0; i < data.length ; i++){
            events.push({id: data[i].id, title: data[i].event_name, start: data[i].start_date, end: data[i].end_date, color: data[i].event_color, url: "{{ url('events') }}" + "/" + data[i].id });
        }

        let calendarEl = document.getElementById('events_calendar');

        let calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
            defaultView: 'dayGridMonth',
            //defaultDate: '2019-03-07',
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listMonth'
            },
            events: events
        });

        calendar.render();
    });
});
$(function() {
    activeMenu($('#menu-events'));
});
</script>
@endsection