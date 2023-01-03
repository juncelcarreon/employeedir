@extends('layouts.main')
@section('title')
Timekeeping | Overtime
@endsection
@section('head')
<style type="text/css">
@include('request.style');
</style>
@endsection
@section('breadcrumb')
Timekeeping <span>/</span> Overtime <span>></span> <?= ucfirst($type) ?> List
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default m-0">
            <div class="panel-heading">
                <a href="<?= url('overtime') ?>" title="Pending Overtime"<?= ($type == 'pending') ? ' class="active"' : '' ?>>PENDING</a> | 
                <a href="<?= url('overtime?status=approved') ?>" title="Approved Overtime"<?= ($type == 'approved') ? ' class="active"' : '' ?>>APPROVED</a> | 
                <a href="<?= url('overtime?status=verifying') ?>" title="Verifying Overtime"<?= ($type == 'verifying') ? ' class="active"' : '' ?>>VERIFYING</a> | 
                <a href="<?= url('overtime?status=completed') ?>" title="Completed Overtime"<?= ($type == 'completed') ? ' class="active"' : '' ?>>COMPLETED</a> | 
                <a href="<?= url('overtime?status=declined') ?>" title="Declined Overtime"<?= ($type == 'declined') ? ' class="active"' : '' ?>>DECLINED</a>

                <a href="<?= url('overtime/create') ?>" class="btn btn-primary pull-right"><span class="fa fa-edit"></span>&nbsp; File Overtime</a>
                <?php
                if($is_leader > 0) {
                ?>
                <a href="<?= url('team-overtime') ?>" class="btn btn-dark pull-right"><span class="fa fa-users"></span>&nbsp; Team Overtime</a>
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
                            <th>Estimated<br> No. Of Hours</th>
                            <th>Status</th>
                            <th>Date<br> Requested</th>
                            <th style="width:80px;">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($overtime_request as $no=>$request) {
                    ?>
                        <tr>
                            <td><?= ++$no ?></td>
                            <td><?= $request->first_name. " " .$request->last_name ?></td>
                            <td title="<?= htmlentities($request->reason) ?>"><?= stringLimit($request->reason, 100) ?></td>
                            <td><span class="d-none"><?= strtotime($request->dates[0]) ?></span> <?= implode('<br>', $request->dates) ?></td>
                            <td><?= array_sum($request->no_of_hours) ?></td>
                            <td><?= timekeepingStatus($request) ?></td>
                            <td><span class="d-none"><?= strtotime($request->created_at) ?></span> <?= date("M d, Y",strtotime($request->created_at)) ?></td>
                            <td class="text-center">
                                <a href="<?= url("overtime/{$request->id}") ?>" title="View">
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