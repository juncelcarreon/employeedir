@extends('layouts.main')
@section('content')
<style type="text/css">
    .panel-heading a{ color: #fff; }
    .panel-heading a.text-danger{ color: #ff0000; text-decoration: none; }
    /*.panel-heading a.active{ text-decoration: underline; }*/
    .panel-heading a.active{ color: #ffc107; text-decoration: none; }
    .panel-heading a.active, .panel-heading a:hover{ color: #ffc107; text-decoration: none; }
    .font-bold{ font-weight: 700; }
    .td-option{ width: 100px; text-align: center; }
    td span{ display: none; }
    tr.even{ background: #ddd !important; }
    .btn-dark{ background: #343a40; }
    .btn-dark:hover{ background: #000; color: #fff; }
    .btn{ color: #fff !important; }
    small{font-size:75% !important;}
</style>
<div class="panel panel-default">
    <div class="panel-heading">
        <a href="<?= url('overtime') ?>"<?= ($type == 'pending') ? ' class="active"' : '' ?>>PENDING</a> | 
        <a href="<?= url('overtime?status=approved') ?>"<?= ($type == 'approved') ? ' class="active"' : '' ?>>APPROVED</a> | 
        <a href="<?= url('overtime?status=verifying') ?>"<?= ($type == 'verifying') ? ' class="active"' : '' ?>>VERIFYING</a> | 
        <a href="<?= url('overtime?status=completed') ?>"<?= ($type == 'completed') ? ' class="active"' : '' ?>>COMPLETED</a> | 
        <a href="<?= url('overtime?status=declined') ?>"<?= ($type == 'declined') ? ' class="active"' : '' ?>>DECLINED</a>

        <a href="<?= url('overtime/create') ?>" class="btn btn-primary pull-right"><span class="fa fa-edit"></span>&nbsp; File Overtime</a>
        @if($is_leader > 0)
        <a href="<?= url('team-overtime') ?>" class="btn btn-dark pull-right" style="margin-right:10px;"><span class="fa fa-users"></span>&nbsp; Team Overtime</a>
        @endif
    </div>
    <div class="pane-body panel">
        <br>
        <br>
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
            $i = 1;
            foreach($overtime_request as $request) {
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
                    <td><?= $i ?></td>
                    <td><?= $request->first_name. " " .$request->last_name ?></td>
                    <td><?= (strlen(htmlentities($request->reason)) > 100) ? substr(htmlentities($request->reason), 0, 100)." ..." : htmlentities($request->reason) ?></td>
                    <td><span><?= strtotime($request->dates[0]) ?></span> <?= implode('<br>', $request->dates) ?></td>
                    <td><?= array_sum($request->no_of_hours) ?></td>
                    <td><?= $status ?></td>
                    <td><span><?= strtotime($request->created_at) ?></span> <?= date("M d, Y",strtotime($request->created_at)) ?></td>
                    <td class="td-option">
                        <a href="<?= url("overtime/{$request->id}") ?>" title="View" class="btn_view"><span class="fa fa-eye"></span></a>
                        &nbsp;&nbsp;
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
$(function () {
    activeMenu($('#menu-overtime'));

    $('._table').DataTable({"pageLength": 50});
});
</script>
@endsection