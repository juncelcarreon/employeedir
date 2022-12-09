@extends('layouts.main')
@section('title')
Linking Sessions > Personal Sessions
@endsection
@section('breadcrumb')
Linking Sessions > Personal Sessions
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
                <table class="table table-striped table-bordered" id="table-list">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Linker</th>
                            <th>Focus</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($my_links as $ll) {
                        $url = url("{$ll->lt_link}-acknowledge/{$ll->lnk_id}");
                        if($ll->lnk_acknw) {
                            $url = url("{$ll->lt_link}/{$ll->lnk_id}");
                        }
                    ?>
                    <tr>
                        <td><span><?= strtotime($ll->created_at) ?></span> <?= date("F d, Y",strtotime($ll->lnk_date)) ?></td>
                        <td><?= $ll->link_type_desc ?></td>
                        <td><?= $ll->first_name.' '.$ll->last_name ?></td>
                        <td><?= $ll->focus ?></td>
                        <td><a class="btn btn-primary" href="<?= $url ?>"><?= ($ll->lnk_acknw) ? 'VIEW' : 'ACKNOWLEDGE' ?> <?= $ll->button ?></a></td>
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