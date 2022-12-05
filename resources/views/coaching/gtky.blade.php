@extends('layouts.main')
@section('title')
Linking Sessions > Getting To Know You > <?= ($obj['update']) ? "View" : "New" ?> Session
@endsection
@section('content')
<style>
.panel-subheading{
    background: #5bc0de !important;
    font-size: 12px;
}
.d-flex{
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
}
</style>
<form id="form_gtky_session" autocomplete="off">
    <input type="hidden" name="lnk_linker" value="<?= $obj['lnk_linker'] ?>">
    <input type="hidden" name="lnk_linker_email" value="<?= $obj['lnk_linker_email'] ?>">
    <input type="hidden" name="update" value="<?= $obj['update'] ? 1 : 0 ?>">
    <input type="hidden" name="gtk_com_num" value="<?= $obj['gtk_com_num'] ?>">
    <input type="hidden" name="gtk_emp_no" value ="<?= $obj['lnk_linkee'] ?>">
    <input type="hidden" name="lnk_linkee" value="<?= $obj['lnk_linkee'] ?>">
    <input type="hidden" name="lnk_linkee_email" value="<?= $obj['lnk_linkee_email'] ?>">
    <input type="hidden" name="lnk_date" value="<?= $obj['lnk_date'] ?>">
    <input type="hidden" name="lnk_type" value="<?= $obj['lnk_type'] ?>">
    <div class="panel panel-primary">
        @include('coaching.sub_menu')
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="linkerName" class="form-label">Linker</label>
                        <input type="text" class="form-control" id="linkerName" name="lnk_linker_name" aria-describedby="Staff" readonly="1" value="<?= Auth::user()->fullName2() ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="staffName" class="form-label">Linkee</label>
                        <input type="text" class="form-control" id="staffName" name="lnk_linkee_name" aria-describedby="Staff" readonly="1" value="<?= $obj['lnk_linkee_name'] ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputDate" class="form-label">Date</label>
                        <input type="text" class="form-control" id="exampleInputDate" aria-describedby="Coaching Date" readonly="1" value="<?= $obj['lnk_date'] ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-heading panel-subheading">
            Getting to Know You Session
        </div>
        <div class="panel-body">
            <div class="row d-flex">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputSkill" class="form-label asterisk-required">Address</label>
                        <input type="text" name="gtk_address" class="form-control" value="<?= $obj['gtk_address'] ?>" required>
                        <div id="gtk_addressHelp" class="form-text" style="color: red; display: none;">* Address is required and necessary.</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputSeWhenUse" class="form-label asterisk-required">Birthday</label>
                        <input id="Input_gtk_bday" type="text" name="gtk_bday" class="form-control" value="<?= $obj['gtk_bday'] ?>" required>
                        <div id="gtk_bdayHelp" class="form-text" style="color: red; display: none;">* Birthday is required and necessary.</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputSeHowUse" class="form-label asterisk-required">Birthplace</label>
                        <input id="exampleInputSeHowUse" type="text" name="gtk_bplace" class="form-control" value="<?= $obj['gtk_bplace'] ?>" required>
                        <div id="gtk_bplaceHelp" class="form-text" style="color: red; display: none;">* Birthplace is required and necessary.</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputSeWhyUse" class="form-label asterisk-required">Mobile Number</label>
                        <input id="exampleInputSeWhyUse" type="text" name="gtk_mobile" class="form-control" value="<?= $obj['gtk_mobile'] ?>" required>
                        <div id="gtk_mobileHelp" class="form-text" style="color: red; display: none;">* Mobile Number is required and necessary.</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleInputSeMyExpect" class="form-label asterisk-required">Email Address</label>
                        <input id="exampleInputSeMyExpect" type="email" name="gtk_email" class="form-control" value="<?= $obj['gtk_email'] ?>" required>
                        <div id="gtk_emailHelp" class="form-text" style="color: red; display: none;">* Email Address is required and necessary.</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="ac_expectation_date" class="form-label asterisk-required">Marital Status</label>
                        <input id="ac_expectation_date" type="text" name="gtk_civil_stat" class="form-control" value="<?= $obj['gtk_civil_stat'] ?>" required>
                        <div id="gtk_civil_statHelp" class="form-text" style="color: red; display: none;">* Civil Status is required and necessary.</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleSEComments" class="form-label asterisk-required">You Most Favorite Thing to Do</label>
                        <textarea id="exampleSEComments" name="gtk_fav_thing" rows="3" class="form-control" required><?= $obj['gtk_fav_thing'] ?></textarea>
                        <div id="gtk_fav_thingHelp" class="form-text" style="color: red; display: none;">* Favorite thing is required and necessary.</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleSEComments" class="form-label asterisk-required">You Most Favorite Color</label>
                        <textarea id="exampleSEComments" name="gtk_fav_color" rows="3" class="form-control" required><?= $obj['gtk_fav_color'] ?></textarea>
                        <div id="gtk_fav_colorHelp" class="form-text" style="color: red; display: none;">* Favorite color is required and necessary.</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleSEComments" class="form-label asterisk-required">Your Most Favorite Movie</label>
                        <textarea id="exampleSEComments" name="gtk_fav_movie" rows="3" class="form-control" required><?= $obj['gtk_fav_movie'] ?></textarea>
                        <div id="gtk_fav_movieHelp" class="form-text" style="color: red; display: none;">* Favorite color is required and necessary.</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleSEComments" class="form-label asterisk-required">Your Most Favorite Song</label>
                        <textarea id="exampleSEComments" name="gtk_fav_song" rows="3" class="form-control" required><?= $obj['gtk_fav_song'] ?></textarea>
                        <div id="gtk_fav_songHelp" class="form-text" style="color: red; display: none;">* Favorite song is required and necessary.</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleSEComments" class="form-label asterisk-required">Your Most Favorite Food</label>
                        <textarea id="exampleSEComments" name="gtk_fav_food" rows="3" class="form-control" required><?= $obj['gtk_fav_food'] ?></textarea>
                        <div id="gtk_fav_foodHelp" class="form-text" style="color: red; display: none;">* Favorite food is required and necessary.</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleSEComments" class="form-label asterisk-required">Allergic to any Food</label>
                        <textarea id="exampleSEComments" name="gtk_allergic_food" rows="3" class="form-control" required><?= $obj['gtk_allergic_food'] ?></textarea>
                        <div id="gtk_allergic_foodHelp" class="form-text" style="color: red; display: none;">* Allergic Food is required and necessary.</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleSEComments" class="form-label asterisk-required">Allergic to any Medicine</label>
                        <textarea id="exampleSEComments" name="gtk_allergic_med" rows="3" class="form-control" required><?= $obj['gtk_allergic_med'] ?></textarea>
                        <div id="gtk_allergic_medHelp" class="form-text" style="color: red; display: none;">* Allergic Medicine is required and necessary.</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleSEComments" class="form-label asterisk-required">Learning Style</label>
                        <textarea id="exampleSEComments" name="gtk_learn_style" rows="3" class="form-control" required><?= $obj['gtk_learn_style'] ?></textarea>
                        <div id="gtk_learn_styleHelp" class="form-text" style="color: red; display: none;">* Learning style is required and necessary.</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleSEComments" class="form-label asterisk-required">Social Style</label>
                        <textarea id="exampleSEComments" name="gtk_social_style" rows="3" class="form-control" required><?= $obj['gtk_social_style'] ?></textarea>
                        <div id="gtk_social_styleHelp" class="form-text" style="color: red; display: none;">* Social style is required and necessary.</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleSEComments" class="form-label asterisk-required">What motivates you:</label>
                        <textarea id="exampleSEComments" name="gtk_motivation" rows="3" class="form-control" required><?= $obj['gtk_motivation'] ?></textarea>
                        <div id="gtk_motivationHelp" class="form-text" style="color: red; display: none;">* Motivation is required and necessary.</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleSEComments" class="form-label asterisk-required">How do you want to be coached:</label>
                        <textarea id="exampleSEComments" name="gtk_how_coached" rows="3" class="form-control" required><?= $obj['gtk_how_coached'] ?></textarea>
                        <div id="gtk_how_coachedHelp" class="form-text" style="color: red; display: none;">* Coaching style is required and necessary.</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleSEComments" class="form-label asterisk-required">What do you consider your strengths</label>
                        <textarea id="exampleSEComments" name="gtk_strength" rows="3" class="form-control" required><?= $obj['gtk_strength'] ?></textarea>
                        <div id="gtk_strengthHelp" class="form-text" style="color: red; display: none;">* Strength is required and necessary.</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleSEComments" class="form-label asterisk-required">What can you do to better to improve</label>
                        <textarea id="exampleSEComments" name="gtk_improvement" rows="3" class="form-control" required><?= $obj['gtk_improvement'] ?></textarea>
                        <div id="gtk_improvementHelp" class="form-text" style="color: red; display: none;">* Improvement is required and necessary.</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleSEComments" class="form-label asterisk-required">Goals in Life</label>
                        <textarea id="exampleSEComments" name="gtk_goals" rows="3" class="form-control" required><?= $obj['gtk_goals'] ?></textarea>
                        <div id="gtk_goalsHelp" class="form-text" style="color: red; display: none;">* Goals required and necessary.</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="exampleSEComments" class="form-label asterisk-required">Anything else you like to add</label>
                        <textarea id="exampleSEComments" name="gtk_others" rows="3" class="form-control" required><?= $obj['gtk_others'] ?></textarea>
                        <div id="gtk_othersHelp" class="form-text" style="color: red; display: none;">* Others are required and necessary.</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group pull-right">
                        <br>
                        <input type="submit" name="save_gtky_session" id="btn-process_submit" class="btn btn-lg btn-primary" value="SAVE GETTING TO KNOW YOU SESSION">
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
function requiredFields(form){
  var result = true;
  form.find('input[required], textarea[required], select[required]').each(function(e) {
      if($(this).hasClass('select2')) {
        if($(this).val() === null){
            $(this).focus();
            $(this).closest('.form-group').find('.select2-container').css({'border':'1px solid #ff0000'});
            $(this).closest('.form-group').find('.form-text').show();

            result = false;

            return false;
        }
      } else {
        if($(this).val() == ''){
            $(this).focus();
            $(this).css({'border':'1px solid #ff0000'});
            $(this).closest('.form-group').find('.form-text').show();

            result = false;

            return false;
        }
        $(this).removeAttr('style');
        $(this).closest('.form-group').find('.form-text').hide();
      }
  });
  return result;
}
$(function(){
    activeMenu($('#menu-linking-sessions'));

    $("#Input_gtk_bday").datetimepicker({
        format: 'MM/DD/YYYY',
        useCurrent: false
    });

    $('#btn-process_submit').click(function(e) {
        e.preventDefault();

        if(requiredFields($(this).closest('form'))) {
          saveForm($(this));
        }
    });
});
</script>
@endsection