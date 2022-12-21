@extends('layouts.main')
@section('title')
Linking Sessions > Pending Sessions
@endsection
@section('head')
<style>
@include('coaching.style');
</style>
@endsection
@section('breadcrumb')
Linking Sessions <span>></span> Pending Sessions
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary m-0">
            @include('coaching.sub_menu')
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped" id="table-list">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Linkee</th>
                                    <th>Focus</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($pending as $p) {
                                if(!empty($p->lnk_id)) {
                            ?>
                            <tr>
                                <td><span><?= strtotime($p->created_at) ?></span> <?= date("F d, Y", strtotime($p->lnk_date)) ?></td>
                                <td><?= $p->lt_desc ?></td>
                                <td><?= strtoupper($p->first_name.' '.$p->last_name) ?></td>
                                <td><?= $p->focus ?></td>
                                <td><a href="<?= url("{$p->lt_link}-edit/{$p->lnk_id}") ?>" class="btn btn-primary">View Coaching</a></td>
                            </tr>
                            <?php
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('coaching.js-script')
@endsection