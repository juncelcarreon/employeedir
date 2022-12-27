@extends('layouts.main')
@section('title')
Blog Post > Activities
@endsection
@section('head')
<style type="text/css">
@include('activity.style');
</style>
@endsection
@section('breadcrumb')
Blog Post <span>></span> Activities
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default m-0">
            <div class="panel-heading">
                List of Activities

                <a href="<?= url('activities/create') ?>" class="btn btn-primary pull-right" ><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Activity</a>
            </div>
            <div class="pane-body panel m-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Activity Title</th>
                            <th>Subtitle</th>
                            <th>Date</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($activities as $no=>$activity) {
                    ?>
                        <tr> 
                            <td><?= ++$no ?></td>
                            <td title="<?= $activity->title ?>"><?= stringLimit($activity->title, 100) ?></td>
                            <td title="<?= $activity->subtitle ?>"><?= stringLimit($activity->subtitle) ?></td>
                            <td><?= prettyDate($activity->activity_date) ?></td>
                            <td>
                                <a target="_blank" href="<?= $activity->image_url ?>" >
                                    <img src="<?= $activity->image_url ?>" alt="<?= $activity->title ?>" />
                                </a>
                            </td>
                            <td>
                                <a href="<?= url("activities/{$activity->id}/edit") ?>" title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </a>&nbsp;&nbsp;
                                <a href="#" class="delete_btn" data-toggle="modal" data-target="#messageModal" title="Delete" data-id="<?= $activity->id ?>">
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
@include('activity.js-script')
@endsection