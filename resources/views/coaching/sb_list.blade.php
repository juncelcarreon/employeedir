@extends('layouts.main')
@section('title')
Linking Sessions > Skill Building
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
                <div class="col-md-12"><b style="color: #0000FF; font-size: 16px;">Skill Building List</b></div>
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
                                <th>Linker</th>
                                <th>Linkee</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($linking as $lk) {
                        ?>
                            <tr>
                                <td><?= date("F d, Y", strtotime($lk->lnk_date)) ?></td>
                                <td><?= $lk->lnk_type ?></td>
                                <td><?= $lk->ac_focus ?></td>
                                <td><?= $lk->linker_name ?></td>
                                <td><?= $lk->linkee_name ?></td>
                                <td><a class="btn btn-primary" href="<?= url("skill-building/{$lk->sb_com_num}?view_accnt=1") ?>">VIEW</a></td>
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