@extends('layouts.main')
@section('title')
Leave > Leave Credits
@endsection
@section('head')
<style type="text/css">
@include('leave.style');
</style>
@endsection
@section('breadcrumb')
Leave <span>></span> Leave Credits
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default mb-0">
            <div class="panel-heading">
                LEAVE CREDITS

                <a href="<?= url('leave') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
                <a href="<?= url('download-credits') ?>" class="pull-right btn btn-success"><span class="fa fa-download"></span>&nbsp; Download Leave Credits</a>
            </div>
            <div class="pane-body panel mb-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="min-width:100px;">Employee ID</th>
                            <th>Employee Name</th>
                            <th><?= $year - 1 ?> PTO<br>Forwarded</th>
                            <th><?= $year ?> PTO<br>Monthly Accrual</th>
                            <th style="width: 100px;">Used PTO<br>(Jan-Jun)</th>
                            <th style="width: 100px;">Used PTO<br>(Jul-Dec)</th>
                            <th style="width: 100px;">Current PTO Balance</th>
                            <th>Action</th>
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
                            $today = date("{$year}-12-12 00:00:00");
                            $hire_date = Carbon\Carbon::parse($employee->hired_date);

                            if($hire_date->year != $year)
                            {
                                $hire_date->year = $year;
                                $hire_date->month = 0;
                            }
                            $hire_date->day = 1;

                            $different_in_months = $hire_date->diffInMonths($today);

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
                            <td><?= strtoupper($employee->employee_name).' ('.$different_in_months.')' ?></td>
                            <td><?= number_format($employee->past_credit - $employee->conversion_credit,2) ?></td>
                            <td><?= number_format($employee->monthly_accrual,2) ?></td>
                            <td><?= number_format($employee->used_jan_to_jun,2) ?></td>
                            <td><?= number_format($employee->used_jul_to_dec,2) ?></td>
                            <td><?= number_format($employee->current_credit,2) ?></td>
                            <td>
                                <a title="Adjust leave credits" href="<?= url("leave/credits/{$employee->id}") ?>"><i class="fa fa-gear"></i></a>
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
    activeMenu($('#menu-leaves'));

    $('.table').DataTable().destroy();

    $('.table').DataTable({"pageLength": 50});
});
</script>
@endsection
