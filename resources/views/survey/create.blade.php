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
        CREATE SURVEY FORM

        <a href="<?= url('survey') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
    </div>
    <div class="panel-body timeline-container">
        <div class="flex-center position-ref full-height">
            <form action="<?= url('survey') ?>" method="post">
            {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong>Survey Name: </strong>
                            <input type="text" name="survey_name" class="form-control" placeholder="Survey Name" required>
                        </div> 
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong>Start Date: </strong>
                            <input type="text" name="start_date" class="form-control datepicker" placeholder="MM/DD/YYYY" autocomplete="off" required>
                        </div> 
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong>End Date: </strong>
                            <input type="text" name="end_date" class="form-control datepicker" placeholder="MM/DD/YYYY" autocomplete="off" required>
                        </div> 
                    </div>
                </div>
                <div class="entry-content">
                    <div class="row row-entry" data-no="1" data-main="1" data-sub="0">
                        <div class="col-md-12" style="border-top: 1px solid rgba(0,0,0,.125); padding-top: 15px; margin-top: 15px"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Question: </strong>
                                <input type="text" name="question[]" class="form-control" placeholder="Question" required>
                            </div> 
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <strong>Item Number: </strong>
                                <input type="number" name="item_no[]" class="form-control" value="1" min="1" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <strong>Sub Item Number: </strong>
                                <select name="is_sub[]" class="form-control select_item" readonly style="pointer-events: none;">
                                    <option value="0" selected>- Item Number -</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <strong style="display:block;margin-bottom:10px;">Choices: </strong>
                            <div class="multiple-content">
                                <div class="row row-multiple">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Choice #1" />
                                                <span class="btn btn-add-multiple input-group-addon">
                                                    <span class="fa fa-plus"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <strong>Question Type: </strong>
                                <select name="type[]" class="form-control">
                                    <option value="0" selected disabled>-- Type --</option>
                                    <option value="Text">Text</option>
                                    <option value="Rating">Rating</option>
                                    <option value="Select">Select</option>
                                    <option value="Multiple Choice">Multiple Choice</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <strong>&nbsp;</strong>
                                <button class="btn btn-primary btn-add"><span class="fa fa-plus"></span></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="border-top: 1px solid rgba(0,0,0,.125); padding-top: 15px; margin-top: 15px"></div>
                <div class="form-group pull-right">
                    <input type="submit" id="register-button" class="btn btn-primary" value="Submit">
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
function addChoices(obj) {
    var parent = obj.closest('.multiple-content'),
        entry = parent.find('.row-multiple:first'),
        entry_last = parent.find('.row-multiple:last');

    var new_entry = entry.clone().insertAfter(entry_last);
        new_entry.find('.btn-add-multiple').html('<span class="fa fa-minus"></span>');
        new_entry.find('.btn-add-multiple').removeClass('btn-add').addClass('btn-remove-multiple')
        new_entry.find('input[type="text"]').val('');
        new_entry.find('.btn-remove-multiple').click(function(e) {
            e.preventDefault();

            $(this).closest('.row-multiple').remove();

            parent.find('.row-multiple').each(function(key) {
                key = key + 1;
                $(this).find('input').attr('placeholder', 'Choice #'+key);
            });
        });

    parent.find('.row-multiple').each(function(key) {
        key = key + 1;
        $(this).find('input').attr('placeholder', 'Choice #'+key);
    });
}
$(function(){
    $('.datepicker').datepicker({
        minDate: 0
    });

    $('.btn-add').click(function(e) {
        e.preventDefault();

        var obj = $(this),
            parent = obj.closest('.entry-content'),
            entry = parent.find('.row-entry:first'),
            entry_last = parent.find('.row-entry:last');

        var new_entry = entry.clone().insertAfter(entry_last);
            new_entry.attr('data-no', $('.row-entry[data-main="1"]').length);
            new_entry.find('.btn-add').html('<span class="fa fa-minus"></span>');
            new_entry.find('.btn-add').removeClass('btn-primary').addClass('btn-danger');
            new_entry.find('.btn-add').removeClass('btn-add').addClass('btn-remove');
            new_entry.find('input[type="text"]').val('');
            new_entry.find('input[type="number"]').val($('.row-entry[data-main="1"]').length);
            new_entry.find('select').val(0);
            new_entry.find('.row-multiple').each(function(key) {
                if(key != 0) {
                    $(this).remove();
                }
            });
            new_entry.find('.select_item').removeAttr('readonly').removeAttr('style');
            new_entry.find('.btn-add-multiple').click(function(e) {
                e.preventDefault();

                addChoices($(this));
            });
            new_entry.find('.btn-remove').click(function(e) {
                e.preventDefault();
                $(this).closest('.row-entry').remove();

                $('.row-entry').each(function(key) {
                    key = key + 1;
                    $(this).find('input[type="number"]').val(key);
                });
            });

            $('.row-entry[data-main="1"]').each(function(key) {
                if(new_entry.attr('data-no') != $(this).attr('data-no')) {
                    new_entry.find('.select_item').append('<option value="' + $(this).attr('data-no') + '">' + $(this).attr('data-no') + '</option>');
                }
            });

            new_entry.find('.select_item').change(function(e) {
                var row = $(this).closest('.row-entry'),
                    no = row.attr('data-no'),
                    sub = parseFloat(row.attr('data-sub')) + 1,
                    number = $(this).val() + '.' + sub;

                if($(this).val() == 0) {
                    row.attr('data-main', 1).attr('data-no', $(this).val()).attr('data-sub', sub);
                    row.find('input[type="number"]').val(number).attr('step', '.1');
                } else {
                    row.attr('data-main', 0).attr('data-no', $(this).val()).attr('data-sub', sub);
                    row.find('input[type="number"]').val(number).attr('step', '.1');
                }
            });
    });

    $('.btn-add-multiple').click(function(e) {
        e.preventDefault();

        addChoices($(this));
    });
});
</script>
@endsection
