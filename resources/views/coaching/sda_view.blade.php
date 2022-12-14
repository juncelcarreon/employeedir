@extends('layouts.main')
@section('title')
Linking Sessions > Skills Development Activities > View Session
@endsection
@section('breadcrumb')
Linking Sessions <span>/</span> Skills Development Activities <span>></span> View Session
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
                    <input type="text" class="form-control" name="lnk_linkee_name" value="<?= $linkee->fullName2() ?>" readonly>
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
        Skill Development Activities Session
    </div>
    <div class="panel-body">
        <div class="row d-flex">
            <div class="col-md-4">
                <div class="form-group">
                    <label>SDA Type</label>
                    <input type="text" name="sda_type" class="form-control" value="<?= $obj->sda_type_desc ?>" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Date of Call</label>
                    <input type="text" name="sda_date_call" class="form-control select-date" value="<?= date('m/d/Y', strtotime($obj->sda_date_call)) ?>" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Call Selection</label>
                    <input type="text" name="sda_call_sel" class="form-control" value="<?= $obj->sda_call_sel ?>" readonly>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>What Went Well, You Said</label>
                    <textarea name="sda_www_u_said" rows="5" class="form-control" readonly><?= $obj->sda_www_u_said ?></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>What Went Well, I Said</label>
                    <textarea name="sda_www_i_said" rows="5" class="form-control" readonly><?= $obj->sda_www_i_said ?></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>What Could Make This Even Better, You Said</label>
                    <textarea name="sda_wcm_u_said" rows="5" class="form-control" readonly><?= $obj->sda_wcm_u_said ?></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>What Could Make this Even Better, I Said</label>
                    <textarea name="sda_wcm_i_said" rows="5" class="form-control" readonly><?= $obj->sda_wcm_i_said ?></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Comments</label>
                    <textarea name="sda_comments" rows="10" class="form-control" readonly><?= $obj->sda_comments ?></textarea>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Feedback</label>
                    <textarea name="sda_feedback" rows="10" class="form-control" readonly><?= $obj->sda_feedback ?></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
@include('coaching.js-script')
@endsection