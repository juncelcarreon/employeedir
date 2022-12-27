@extends('layouts.main')
@section('title')
Linking Sessions > Cementing Expectation > View Session
@endsection
@section('head')
<style>
@include('coaching.style');
</style>
@endsection
@section('breadcrumb')
Linking Sessions <span>/</span> Cementing Expectation <span>></span> View Session
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary m-0">
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
                Cementing Expectation Session
            </div>
            <div class="panel-body">
                <div class="row d-flex">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Focus</label>
                            <input type="text" class="form-control" name="rf_focus" value="<?= $obj->fc_desc ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Behavior/Skill</label>
                            <input type="text" name="se_skill" class="form-control" value="<?= $obj->se_skill ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>When we use the Skill</label>
                            <input type="text" name="se_when_use" class="form-control" value="<?= $obj->se_when_use ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>How we use the Skill</label>
                            <input type="text" name="se_how_use" class="form-control" value="<?= $obj->se_how_use ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Why we use the Skill</label>
                            <input type="text" name="se_why_use" class="form-control" value="<?= $obj->se_why_use ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>My Expectations</label>
                            <input type="text" name="se_expectations" class="form-control" value="<?= $obj->se_expectations ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Comments</label>
                            <textarea name="se_comments" rows="10" class="form-control" readonly><?= $obj->se_comments ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Feedback</label>
                            <textarea name="se_feedback" rows="10" class="form-control" readonly><?= $obj->se_feedback ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@include('coaching.js-script')
@endsection