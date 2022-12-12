@extends('layouts.main')
@section('title')
Linking Sessions > Quick Link > Edit Session
@endsection
@section('breadcrumb')
Linking Sessions <span>/</span> Quick Link <span>></span> Edit Session
@endsection
@section('content')
<style>
@include('coaching.style');
</style>
<form action="<?= url('update-quick-link') ?>" method="post" autocomplete="off">
    {{ csrf_field() }}
    <input type="hidden" name="rf_lnk_id" value="<?= $obj->rf_lnk_id ?>">
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
            Quick Link Session

            <a id="btn-history" class="btn btn-warning pull-right" href="#" data-toggle="modal" data-target="#modal-history"><i class="fa fa-history"></i> History</a>
        </div>
        <div class="panel-body">
            <div class="row d-flex">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="asterisk-required">Focus</label>
                        <select name="rf_focus" class="form-control select2" required>
                            <option value="0" disabled selected>Select a Focus</option>
                            <?php
                            foreach($sel_focus as $ss) {
                            ?>
                            <option value="<?= $ss->fc_id ?>"<?= ($obj->rf_focus == $ss->fc_id) ? " selected" : ""?>><?= $ss->fc_desc ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="asterisk-required">Comments</label>
                        <textarea name="rf_comments" rows="10" class="form-control" required><?= $obj->rf_comments ?></textarea>
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
@include('coaching.modal.quick_link')
@include('coaching.js-script')
@endsection