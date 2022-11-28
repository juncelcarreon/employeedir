@extends('layouts.main')
@section('title')
Linking Sessions > Personal Sessions
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
                <div class="col-md-12"><b style="color: #0000FF; font-size: 16px;">My Personal Linking Sessions</b></div>
            </div>
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Linker</th>
                                <th>Type</th>
                                <th>Focus</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($my_links as $ll) {
                        ?>
                        <tr>
                            <td><?= date("F d, Y",strtotime($ll->lnk_date)) ?></td>
                            <td><?= $ll->lnk_linker_name ?></td>
                            <td><?= $ll->link_type_desc ?></td>
                            <td><?= $ll->focus ?></td>
                            <td><?= $ll->link_button ?></td>
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