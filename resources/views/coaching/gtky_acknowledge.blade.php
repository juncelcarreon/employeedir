@extends('layouts.main')
@section('title')
Linking Sessions > Getting To Know You > Acknowledge Session
@endsection
@section('breadcrumb')
Linking Sessions > Getting To Know You > Acknowledge Session
@endsection
@section('content')
<style>
@include('coaching.style');
</style>
<form action="<?= url('acknowledged-gtky') ?>" method="post" autocomplete="off">
    {{ csrf_field() }}
    <input type="hidden" name="gtk_link_id" value="<?= $obj->gtk_link_id ?>">
    <input type="hidden" name="gtk_com_num" value="<?= $obj->gtk_com_num ?>">
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
                        <input type="text" class="form-control" name="lnk_linkee_name" value="<?= Auth::user()->fullName2() ?>" readonly>
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
            Getting to Know You Session
        </div>
        <div class="panel-body">
            <div class="row d-flex">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="gtk_address" class="form-control" value="<?= $obj->gtk_address ?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Birthday</label>
                        <input type="text" name="gtk_bday" class="form-control select-date" value="<?= date('m/d/Y', strtotime($obj->gtk_bday)) ?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Birthplace</label>
                        <input type="text" name="gtk_bplace" class="form-control" value="<?= $obj->gtk_bplace ?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Mobile Number</label>
                        <input type="text" name="gtk_mobile" class="form-control" value="<?= $obj->gtk_mobile ?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="gtk_email" class="form-control" value="<?= $obj->gtk_email ?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Marital Status</label>
                        <input type="text" name="gtk_civil_stat" class="form-control" value="<?= $obj->gtk_civil_stat ?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>You Most Favorite Thing to Do</label>
                        <textarea name="gtk_fav_thing" rows="3" class="form-control" readonly><?= $obj->gtk_fav_thing ?></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>You Most Favorite Color</label>
                        <textarea name="gtk_fav_color" rows="3" class="form-control" readonly><?= $obj->gtk_fav_color ?></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Your Most Favorite Movie</label>
                        <textarea name="gtk_fav_movie" rows="3" class="form-control" readonly><?= $obj->gtk_fav_movie ?></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Your Most Favorite Song</label>
                        <textarea name="gtk_fav_song" rows="3" class="form-control" readonly><?= $obj->gtk_fav_song ?></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Your Most Favorite Food</label>
                        <textarea name="gtk_fav_food" rows="3" class="form-control" readonly><?= $obj->gtk_fav_food ?></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Allergic to any Food</label>
                        <textarea name="gtk_allergic_food" rows="3" class="form-control" readonly><?= $obj->gtk_allergic_food ?></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Allergic to any Medicine</label>
                        <textarea name="gtk_allergic_med" rows="3" class="form-control" readonly><?= $obj->gtk_allergic_med ?></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Learning Style</label>
                        <textarea name="gtk_learn_style" rows="3" class="form-control" readonly><?= $obj->gtk_learn_style ?></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Social Style</label>
                        <textarea name="gtk_social_style" rows="3" class="form-control" readonly><?= $obj->gtk_social_style ?></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>What motivates you:</label>
                        <textarea name="gtk_motivation" rows="3" class="form-control" readonly><?= $obj->gtk_motivation ?></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>How do you want to be coached:</label>
                        <textarea name="gtk_how_coached" rows="3" class="form-control" readonly><?= $obj->gtk_how_coached ?></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>What do you consider your strengths</label>
                        <textarea name="gtk_strength" rows="3" class="form-control" readonly><?= $obj->gtk_strength ?></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>What can you do to better to improve</label>
                        <textarea name="gtk_improvement" rows="3" class="form-control" readonly><?= $obj->gtk_improvement ?></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Goals in Life</label>
                        <textarea name="gtk_goals" rows="3" class="form-control" readonly><?= $obj->gtk_goals ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="asterisk-required">Anything else you like to add</label>
                        <textarea name="gtk_others" rows="5" class="form-control" required><?= $obj->gtk_others ?></textarea>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group pull-right">
                        <br>
                        <input type="submit" name="save_linking" id="btn-process_submit" class="btn btn-lg btn-primary" value="ACKNOWLEDGE LINKING">
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@include('coaching.js-script')
@endsection