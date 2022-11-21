@extends('layouts.main')
@section('title')
    Request | Leaves > Credits > Edit
@endsection
@section('content')
<style type="text/css">
    small.leave-success{
        color: green;
    }
    .dataTables_wrapper{
        margin: 0;
        padding: 0;
    }
</style>
<div class="panel panel-default">
    <div class="panel-heading">
        EDIT LEAVE CREDIT

        <a href="<?= route('expanded.credits') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
    </div>
    <div class="panel panel-body">
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
              <!--   <div class="col-md-3">
                    <div class="form-group">
                        <label>Remaining Leave Credits</label>
                	</div>
                </div> -->
                <div class="col-md-12">
                	<div class="form-group">
                         <table class="table table-bordered">
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
                                    <td><?= $credits->is_regular == 1 ? number_format($credits->current_credit, 2) : '0.00' ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div style="display: flex; gap: 1rem;">
                        <div class="form-group">
                            <label for="pto_forwarded"><?= now()->subYear()->format('Y') ?> PTO
                                Forwarded</label>
                            <input type="number" name="pto_forwarded" id="pto_forwarded"
                                step="0.01" value="0" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="monthly_accrual"><?= now()->format('Y') ?> Monthly Accrual</label>
                            <input type="number" name="monthly_accrual" id="monthly_accrual" 
                                step="0.01" value="0" class="form-control">
                        </div>
                    </div>
                     <input type="hidden" class="form-control" disabled value="<?= number_format($credits->current_credit, 2) ?>">
                    <input type="hidden" class="form-control" value="<?= $employee->id ?>" name="employee_id">
                    <button class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
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
