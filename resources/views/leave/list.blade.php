@extends('layouts.main')
@section('content')
<style type="text/css">
@include('leave.leave-style');
</style>
<div class="panel panel-default">
    <div class="panel-heading">
        APPROVED LEAVES LIST

        <a href="<?= url('leave') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
    </div>
    <div class="pane-body panel">
        <table id="table_leave">
            <thead>
                <tr>
                    <th class="w-50">#</th>
                    <th class="w-100">Employee</th>
                    <th class="w-200">Leave Type - Reason</th>
                    <th class="w-100">Leave Dates</th>
                    <th>Pay Status</th>
                    <th>No. Of<br> Days</th>
                    <th>Date<br> Requested</th>
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

                    $reason = $request->pay_type_id == 1 ? "Planned - " : "Unplanned - ";
                    $reason .= (strlen($request->reason) > 80) ? substr($request->reason, 0, 80)." ..." : $request->reason;
            ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= $request->first_name. " " .$request->last_name ?></td>
                    <td><?= $reason ?></td>
                    <td><span><?= strtotime($dates[0]) ?></span> <?= implode('<br>', $dates); ?></td>
                    <td><?= implode('<br>', $pay_status); ?></td>
                    <td><?= (float) $num_days ?></td>
                    <td><span><?= strtotime($request->date_filed) ?></span> <?= date("M d, Y",strtotime($request->date_filed)) ?></td>
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
<script type="text/javascript">
$(function () {
    activeMenu($('#menu-leaves'));

    $('#table_leave').DataTable({"pageLength": 50});
});
</script>
@endsection