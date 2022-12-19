@extends('layouts.main')
@section('title')
Employees
@endsection
@section('head')
<style type="text/css">
@include('employee.style');
</style>
@endsection
@section('breadcrumbs')
Employees
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="header-container mb-5">
            <div class="d-flex">
                <ul class="alphabet-search">
                    <li>
                        <form>
                            <input type="hidden" name="alphabet" value="<?= $request->alphabet ?>">
                            <input type="hidden" name="department" value="<?= $request->department ?>">
                            <input type="text" placeholder="Search by name" id="search_employee" name="keyword" value="<?= $request->keyword ?>">
                            <button class="btn btn-primary"><span class="fa fa-search"></span></button>
                        </form>
                    </li>
                    <li>
                        <a href="<?= url('employees') ?>" class="btn btn-info">
                            <i class="fa fa-list"></i> &nbsp; List Type View
                        </a>
                    </li>
                </ul>
                <ul class="alphabet-search pull-right">
                    <li>
                        <span class="fa fa-filter" title="Filter By"></span>
                        <select id="sort_option_list">
                            <option value="1"<?= isset($request->department) ? " selected" : "" ?>>Department</option>
                            <option value="2"<?= isset($request->position) ? " selected" : "" ?>>Position</option>
                            <option value="3"<?= isset($request->birthmonth) ? " selected" : "" ?>>Birth Month</option>
                        </select>
                    </li>
                    <li>
                    <?php
                        if($request->department == '' && $request->position == '' && $request->birthmonth == '') {
                    ?>
                        <select id="departments_list">
                            <option disabled selected>Search by department:</option>
                            <?php
                            foreach( $departments as $department) {
                            ?>
                            <option value="<?= $department->department_name ?>"<?= $request->department == $department->department_name ? " selected" : "";?> ><?= $department->department_name ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    <?php
                        } else {
                    ?>
                        <select id="departments_list"<?= isset($request->department) ? '' : ' class="d-none"' ?>>
                            <option disabled selected>Search by department:</option>
                            <?php
                            foreach( $departments as $department) {
                            ?>
                            <option value="<?= $department->department_name ?>"<?= $request->department == $department->department_name ? " selected" : "";?> ><?= $department->department_name ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    <?php
                        }
                    ?>
                        <select id="position_list"<?= isset($request->position) ? '' : ' class="d-none"' ?>>
                            <option disabled selected>Search by Position:</option>
                            <?php
                            foreach( $positions as $position) {
                            ?>
                            <option value="<?= $position->position_name ?>" <?= $request->position == $position->position_name ? " selected" : "";?> ><?= $position->position_name ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <select id="month_list"<?= isset($request->birthmonth) ? '' : ' class="d-none"' ?>>
                            <option disabled selected>Search by Birth Month:</option>
                            <?php
                            for( $m = 1; $m <= 12 ; $m++) {
                            ?>
                            <option value="<?= $m ?>"<?= $request->birthmonth == $m ? " selected" : "";?>><?= date('F', mktime(0,0,0,$m, 1, date('Y'))) ?></option>
                            <?php
                            }
                            ?>
                        </select>
                   </li>
                </ul>
            </div>
            <div class="d-flex justify-center">
                <ul class="alphabet-search">
                    <li class="mx-5">
                        <a href="?alphabet=">All</a>
                    </li>
                    <?php
                    foreach (range('A', 'Z') as $letter) {
                    ?>
                    <li class="mx-5">
                        <a class="alphabet<?= $request->alphabet == $letter ? " selected" : '' ?>" href="?alphabet=<?= $letter . "\n" . "&keyword=" . $request->keyword . "&department=" . $request->department ?>" ><?= $letter . "\n" ?></a>
                    </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
<?php
    if(count($employees) == 0) {
?>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div class="text-center">
            <h3>No results found.</h3>
        </div>
<?php
    }
?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="row" id="employee-card">
<?php
$count = 1;
$row = 1;
    foreach($employees as $employee) {
?>
            <div class="col-md-3" data-row="<?= $row ?>">
                <div class="section-header p-10">
                    <h4 class="m-0"><span class="fa fa-id-card" title="Employee ID"></span>&nbsp;&nbsp; <?= $employee->eid ?></h4>
                </div>
                <div class="panel panel-container panel-card">
                    <div class="text-center">
                        <div class="emp-profile-img m-0">
                            <img src="<?= $employee->profile_img ?>" alt="image" />
                        </div>
                        <h4 class="card-title">
                        <?php
                        if(Auth::check() && (Auth::user()->id == $employee->supervisor_id || Auth::user()->id == $employee->manager_id)) {
                        ?>
                            <a href="<?= url("employee_info/{$employee->id}") ?>"><?= $employee->fullname() ?></a>
                        <?php
                        } else {
                            echo $employee->fullname();
                        }
                        ?>
                        </h4>
                        <h6 class="card-subtitle card-position"><?= $employee->position_name ?></h6>
                        <h6 class="card-subtitle card-team"><?= $employee->team_name ?></h6>
                        <h5 class="card-subtitle">
                            <span class="fa fa-envelope mb-5" title="Email Address"></span>
                            <span class="employee-description employee-email"><?= $employee->email ?></span>
                        </h5>
                        <h6>
                            <span class="name-format mb-5">Immediate Superior: </span>
                            <?= $employee->supervisor_name ?>
                        </h6>
                        <h6>
                            <span class="name-format mb-5">Manager: </span>
                            <?= $employee->manager_name ?>
                        </h6>
                    </div>
                    <br>
                </div>
            </div>
<?php
if($count % 4 == 0) { $row++; }
$count++;
}
?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 header-container">
        <div class="text-center mt-20">
            <?= $employees->appends(Illuminate\Support\Facades\Input::except('page'))->links() ?>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
function rfc3986EncodeURIComponent (str) {  
    return encodeURIComponent(str).replace(/[!'()*]/g, escape);
}
$(function() {
    var name_h = 21;
    var position_h = 13;
    var team_h = 13;

    activeMenu($('#menu-active-employees'));

    $('#employee-card .col-md-3').each(function(key){
        var row = $(this).data('row'),
            name = $(this).find('h4.card-title'),
            position = $(this).find('h6.card-position'),
            team = $(this).find('h6.card-team');

        if(name_h != name.height()) {
            var h = (name_h > name.height()) ? name_h : name.height();

            $('#employee-card .col-md-3[data-row="'+row+'"]').find('h4.card-title').addClass('text-align-center').height(h);
        }

        if(position_h != position.height()) {
            var h = (position_h > position.height()) ? position_h : position.height();

            $('#employee-card .col-md-3[data-row="'+row+'"]').find('h6.card-position').addClass('text-align-center').height(h);
        }

        if(team_h != team.height()) {
            var h = (team_h > team.height()) ? team_h : team.height();

            $('#employee-card .col-md-3[data-row="'+row+'"]').find('h6.card-team').addClass('text-align-center').height(h);
        }
    });

    $('#sort_option_list').change(function(){
        switch($(this).val()){
            case '1':
                $('#departments_list').show();
                $('#position_list').hide();
                $('#month_list').hide();
            break;
            case '2':
                $('#departments_list').hide();
                $('#position_list').show();
                $('#month_list').hide();
            break;
            case '3':
                $('#departments_list').hide();
                $('#position_list').hide();
                $('#month_list').show();
            break;
        }
    });

    $('#departments_list').change(function(){
        var url = location.protocol + '//' + location.host + location.pathname;
        var keyword = "keyword=" + $("#search_employee").val();
        var alphabet = "alphabet=" + $('input[name=alphabet]').val();
        var department = "department=" + rfc3986EncodeURIComponent($(this).val());
        url += "?" + keyword + "&" + alphabet + "&" + department;
        window.location.replace(url);
    });

    $('#position_list').change(function(){
        var url = location.protocol + '//' + location.host + location.pathname;
        var keyword = "keyword=" + $("#search_employee").val();
        var alphabet = "alphabet=" + $('input[name=alphabet]').val();
        var position = "position=" + rfc3986EncodeURIComponent($(this).val());
        url += "?" + keyword + "&" + alphabet + "&" + position;
        window.location.replace(url);
    });

    $('#month_list').change(function(){
        var url = location.protocol + '//' + location.host + location.pathname;
        var position = "birthmonth=" + $(this).val();
        url += "?" + position;
        window.location.replace(url);
    });
});
</script>
@endsection