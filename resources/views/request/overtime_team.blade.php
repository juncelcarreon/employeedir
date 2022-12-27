@extends('layouts.main')
@section('title')
Timekeeping | Overtime > Team Overtime
@endsection
@section('head')
<style type="text/css">
@include('request.style');
</style>
@endsection
@section('breadcrumb')
Timekeeping <span>/</span> Overtime <span>/</span> Team Overtime <span>></span><?= ucfirst($type) ?> List
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default m-0">
            <div class="panel-heading">
                <a href="<?= url('team-overtime') ?>" title="Pending Team Overtime"<?= ($type == 'pending') ? ' class="active"' : '' ?>>PENDING</a> | 
                <a href="<?= url('team-overtime?status=approved') ?>" title="Approved Team Overtime"<?= ($type == 'approved') ? ' class="active"' : '' ?>>APPROVED</a> | 
                <a href="<?= url('team-overtime?status=verifying') ?>" title="Verifying Team Overtime"<?= ($type == 'verifying') ? ' class="active"' : '' ?>>VERIFYING</a> | 
                <a href="<?= url('team-overtime?status=completed') ?>" title="Completed Team Overtime"<?= ($type == 'completed') ? ' class="active"' : '' ?>>COMPLETED</a> | 
                <a href="<?= url('team-overtime?status=declined') ?>" title="Declined Team Overtime"<?= ($type == 'declined') ? ' class="active"' : '' ?>>DECLINED</a>

                <a href="<?= url('overtime') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
            </div>
            <div class="pane-body panel m-0">
                <table class="_table">
                    <thead>
                        <tr>
                            <th style="width:50px;">#</th>
                            <th style="width:150px;">Employee</th>
                            <th style="width:200px;">Reason</th>
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
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
$(function() {
    activeMenu($('#menu-overtime'));

    $('._table').DataTable({"pageLength": 50});
});
</script>
@endsection