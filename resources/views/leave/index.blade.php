@extends('layouts.main')
@section('title')
Leave > <?= ucfirst($type) ?> List
@endsection
@section('head')
<style type="text/css">
@include('leave.style');
</style>
@endsection
@section('breadcrumb')
Leave <span>></span> <?= ucfirst($type) ?> List
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
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="min-width: 50px;">#</th>
                            <th style="width: 100px;">Employee</th>
                            <th style="width: 150px;">Leave Type - Reason</th>
                            <th style="width: 100px;">Leave<br> Dates</th>
                            <th style="width: 80px;">Pay<br> Status</th>
                            <th style="width: 50px;">No. Of<br> Days</th>
                            <th>Status</th>
                            <th>Date<br> Requested</th>
                            <th style="width: 60px;">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($leave_requests as $no=>$request) {
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
                            <td><?= ++$no ?></td>
                            <td><?= $request->first_name. " " .$request->last_name ?></td>
                            <td title="<?= htmlentities($request->reason) ?>"><?= ($request->pay_type_id == 1 ? "Planned - " : "Unplanned - ").stringLimit($request->reason, 80) ?></td>
                            <td><span class="d-none"><?= strtotime($dates[0]) ?></span> <?php echo implode('<br>', $dates); ?></td>
                            <td><?php echo implode('<br>', $pay_status); ?></td>
                            <td><?= (float) $num_days ?></td>
                            <td><?= leaveStatus($request->approve_status_id) ?></td>
                            <td><span class="d-none"><?= strtotime($request->date_filed) ?></span> <?= date("M d, Y",strtotime($request->date_filed)) ?></td>
                            <td class="text-center">
                                <a href="<?= url("leave/{$request->id}") ?>" title="View" class="btn_view">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php
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