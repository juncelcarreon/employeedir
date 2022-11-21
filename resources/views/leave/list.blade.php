@extends('layouts.main')
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
        APPROVED LEAVES LIST

        <a href="<?= url('leave') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
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
                    <th style="width:100px;">Leave Dates</th>
                    <th>Pay Status</th>
                    <th>No. Of Days</th>
                    <th>Date Requested</th>
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

                $reason = $request->pay_type_id == 1 ? "Planned - " : "Unplanned - ";
                $reason .= (strlen($request->reason) > 80) ? substr($request->reason, 0, 80)." ..." : $request->reason;
            ?>
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $request->first_name. " " .$request->last_name }}</td>
                    <td>{{ $reason }}</td>
                    <td><span><?= strtotime($dates[0]) ?></span> <?php echo implode('<br>', $dates); ?></td>
                    <td><?php echo implode('<br>', $pay_status); ?></td>
                    <td>{{ (float) $num_days }}</td>
                    <td><span><?= strtotime($request->date_filed) ?></span> {{ date("M d, Y",strtotime($request->date_filed)) }}</td>
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