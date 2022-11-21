@extends('layouts.main')
@section('title')
    Blog Posts | Events
@endsection
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        Events List

        <a href="<?= url('events/create') ?>" class="btn btn-primary pull-right"><span class="fa fa-plus"></span>&nbsp; Add Event</a>
        <a href="<?= url('events/calendar') ?>" class="btn btn-info pull-right" style="margin-right: 10px;"><span class="fa fa-calendar"></span>&nbsp; Calendar View</a>
    </div>
    <div class="pane-body panel">
        <br>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <td>#</td>
                    <td>Name</td>
                    <td>Description</td>
                    <td>Start Date</td>
                    <td>End Date</td>
                    <td>Tip Color</td>
                    <td>Option</td>
                </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            foreach($events as $event) {
            ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= $event->event_name ?></td>
                    <td><?= $event->event_description ?></td>
                    <td><?= prettyDate($event->start_date) ?></td>
                    <td><?= prettyDate($event->end_date) ?></td>
                    <td>
                        <div style="background: <?= $event->event_color ?>; width: 20px; height: 20px; margin:0 auto;"></div>
                    </td>
                    <td>
                        <a title="View" href="<?= url("events/{$event->id}") ?>"><span class="fa fa-eye"></span></a>&nbsp;&nbsp;
                        <a title="Edit" href="<?= url("events/{$event->id}/edit") ?>"><span class="fa fa-pencil"></span></a>&nbsp;&nbsp;
                        <a href="#" class="delete_btn" data-toggle="modal" data-target="#messageModal" title="Delete" data-id="<?= $event->id ?>">
                            <i class="fa fa-trash" style="color: red;" ></i>
                        </a>
                    </td>
                </tr>
            <?php
            $i++;
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('scripts')
<script>
$(function() {
    activeMenu($('#menu-events'));

    $('.delete_btn').click(function(){
        $('#messageModal .modal-title').html('Delete Event');
        $('#messageModal #message').html('Are you sure you want to delete the activity ?');
        $('#messageModal .delete_form').attr('action', "<?= url('events') ?>/" + $(this).attr("data-id"));
    });
    $('#messageModal #yes').click(function(){
        $('#messageModal .delete_form').submit();
    });
});
</script>
@endsection