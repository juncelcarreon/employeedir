@extends('layouts.main')
@section('title')
Request | Undertime
@endsection
@section('content')
<style>
@include('request.style');
</style>
<div class="panel panel-default">
    <div class="panel-heading">
        <a href="<?= url('undertime') ?>"<?= ($type == 'pending') ? ' class="active"' : '' ?>>PENDING</a> | 
        <a href="<?= url('undertime?status=approved') ?>"<?= ($type == 'approved') ? ' class="active"' : '' ?>>APPROVED</a> | 
        <a href="<?= url('undertime?status=declined') ?>"<?= ($type == 'declined') ? ' class="active"' : '' ?>>DECLINED</a>

        <a href="<?= url('undertime/create') ?>" class="btn btn-primary pull-right"><span class="fa fa-edit"></span>&nbsp; File Undertime</a>
        <?php
        if($is_leader > 0) {
        ?>
        <a href="<?= url('team-undertime') ?>" class="btn btn-dark pull-right" style="margin-right:10px;"><span class="fa fa-users"></span>&nbsp; Team Undertime</a>
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
                    <th style="width:200px;">Reason</th>
                    <th style="width:80px;">Date</th>
                    <th>No. Of Hours</th>
                    <th>Status</th>
                    <th>Date<br> Requested</th>
                    <th style="width:80px;">Options</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach($undertime_request as $no=>$request) {
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

                $no_of_hours = 0;
                if(!empty($request->time_in) && !empty($request->time_out)) {
                    $start = new DateTime($request->time_in);
                    $end = $start->diff(new DateTime($request->time_out));
                    $end->d = $end->d * 24;
                    $end->h = ($end->h - 1) + $end->d;

                    $no_of_hours = $end->h;
                }
            ?>
                <tr>
                    <td><?= ++$no ?></td>
                    <td><?= $request->first_name. " " .$request->last_name ?></td>
                    <td><?= (strlen(htmlentities($request->reason)) > 100) ? substr(htmlentities($request->reason), 0, 100)." ..." : htmlentities($request->reason) ?></td>
                    <td><span><?= strtotime($request->date) ?></span> <?= date("M d, Y", strtotime($request->date)) ?></td>
                    <td><?= number_format($no_of_hours, 2) ?></td>
                    <td><?= $status ?></td>
                    <td><span><?= strtotime($request->created_at) ?></span> <?= date("M d, Y", strtotime($request->created_at)) ?></td>
                    <td class="td-option">
                        <a href="<?= url("undertime/{$request->id}") ?>" title="View" class="btn_view"><b class="fa fa-eye"></b></a>
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
    activeMenu($('#menu-undertime'));

    $('._table').DataTable({"pageLength": 50}); 
});
</script>
@endsection