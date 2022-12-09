@extends('layouts.main')
@section('title')
Linking Sessions > Skill Building
@endsection
@section('breadcrumb')
Linking Sessions > Skill Building > List
@endsection
@section('content')
<style>
@include('coaching.style');
</style>
<div class="panel panel-primary">
    @include('coaching.sub_menu')
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered" id="table-list">
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
                            <td><a class="btn btn-primary" href="<?= url("skill-building/{$lk->sb_com_num}") ?>">VIEW</a></td>
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
@include('coaching.js-script')
@endsection