@extends('layouts.main')
@section('title')
Linking Sessions > Goal Setting > New Session
@endsection
@section('head')
<style>
@include('coaching.style');
</style>
@endsection
@section('breadcrumb')
Linking Sessions <span>/</span> Goal Setting <span>></span> New Session
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <form action="<?= url('add-goal-setting') ?>" method="post" autocomplete="off">
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
                    Goal Setting Session

                    <a id="btn-history" class="btn btn-warning pull-right" href="#" data-toggle="modal" data-target="#modal-history"><i class="fa fa-history"></i>&nbsp; History</a>
                </div>
                <div class="panel-body">
                    <div class="row d-flex">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="asterisk-required">Accomplishments</label>
                                <input type="text" name="gs_accmpl" class="form-control" required>
                                <div class="form-text d-none"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <table class="table-metric table-bordered table-striped">
                                    <tr>
                                        <th>Num</th>
                                        <th>Metric</th>
                                        <th>Target</th>
                                        <th>Prev Month</th>
                                        <th>Cur Month</th>
                                    </tr>
                                    <tr>
                                        <td><strong>1</strong></td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="gs_metric_01" class="form-control" required>
                                                <div class="form-text d-none"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="gs_target_01" class="form-control" required>
                                                <div class="form-text d-none"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="gs_prev_01" class="form-control" required>
                                                <div class="form-text d-none"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="gs_curr_01" class="form-control" required>
                                                <div class="form-text d-none"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>2</strong></td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="gs_metric_02" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="gs_target_02" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="gs_prev_02" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="gs_curr_02" class="form-control">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>3</strong></td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="gs_metric_03" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="gs_target_03" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="gs_prev_03" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="gs_curr_03" class="form-control">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>4</strong></td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="gs_metric_04" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="gs_target_04" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="gs_prev_04" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="gs_curr_04" class="form-control">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>5</strong></td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="gs_metric_05" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="gs_target_05" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="gs_prev_05" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="gs_curr_05" class="form-control">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>6</strong></td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="gs_metric_06" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="gs_target_06" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="gs_prev_06" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="gs_curr_06" class="form-control">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>7</strong></td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="gs_metric_07" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="gs_target_07" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="gs_prev_07" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="gs_curr_07" class="form-control">
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="asterisk-required">Tip for the Month</label>
                                <textarea name="gs_tip" rows="5" class="form-control" required></textarea>
                                <div class="form-text d-none"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="asterisk-required">Commitment</label>
                                <textarea name="gs_com" rows="5" class="form-control" required></textarea>
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
@endsection
@section('scripts')
@include('coaching.js-script')
@include('coaching.modal.goal_setting')
@endsection