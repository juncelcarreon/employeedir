@extends('layouts.main')
@section('title')
Blog Posts > Activities
@endsection
@section('breadcrumb')
Blog Posts <span>></span> Activities
@endsection
@section('content')
<style type="text/css">
@include('activity.style');
</style>
<div class="panel panel-default">
    <div class="panel-heading">
        List of Activities

        <a href="<?= url('activities/create') ?>" class="btn btn-primary pull-right" ><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Activity</a>
    </div>
    <div class="pane-body panel">
        <br>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th align="left">#</th>
                    <th>Activity Title</th>
                    <th>Subtitle</th>
                    <th>Message</th>
                    <th>Image</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            foreach($activities as $activity) {
            ?>
                <tr> 
                    <td><?= $i ?></td>
                    <td><?= $activity->title ?></td>
                    <td><?= $activity->subtitle ?></td>
                    <td><?= truncate($activity->message, 50, false) ?></td>
                    <td align="center">
                        <a target="_blank" href="<?= $activity->image_url ?>" >
                            <img src="<?= $activity->image_url ?>" style=" height: 40px;" />
                        </a>
                    </td>
                    <td align="center">
                        <a href="<?= url("activities/{$activity->id}/edit") ?>" title="Edit">
                            <i class="fa fa-pencil"></i>
                        </a>&nbsp;&nbsp;
                        <a href="#" class="delete_btn" data-toggle="modal" data-target="#messageModal" title="Delete" data-id="<?= $activity->id ?>">
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
<script type="text/javascript">
$(function() {
    activeMenu($('#menu-activities'));

    $('.delete_btn').click(function(){
        $('#messageModal .modal-title').html('Delete Activity');
        $('#messageModal #message').html('Are you sure you want to delete the activity ?');
        $('#messageModal .delete_form').attr('action', "{{ url('activities') }}/" + $(this).attr("data-id"));
    });

    $('#messageModal #yes').click(function(){
        $('#messageModal .delete_form').submit();
    });
});
</script>
@endsection 