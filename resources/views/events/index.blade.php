@extends('layouts.main')
@section('title')
Blog Post > Events
@endsection
@section('head')
@include('events.style')
@endsection
@section('breadcrumb')
Blog Post <span>></span> Events
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default m-0">
            <div class="panel-heading">
                Events List

                <a href="<?= url('events/create') ?>" class="btn btn-primary pull-right"><span class="fa fa-plus"></span>&nbsp; Add Event</a>
                <a href="<?= url('events/calendar') ?>" class="btn btn-info pull-right"><span class="fa fa-calendar"></span>&nbsp; Calendar View</a>
            </div>
            <div class="pane-body panel m-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Tip Color</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($events as $no=>$event) {
                    ?>
                        <tr>
                            <td><?= ++$no ?></td>
                            <td title="<?= $event->event_name ?>"><?= stringLimit($event->event_name, 100) ?></td>
                            <td title="<?= $event->event_description ?>"><?= stringLimit($event->event_description, 100) ?></td>
                            <td><span class="d-none"><?= strtotime($event->start_date) ?></span> <?= prettyDate($event->start_date) ?></td>
                            <td><span class="d-none"><?= strtotime($event->end_date) ?></span> <?= prettyDate($event->end_date) ?></td>
                            <td class="data-center">
                                <div class="tip-color" style="background-color:<?= $event->event_color ?>;"></div>
                            </td>
                            <td>
                                <a title="View" href="<?= url("events/{$event->id}") ?>">
                                    <i class="fa fa-eye"></i>
                                </a>&nbsp;&nbsp;
                                <a title="Edit" href="<?= url("events/{$event->id}/edit") ?>">
                                    <i class="fa fa-pencil"></i>
                                </a>&nbsp;&nbsp;
                                <a href="#" class="delete_btn" data-toggle="modal" data-target="#messageModal" title="Delete" data-id="<?= $event->id ?>">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@include('events.js-script')
@endsection