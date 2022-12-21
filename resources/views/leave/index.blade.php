@extends('layouts.main')
@section('title')
Request | Leave > <?= ucfirst($type) ?> List
@endsection
@section('head')
<style type="text/css">
@include('leave.leave-style');
</style>
@endsection
@section('breadcrumb')
Request <span>/</span> Leave <span>></span> <?= ucfirst($type) ?> List
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default mb-0">
            <div class="panel-heading">
                <a href="<?= url('leave') ?>" title="Pending Leaves"<?= ($type == 'pending') ? ' class="active"' : '' ?>>PENDING</a> | 
                <a href="<?= url('approved-leaves') ?>" title="Approved Leaves"<?= ($type == 'approve') ? ' class="active"' : '' ?>>APPROVED</a> | 
                <a href="<?= url('cancelled-leaves') ?>" title="Cancelled Leaves"<?= ($type == 'cancelled') ? ' class="active"' : '' ?>>CANCELLED</a>

                <a href="<?= url('leave/create') ?>" class="btn btn-primary pull-right"><span class="fa fa-edit"></span>&nbsp; File A Leave</a>
                <?php
                if(Auth::check()) {
                    if(Auth::user()->dept_code == 'OE01' && !Auth::user()->isAdmin()) {
                ?>
                <a href="<?= url('approved-lists') ?>" class="btn btn-success pull-right"><span class="fa fa-check"></span>&nbsp; Approved Leaves</a>
                <?php
                    }
                    if(Auth::user()->isAdmin()) {
                ?>
                <a href="<?= url('expanded-credits') ?>" class="btn btn-info pull-right"><span class="fa fa-money"></span>&nbsp; Leave Credits</a>
                <a href="<?= url('leave-report') ?>" class="btn btn-success pull-right"><span class="fa fa-file"></span>&nbsp; Leave Report</a>
                <?php
                    }
                }
                if($is_leader > 0) {
                ?>
                <a href="<?= url('for-approval') ?>" class="btn btn-dark pull-right"><span class="fa fa-users"></span>&nbsp; Team Leave</a>
                <?php
                }
                ?>
            </div>
            <div class="pane-body panel mb-0">
                <table id="table_leave">
                    <thead>
                        <tr>
                            <th class="w-50">#</th>
                            <th class="w-100">Employee</th>
                            <th class="w-180">Leave Type - Reason</th>
                            <th class="w-100">Leave<br> Dates</th>
                            <th class="w-80">Pay<br> Status</th>
                            <th class="w-50">No. Of<br> Days</th>
                            <th>Status</th>
                            <th>Date<br> Requested</th>
                            <th class="w-60">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 1;
                    foreach($leave_requests as $request) {
                        if(!empty($request->leave_details)) {
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
<script type="text/javascript">
$(function () {
    activeMenu($('#menu-leaves'));

    $('#table_leave').DataTable({"pageLength": 50});
});
</script>
@endsection