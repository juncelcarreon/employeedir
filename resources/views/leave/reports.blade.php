@extends('layouts.main')
@section('title')
    Request | Leaves > Reports
@endsection
@section('content')
<style>
    .dates_info{
        color: #000; 
        border: none;
        padding: 16px;
        width: 160px;
    }
    th{
        text-align: center; 
        vertical-align: bottom;
    }
</style>
<div class="panel panel-default">
    <div class="panel-heading">
        LEAVE TRACKER REPORTS &nbsp; - &nbsp;&nbsp;&nbsp; 
        <input id="startdate" type="text" class="dates_info" autocomplete="off" placeholder="From"> &nbsp;&nbsp;&nbsp; 
        <input id="enddate" type="text" class="dates_info" autocomplete="off" placeholder="To">
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" name="pay_type" value="monthly"> <label for="male">Monthly</label>&nbsp;&nbsp;
        <input type="radio" name="pay_type" value="weekly"> <label for="male">Weekly</label>
        &nbsp;&nbsp;&nbsp;&nbsp;

        <a href="<?= url('leave') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
        <?php
        if(isset($target)) {
        ?>
        <a href="<?= url("download-report?from={$target['from']}&to={$target['to']}&type={$target['type']}") ?>" class="btn btn-md btn-success pull-right" style="margin-right:10px;"><span class="fa fa-download"></span>&nbsp; Download</a>
        <?php
        } else {
        ?>
        <a href="#" class="btn btn-md btn-success pull-right" style="margin-right:10px;"><span class="fa fa-download"></span>&nbsp; Download</a>
        <?php
        }
        ?>
        <button id="id_btn_display" class="btn btn-md btn-primary pull-right" style="margin-right:10px;"><span class="fa fa-file"></span>&nbsp; Display Report</button>
    </div>
    <div class="pane-body panel">
        <br>
        <br>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Leave ID</th>
                <th>EE Number</th>
                <th>EE Name</th>
                <th>Start</th>
                <th>End</th>
                <th>VL</th>
                <th>SL</th>
                <th>EL</th>
                <th>VLWOP</th>
                <th>SLWOP</th>
                <th>ELWOP</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if(isset($obj)):
                $leave_id = isset($obj[0]) ? $obj[0]->leave_id : 0;
                $ename = isset($obj[0]) ? $obj[0]->emp_name : '';
                $eid = isset($obj[0]) ? $obj[0]->eid : 0;
                $l_id = isset($obj[0]) ? $obj[0]->leave_id : '';
                $date_filed = isset($obj[0]) ? $obj[0]->date_filed : '';
                $start = isset($obj[0]) ? $obj[0]->date : '';
                $stop = isset($obj[0]) ? $obj[0]->date : '';
                $track = 0;
                $vl = 0;
                $sl = 0;
                $el = 0;
                $vlwop = 0;
                $slwop = 0;
                $elwop = 0;
                foreach($obj as $o):
                    if($leave_id == $o->leave_id):
                    
                    else:
                    ?>
                <tr>
                    <td><?= str_pad($l_id,5,"0",STR_PAD_LEFT) ?></td>
                    <td><?= $eid ?></td>
                    <td><?= $ename ?></td>
                    <td><?= date("F d, Y", strtotime($start)) ?></td>
                    <td><?= date("F d, Y", strtotime($stop)) ?></td>
                    <td><?= $vl ?></td>
                    <td><?= $sl ?></td>
                    <td><?= $el ?></td>
                    <td><?= $vlwop ?></td>
                    <td><?= $slwop ?></td>
                    <td><?= $elwop ?></td>
                </tr>
                    <?php
                        $vl = 0;
                        $sl = 0;
                        $el = 0;
                        $vlwop = 0;
                        $slwop = 0;
                        $elwop = 0;
                        $leave_id = $o->leave_id;
                        $ename = $o->emp_name;
                        $eid = $o->eid;
                        $l_id = $o->leave_id;
                        $date_filed = $o->date_filed;
                        $start = $o->date;
                    endif;
                    switch($o->leave_type_id):
                        case 4: $o->pay_type == 1 ? $sl+=$o->length : $slwop+=$o->length; break;
                        case 5: $o->pay_type == 1 ? $vl+=$o->length : $vlwop+=$o->length; break;
                        case 6: $o->pay_type == 1 ? $el+=$o->length : $elwop+=$o->length; break;
                    endswitch;
                    $stop = $o->date;
                endforeach;
                if($l_id){
            ?>
                <tr>
                    <td><?= str_pad($l_id,5,"0",STR_PAD_LEFT) ?></td>
                    <td><?= $eid ?></td>
                    <td><?= $ename ?></td>
                    <td><?= date("F d, Y", strtotime($start)) ?></td>
                    <td><?= date("F d, Y", strtotime($stop)) ?></td>
                    <td><?= $vl ?></td>
                    <td><?= $sl ?></td>
                    <td><?= $el ?></td>
                    <td><?= $vlwop ?></td>
                    <td><?= $slwop ?></td>
                    <td><?= $elwop ?></td>
                </tr>
            <?php
                }
            endif;
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

    $( ".dates_info" ).datepicker({
        changeMonth: true
    });

    $("#id_btn_display").click(function(e){
        e.preventDefault();

        var val = {
            from    : $("#startdate").val(),
            to      : $("#enddate").val(),
            type    : $('input[name="pay_type"]:checked').val()
        };

        console.log(val);
        location.href = "/display-report?from=" + val.from + "&to=" + val.to + "&type=" + val.type;
    });
});
</script>
@endsection