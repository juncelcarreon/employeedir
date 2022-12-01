@extends('layouts.main')
@section('title')
Request | Overtime
@endsection
@section('content')
<style>
@include('request.style');
</style>
<div class="panel panel-default">
    <div class="panel-heading">
        <a href="<?= url('overtime') ?>"<?= ($type == 'pending') ? ' class="active"' : '' ?>>PENDING</a> | 
        <a href="<?= url('overtime?status=approved') ?>"<?= ($type == 'approved') ? ' class="active"' : '' ?>>APPROVED</a> | 
        <a href="<?= url('overtime?status=verifying') ?>"<?= ($type == 'verifying') ? ' class="active"' : '' ?>>VERIFYING</a> | 
        <a href="<?= url('overtime?status=completed') ?>"<?= ($type == 'completed') ? ' class="active"' : '' ?>>COMPLETED</a> | 
        <a href="<?= url('overtime?status=declined') ?>"<?= ($type == 'declined') ? ' class="active"' : '' ?>>DECLINED</a>

        <a href="<?= url('overtime/create') ?>" class="btn btn-primary pull-right"><span class="fa fa-edit"></span>&nbsp; File Overtime</a>
        <?php
        if($is_leader > 0) {
        ?>
        <a href="<?= url('team-overtime') ?>" class="btn btn-dark pull-right" style="margin-right:10px;"><span class="fa fa-users"></span>&nbsp; Team Overtime</a>
        <?php
        }
        ?>
    </div>
    <div class="pane-body panel">
        <table class="_table">
            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th>Employee</th>
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
                $status = $request->status;
                if($request->status == 'APPROVED' && !empty($request->approved_reason)) {
                    $status = 'REVERTED';
                }
                if($request->status == 'PENDING') {
                    if(empty($request->recommend_date)) {
                        $status .= ' <br><small>(Recommendation / Approval)</small>';
                    } else {
                        $status .= ' <br><small>(Approval)</small>';
                    }
                }
            ?>
                <tr>
                    <td><?= ++$no ?></td>
                    <td><?= $request->first_name. " " .$request->last_name ?></td>
                    <td><?= (strlen(htmlentities($request->reason)) > 100) ? substr(htmlentities($request->reason), 0, 100)." ..." : htmlentities($request->reason) ?></td>
                    <td><span><?= strtotime($request->dates[0]) ?></span> <?= implode('<br>', $request->dates) ?></td>
                    <td><?= array_sum($request->no_of_hours) ?></td>
                    <td><?= $status ?></td>
                    <td><span><?= strtotime($request->created_at) ?></span> <?= date("M d, Y",strtotime($request->created_at)) ?></td>
                    <td class="td-option">
                        <a href="<?= url("overtime/{$request->id}") ?>" title="View"><b class="fa fa-eye"></b></a>
                    </td>
                </tr>
            <?php 
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
$(function() {
    activeMenu($('#menu-overtime'));

    $('._table').DataTable({"pageLength": 50});
});
</script>
@endsection