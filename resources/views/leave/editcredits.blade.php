@extends('layouts.main')
@section('title')
Request | Leave > Edit Credit
@endsection
@section('head')
<style type="text/css">
@include('leave.leave-style');
</style>
@endsection
@section('breadcrumb')
Request <span>/</span> Leave <span>></span> Edit Credit
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default mb-0">
            <div class="panel-heading">
                EDIT LEAVE CREDIT

                <a href="<?= url('expanded-credits') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
            </div>
            <div class="panel panel-body mb-0">
                <form method="POST" action="<?= url('leave/credits') ?>">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Employee Name</label>
                                <p><?= $employee->fullName2() ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Department</label>
                                <p><?= $employee->team_name ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Position</label>
                                <p><?= $employee->position_name ?></p>
                            </div>
                        </div>
                        <div class="col-md-12">
                        	<div class="form-group">
                                 <table class="table table-striped" id="leave_credits_table">
                                    <thead>
                                        <tr>
                                            <th><?= now()->subYear()->format('Y') ?> PTO Forwarded</th>
                                            <th><?= now()->format('Y') ?> Monthly Accrual</th>
                                            <th>Used PTO<br>(Jan-Jun)</th>
                                            <th>Used PTO<br>(Jul-Dec)</th>
                                            <th>Current PTO Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?= number_format($credits->past_credit - $credits->conversion_credit, 2) ?></td>
                                            <td><?= number_format($credits->monthly_accrual, 2) ?></td>
                                            <td><?= number_format($credits->used_jan_to_jun, 2) ?></td>
                                            <td><?= number_format($credits->used_jul_to_dec, 2) ?></td>
                                            <td class="td-total"><?= $credits->is_regular == 1 ? number_format($credits->current_credit, 2) : '0.00' ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="pto_forwarded"><?= now()->subYear()->format('Y') ?> PTO
                                    Forwarded</label>
                                <input type="number" name="pto_forwarded" id="pto_forwarded"
                                    step="0.01" value="0" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="monthly_accrual"><?= now()->format('Y') ?> Monthly Accrual</label>
                                <input type="number" name="monthly_accrual" id="monthly_accrual" 
                                    step="0.01" value="0" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                             <input type="hidden" class="form-control" disabled value="<?= number_format($credits->current_credit, 2) ?>">
                            <input type="hidden" class="form-control" value="<?= $employee->id ?>" name="employee_id">
                            <button class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
$(function() {
    activeMenu($('#menu-leaves'));
});
</script>
@endsection
