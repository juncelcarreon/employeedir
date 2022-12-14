@extends('layouts.main')
@section('title')
Timekeeping | Overtime > Timekeeping
@endsection
@section('head')
<style type="text/css">
@include('request.style');
</style>
@endsection
@section('breadcrumb')
Timekeeping <span>/</span> Overtime <span>></span> Timekeeping
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <form action="<?= url('overtime/verification') ?>" method="post">
        {{ csrf_field() }}
            <input type="hidden" name="id" value="<?= $overtime->id ?>">
            <div class="panel panel-default m-0">
                <div class="panel-heading">
                    OVERTIME TIMEKEEPING

                    <a href="<?= url("overtime/{$overtime->id}") ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
                </div>
                <div class="panel-body timeline-container">
                    <div class="flex-center position-ref full-height">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Name:</strong>
                                    <p><?= $overtime->first_name.' '.$overtime->last_name ?></p>
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Position:</strong>
                                    <p><?= $overtime->position_name ?></p>
                                </div> 
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <strong>Department:</strong>
                                    <p><?= $overtime->team_name ?></p>
                                </div> 
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <strong>Date Filed:</strong>
                                    <p><?= date('m/d/Y',strtotime($overtime->created_at)) ?></p>
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <strong>Reason:</strong>
                                    <p class="pre-line"><?= htmlentities($overtime->reason) ?></p>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-heading panel-subheading">
                    TIMEKEEPING LOG
                </div>
                <div class="panel-body timeline-container">
                    <div class="flex-center position-ref full-height">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped" id="table-timekeeping">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>No. of Hours (Estimate)</th>
                                            <th>Time In</th>
                                            <th>Time Out</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach($overtime->dates as $key=>$date) {
                                    ?>
                                        <tr>
                                            <td><?= date('F d, Y',strtotime($date)) ?></td>
                                            <td><?= $overtime->no_of_hours[$key] ?></td>
                                            <td>
                                                <input type="hidden" name="ids[]" value="<?= $overtime->ids[$key] ?>">
                                                <div class="form-group">
                                                    <div class="input-group datetimepicker time_in">
                                                        <input type="text" name="time_in[]" class="form-control input_none" value="<?= empty($overtime->time_in[$key]) ? '' : date('m/d/Y H:i A', strtotime($overtime->time_in[$key])) ?>" autocomplete="off" placeholder="MM/DD/YYYY 00:00 AM"<?= ($key == 0) ? ' required' : '' ?> />
                                                        <span class="input-group-addon">
                                                            <i class="glyphicon glyphicon-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <div class="input-group datetimepicker time_out">
                                                        <input type="text" name="time_out[]" class="form-control input_none" value="<?= empty($overtime->time_out[$key]) ? '' : date('m/d/Y H:i A', strtotime($overtime->time_out[$key])) ?>" autocomplete="off" placeholder="MM/DD/YYYY 00:00 AM" />
                                                        <span class="input-group-addon">
                                                            <i class="glyphicon glyphicon-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                            if(!empty($overtime->approved_reason) && $overtime->status == 'APPROVED') {
                            ?>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <strong class="asterisk-required">Remark <small>(Revert Reason):</small></strong>
                                    <textarea class="form-control" name="remarks" rows="5" required></textarea>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
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