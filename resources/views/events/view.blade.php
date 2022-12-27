@extends('layouts.main')
@section('title')
Blog Post > Events > <?= $event->event_name ?>
@endsection
@section('head')
@include('events.style')
@endsection
@section('breadcrumb')
Blog Post <span>/</span> Events <span>></span> <?= $event->event_name ?>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default m-0">
            <div class="panel-heading">
                View Event

                <?php
                $url = url('events/calendar');
                if(Auth::user()->isAdmin()) { $url = url('events'); }
                ?>
                <a href="<?= $url ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
            </div>
            <div class="panel-body timeline-container">
                <div class="row">
                    <div class="col-md-12">
                        <table id="table-view">
                            <tr>
                                <td>Event Name</td>
                                <td><?= $event->event_name ?></td>
                            </tr>
                            <tr>
                                <td>Event Description</td>
                                <td><?= $event->event_description ?></td>
                            </tr>
                            <tr>
                                <td>Start Date</td>
                                <td><?= prettyDate($event->start_date) ?></td>
                            </tr>
                            <tr>
                                <td>End Date</td>
                                <td><?= prettyDate($event->end_date) ?></td>
                            </tr>
                            <tr>
                                <td>Tip Color</td>
                                <td><div class="tip-color" style="background: <?= $event->event_color ?>;"></div></td>
                            </tr>
                            <tr>
                                <td>Create Date</td>
                                <td><?= prettyDate($event->created_at) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <?php
                    if(Auth::check() && Auth::user()->isAdmin()) {
                ?>
                <div class="division"></div>
                <div class="form-group pull-right">
                    <a href="<?= url("events/{$event->id}/edit") ?>" class="btn btn-primary pull-right">Edit</a>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@include('events.js-script')
@endsection