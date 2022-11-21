@extends('layouts.main')
@section('content')
<style type="text/css">
    .panel-heading a{ color: #fff; }
    .panel-heading a.text-danger{ color: #ff0000; text-decoration: none; }
    /*.panel-heading a.active{ text-decoration: underline; }*/
    .panel-heading a.active{ color: #ffc107; text-decoration: none; }
    .panel-heading a.active, .panel-heading a:hover{ color: #ffc107; text-decoration: none; }
    .font-bold{ font-weight: 700; }
    .td-option{ width: 100px; text-align: center; }
    td span{ display: none; }
    tr.even{ background: #ddd !important; }
    .btn-dark{ background: #343a40; }
    .btn-dark:hover{ background: #000; color: #fff; }
    .btn{ color: #fff !important; }
    small{font-size:75% !important;}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                SURVEY

                <a href="<?= url('survey/create') ?>" class="btn btn-primary pull-right"><span class="fa fa-edit"></span>&nbsp; Create Survey</a>
            </div>
            <div class="pane-body panel">
                <br>
                <br>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(function () {
    $('._table').DataTable({"pageLength": 50});
});
</script>
@endsection