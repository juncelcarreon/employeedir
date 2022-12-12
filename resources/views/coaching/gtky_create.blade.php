@extends('layouts.main')
@section('title')
Linking Sessions > Getting To Know You > New Session
@endsection
@section('breadcrumb')
Linking Sessions <span>/</span>; Getting To Know You <span>></span> New Session
@endsection
@section('content')
<style>
@include('coaching.style');
</style>
<form action="<?= url('add-gtky') ?>" method="post" autocomplete="off">
    {{ csrf_field() }}
    <input type="hidden" name="lnk_linkee" value="<?= $obj['lnk_linkee'] ?>">
    <input type="hidden" name="lnk_linkee_email" value="<?= $obj['lnk_linkee_email'] ?>">
    <input type="hidden" name="lnk_date" value="<?= $obj['lnk_date'] ?>">
    <div class="panel panel-primary">
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
            Getting to Know You Session

            <a id="btn-history" class="btn btn-warning pull-right" href="#" data-toggle="modal" data-target="#modal-history"><i class="fa fa-history"></i> History</a>
        </div>
        <div class="panel-body">
            <div class="row d-flex">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">Address</label>
                        <input type="text" name="gtk_address" class="form-control" required>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">Birthday</label>
                        <input type="text" name="gtk_bday" class="form-control select-date" required>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">Birthplace</label>
                        <input type="text" name="gtk_bplace" class="form-control" required>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">Mobile Number</label>
                        <input type="text" name="gtk_mobile" class="form-control" required>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">Email Address</label>
                        <input type="email" name="gtk_email" class="form-control" required>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">Marital Status</label>
                        <input type="text" name="gtk_civil_stat" class="form-control" required>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">You Most Favorite Thing to Do</label>
                        <textarea name="gtk_fav_thing" rows="3" class="form-control" required></textarea>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">You Most Favorite Color</label>
                        <textarea name="gtk_fav_color" rows="3" class="form-control" required></textarea>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">Your Most Favorite Movie</label>
                        <textarea name="gtk_fav_movie" rows="3" class="form-control" required></textarea>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">Your Most Favorite Song</label>
                        <textarea name="gtk_fav_song" rows="3" class="form-control" required></textarea>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">Your Most Favorite Food</label>
                        <textarea name="gtk_fav_food" rows="3" class="form-control" required></textarea>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">Allergic to any Food</label>
                        <textarea name="gtk_allergic_food" rows="3" class="form-control" required></textarea>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">Allergic to any Medicine</label>
                        <textarea name="gtk_allergic_med" rows="3" class="form-control" required></textarea>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">Learning Style</label>
                        <textarea name="gtk_learn_style" rows="3" class="form-control" required></textarea>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">Social Style</label>
                        <textarea name="gtk_social_style" rows="3" class="form-control" required></textarea>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">What motivates you:</label>
                        <textarea name="gtk_motivation" rows="3" class="form-control" required></textarea>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">How do you want to be coached:</label>
                        <textarea name="gtk_how_coached" rows="3" class="form-control" required></textarea>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">What do you consider your strengths</label>
                        <textarea name="gtk_strength" rows="3" class="form-control" required></textarea>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">What can you do to better to improve</label>
                        <textarea name="gtk_improvement" rows="3" class="form-control" required></textarea>
                        <div class="form-text d-none"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="asterisk-required">Goals in Life</label>
                        <textarea name="gtk_goals" rows="3" class="form-control" required></textarea>
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
@include('coaching.modal.getting_to_know_you')
@include('coaching.js-script')
@endsection