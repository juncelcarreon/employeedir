@extends('layouts.main')
@section('title')
Linking Sessions > Skill Building > Edit Session
@endsection
@section('breadcrumb')
Linking Sessions <span>/</span> Skill Building <span>></span> Edit Session
@endsection
@section('content')
<style>
@include('coaching.style');
</style>
<form action="<?= url('update-skill-building') ?>" method="post" autocomplete="off">
    {{ csrf_field() }}
    <input type="hidden" name="sb_com_num" value="<?= $obj->sb_com_num ?>">
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
            Skill Building Session

            <a id="btn-history" class="btn btn-warning pull-right" href="#" data-toggle="modal" data-target="#modal-history"><i class="fa fa-history"></i> History</a>
        </div>
        <div class="panel-body">
            <div class="row d-flex">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">Focus</label>
                        <select name="sb_focus" class="form-control select2" required>
                            <option value="0" disabled selected>Select a Focus</option>
                            <?php
                            foreach($sel_focus as $ss) {
                            ?>
                            <option value="<?= $ss->fc_id ?>"<?= ($obj->sb_focus == $ss->fc_id) ? " selected" : ""?>><?= $ss->fc_desc ?></option>
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
                        <input type="text" name="sb_skill" class="form-control" value="<?= $obj->sb_skill ?>" required>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">When we use the Skill</label>
                        <input type="text" name="sb_when_skill" class="form-control" value="<?= $obj->sb_when_skill ?>" required>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">How we use the Skill</label>
                        <input type="text" name="sb_how_skill" class="form-control" value="<?= $obj->sb_how_skill ?>" required>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">Why we use the Skill</label>
                        <input type="text" name="sb_why_skill" class="form-control" value="<?= $obj->sb_why_skill ?>" required>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">Timeframe for Quick Link</label>
                        <input type="text" name="sb_timeframe" class="form-control" value="<?= $obj->sb_timeframe ?>" required>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="asterisk-required">Takeaways from activity</label>
                        <textarea name="sb_takeaway" rows="10" class="form-control" required><?= $obj->sb_timeframe ?></textarea>
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
@include('coaching.modal.skill_building')
@include('coaching.js-script')
@endsection