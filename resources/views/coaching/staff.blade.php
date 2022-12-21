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
                        <table class="table table-bordered" id="table-list">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Focus</th>
                                    <th>Linker</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($linking as $lk) {
                                if(!empty($lk->lnk_id)) {
                            ?>
                                <tr>
                                    <td><span><?= strtotime($lk->created_at) ?></span> <?= date("F d, Y", strtotime($lk->lnk_date)) ?></td>
                                    <td><?= $lk->link_type_desc ?></td>
                                    <td><?= $lk->focus ?></td>
                                    <td><?= strtoupper($lk->first_name.' '.$lk->last_name) ?></td>
                                    <td><a class="btn btn-primary" href="<?= url("{$lk->lt_link}-acknowledge/{$lk->lnk_id}") ?>">ACKNOWLEDGE</a></td>
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