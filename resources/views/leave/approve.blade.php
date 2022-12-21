@extends('layouts.main')
@section('title')
Request | Leave > Team Leave > <?= ucfirst($type) ?> List
@endsection
@section('head')
<style type="text/css">
@include('leave.leave-style');
</style>
@endsection
@section('breadcrumb')
Request <span>/</span> Team Leave <span>></span> <?= ucfirst($type) ?> List
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default mb-0">
            <div class="panel-heading">
                <a href="<?= url('for-approval') ?>" title="Pending Team Leave"<?= ($type == 'pending') ? ' class="active"' : '' ?>>PENDING</a> | 
                <a href="<?= url('team-approves') ?>" title="Approved Team Leave"<?= ($type == 'approve') ? ' class="active"' : '' ?>>APPROVED</a> | 
                <a href="<?= url('team-cancelled') ?>" title="Cancelled Team Leave"<?= ($type == 'cancelled') ? ' class="active"' : '' ?>>CANCELLED</a>

                <a href="<?= url('leave') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
            </div>
            <div class="pane-body panel mb-0">
                <table id="table_leave">
                    <thead>
                        <tr>
                            <th class="w-50">#</th>
                            <th class="w-100">Employee</th>
                            <th class="w-200">Leave Type - Reason</th>
                            <th>Leave<br> Dates</th>
                            <th>No. Of<br> Days</th>
                            <th>Status</th>
                            <th>Date<br> Requested</th>
                            <th class="w-80">Options</th>
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
                            <td><span><?= strtotime($dates[0]) ?></span> <?= implode('<br>', $dates); ?></td>
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