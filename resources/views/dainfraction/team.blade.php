@extends('layouts.main')
@section('title')
DA Infractions > Team Infractions
@endsection
@section('head')
<style type="text/css">
@include('dainfraction.style');
</style>
@endsection
@section('breadcrumb')
DA Infractions <span>></span> Team Infractions
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default m-0">
            <div class="panel-heading">
                DA INFRACTIONS

                <a href="<?= url('dainfraction') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
            </div>
            <div class="pane-body panel m-0">
                <br>
                <br>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width:50px;">#</th>
                            <th style="width:200px;">Employee</th>
                            <th style="width:200px;">Title</th>
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
                            <td title="<?= $infraction->title ?>"><?= $infraction->infraction_type.' - '.$infraction->title ?></td>
                            <td><span><?= strtotime($infraction->date) ?></span> <?= date('M d, Y', strtotime($infraction->date)) ?></td>
                            <td><?= $status ?></td>
                            <td><span><?= strtotime($infraction->created_at) ?></span> <?= date("M d, Y",strtotime($infraction->created_at)) ?></td>
                            <td class="text-center">
                                <a href="<?= url("dainfraction/{$infraction->id}") ?>" title="View" class="btn_view">
                                    <span class="fa fa-eye"></span>
                                </a>
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
@endsection
@section('scripts')
@include('dainfraction.script')
@endsection