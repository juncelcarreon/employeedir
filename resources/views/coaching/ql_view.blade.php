@extends('layouts.main')
@section('title')
Linking Sessions > Quick Link > View Session
@endsection
@section('breadcrumb')
Linking Sessions > Quick Link > View Session
@endsection
@section('content')
<style>
@include('coaching.style');
</style>
<div class="panel panel-primary">
    @include('coaching.sub_menu')
    <div class="panel-body">
        <div class="row d-flex">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Linker</label>
                    <input type="text" class="form-control" name="lnk_linker_name" value="<?= $linker->fullName2() ?>" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Linkee</label>
                    <input type="text" class="form-control" name="lnk_linker_name" value="<?= $linkee->fullName2() ?>" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Date</label>
                    <input type="text" class="form-control" value="<?= date('F d, Y', strtotime($obj->lnk_date)) ?>" readonly>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-subheading">
        Quick Link Session
    </div>
    <div class="panel-body">
        <div class="row d-flex">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Focus</label>
                    <input type="text" class="form-control" name="rf_focus" value="<?= $obj->fc_desc ?>" readonly>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Comments</label>
                    <textarea name="rf_comments" rows="10" class="form-control" readonly><?= $obj->rf_comments ?></textarea>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Feedback</label>
                    <textarea name="rf_feedback" rows="10" class="form-control" readonly><?= $obj->rf_feedback ?></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
@include('coaching.js-script')
@endsection