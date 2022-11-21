@extends('layouts.main')
@section('title')
    Blog Posts | Activities > Edit
@endsection
@section('content')
<style type="text/css">
    #img_holder{
        width: 200px;
        margin: 0 auto;
        max-width: 100%;
    }
</style>
<div class="panel panel-default">
    <div class="panel-heading">
        Edit Activity

        <a href="<?= url('activities') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
    </div>
    <div class="panel-body timeline-container">
        <div class="flex-center position-ref full-height">
            {{ Form::open(array('url' => 'activities/' . $activity->id,'id' => 'edit_activity_form', 'files' => true)) }}
                {{ Form::hidden('_method', 'PUT') }}
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" value="{{ $activity->title}}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Subtitle</label>
                            <input type="text" name="subtitle" value="{{ $activity->subtitle}}" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Message</label>
                            <textarea name="message" class="form-control" style="min-height: 100px; resize: vertical;">{{ $activity->message}}</textarea>
                        </div>
                        <br>
                    </div>
                    <div class="col-md-12" style="text-align: center;">
                        <img src="{{$activity->image_url}}" id="img_holder" class="{{ (isset($activity->image_url) || $activity->image_url != '') ? '' : 'hidden'}}">
                        <br>
                        <br>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Image Attachment</label>
                            <input type="file" name="image_url">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Activity Date</label>
                            <input type="text" name="activity_date" class="form-control datepicker" required value="{{ slashedDate($activity->activity_date) }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="border-top: 1px solid rgba(0,0,0,.125); padding-top: 15px; margin-top: 15px"></div>
                <div class="form-group pull-right">
                    <button class="btn btn-primary">Update</button>
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
var changed = false;
window.onbeforeunload = function(){
    if(changed){
        return '';
    }
}
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $('#img_holder').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$(function() {
    activeMenu($('#menu-activities'));

    $('#edit_department_form').validate({
        ignore: []
    });
    $('#image_uploader').change(function(){
        changed = true;
    });
    $('input').change(function(){
        changed = true;
    });
    $('select').change(function(){
        changed = true;
    });
    $('#edit_activity_form').submit(function(){
        changed = false;
    });

    $("input[name=image_url]").change(function() {
        readURL(this);
    });
});
</script>
@endsection