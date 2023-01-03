@extends('layouts.main')
@section('title')
Timekeeping | Undertime
@endsection
@section('head')
<style type="text/css">
@include('request.style');
</style>
@endsection
@section('breadcrumb')
Timekeeping <span>/</span> Undertime <span>></span> <?= ucfirst($type) ?> List
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default m-0">
            <div class="panel-heading">
                <a href="<?= url('undertime') ?>" title="Pending Undertime"<?= ($type == 'pending') ? ' class="active"' : '' ?>>PENDING</a> | 
                <a href="<?= url('undertime?status=approved') ?>" title="Approved Undertime"<?= ($type == 'approved') ? ' class="active"' : '' ?>>APPROVED</a> | 
                <a href="<?= url('undertime?status=declined') ?>" title="Declined Undertime"<?= ($type == 'declined') ? ' class="active"' : '' ?>>DECLINED</a>

                <a href="<?= url('undertime/create') ?>" class="btn btn-primary pull-right"><span class="fa fa-edit"></span>&nbsp; File Undertime</a>
                <?php
                if($is_leader > 0) {
                ?>
                <a href="<?= url('team-undertime') ?>" class="btn btn-dark pull-right"><span class="fa fa-users"></span>&nbsp; Team Undertime</a>
                <?php
                }
                ?>
            </div>
            <div class="pane-body panel m-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width:50px;">#</th>
                            <th style="width:100px;">Employee</th>
                            <th style="width:150px;">Reason</th>
                            <th>Date</th>
                            <th>No. Of Hours</th>
                            <th>Status</th>
                            <th>Date<br> Requested</th>
                            <th style="width:80px;">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($undertime_request as $no=>$request) {
                    ?>
                        <tr>
                            <td><?= ++$no ?></td>
                            <td><?= $request->first_name. " " .$request->last_name ?></td>
                            <td title="<?= htmlentities($request->reason) ?>"><?= stringLimit($request->reason, 100) ?></td>
                            <td><span class="d-none"><?= strtotime($request->date) ?></span> <?= date("M d, Y", strtotime($request->date)) ?></td>
                            <td><?= numberOfHours($request->time_in, $request->time_out, true) ?></td>
                            <td><?= timekeepingStatus($request) ?></td>
                            <td><span class="d-none"><?= strtotime($request->created_at) ?></span> <?= date("M d, Y", strtotime($request->created_at)) ?></td>
                            <td class="text-center">
                                <a href="<?= url("undertime/{$request->id}") ?>" title="View" class="btn_view">
                                    <i class="fa fa-eye"></i>
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
@include('request.js-script');
@endsection