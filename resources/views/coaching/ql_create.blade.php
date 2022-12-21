@extends('layouts.main')
@section('title')
Linking Sessions > Quick Link > New Session
@endsection
@section('head')
<style>
@include('coaching.style');
</style>
@endsection
@section('breadcrumb')
Linking Sessions <span>/</span> Quick Link <span>></span> New Session
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <form action="<?= url('add-quick-link') ?>" method="post" autocomplete="off">
            {{ csrf_field() }}
            <input type="hidden" name="lnk_linkee" value="<?= $obj['lnk_linkee'] ?>">
            <input type="hidden" name="lnk_linkee_email" value="<?= $obj['lnk_linkee_email'] ?>">
            <input type="hidden" name="lnk_date" value="<?= $obj['lnk_date'] ?>">
            <div class="panel panel-primary m-0">
                @include('coaching.sub_menu')
                <div class="panel-body">
                    <div class="row d-flex">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Linker</label>
                                <input type="text" class="form-control" name="lnk_linker_name" value="<?= Auth::user()->fullName2() ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Linkee</label>
                                <input type="text" class="form-control" name="lnk_linkee_name" value="<?= $obj['lnk_linkee_name'] ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Date</label>
                                <input type="text" class="form-control" value="<?= $obj['lnk_date'] ?>" readonly>
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
                                    foreach($obj['sel_focus'] as $ss) {
                                    ?>
                                    <option value="<?= $ss->fc_id ?>"><?= $ss->fc_desc ?></option>
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
                                <textarea name="rf_comments" rows="10" class="form-control" required></textarea>
                                <div class="form-text d-none"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group pull-right">
                                <br>
                                <input type="submit" name="save_linking" id="btn-process_submit" class="btn btn-lg btn-primary" value="SAVE LINKING">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@include('coaching.modal.quick_link')
@include('coaching.js-script')
@endsection