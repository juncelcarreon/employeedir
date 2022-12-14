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
.dtfc-fixed-left{
    background-color: #fff !important;
}
</style>
<div class="panel panel-default">
    <div class="panel-heading">
        LEAVE TRACKER REPORTS &nbsp; - &nbsp;&nbsp;&nbsp; 
        <input id="startdate" type="text" class="dates_info" autocomplete="off" placeholder="From" value="<?= (isset($target)) ? date('m/d/Y', strtotime($target['from'])) : '' ?>"> &nbsp;&nbsp;&nbsp; 
        <input id="enddate" type="text" class="dates_info" autocomplete="off" placeholder="To" value="<?= (isset($target)) ? date('m/d/Y', strtotime($target['to'])) : '' ?>">
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" id="radio-monthly" name="pay_type" value="monthly"<?= (isset($target) && $target['type'] == 'monthly') ? ' checked' : '' ?>> <label for="radio-monthly">Monthly</label>&nbsp;&nbsp;
        <input type="radio" id="radio-weekly" name="pay_type" value="weekly"<?= (isset($target) && $target['type'] == 'weekly') ? ' checked' : '' ?>> <label for="radio-weekly">Weekly</label>
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
        <table class="_table stripe row-border order-column">
            <thead>
                <tr>
                    <th style="width:100px;">Leave ID</th>
                    <th style="width:150px;">EE Number</th>
                    <th style="width:200px;border-right: 3px solid #ddd !important;">EE Name</th>
                    <th style="width:150px;">Start</th>
                    <th style="width:150px;">End</th>
                    <th style="width:50px;">VL</th>
                    <th style="width:50px;">SL</th>
                    <th style="width:50px;">EL</th>
                    <th style="width:50px;">CTO</th>
                    <th style="width:50px;">BL</th>
                    <th style="width:50px;">PL</th>
                    <th>VLWOP</th>
                    <th>SLWOP</th>
                    <th>ELWOP</th>
                    <th>BLWOP</th>
                    <th>PLWOP</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if(isset($obj)) {
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
                $cto = 0;
                $bl = 0;
                $pl = 0;
                $vlwop = 0;
                $slwop = 0;
                $elwop = 0;
                $blwop = 0;
                $plwop = 0;
                foreach($obj as $o) {
                    if($leave_id != $o->leave_id) {
            ?>
                <tr>
                    <td style="background-color:#fff !important;"><?= str_pad($l_id,5,"0",STR_PAD_LEFT) ?></td>
                    <td><?= $eid ?></td>
                    <td style="border-right: 3px solid #ddd !important;"><?= $ename ?></td>
                    <td><?= date("F d, Y", strtotime($start)) ?></td>
                    <td><?= date("F d, Y", strtotime($stop)) ?></td>
                    <td class="text-center"><?= $vl ?></td>
                    <td class="text-center"><?= $sl ?></td>
                    <td class="text-center"><?= $el ?></td>
                    <td class="text-center"><?= $cto ?></td>
                    <td class="text-center"><?= $bl ?></td>
                    <td class="text-center"><?= $pl ?></td>
                    <td class="text-center"><?= $vlwop ?></td>
                    <td class="text-center"><?= $slwop ?></td>
                    <td class="text-center"><?= $elwop ?></td>
                    <td class="text-center"><?= $blwop ?></td>
                    <td class="text-center"><?= $plwop ?></td>
                </tr>
                    <?php
                        $vl = 0;
                        $sl = 0;
                        $el = 0;
                        $cto = 0;
                        $bl = 0;
                        $pl = 0;
                        $vlwop = 0;
                        $slwop = 0;
                        $elwop = 0;
                        $blwop = 0;
                        $plwop = 0;
                        $leave_id = $o->leave_id;
                        $ename = $o->emp_name;
                        $eid = $o->eid;
                        $l_id = $o->leave_id;
                        $date_filed = $o->date_filed;
                        $start = $o->date;
                    }
                    switch($o->leave_type_id) {
                        case 1: $o->pay_type == 1 ? $bl+=$o->length : $blwop+=$o->length; break;
                        case 2: $o->pay_type == 1 ? $pl+=$o->length : $plwop+=$o->length; break;
                        case 4: $o->pay_type == 1 ? $sl+=$o->length : $slwop+=$o->length; break;
                        case 5: $o->pay_type == 1 ? $vl+=$o->length : $vlwop+=$o->length; break;
                        case 6: $o->pay_type == 1 ? $el+=$o->length : $elwop+=$o->length; break;
                        default: $cto+=$o->length; break;
                    }
                    $stop = $o->date;
                }
                if($l_id) {
            ?>
                <tr>
                    <td style="background-color:#fff !important;"><?= str_pad($l_id,5,"0",STR_PAD_LEFT) ?></td>
                    <td><?= $eid ?></td>
                    <td style="border-right: 3px solid #ddd !important;"><?= $ename ?></td>
                    <td><?= date("F d, Y", strtotime($start)) ?></td>
                    <td><?= date("F d, Y", strtotime($stop)) ?></td>
                    <td class="text-center"><?= $vl ?></td>
                    <td class="text-center"><?= $sl ?></td>
                    <td class="text-center"><?= $el ?></td>
                    <td class="text-center"><?= $cto ?></td>
                    <td class="text-center"><?= $bl ?></td>
                    <td class="text-center"><?= $pl ?></td>
                    <td class="text-center"><?= $vlwop ?></td>
                    <td class="text-center"><?= $slwop ?></td>
                    <td class="text-center"><?= $elwop ?></td>
                    <td class="text-center"><?= $blwop ?></td>
                    <td class="text-center"><?= $plwop ?></td>
                </tr>
            <?php
                }
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

    $('._table').DataTable({
        "pageLength": 10,
        "scrollX": true,
        "scrollCollapse": true,
        "fixedColumns": {
            "left": 3
        }
    });

    $("#startdate").datepicker({
        changeMonth: true,
        onSelect: function(dateText, inst) {
            $('#enddate').datepicker('option', 'minDate', dateText);
        }
    });

    $("#enddate").datepicker({
        changeMonth: true,
        onSelect: function(dateText, inst) {
            $('#startdate').datepicker('option', 'maxDate', dateText);
        }
    });

    $("#id_btn_display").click(function(e){
        e.preventDefault();

        var val = {
            from    : $("#startdate").val(),
            to      : $("#enddate").val(),
            type    : $('input[name="pay_type"]:checked').val()
        };

        location.href = "/display-report?from=" + val.from + "&to=" + val.to + "&type=" + val.type;
    });
});
</script>
@endsection