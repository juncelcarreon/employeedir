@extends('layouts.main')
@section('content')
<style>
.form-group strong {
    display: block;
    margin-bottom: 10px;
}
.dataTables_wrapper{
    margin: 0;
}
</style>
<div class="panel panel-default">
    <div class="panel-heading">
        OVERTIME TIMEKEEPING

        <a href="<?= url("overtime/{$overtime->id}") ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
    </div>
    <div class="panel-body timeline-container ">
        <div class="flex-center position-ref full-height">
            <form action="<?= url('overtime/verification') ?>" method="post">
            {{ csrf_field() }}
                <input type="hidden" name="id" value="<?= $overtime->id ?>">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <strong>Name: </strong>
                            <p><?= $overtime->first_name.' '.$overtime->last_name ?></p>
                        </div> 
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <strong>Position: </strong>
                            <p><?= $overtime->position_name ?></p>
                        </div> 
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <strong>Department: </strong>
                            <p><?= $overtime->team_name ?></p>
                        </div> 
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <strong>Date Filed: </strong>
                            <p><?= date('m/d/Y',strtotime($overtime->created_at)) ?></p>
                        </div> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>Reason: </strong>
                            <p style="white-space: pre;"><?= htmlentities($overtime->reason) ?></p>
                        </div> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
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
                                                <input type="text" name="time_in[]" class="form-control" value="<?= empty($overtime->time_in[$key]) ? '' : date('m/d/Y H:i A', strtotime($overtime->time_in[$key])) ?>" onkeydown="return false" placeholder="MM/DD/YYYY 00:00 AM" />
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <div class="input-group datetimepicker time_out">
                                                <input type="text" name="time_out[]" class="form-control" value="<?= empty($overtime->time_out[$key]) ? '' : date('m/d/Y H:i A', strtotime($overtime->time_out[$key])) ?>" onkeydown="return false" placeholder="MM/DD/YYYY 00:00 AM" />
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
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
                </div>
                <div class="col-md-12" style="border-top: 1px solid rgba(0,0,0,.125); padding-top: 15px; margin-top: 15px"></div>
                <div class="form-group pull-right">
                    <input type="submit" id="register-button" class="btn btn-primary" value="Update">
                    <input type="reset" class="btn btn-default" value="Reset">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<!-- <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea', forced_root_block : 'p' });</script> -->
<script type="text/javascript">
$(function(){
    activeMenu($('#menu-overtime'));

    $('.datetimepicker').datetimepicker({ useCurrent: false });

    $(".time_in").on("dp.change", function (e) {
        var obj = $(this),
            row = obj.closest('tr');

        row.find('.time_out').data("DateTimePicker").minDate(e.date);
    });

    $(".time_out").on("dp.change", function (e) {
        var obj = $(this),
            row = obj.closest('tr');

        row.find('.time_in').data("DateTimePicker").maxDate(e.date);
    });

    $('input[type="submit"]').click(function(e) {
        e.preventDefault();
        var obj = $(this),
            form = obj.closest('form');

        $('body').css({'pointer-events':'none'});
        obj.attr('disabled', true);
        obj.val('Please wait');
        form.submit();
    });

    $('input[type="reset"]').click(function(e) {
        e.preventDefault();

        $('.datetimepicker').each(function() {
            $(this).data("DateTimePicker").clear();
        });
    });
});
</script>
@endsection