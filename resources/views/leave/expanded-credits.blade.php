@extends('layouts.main')
@section('title')
    Request | Leaves > Credits
@endsection
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        LEAVE CREDITS
        <!--                     @if(Auth::check())
            @if(Auth::user()->isAdmin())
            <a href="{{ url('download-credits') }}" class="pull-right btn btn-info"><span class="fa fa-gear"></span>&nbsp;Download Leave Credits</a>&nbsp;
            <a href="{{ url('leave') }}" class="pull-right btn btn-primary"><span class="fa fa-gear"></span>&nbsp;View Leave Lists</a>&nbsp;
            @endif
        @endif -->

        <a href="<?= url('leave') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
    </div>
    <div class="pane-body panel">
        <br>
        <br>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th><?= date('Y') - 1 ?> PTO<br>Forwarded</th>
                    <th><?= date('Y') ?> PTO<br>Monthly Accrual</th>
                    <th>Used PTO<br>(Jan-Jun)</th>
                    <th>Used PTO<br>(Jul-Dec)</th>
                    <th>Current PTO Balance</th>
                <?php
                if(Auth::user()->isAdmin()) {
                ?>
                    <th>Action</th>
                <?php
                }
                ?>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($employees as $employee) {
                    $div = 0;
                    switch($employee->employee_category):
                        case 1: $div = 20; break;
                        case 2: $div = 14; break;
                        case 3: $div = 10; break;
                        case 4: $div = 10; break;
                    endswitch;
                    $different_in_months = App\Helpers\DateHelper::getDifferentMonths($employee->hired_date);
                    $monthly_accrual = (($div / 12) * $different_in_months) + $employee->monthly_accrual;
                    $employee->monthly_accrual = $monthly_accrual;
                    $employee->current_credit = ($monthly_accrual + $employee->past_credit) - ($employee->used_jan_to_jun + $employee->used_jul_to_dec);

                    $pto_forwarded = $employee->past_credit - $employee->conversion_credit;
                    $pto_accrue = $employee->current_credit;
                    $loa = abs($employee->loa);
                    $use_jan_jun = $employee->used_jan_to_jun;
                    $pto_expired = $employee->expired_credit;
                    $balance = $pto_forwarded + $pto_accrue - $loa - $use_jan_jun - $pto_expired;
                ?>
                <tr>
                    <td><?= $employee->eid ?></td>
                    <td><?= $employee->employee_name ?></td>
                    <td><?= number_format($employee->past_credit - $employee->conversion_credit,2) ?></td>
                    <td><?= number_format($employee->monthly_accrual,2) ?></td>
                    <td><?= number_format($employee->used_jan_to_jun,2) ?></td>
                    <td><?= number_format($employee->used_jul_to_dec,2) ?></td>
                    <td><?= $employee->is_regular == 1 ? number_format($employee->current_credit,2) : '0.00' ?></td>
                    <?php
                    if(Auth::user()->isAdmin()) {
                    ?>
                        <td>
                            <a title="Adjust leave credits" href="<?= url("leave/credits/{$employee->id}") ?>"><i class="fa fa-gear"></i></a>
                        </td>
                    <?php
                    }
                    ?>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
$(function() {
    activeMenu($('#menu-leaves'));
});
$('.table').dataTable({ "pageLength": 50 }).fnDestroy();
</script>
@endsection
