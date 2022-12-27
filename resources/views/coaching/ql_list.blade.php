@extends('layouts.main')
@section('title')
Linking Sessions > Quick Link
@endsection
@section('head')
<style>
@include('coaching.style');
</style>
@endsection
@section('breadcrumb')
Linking Sessions <span>/</span> Quick Link <span>></span> List
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
                                    <th>Focus</th>
                                    <th><?= $label ?></th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($linking as $lk) {
                            ?>
                                <tr>
                                    <td><span><?= strtotime($lk->created_at) ?></span> <?= date("F d, Y", strtotime($lk->lnk_date)) ?></td>
                                    <td><?= $lk->fc_desc ?></td>
                                    <td><?= strtoupper($lk->first_name.' '.$lk->last_name) ?></td>
                                    <td><a class="btn btn-primary" href="<?= url("quick-link/{$lk->rf_lnk_id}")?>">VIEW</a></td>
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
    </div>
</div>
@endsection
@section('scripts')
@include('coaching.js-script')
@endsection