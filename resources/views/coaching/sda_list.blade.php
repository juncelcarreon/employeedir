@extends('layouts.main')
@section('title')
Linking Sessions > Skills Development Activity
@endsection
<style>
.dataTables_wrapper{margin:0 !important;}
</style>
@section('content')
<div class="container-fluid">
    <div class="panel panel-primary">
        @include('coaching.sub_menu')
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12" style="padding: 12px;"><b style="color: #0000FF; font-size: 16px;">Skills Development Activity List</b></div>
            </div>
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
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
                                <td><?= date("F d, Y", strtotime($lk->lnk_date)) ?></td>
                                <td><?= $lk->link_type ?></td>
                                <td><?= $lk->focus ?></td>
                                <td><?= $lk->link_person ?></td>
                                <td><a class="btn btn-primary" href="<?= url("skill-dev-act/{$lk->sda_com_id}?view_only=1") ?>">VIEW</a></td>
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
<script type="text/javascript">
$(function(){
    activeMenu($('#menu-linking-sessions'));
});
</script>
@endsection