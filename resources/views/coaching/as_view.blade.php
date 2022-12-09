@extends('layouts.main')
@section('title')
Linking Sessions > Accountability Setting > View Session
@endsection
@section('breadcrumb')
Linking Sessions > Accountability Setting > View Session
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
                    <input type="text" class="form-control" name="lnk_linkee" value="<?= $linkee->fullName2() ?>" readonly>
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
        Accountability Setting Session
    </div>
    <div class="panel-body">
        <div class="row d-flex">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Focus</label>
                    <input type="text" class="form-control" name="ac_focus" value="<?= $obj->fc_desc ?>" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Behavior/Skill</label>
                    <input type="text" name="ac_skill" class="form-control" value="<?= $obj->ac_skill ?>" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>When we use the Skill</label>
                    <input type="text" name="ac_when_use" class="form-control" value="<?= $obj->ac_when_use ?>" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>How we use the Skill</label>
                    <input type="text" name="ac_how_use" class="form-control" value="<?= $obj->ac_how_use ?>" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Why we use the Skill</label>
                    <input type="text" name="ac_why_use" class="form-control" value="<?= $obj->ac_why_use ?>" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>My Expectations</label>
                    <input type="text" name="ac_expectations" class="form-control" value="<?= $obj->ac_expectations ?>" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Date Expectation was Set</label>
                    <input type="text" name="ac_expectation_date" class="form-control select-date" value="<?= date('m/d/Y', strtotime($obj->ac_expectation_date)) ?>" readonly>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Comments</label>
                    <textarea name="ac_comments" rows="10" class="form-control" readonly><?= $obj->ac_comments ?></textarea>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Feedback</label>
                    <textarea name="ac_feedback" rows="10" class="form-control" readonly><?= $obj->ac_feedback ?></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
@include('coaching.js-script')
@endsection