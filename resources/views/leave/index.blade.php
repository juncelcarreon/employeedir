@extends('layouts.main')
@section('content')
<style type="text/css">
    .panel-heading a{ color: #fff; }
    .panel-heading a.text-danger{ color: #ff0000; }
    .panel-heading a.active{ text-decoration: underline; }
    .font-bold{ font-weight: 700; }
    .td-option{ width: 100px; text-align: center; }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="/leave"<?= ($type == 'pending') ? ' class="active"' : '' ?>>Pending Leaves</a> | 
                <a href="/approved-leaves"<?= ($type == 'approve') ? ' class="active"' : '' ?>>Approved Leaves</a> | 
                <a href="/cancelled-leaves" class="text-danger<?= ($type == 'cancelled') ? ' active' : '' ?>">Cancelled Leaves</a> | 
                <a href="/leave/create" class="font-bold">FILE A LEAVE</a>
                @if(Auth::check())
                    @if(Auth::user()->isAdmin())
                        | <a href="{{ url('leave-report') }}">Leave Report</a> | 
                        <a href="{{ url('expanded-credits') }}">Leave Credits</a>
                    @endif
                @endif
            </div>
            <div class="pane-body panel">
                <br>
                <br>
                <table class="_table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee</th>
                            <th style="width: 450px;">Leave Type - Reason</th>
                            <th>Leave Dates</th>
                            <th>Pay Status</th>
                            <th>No. Of Days</th>
                            <th>Status</th>
                            <th>Date Requested</th>
                            <th width="100px">Options</th>
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

                        $leave_status = $request->approve_status_id == 1 ? "Approved" :
                                ($request->approve_status_id == 2 ? "Not Approved" : "Pending");
                        
                        $reason = $request->pay_type_id == 1 ? "Planned - " : "Unplanned - ";
                        $reason .= $request->reason;
                    ?>
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $request->first_name. " " .$request->last_name }}</td>
                            <td>{{ $reason }}</td>
                            <td><?php echo implode('<br>', $dates); ?></td>
                            <td><?php echo implode('<br>', $pay_status); ?></td>
                            <td>{{ (float) $num_days }}</td>
                            <td>{{ $leave_status }}</td>
                            <td>{{ date("M d, Y",strtotime($request->date_filed)) }}</td>
                            <td class="td-option">
                                <a href="{{url('leave') . '/' . $request->id}}" title="View" data-id="{{ $request->id }}" class="btn_view"><span class="fa fa-eye"></span></a>
                                &nbsp;&nbsp;
                            </td>
                        </tr>
                    <?php 
                    $i++;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(function () { $('._table').DataTable(); });
</script>
@endsection