@extends('layouts.main')
@section('title')
Linking Sessions > Getting To Know You > <?= ($obj['update']) ? "View" : "New" ?> Session
@endsection
@section('content')
<div class="container-fluid">
    <div class="panel panel-primary">
        @include('coaching.sub_menu')
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12" style="padding: 12px;"><b style="color: #0000FF; font-size: 16px;"><?= ($obj['update']) ? "VIEW/UPDATE" : "NEW" ?> Getting to Know You Session</b></div>
            </div>
            <div class="row">
                <div class="col-md-6"><!-- Left Panel -->
                    <form id="form_gtky_session" autocomplete="off">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <label for="staffName" class="form-label">Staff</label>
                                    <input type="text" class="form-control" id="staffName" name="lnk_linkee_name" aria-describedby="Staff" readonly="1" value="<?= $obj['lnk_linkee_name'] ?>">
                                </div>
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <label for="exampleInputDate" class="form-label">Date</label>
                                    <input type="text" class="form-control" id="exampleInputDate" aria-describedby="Coaching Date" readonly="1" value="<?= $obj['lnk_date'] ?>">
                                </div>
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <label for="exampleInputSkill" class="form-label">Address</label>
                                    <input type="text" name="gtk_address" class="form-control" value="<?= $obj['gtk_address'] ?>">
                                    <div id="gtk_addressHelp" class="form-text" style="color: red; display: none;">* Address is required and necessary.</div>
                                </div>
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <label for="exampleInputSeWhenUse" class="form-label">Birthday</label>
                                    <input id="Input_gtk_bday" type="text" name="gtk_bday" class="form-control" value="<?= $obj['gtk_bday'] ?>">
                                    <div id="gtk_bdayHelp" class="form-text" style="color: red; display: none;">* Birthday is required and necessary.</div>
                                </div>
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <label for="exampleInputSeHowUse" class="form-label">Birthplace</label>
                                    <input id="exampleInputSeHowUse" type="text" name="gtk_bplace" class="form-control" value="<?= $obj['gtk_bplace'] ?>">
                                    <div id="gtk_bplaceHelp" class="form-text" style="color: red; display: none;">* Birthplace is required and necessary.</div>
                                </div>
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <label for="exampleInputSeWhyUse" class="form-label">Mobile Number</label>
                                    <input id="exampleInputSeWhyUse" type="text" name="gtk_mobile" class="form-control" value="<?= $obj['gtk_mobile'] ?>">
                                    <div id="gtk_mobileHelp" class="form-text" style="color: red; display: none;">* Mobile Number is required and necessary.</div>
                                </div>
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <label for="exampleInputSeMyExpect" class="form-label">Email Address</label>
                                    <input id="exampleInputSeMyExpect" type="text" name="gtk_email" class="form-control" value="<?= $obj['gtk_email'] ?>">
                                    <div id="gtk_emailHelp" class="form-text" style="color: red; display: none;">* Email Address is required and necessary.</div>
                                </div>
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <label for="ac_expectation_date" class="form-label">Marital Status</label>
                                    <input id="ac_expectation_date" type="text" name="gtk_civil_stat" class="form-control" value="<?= $obj['gtk_civil_stat'] ?>">
                                    <div id="gtk_civil_statHelp" class="form-text" style="color: red; display: none;">* Civil Status is required and necessary.</div>
                                </div>
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <label for="exampleSEComments" class="form-label">You Most Favorite Thing to Do</label>
                                    <textarea id="exampleSEComments" name="gtk_fav_thing" rows="3" class="form-control"><?= $obj['gtk_fav_thing'] ?></textarea>
                                    <div id="gtk_fav_thingHelp" class="form-text" style="color: red; display: none;">* Favorite thing is required and necessary.</div>
                                </div>
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <label for="exampleSEComments" class="form-label">You Most Favorite Color</label>
                                    <textarea id="exampleSEComments" name="gtk_fav_color" rows="3" class="form-control"><?= $obj['gtk_fav_color'] ?></textarea>
                                    <div id="gtk_fav_colorHelp" class="form-text" style="color: red; display: none;">* Favorite color is required and necessary.</div>
                                </div>
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <label for="exampleSEComments" class="form-label">Your Most Favorite Movie</label>
                                    <textarea id="exampleSEComments" name="gtk_fav_movie" rows="3" class="form-control"><?= $obj['gtk_fav_movie'] ?></textarea>
                                    <div id="gtk_fav_movieHelp" class="form-text" style="color: red; display: none;">* Favorite color is required and necessary.</div>
                                </div>
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <label for="exampleSEComments" class="form-label">Your Most Favorite Song</label>
                                    <textarea id="exampleSEComments" name="gtk_fav_song" rows="3" class="form-control"><?= $obj['gtk_fav_song'] ?></textarea>
                                    <div id="gtk_fav_songHelp" class="form-text" style="color: red; display: none;">* Favorite song is required and necessary.</div>
                                </div>
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <label for="exampleSEComments" class="form-label">Your Most Favorite Food</label>
                                    <textarea id="exampleSEComments" name="gtk_fav_food" rows="3" class="form-control"><?= $obj['gtk_fav_food'] ?></textarea>
                                    <div id="gtk_fav_foodHelp" class="form-text" style="color: red; display: none;">* Favorite food is required and necessary.</div>
                                </div>
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <label for="exampleSEComments" class="form-label">Allergic to any Food</label>
                                    <textarea id="exampleSEComments" name="gtk_allergic_food" rows="3" class="form-control"><?= $obj['gtk_allergic_food'] ?></textarea>
                                    <div id="gtk_allergic_foodHelp" class="form-text" style="color: red; display: none;">* Allergic Food is required and necessary.</div>
                                </div>
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <label for="exampleSEComments" class="form-label">Allergic to any Medicine</label>
                                    <textarea id="exampleSEComments" name="gtk_allergic_med" rows="3" class="form-control"><?= $obj['gtk_allergic_med'] ?></textarea>
                                    <div id="gtk_allergic_medHelp" class="form-text" style="color: red; display: none;">* Allergic Medicine is required and necessary.</div>
                                </div>
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <label for="exampleSEComments" class="form-label">Learning Style</label>
                                    <textarea id="exampleSEComments" name="gtk_learn_style" rows="3" class="form-control"><?= $obj['gtk_learn_style'] ?></textarea>
                                    <div id="gtk_learn_styleHelp" class="form-text" style="color: red; display: none;">* Learning style is required and necessary.</div>
                                </div>
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <label for="exampleSEComments" class="form-label">Social Style</label>
                                    <textarea id="exampleSEComments" name="gtk_social_style" rows="3" class="form-control"><?= $obj['gtk_social_style'] ?></textarea>
                                    <div id="gtk_social_styleHelp" class="form-text" style="color: red; display: none;">* Social style is required and necessary.</div>
                                </div>
                            </div>
                        </div>
                        
                                   <div>&nbsp;</div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <label for="exampleSEComments" class="form-label">What motivates you:</label>
                                    <textarea id="exampleSEComments" name="gtk_motivation" rows="3" class="form-control"><?= $obj['gtk_motivation'] ?></textarea>
                                    <div id="gtk_motivationHelp" class="form-text" style="color: red; display: none;">* Motivation is required and necessary.</div>
                                </div>
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <label for="exampleSEComments" class="form-label">How do you want to be coached:</label>
                                    <textarea id="exampleSEComments" name="gtk_how_coached" rows="3" class="form-control"><?= $obj['gtk_how_coached'] ?></textarea>
                                    <div id="gtk_how_coachedHelp" class="form-text" style="color: red; display: none;">* Coaching style is required and necessary.</div>
                                </div>
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <label for="exampleSEComments" class="form-label">What do you consider your strengths</label>
                                    <textarea id="exampleSEComments" name="gtk_strength" rows="3" class="form-control"><?= $obj['gtk_strength'] ?></textarea>
                                    <div id="gtk_strengthHelp" class="form-text" style="color: red; display: none;">* Strength is required and necessary.</div>
                                </div>
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <label for="exampleSEComments" class="form-label">What can you do to better to improve</label>
                                    <textarea id="exampleSEComments" name="gtk_improvement" rows="3" class="form-control"><?= $obj['gtk_improvement'] ?></textarea>
                                    <div id="gtk_improvementHelp" class="form-text" style="color: red; display: none;">* Improvement is required and necessary.</div>
                                </div>
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <label for="exampleSEComments" class="form-label">Goals in Life</label>
                                    <textarea id="exampleSEComments" name="gtk_goals" rows="3" class="form-control"><?= $obj['gtk_goals'] ?></textarea>
                                    <div id="gtk_goalsHelp" class="form-text" style="color: red; display: none;">* Goals required and necessary.</div>
                                </div>
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="mb-3">
                                    <label for="exampleSEComments" class="form-label">Anything else you like to add</label>
                                    <textarea id="exampleSEComments" name="gtk_others" rows="3" class="form-control"><?= $obj['gtk_others'] ?></textarea>
                                    <div id="gtk_othersHelp" class="form-text" style="color: red; display: none;">* Others are required and necessary.</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <br>
                                    <input type="hidden" name="lnk_linker" value="<?= $obj['lnk_linker'] ?>">
                                    <input type="hidden" name="lnk_linker_email" value="<?= $obj['lnk_linker_email'] ?>">
                                    <input type="hidden" name="update" value="<?= $obj['update'] ? 1 : 0 ?>">
                                    <input type="hidden" name="gtk_com_num" value="<?= $obj['gtk_com_num'] ?>">
                                    <input type="hidden" name="gtk_emp_no" value ="<?= $obj['lnk_linkee'] ?>">
                                    <input type="hidden" name="lnk_linkee" value="<?= $obj['lnk_linkee'] ?>">
                                    <input type="hidden" name="lnk_linkee_email" value="<?= $obj['lnk_linkee_email'] ?>">
                                    <input type="hidden" name="lnk_date" value="<?= $obj['lnk_date'] ?>">
                                    <input type="hidden" name="lnk_type" value="<?= $obj['lnk_type'] ?>">

                                    <input type="submit" name="save_gtky_session" id="btn-process_submit" class="btn btn-lg btn-primary" value="SAVE GETTING TO KNOW YOU SESSION">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                <?php
                if(isset($obj['gtky_listing'])) {
                ?>
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Linker</th>
                                <th>Linkee</th>
                                <th>View GTKY</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($obj['linkee_listing'] as $lk) {
                        ?>
                            <tr>
                                <td><?= date("F d, Y", strtotime($lk->lnk_date)) ?></td>
                                <td><?= $lk->linker ?></td>
                                <td><?= $lk->ac_focus ?></td>
                                <td><?= $lk->status ?></td>
                                <td><a href="<?= url($lk->link) ?>" class="link-primary" target="_blank">View</a> </td>
                            </tr>
                        <?php    
                        }
                        ?>
                        </tbody>
                    </table>
                <?php
                }
                ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
function initVals(){
    var gtk_address     = <?= $obj['gtk_address'] ? 1 : 0 ?>;
    var gtk_bday        = <?= $obj['gtk_bday'] ? 1 : 0 ?>;
    var gtk_bplace      = <?= $obj['gtk_bplace'] ? 1 : 0 ?>;
    var gtk_mobile      = <?= $obj['gtk_mobile'] ? 1 : 0 ?>;
    var gtk_email       = <?= $obj['gtk_email'] ? 1 : 0 ?>;
    var gtk_civil_stat  = <?= $obj['gtk_civil_stat'] ? 1 : 0 ?>;
    var gtk_fav_thing   = <?= $obj['gtk_fav_thing'] ? 1 : 0 ?>;
    var gtk_fav_color   = <?= $obj['gtk_fav_color'] ? 1 : 0 ?>;
    var gtk_fav_movie   = <?= $obj['gtk_fav_movie'] ? 1 : 0 ?>;
    var gtk_fav_song   = <?= $obj['gtk_fav_song'] ? 1 : 0 ?>;
    var gtk_fav_food   = <?= $obj['gtk_fav_food'] ? 1 : 0 ?>;
    var gtk_allergic_food   = <?= $obj['gtk_allergic_food'] ? 1 : 0 ?>;
    var gtk_allergic_med   = <?= $obj['gtk_allergic_med'] ? 1 : 0 ?>;
    var gtk_learn_style   = <?= $obj['gtk_learn_style'] ? 1 : 0 ?>;
    var gtk_social_style   = <?= $obj['gtk_social_style'] ? 1 : 0 ?>;
    var gtk_motivation   = <?= $obj['gtk_motivation'] ? 1 : 0 ?>;
    var gtk_how_coached    = <?= $obj['gtk_how_coached'] ? 1 : 0 ?>;
    var gtk_strength   = <?= $obj['gtk_strength'] ? 1 : 0 ?>;
    var gtk_improvement   = <?= $obj['gtk_improvement'] ? 1 : 0 ?>;
    var gtk_goals   = <?= $obj['gtk_goals'] ? 1 : 0 ?>;
    var gtk_others   = <?= $obj['gtk_others'] ? 1 : 0 ?>;
    var flag            = <?= $obj['flag'] ? 1 : 0 ?>;

    if(flag && gtk_address == 0){
        $("#gtk_addressHelp").show();
    }

    if(flag && gtk_bday == 0){
        $("#gtk_bdayHelp").show();
    }

    if(flag && gtk_bplace == 0){
        $("#gtk_bplaceHelp").show();
    }

    if(flag && gtk_mobile == 0){
        $("#gtk_mobileHelp").show();
    }

    if(flag && gtk_email == 0){
        $("#gtk_emailHelp").show();
    }

    if(flag && gtk_civil_stat == 0){
        $("#gtk_civil_statHelp").show();
    }

    if(flag && gtk_fav_thing == 0){
        $("#gtk_fav_thingHelp").show();
    }

    if(flag &&  gtk_fav_color == 0){
        $("#gtk_fav_colorHelp").show();
    }

    if(flag && gtk_fav_movie == 0){
        $("#gtk_fav_movieHelp").show();
    }

    if(flag && gtk_fav_song == 0){
        $("#gtk_fav_songHelp").show();
    }

    if(flag &&  gtk_fav_food == 0){
        $("#gtk_fav_foodHelp").show();
    }

    if(flag && gtk_allergic_food == 0){
        $("#gtk_allergic_foodHelp").show();
    }

    if(flag && gtk_allergic_med == 0){
        $("#gtk_allergic_medHelp").show();
    }

    if(flag && gtk_learn_style == 0){
        $("#gtk_learn_styleHelp").show();
    }

    if(flag && gtk_social_style == 0){
        $("#gtk_social_styleHelp").show();
    }

    if(flag &&  gtk_motivation == 0){
        $("#gtk_motivationHelp").show();
    }

    if(flag && gtk_how_coached == 0){
        $("#gtk_how_coachedHelp").show();
    }

    if(flag && gtk_strength == 0){
        $("#gtk_strengthHelp").show();
    }

    if(flag && gtk_improvement == 0){
        $("#gtk_improvementHelp").show();
    }

    if(flag && gtk_goals == 0){
        $("#gtk_goalsHelp").show();
    }

    if(flag &&  gtk_others == 0){
        $("#gtk_othersHelp").show();
    }
}
$(function(){
    activeMenu($('#menu-linking-sessions'));

    $("#Input_gtk_bday").datepicker({
        changeMonth : true,
        changeYear  : true,
        yearRange   : "1930:<?= date("Y") ?>",
        maxDate     : 0
    });

    initVals();
});
</script>
@endsection