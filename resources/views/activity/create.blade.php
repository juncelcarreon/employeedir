@extends('layouts.main')
@section('title')
    Blog Posts | Activities > Create
@endsection
@section('content')
<style type="text/css">
    #division_id-error{
        margin-top: 65px;
        margin-left: -61px;
        position: absolute;
    }
    label.error + span{
        padding-bottom: 30px;
    }
    #account_id-error{
        margin-left: -60px;
    }
    #img_holder{
        width: 200px;
        margin: 0 auto;
        max-width: 100%;
    }
</style>
<div class="panel panel-default">
    <div class="panel-heading">
        New Activity

        <a href="<?= url('activities') ?>" class="btn btn-danger pull-right"><span class="fa fa-chevron-left"></span>&nbsp; Back</a>
    </div>
    <div class="panel-body timeline-container">
        <div class="flex-center position-ref full-height">
            <form id="create_activity_form" role="form" method="POST" action="<?= route('activities.store') ?>" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Subtitle</label>
                            <input type="text" name="subtitle" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Message</label>
                            <textarea name="message" class="form-control" style="min-height: 100px; resize: vertical;"></textarea>
                        </div>
                        <br>
                    </div>
                    <div class="col-md-12" style="text-align: center;">
                        <img src="" id="img_holder">
                        <br>
                        <br>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Image Attachment</label>
                            <input type="file" name="image_url" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Activity Date</label>
                            <input type="text" name="activity_date" class="form-control datepicker" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="border-top: 1px solid rgba(0,0,0,.125); padding-top: 15px; margin-top: 15px"></div>
                <div class="form-group pull-right">
                    <button class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
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

    $('#create_activity_form').validate({
        ignore: []
    });

    $("input[name=image_url]").change(function() {
      readURL(this);
    });
});
</script>
@endsection