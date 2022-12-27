@extends('layouts.main')
@section('title')
Departments
@endsection
@section('head')
<style type="text/css">
@include('admin.style');
</style>
@endsection
@section('breadcrumb')
Departments
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default m-0">
            <div class="panel-heading">
                List of Departments

                <a href="<?= url('department/create') ?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp; Add Department</a>
            </div>
            <div class="pane-body panel m-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th align="left">#</th>
                            <th>Department Code</th>
                            <th style="max-width: 250px;">Department Name</th>
                            <th>Division</th>
                            <th>Account</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($departments as $idx=>$department) {
                    ?>
                        <tr> 
                            <td><?= ++$idx ?></td>
                            <td><?= $department->department_code ?></td>
                            <td><h5><?= $department->department_name ?></h5></td>
                            <td><?= (isset($department->division)) ? $department->division->division_name : 'N/A' ?></td>
                            <td><?= (isset($department->account)) ? $department->account->account_name : 'N/A' ?></td>
                            <td align="center">
                                <a href="<?= url("department/{$department->id}/edit") ?>" title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </a>&nbsp;&nbsp;
                                <a href="javascript:;" class="delete_btn" data-toggle="modal" data-target="#messageModal" title="Delete" data-id="<?= $department->id ?>">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
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
@endsection
@section('scripts')
<script type="text/javascript">
$(function(e) {
    activeMenu($('#menu-department'));

    $('.delete_btn').click(function(){
        $('#messageModal .modal-title').html('Delete Department');
        $('#messageModal #message').html('Are you sure you want to delete the department ?');
        $('#messageModal .delete_form').attr('action', "<?= url('department') ?>/" + $(this).attr("data-id"));
    });

    $('#messageModal #yes').click(function(){
        $('#messageModal .delete_form').submit();
    });
});
</script>
@endsection