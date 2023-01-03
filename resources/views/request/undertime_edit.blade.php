@extends('layouts.main')
@section('title')
Timekeeping | Undertime > Edit Undertime Application
@endsection
@section('head')
<style type="text/css">
@include('request.style');
</style>
@endsection
@section('breadcrumb')
Timekeeping <span>/</span> Undertime <span>></span> Edit Undertime
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <form action="<?= url('undertime/update') ?>" method="post">
        {{ csrf_field() }}
            <input type="hidden" name="id" value="<?= $undertime->id ?>" />
            <div class="panel panel-default m-0">
                <div class="panel-heading">
                    UNDERTIME REQUEST FORM

                    <a href="<?= url("undertime/{$undertime->id}") ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
                </div>
                <div class="panel-body timeline-container">
                    <div class="flex-center position-ref full-height">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Name:</strong>
                                    <p><?= $undertime->first_name.' '.$undertime->last_name ?></p>
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Position:</strong>
                                    <p><?= $undertime->position_name ?></p>
                                </div> 
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <strong>Department:</strong>
                                    <p><?= $undertime->team_name ?></p>
                                </div> 
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <strong>Date Filed:</strong>
                                    <p><?= date('m/d/Y',strtotime($undertime->created_at)) ?></p>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-heading panel-subheading">
                    UNDERTIME INFORMATION
                </div>
                <div class="panel-body timeline-container">
                    <div class="flex-center position-ref full-height">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <strong class="asterisk-required">Undertime Date:</strong>
                                    <input type="text" name="date" class="form-control datepicker input_none" placeholder="MM/DD/YYYY" value="<?= date('m/d/Y',strtotime($undertime->date)) ?>" autocomplete="off" required />
                                </div> 
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <strong class="asterisk-required">Time In:</strong>
                                    <div class="input-group datetimepicker time_in">
                                        <input type="text" name="time_in" class="form-control input_none" value="<?= date('m/d/Y H:i A',strtotime($undertime->time_in)) ?>" placeholder="MM/DD/YYYY 00:00 AM" autocomplete="off" required />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <strong class="asterisk-required">Time Out:</strong>
                                    <div class="input-group datetimepicker time_out">
                                        <input type="text" name="time_out" class="form-control input_none" value="<?= date('m/d/Y H:i A',strtotime($undertime->time_out)) ?>" placeholder="MM/DD/YYYY 00:00 AM" autocomplete="off" required />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <strong class="asterisk-required">Reason: </strong>
                                    <textarea name="reason" class="form-control" rows="4" required><?= $undertime->reason ?></textarea>
                                </div> 
                            </div>
                        </div>
                        <div class="division"></div>
                        <div class="form-group pull-right">
                            <input type="submit" class="btn btn-primary btn_submit" value="Update" />
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