@extends('layouts.main')
@section('title')
Linking Sessions > Accountability Setting > Edit Session
@endsection
@section('breadcrumb')
Linking Sessions > Accountability Setting > Edit Session
@endsection
@section('content')
<style>
@include('coaching.style');
</style>
<form action="<?= url('update-acc-set') ?>" method="post" autocomplete="off">
    {{ csrf_field() }}
    <input type="hidden" name="ac_com_id" value="<?= $obj->ac_com_id ?>">
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
            Accountability Setting Session

            <a id="btn-history" class="btn btn-warning pull-right" href="#" data-toggle="modal" data-target="#modal-history"><i class="fa fa-history"></i> History</a>
        </div>
        <div class="panel-body">
            <div class="row d-flex">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">Focus</label>
                        <select name="ac_focus" class="form-control select2" required>
                            <option value="0" disabled selected>Select a Focus</option>
                            <?php
                            foreach($sel_focus as $ss) {
                            ?>
                            <option value="<?= $ss->fc_id ?>"<?= ($obj->ac_focus == $ss->fc_id) ? " selected" : ""?>><?= $ss->fc_desc ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">Behavior/Skill</label>
                        <input type="text" name="ac_skill" class="form-control" value="<?= $obj->ac_skill ?>" required>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">When we use the Skill</label>
                        <input type="text" name="ac_when_use" class="form-control" value="<?= $obj->ac_when_use ?>" required>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">How we use the Skill</label>
                        <input type="text" name="ac_how_use" class="form-control" value="<?= $obj->ac_how_use ?>" required>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">Why we use the Skill</label>
                        <input type="text" name="ac_why_use" class="form-control" value="<?= $obj->ac_why_use ?>" required>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">My Expectations</label>
                        <input type="text" name="ac_expectations" class="form-control" value="<?= $obj->ac_expectations ?>" required>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">Date Expectation was Set</label>
                        <input type="text" name="ac_expectation_date" class="form-control select-date" value="<?= date('m/d/Y', strtotime($obj->ac_expectation_date)) ?>" required>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="asterisk-required">Comments</label>
                        <textarea name="ac_comments" rows="10" class="form-control" required><?= $obj->ac_comments ?></textarea>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group pull-right">
                        <br>
                        <input type="submit" name="save_linking" id="btn-process_submit" class="btn btn-lg btn-primary" value="UPDATE LINKING">
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@include('coaching.modal.accountability_setting')
@include('coaching.js-script')
@endsection