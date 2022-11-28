@extends('layouts.main')
@section('title')
Linking Sessions > Quick Link > New Session
@endsection
<style>
.dataTables_wrapper{margin:0 !important;}
</style>
@section('content')
<div class="container-fluid">
    <div class="panel panel-primary">
        @include('coaching.sub_menu')
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12"><b style="color: #0000FF; font-size: 16px;">New Quick Link Session</b></div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <form id="form_quick_link">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-11">
                                <div class="mb-3">
                                    <label for="staffName" class="form-label">Staff</label>
                                    <input type="text" class="form-control" id="staffName" name="lnk_linkee_name" aria-describedby="Staff" readonly="1" value="<?= $obj['lnk_linkee_name'] ?>">
                                </div>
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-11">
                                <div class="mb-3">
                                    <label for="exampleInputDate" class="form-label">Date</label>
                                    <input type="text" class="form-control" id="exampleInputDate" aria-describedby="Coaching Date" readonly="1" value="<?= $obj['lnk_date'] ?>">
                                </div>
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-11">
                                <div class="mb-3">
                                    <label for="focus_Name" class="form-label">Focus</label>
                                    <select id="focus_Name" name="rf_focus" class="form-control select2" aria-label="Select a Focus" aria-describedby="rf_focusHelp">
                                        <option value="0" selected>Select a Focus</option>
                                        <?php
                                        foreach($obj['sel_focus'] as $ss) {
                                        ?>
                                        <option value="<?= $ss->fc_id ?>"<?= ($obj['rf_focus'] == $ss->fc_id) ? " selected" : ""?>><?= $ss->fc_desc ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <div id="rf_focusHelp" class="form-text" style="color: red; display: none;">* Focus is required and necessary.</div>
                                </div>
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-11">
                                <div class="mb-3">
                                    <label for="exampleInputDate" class="form-label">Comments</label>
                                    <textarea name="rf_comments" rows="10" class="form-control"><?= $obj['rf_comments'] ?></textarea>
                                    <div id="rf_commentsHelp" class="form-text" style="color: red; display: none;">* Comments is required and necessary.</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <br>
                                    <input type="hidden" name="lnk_linker" value="<?= $obj['lnk_linker'] ?>">
                                    <input type="hidden" name="lnk_linkee" value="<?= $obj['lnk_linkee'] ?>">
                                    <input type="hidden" name="lnk_linkee_email" value="<?= $obj['lnk_linkee_email'] ?>">
                                    <input type="hidden" name="lnk_date" value="<?= $obj['lnk_date'] ?>">
                                    <input type="hidden" name="lnk_type" value="<?= $obj['lnk_type'] ?>">
                                    <input type="hidden" name="lnk_linker_email" value="<?= $obj['lnk_linker_email'] ?>">
                                    <input type="submit" name="save_linking" id="btn-process_submit" class="btn btn-lg btn-primary" value="SAVE LINKING">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Linker</th>
                                <th>Focus</th>
                                <th>Status</th>
                                <th>View Coaching</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($obj['linkee_listing'] as $lk) {
                            ?>
                            <tr>
                                <td><?= date("F d, Y", strtotime($lk->lnk_date)) ?></td>
                                <td><?= $lk->linker ?></td>
                                <td><?= $lk->rf_focus ?></td>
                                <td><?= $lk->status ?></td>
                                <td><a href="<?= url($lk->link) ?>" class="link-primary" target="_blank">View</a> </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
function initVals() {
    var focus = <?= $obj['rf_focus'] ? 1 : 0 ?>;
    var comments = <?= $obj['rf_comments'] ? 1 : 0 ?>;
    var flag = <?= $obj['flag'] ? 1 : 0 ?>;

    if(flag && focus == 0){
        $("#rf_focusHelp").show();
    }

    if(flag && comments == 0){
        $("#rf_commentsHelp").show();
    }
}
$(function(){
    activeMenu($('#menu-linking-sessions'));

    initVals();
});
</script>
@endsection