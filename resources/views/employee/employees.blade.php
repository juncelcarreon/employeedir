@extends('layouts.main')
@section('breadcrumb')
Employees > Active Employees
@endsection
@section('title')
Employees > Active Employees
@endsection
@section('content')
<style type="text/css">
.header-container{
    position: relative;
    z-index: 10;
}
.header-margin{
    margin: 20px auto 5px;
}
.alphabet-search{
    display: inline-flex;
    list-style: none;
    padding-left: 0;
}
.alphabet-search li{
    margin-right: 10px;
}
.alphabet-search form button{
    height: 35px;
    margin: 1px 0 0;
}
.alphabet-search li.m-t-5{
    margin-top: -5px
}
#search_employee{
    padding: 5px;
}
select{
    cursor: pointer !important;
    padding: 7px; 
    border-radius: 0px !important; 
    font-size: 11px !important;
}
select.d-none{
    display: none;
}
select#month_list{
    width: 200px; 
}
.fa-filter{
    color: #777777; 
    font-size: 18px; 
    padding: 5px;
}
.btn-clear{
    margin: 0px;
    height: 30px;
}
.d-flex{
    display: flex; 
    justify-content:space-between;
    align-items: center;
}
.emp-profile{
    background-color: #fff;
    padding: 10px; 
    margin: 0 auto;
    border-bottom: 1px solid #ddd;
}
.emp-image{
    width: 60px; 
    height: 60px;
    margin: 15px;
    position: relative;
    border-radius: 50%;
    overflow: hidden;
}
.emp-image img{
    width: 100%;
    height: 100%;
    object-fit:cover;
}
.employee-description{
    color: #777;
    font-size: 12px;
}
.employee-email{
    color: #0c59a2;
}
h4.timeline-title{
    font-size: 17px; 
    text-transform: uppercase;
}
h4.timeline-title a{
    transition: linear 0.3s;
}
h4.timeline-title a:hover{
    padding-left: 5px;
}
h5{
    color: #455;
}
h3, h6.employee-account{
    color: #777;
}
h6 span.name-format{
    color: #808080;
}
.pagination>li:first-child>a, .pagination>li:first-child>span{
    border-top-left-radius: 0px !important;
    border-bottom-left-radius: 0px !important;
}
.pagination>li:last-child>a, .pagination>li:last-child>span {
    border-top-right-radius: 0px !important;
    border-bottom-right-radius: 0px !important;
}
.p-0{
    padding: 0 !important;
}
.emp-profile .fa-eye, .fa-pencil{
    color: #3A75FB;
}
.emp-profile .fa-user-times{
    color: #ff0000;
}
</style>
<div class="col-md-12">
    <div class="header-container header-margin">
        <a href="<?= url('employee_info/create') ?>" class="btn btn-primary">
            <i class="fa fa-plus"></i> &nbsp; Add Employee
        </a>
        <a href="/download-filter?<?= (empty($_SERVER['QUERY_STRING']) ? '' : $_SERVER['QUERY_STRING']) ?>" class="btn btn-info" >
            <i class="glyphicon glyphicon-arrow-down"></i>&nbsp; Download Employee Information
        </a>
        <br>
        <br>
        <ul class="alphabet-search">
            <li>
                <form>
                    <input type="hidden" name="alphabet" value="<?= $request->alphabet ?>">
                    <input type="hidden" name="department" value="<?= $request->department ?>">
                    <input type="text" placeholder="Search by name" id="search_employee" name="keyword" value="<?= $request->keyword ?>">
                    <button class="btn btn-primary">
                        <span class="fa fa-search"></span>
                    </button>
                </form>
            </li>
            <li class="m-t-5">
                &nbsp;
                &nbsp;
                <label>Inactive Employees</label>
                <input type="radio" id="inactive_employees">
                <br>
                &nbsp;
                &nbsp;
                <label>No Profile Images</label>
                <input type="radio" id="no_profile_images" <?= $request->no_profile_images == 'true' ? 'checked' : '' ?>>
            </li>
            <li>
                &nbsp;
                &nbsp;
                <label>Invalid Birthday</label>
                <input type="radio" id="invalid_birth_date" <?= $request->invalid_birth_date == 'true' ? 'checked' : '' ?>>
            </li>
            <li>
                <span class="fa fa-filter" title="Filter By"></span>
                <select id="sort_option_list">
                    <option value="1" <?= isset($request->department) ? "selected" : "" ?>>Department</option>
                    <option value="2" <?= isset($request->position) ? "selected" : "" ?>>Position</option>
                    <option value="3" <?= isset($request->birthmonth) ? "selected" : "" ?>>Birth Month</option>
                </select>
            </li>
            <li>
                <?php
                if($request->department == '' && $request->position == '' && $request->birthmonth == '') {
                ?>
                <select id="departments_list">
                    <option disabled selected>Search by department:</option>
                    <?php
                    foreach($departments as $department) {
                    ?>
                    <option<?= $request->department == $department->department_name ? " selected" : "";?> ><?= $department->department_name ?></option>
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
                    foreach($departments as $department) {
                    ?>
                    <option<?= $request->department == $department->department_name ? " selected" : "";?> ><?= $department->department_name ?></option>
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
                    foreach($positions as $position) {
                    ?>
                    <option<?= $request->position == $position->position_name ? " selected" : "";?> ><?= $position->position_name ?></option>
                    <?php
                    }
                    ?>
               </select>
                <select id="month_list"<?= isset($request->birthmonth) ? '' : ' class="d-none"' ?>>
                    <option disabled selected>Search by Birth Month:</option>
                    <?php
                    for($m = 1; $m <= 12; $m++) {
                    ?>
                    <option value="<?= $m ?>"<?= $request->birthmonth == $m ? " selected" : "";?> ><?= date('F', mktime(0,0,0,$m, 1, date('Y'))) ?></option>
                    <?php
                    }
                    ?>
                </select>
            </li>
            <li>
                <a href="<?= url('employees') ?>" class="btn btn-default btn-clear">Clear Filter</a>
            </li>
        </ul>
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
foreach($employees as $employee) {
?>
    <div class="col-md-12 p-0">
        <div class="emp-profile">
            <div class="row d-flex">
                <div class="col-md-1">
                    <div class="emp-image">
                        <img src="<?= $employee->profile_img ?>" alt="<?= $employee->fullname() ?>" />
                    </div>
                </div>
                <div class="col-md-3">
                    <h4 class="timeline-title name-format">
                        <a href="<?= url("employee_info/{$employee->id}") ?>"><?= $employee->fullname() ?></a>
                    </h4>
                    <h5><?= $employee->position_name ?></h5>
                    <h6 class="employee-account"><?= $employee->team_name ?> <?= isset($employee->account) ? "- ". $employee->account->account_name : "" ; ?></h6>
                </div>
                <div class="col-md-3">
                    <h5>
                        <span class="fa fa-id-card" title="Employee ID"></span>
                        <span class="employee-description">&nbsp;&nbsp;<?= $employee->eid ?></span>
                    </h5>
                    <h5>
                        <span class="fa fa-envelope" title="Email Address"></span>&nbsp;&nbsp;
                        <span class="employee-description employee-email"><?= $employee->email ?></span>
                    </h5>
                <?php
                if(isset($employee->ext) && $employee->ext != '--' && $employee->ext != '') {
                ?>
                    <h5>
                        <span class="fa fa-phone" title="Extension Number"></span>
                        <span class="employee-description" >&nbsp;&nbsp;<?= $employee->ext ?></span>
                    </h5>
                <?php
                }
                if(isset($employee->alias) && $employee->alias != '--' && $employee->alias != '') {
                ?>
                    <h5>
                        <span class="fa fa-mobile" title="Phone Name"></span>
                        <span class="employee-description" >&nbsp;&nbsp;<?= $employee->alias ?></span>
                    </h5>
                <?php
                }
                ?>
                </div>
                <div class="col-md-3">
                    <h6>
                        <span class="fa fa-user" title="Supervisor"></span>
                        <span class="name-format">Immediate Superior: </span>
                        <?= $employee->supervisor_name ?>
                    </h6>
                    <h6>
                        <span class="fa fa-user" title="Manager"></span>
                        <span class="name-format">Manager: </span>
                        <?= $employee->manager_name ?>
                    </h6>
                </div>
                <div class="col-md-2">
                    <div class="options">
                        <a href="<?= url("employee_info/{$employee->id}") ?>" title="View">
                            <i class="fa fa-eye"></i>
                        </a>&nbsp;&nbsp;    
                        <a href="<?= url("employee_info/{$employee->id}/edit") ?>" title="Edit">
                            <i class="fa fa-pencil"></i>
                        </a>&nbsp;&nbsp;
                        <a href="#" class="delete_btn" data-toggle="modal" data-target="#messageModal" title="Deactivate" data-id="<?= $employee->id ?>">
                            <i class="fa fa-user-times"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>
</div>
<div class="col-md-12 header-container">
    <div class="pull-right">
        <?= $employees->appends(Illuminate\Support\Facades\Input::except('page'))->links() ?>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
function rfc3986EncodeURIComponent (str) {  
    return encodeURIComponent(str).replace(/[!'()*]/g, escape);
}
$(function() {
    activeMenu($('#menu-active-employees'));

    $('.delete_btn').click(function(){
        $('#messageModal .modal-title').html('Delete Employee');
        $('#messageModal #message').html('Are you sure you want to delete the employee ?');

        $('#messageModal .delete_form').attr('action', "<?= url('employee_info') ?>/" + $(this).attr("data-id"));
    });

    $('#messageModal #yes').click(function(){
        $('#messageModal .delete_form').submit();
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

    $('#month_list').change(function(){
        var url = location.protocol + '//' + location.host + location.pathname;
        var birthmonth = "birthmonth=" + $(this).val();
        url += "?" + birthmonth;
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

    $('#inactive_employees').change(function(){
        if($(this).is(':checked')){
            var url = '{{ url("employees/separated") }}';
            window.location.replace(url);
        }
    });

    $('#no_profile_images').change(function(){
        var url = location.protocol + '//' + location.host + location.pathname;
        if($(this).is(':checked')){
            var no_profile_images = "no_profile_images=" + true;
            url += "?" + no_profile_images;
            window.location.replace(url);
        }
    });

    $('#invalid_birth_date').change(function(){
        var url = location.protocol + '//' + location.host + location.pathname;
        if($(this).is(':checked')){
            var no_profile_images = "invalid_birth_date=" + true;
            url += "?" + no_profile_images;
            window.location.replace(url);
        } else{
            window.location.replace(url);
        }
    });
});
</script>
@endsection