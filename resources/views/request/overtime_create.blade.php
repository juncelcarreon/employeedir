@extends('layouts.main')
@section('title')
Timekeeping | Overtime > Create
@endsection
@section('head')
<style type="text/css">
@include('request.style');
</style>
@endsection
@section('breadcrumb')
Timekeeping <span>/</span> Overtime <span>></span> File Overtime
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <form action="<?= url('overtime') ?>" method="post">
        {{ csrf_field() }}
            <div class="panel panel-default m-0">
                <div class="panel-heading">
                    OVERTIME REQUEST FORM

                    <a href="<?= url('overtime') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
                </div>
                <div class="panel-body timeline-container">
                    <div class="flex-center position-ref full-height">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Name:</strong>
                                    <p><?= Auth::user()->fullname2() ?></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Position:</strong>
                                    <p><?= Auth::user()->position_name ?></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <strong>Department:</strong>
                                    <p><?= Auth::user()->team_name ?></p>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <strong>Date Filed:</strong>
                                    <p><?= date('m/d/Y') ?></p>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-heading panel-subheading">
                    OVERTIME INFORMATION
                </div>
                <div class="panel-body timeline-container">
                    <div class="flex-center position-ref full-height">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <strong class="asterisk-required">Overtime Date:</strong>
                                </div> 
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <strong class="asterisk-required">Estimated No. of Hours:</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <strong>&nbsp;</strong>
                                </div>
                            </div>
                        </div>
                        <div class="entry-content">
                            <div class="row row-entry">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" name="date[]" class="form-control datepicker input_none" placeholder="MM/DD/YYYY" autocomplete="off" required />
                                    </div> 
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="number" name="no_of_hours[]" class="form-control" value="1.00" min="1" required />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-add">
                                            <span class="fa fa-plus"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <strong class="asterisk-required">Reason:</strong>
                                    <textarea name="reason" class="form-control" rows="4" required></textarea>
                                </div> 
                            </div>
                        </div>
                        <div class="division"></div>
                        <div class="form-group pull-right">
                            <input type="submit" class="btn btn-primary btn_submit" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
@include('request.js-script');
@endsection
