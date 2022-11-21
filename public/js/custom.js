$('#calendar').datepicker({});

!function ($) {
  $(document).on("click","ul.nav li.parent > a ", function(){
    $(this).find('em').toggleClass("fa-minus");
  });
  $(".sidebar span.icon").find('em:first').addClass("fa-plus");
}

(window.jQuery);
$(window).on('resize', function () {
  if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
});
$(window).on('resize', function () {
  if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
});

$(document).on('click', '#toggle-sidebar',function(e){
  if ($('#sidebar-collapse:visible').length){
    hideSidebar()
  }else{
    showSidebar()
  }
})

$(document).on('click', '.panel-heading span.clickable', function(e){
  var $this = $(this);
	if(!$this.hasClass('panel-collapsed')) {
		$this.parents('.panel').find('.panel-body').slideUp();
		$this.addClass('panel-collapsed');
		$this.find('em').removeClass('fa-toggle-up').addClass('fa-toggle-down');
	} else {
		$this.parents('.panel').find('.panel-body').slideDown();
		$this.removeClass('panel-collapsed');
		$this.find('em').removeClass('fa-toggle-down').addClass('fa-toggle-up');
	}
})

$(document).ready(function () {
  $('.table').DataTable();
	$('.datepicker').datepicker();
	$('.select2').select2();
	$('.select2').on('change', function() {
    $(this).trigger('blur');
  });
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
});

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#profile_image').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}
$("#image_uploader").change(function() {
  readURL(this);
});

function joinGrammar(prod_date){
  var prod_date_timestamp = new Date(prod_date).getTime();
  var current_timestamp = Date.now();

  if(prod_date_timestamp > current_timestamp){
    return "Will join";
  }
  return "Joined";
}
function timeConverter(prod_date){
  var a = new Date(prod_date);
  var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
  var year = a.getFullYear();
  var month = months[a.getMonth()];
  var date = a.getDate();
  var hour = a.getHours();
  var min = a.getMinutes();
  var sec = a.getSeconds();
  var time =  month + ' ' + date + ', ' + year;
  return time;
}
function timeConverter2(prod_date){
  var a = new Date(prod_date);
  var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
  var year = a.getFullYear();
  var month = months[a.getMonth()];
  var date = a.getDate();
  var hour = a.getHours();
  var min = a.getMinutes();
  var sec = a.getSeconds();
  var time =  month + ' ' + date;
  return time;
}

function showSidebar(){
  $('.navbar-brand').show();
  $('#sidebar-collapse').show(100);
  $('#main-container').removeClass().addClass('col-sm-10 col-sm-offset-2');
}

function hideSidebar(){
  $('.navbar-brand').hide(100);
  $('#sidebar-collapse').hide('fade');
  $('#main-container').removeClass().addClass('col-sm-12 col-sm-offset-0');
}

function activeMenu(menu){
  menu.closest('li').addClass('active');
  if(menu.hasClass('menu-child-item')) {
      menu.closest('ul.menu-child').show();
      menu.closest('ul.menu-child').closest('li').addClass('menu-open');
      menu.closest('ul.menu-child').closest('li').find('.menu-has-child').attr('data-key', 'open');
  }
}

function checkRequired(form){
  var result = true;
  form.find('input[required], textarea[required], select[required]').each(function(e) {
      if($(this).hasClass('select2')) {
        if($(this).val() === null){
            $(this).focus();
            $(this).closest('.form-group').find('.select2-container').css({'border':'1px solid #ff0000'});

            result = false;

            return false;
        }
      } else {
        if($(this).val() == ''){
            $(this).focus();
            $(this).css({'border':'1px solid #ff0000'});

            result = false;

            return false;
        }
        $(this).removeAttr('style');
      }
  });
  return result;
}

function saveForm(obj){
  $('body').css({'pointer-events':'none'});
  obj.attr('disabled', true);
  if(obj.is('button')) {
    obj.text('Please wait');
  } else {
    obj.val('Please wait');
  }
  obj.closest('form').submit();
}

$('.menu-has-child').click(function(e) {
  e.preventDefault();

  var obj = $(this),
      main = obj.closest('li');

  $('#sidebar-collapse .nav .menu-open').each(function(key) {
    if($(this).find('.menu-has-child').attr('id') != obj.attr('id')) {
      $(this).removeClass('menu-open');
      $(this).find('.menu-has-child').attr('data-key', 'close');
      $(this).find('.menu-child').hide(200);
    }
  })

  if(obj.attr('data-key') == 'open') {
    obj.attr('data-key', 'close');
    main.removeClass('menu-open');
    main.find('ul.menu-child').hide(200);
  } else {
    obj.attr('data-key', 'open');
    main.addClass('menu-open');
    main.find('ul.menu-child').show(200);
  }
});

$('.btn_submit').click(function(e) {
    e.preventDefault();

    if(checkRequired($(this).closest('form'))) {
      saveForm($(this));
    }
});