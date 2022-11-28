@extends('layouts.main')
@section('title')
    Request | Leaves List
@endsection
@section('content')
<style type="text/css">
    .panel-heading a{ color: #fff; }
    .panel-heading a.text-danger{ color: #ff0000; }
    .panel-heading a.active{ text-decoration: underline; }
    .font-bold{ font-weight: 700; }
    .td-option{ width: 100px; text-align: center; }
    td span{ display: none; }
    tr.even{ background: #ddd !important; }
    .btn-dark{ background: #343a40; }
    .btn-dark:hover{ background: #000; color: #fff; }
    small{font-size:75% !important;}
</style>
<div class="panel panel-default">
    <div class="panel-heading">
        <a href="<?= url('leave') ?>"<?= ($type == 'pending') ? ' class="active"' : '' ?>>Pending Leaves</a> | 
        <a href="<?= url('approved-leaves') ?>"<?= ($type == 'approve') ? ' class="active"' : '' ?>>Approved Leaves</a> | 
        <a href="<?= url('cancelled-leaves') ?>" class="text-danger<?= ($type == 'cancelled') ? ' active' : '' ?>">Cancelled Leaves</a> <!-- | -->

        <a href="<?= url('leave/create') ?>" class="btn btn-primary pull-right"><span class="fa fa-edit"></span>&nbsp; File A Leave</a>
        <?php
        if(Auth::check()) {
            if(Auth::user()->dept_code == 'OE01' && !Auth::user()->isAdmin()) {
        ?>
                <a href="<?= url('approved-lists') ?>" class="btn btn-success pull-right" style="margin-right:10px;"><span class="fa fa-check"></span>&nbsp; Approved Leaves</a>
        <?php
            }
            if(Auth::user()->isAdmin()) {
        ?>
                <a href="<?= url('expanded-credits') ?>" class="btn btn-info pull-right" style="margin-right:10px;"><span class="fa fa-money"></span>&nbsp; Leave Credits</a>
                <a href="<?= url('leave-report') ?>" class="btn btn-success pull-right" style="margin-right:10px;"><span class="fa fa-file"></span>&nbsp; Leave Report</a>
        <?php
            }
        }
        if($is_leader > 0) {
        ?>
        <a href="<?= url('for-approval') ?>" class="btn btn-dark pull-right" style="margin-right:10px;"><span class="fa fa-users"></span>&nbsp; Team Leave</a>
        <?php
        }
        ?>
    </div>
    <div class="pane-body panel">
        <br>
        <br>
        <table class="_table">
            <thead>
                <tr>
                    <th style="width:50px;">#</th>
                    <th style="width:100px;">Employee</th>
                    <th style="width:180px;">Leave Type - Reason</th>
                    <th style="width:100px;">Leave<br> Dates</th>
                    <th style="width:80px;">Pay<br> Status</th>
                    <th style="width:40px;">No. Of<br> Days</th>
                    <th>Status</th>
                    <th>Date<br> Requested</th>
                    <th style="width:60px;">Options</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            foreach($leave_requests as $request) {
                $reason = "";
                $num_days = 0;
                $dates = [];
                $pay_status = [];
                foreach($request->leave_details as $detail):
                    array_push($dates, date('M d, Y', strtotime($detail->date)));
                    array_push($pay_status, (($detail->pay_type) ? 'With Pay' : 'Without Pay'));
                    $num_days += $detail->length;
                endforeach;

                $leave_status = "Pending <br> <small>(Recommendation / Approval)</small>";
                switch($request->approve_status_id) {
                    case 1:
                        $leave_status = 'Approved';
                        break;
                    case 2:
                        $leave_status = 'Not Approved';
                        break;
                    case 3:
                        $leave_status = "Pending <br> <small>(Approval)</small>";
                        break;
                }

                $reason = $request->pay_type_id == 1 ? "Planned - " : "Unplanned - ";
                $reason .= (strlen($request->reason) > 80) ? substr($request->reason, 0, 80)." ..." : $request->reason;
            ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= $request->first_name. " " .$request->last_name ?></td>
                    <td><?= $reason ?></td>
                    <td><span><?= strtotime($dates[0]) ?></span> <?php echo implode('<br>', $dates); ?></td>
                    <td><?php echo implode('<br>', $pay_status); ?></td>
                    <td><?= (float) $num_days ?></td>
                    <td><?= $leave_status ?></td>
                    <td><span><?= strtotime($request->date_filed) ?></span> <?= date("M d, Y",strtotime($request->date_filed)) ?></td>
                    <td class="td-option">
                        <a href="<?= url("leave/{$request->id}") ?>" title="View" class="btn_view">
                            <span class="fa fa-eye"></span>
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
$(function () {
    activeMenu($('#menu-leaves'));

    $('._table').DataTable({"pageLength": 50}); 
});
</script>
@endsection