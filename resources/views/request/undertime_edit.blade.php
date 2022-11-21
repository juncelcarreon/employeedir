@extends('layouts.main')
@section('content')
<style>
.form-group strong {
    display: block;
    margin-bottom: 10px;
}
.form-group button {
    display: block;
    width: 100%;
}
</style>
<div class="panel panel-default">
    <div class="panel-heading">
        UNDERTIME REQUEST FORM

        <a href="<?= url("undertime/{$undertime->id}") ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
    </div>
    <div class="panel-body timeline-container ">
        <div class="flex-center position-ref full-height">
            <form action="<?= url('undertime/update') ?>" method="post">
            {{ csrf_field() }}
                <input type="hidden" name="id" value="<?= $undertime->id ?>">
                <div class="row">
                    <div class="col-md-8"></div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong>Date Filed: </strong>
                            <input type="text" value="<?= date('m/d/Y',strtotime($undertime->created_at)) ?>" name="date_filed" class="form-control" placeholder="Date Filed" readonly autocomplete="off">
                        </div> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong>Name: </strong>
                            <input type="text" name="name" class="form-control" placeholder="Position" value="<?= $undertime->first_name.' '.$undertime->last_name ?>" readonly>
                        </div> 
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong>Position: </strong>
                            <input type="text" name="position" class="form-control" placeholder="Position" value="<?= $undertime->position_name ?>" readonly>
                        </div> 
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong>Department: </strong>
                            <input type="text" name="department" class="form-control" placeholder="Dept/Section" value="<?= $undertime->team_name ?>" readonly>
                        </div> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong>Undertime Date: </strong>
                            <input type="text" name="date" class="form-control undertime_date" placeholder="MM/DD/YYYY" value="<?= date('m/d/Y',strtotime($undertime->date)) ?>" autocomplete="off" required>
                        </div> 
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong>Time In:</strong>
                            <div class="input-group datetimepicker time_in">
                                <input type="text" name="time_in" class="form-control" value="<?= date('m/d/Y H:i A',strtotime($undertime->time_in)) ?>" onkeydown="return false" placeholder="MM/DD/YYYY 00:00 AM" required/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong>Time Out:</strong>
                            <div class="input-group datetimepicker time_out">
                                <input type="text" name="time_out" class="form-control" value="<?= date('m/d/Y H:i A',strtotime($undertime->time_out)) ?>" onkeydown="return false" placeholder="MM/DD/YYYY 00:00 AM" required/>
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
                            <strong>Reason: </strong>
                            <textarea name="reason" class="form-control" rows="4" required><?= $undertime->reason ?></textarea>
                        </div> 
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
    activeMenu($('#menu-undertime'));

    $('.time_in').datetimepicker({ useCurrent: false, maxDate: new Date('<?= $undertime->time_out ?>') });
    $('.time_out').datetimepicker({ useCurrent: false, minDate: new Date('<?= $undertime->time_in ?>') });

    $('.undertime_date').datepicker();

    $(".time_in").on("dp.change", function (e) {
        $('.time_out').data("DateTimePicker").minDate(e.date);
    });

    $(".time_out").on("dp.change", function (e) {
        $('.time_in').data("DateTimePicker").maxDate(e.date);
    });

    $('input[type="submit"]').click(function(e) {
        var obj = $(this),
            form = obj.closest('form'),
            result = true;

        form.find('input[required], textarea[required], select[required]').each(function(e) {
            if($(this).val() == ''){
                $(this).focus();

                result = false;

                return;
            }
        });

        if(result) {
            $('body').css({'pointer-events':'none'});
            obj.attr('disabled', true);
            obj.val('Please wait');
            form.submit();
        }
    });

    $('input[type="reset"]').click(function(e) {
        e.preventDefault();

        var obj = $(this),
            form = obj.closest('form');

        form.find('input[required], textarea[required]').each(function() {
            $(this).val('');
        });
    });
});
</script>
@endsection