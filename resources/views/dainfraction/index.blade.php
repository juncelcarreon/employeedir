@extends('layouts.main')
@section('content')
<style type="text/css">
    .panel-heading a{ color: #fff; }
    .panel-heading a.text-danger{ color: #ff0000; text-decoration: none; }
    /*.panel-heading a.active{ text-decoration: underline; }*/
    .panel-heading a.active{ color: #ffc107; text-decoration: none; }
    .panel-heading a.active, .panel-heading a:hover{ color: #ffc107; text-decoration: none; }
    .font-bold{ font-weight: 700; }
    .td-option{ width: 100px; text-align: center; }
    td span{ display: none; }
    tr.even{ background: #ddd !important; }
    .btn{ color: #fff !important; }
    small{display: block; font-size: 75% !important;}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
<!--                 <a href="<?= url('dainfraction') ?>"<?= ($type == 'not-acknowledged') ? ' class="active"' : '' ?>>NOT ACKNOWLEDGED</a> | 
                <a href="<?= url('dainfraction?status=acknowledged') ?>"<?= ($type == 'acknowledged') ? ' class="active"' : '' ?>>ACKNOWLEDGED</a> -->
                DA INFRACTIONS

                <a href="<?= url('dainfraction/create') ?>" class="btn btn-primary pull-right"><span class="fa fa-edit"></span>&nbsp; File DA Infraction</a>
            </div>
            <div class="pane-body panel">
                <br>
                <br>
                <table class="_table">
                    <thead>
                        <tr>
                            <th style="width:50px;">#</th>
                            <th>Employee</th>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Date Filed</th>
                            <th style="width:80px;">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 1;
                    foreach($infractions as $infraction) {
                        $status = 'Not Acknowledged';
                        switch($infraction->status) {
                            case 1:
                            $status = 'Acknowledged';
                                break;
                            case 2:
                            $status = 'Acknowledged <small>(Pending Explanation)</small>';
                                break;
                        }
                    ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $infraction->first_name.' '.$infraction->last_name ?></td>
                            <td><?= $infraction->title ?></td>
                            <td><span><?= strtotime($infraction->date) ?></span> <?= date('M d, Y', strtotime($infraction->date)) ?></td>
                            <td><?= $status ?></td>
                            <td><span><?= strtotime($infraction->created_at) ?></span> <?= date("M d, Y",strtotime($infraction->created_at)) ?></td>
                            <td class="td-option">
                                <a href="<?= url("dainfraction/{$infraction->id}") ?>" title="View" class="btn_view"><span class="fa fa-eye"></span></a>
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
$(function () {
    activeMenu($('#menu-dainfraction'));

    $('._table').DataTable({"pageLength": 50});
});
</script>
@endsection