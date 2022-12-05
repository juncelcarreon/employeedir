@extends('layouts.main')
@section('title')
Linking Sessions > Pending
@endsection
<style>
.dataTables_wrapper{
    margin:0 !important;
}
b{
    color: #0000FF; 
    font-size: 16px;
}
td span{
    display: none;
}
</style>
@section('content')
<div class="container-fluid">
     <div class="panel panel-primary">
        @include('coaching.sub_menu')
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12"><b>Pending Coaching Sessions</b></div>
            </div>
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <table class="table table-striped">
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
                            <td><span><?= strtotime($p->lnk_date) ?></span> <?= date("F d, Y", strtotime($p->lnk_date)) ?></td>
                            <td><?= $p->link_type ?></td>
                            <td><?= $p->linkee ?></td>
                            <td><?= $p->focus ?></td>
                            <td><a href="<?= url("{$p->lt_link}/{$p->lnk_id}") ?>" class="btn btn-primary">View Coaching</a></td>
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
<script type="text/javascript">
$(function(){
    activeMenu($('#menu-linking-sessions'));

    $('.table').DataTable({
        order: [[0, 'desc'],[2, 'asc']],
    });
});
</script>
@endsection