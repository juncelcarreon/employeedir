@extends('layouts.main')
@section('title')
Leave > Approved Leave List
@endsection
@section('head')
<style type="text/css">
@include('leave.style');
</style>
@endsection
@section('breadcrumb')
Leave <span>></span> Approved Leave List
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default mb-0">
            <div class="panel-heading">
                APPROVED LEAVES LIST

                <a href="<?= url('leave') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
            </div>
            <div class="pane-body panel mb-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="min-width: 50px;">#</th>
                            <th style="width: 100px;">Employee</th>
                            <th style="width: 200px;">Leave Type - Reason</th>
                            <th style="width: 150px;">Leave Dates</th>
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
                            $num_days = 0;
                            $dates = [];
                            $pay_status = [];
                            foreach($request->leave_details as $detail):
                                array_push($dates, date('M d, Y', strtotime($detail->date)));
                                array_push($pay_status, (($detail->pay_type) ? 'With Pay' : 'Without Pay'));
                                $num_days += $detail->length;
                            endforeach;
                    ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $request->first_name. " " .$request->last_name ?></td>
                            <td title="<?= htmlentities($request->reason) ?>"><?= ($request->pay_type_id == 1 ? "Planned - " : "Unplanned - ").stringLimit($request->reason, 80) ?></td>
                            <td><span class="d-none"><?= strtotime($dates[0]) ?></span> <?= implode('<br>', $dates); ?></td>
                            <td><?= implode('<br>', $pay_status); ?></td>
                            <td><?= (float) $num_days ?></td>
                            <td><span class="d-none"><?= strtotime($request->date_filed) ?></span> <?= date("M d, Y",strtotime($request->date_filed)) ?></td>
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

    $('.table').DataTable().destroy();

    $('.table').DataTable({"pageLength": 50});
});
</script>
@endsection