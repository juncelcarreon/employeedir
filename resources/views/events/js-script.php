@section('scripts')
<script src='<?= asset('js/spectrum.js') ?>'></script>
<script src='<?= asset('js/fullcalendar/main.min.js') ?>'></script>
<script src='<?= asset('js/fullcalendar/list.min.js') ?>'></script>
<script src='<?= asset('js/fullcalendar/daygrid.min.js') ?>'></script>
<script src='<?= asset('js/fullcalendar/timegrid.min.js') ?>'></script>
<script src='<?= asset('js/fullcalendar/interaction.min.js') ?>'></script>
<script>
let events = [];
if($('#events_calendar').length > 0) {
    document.addEventListener('DOMContentLoaded', function() {
        $.get("<?= url('events/lists') ?>", function(data){

            for(let i=0; i < data.length ; i++){
                events.push({id: data[i].id, title: data[i].event_name, start: data[i].start_date, end: data[i].end_date, color: data[i].event_color, url: "<?= url('events') ?>" + "/" + data[i].id });
            }

            let calendarEl = document.getElementById('events_calendar');

            let calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
                defaultView: 'dayGridMonth',
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,listMonth'
                },
                events: events
            });

            calendar.render();
        });
    });
}
function saveForm(obj){
    $('body').css({'pointer-events':'none'});
    obj.attr('disabled', true);
    obj.text('Please wait');
    obj.closest('form').submit();
}
function requiredFields(form){
    var result = true;
    form.find('input[required], textarea[required], select[required]').each(function(e) {
        var label = $(this).closest('.form-group').find('label').text();
        if($(this).val() == ''){
            $(this).focus();
            $(this).addClass('border-required');
            $(this).closest('.form-group').find('.form-text').text('* '+label+' is required.').removeClass('d-none');

            result = false;

            return false;
        }

        $(this).removeClass('border-required');
        $(this).closest('.form-group').find('.form-text').addClass('d-none');
    });
    return result;
}
$(function() {
    var pallettes = [
        ["#ffffff", "#000000", "#efefe7", "#184a7b", "#4a84bd", "#c6524a", "#9cbd5a", "#8463a5", "#4aadc6", "#f79442"],
        ["#f7f7f7", "#7b7b7b", "#dedec6", "#c6def7", "#dee7f7", "#f7dede", "#eff7de", "#e7e7ef", "#deeff7", "#ffefde"],
        ["#dedede", "#5a5a5a", "#c6bd94", "#8cb5e7", "#bdcee7", "#e7bdb5", "#d6e7bd", "#cec6de", "#b5deef", "#ffd6b5"],
        ["#bdbdbd", "#393939", "#948c52", "#528cd6", "#94b5d6", "#de9494", "#c6d69c", "#b5a5c6", "#94cede", "#ffc68c"],
        ["#a5a5a5", "#212121", "#4a4229", "#10315a", "#316394", "#943131", "#739439", "#5a4a7b", "#31849c", "#e76b08"],
        ["#848484", "#080808", "#181810", "#082139", "#214263", "#632121", "#4a6329", "#393152", "#215a63", "#944a00"],
        ["#c60000", "#ff0000", "#ffc600", "#ffff00", "#94d652", "#00b552", "#00b5f7", "#0073c6", "#002163", "#7331a5"],
    ];

    activeMenu($('#menu-events'));

    $('.delete_btn').click(function(){
        $('#messageModal .modal-title').html('Delete Event');
        $('#messageModal #message').html('Are you sure you want to delete the activity ?');
        $('#messageModal .delete_form').attr('action', "<?= url('events') ?>/" + $(this).attr("data-id"));
    });

    $('#messageModal #yes').click(function(){
        $('#messageModal .delete_form').submit();
    });

    $('.datetimepicker').datetimepicker({ useCurrent: false });

    $("#start_date").on("dp.change", function (e) {
        $('#end_date').data("DateTimePicker").minDate(e.date);
    });

    $("#end_date").on("dp.change", function (e) {
        $('#start_date').data("DateTimePicker").maxDate(e.date);
    });

    $("#event_color").spectrum({
        hideAfterPaletteSelect:true,
        showPalette: true,
        showSelectionPalette: true,
        palette: pallettes
    });

    $("#event_color").show();

    $("#event_color").attr('type', 'hidden');

    $('.btn-submit').click(function(e) {
        e.preventDefault();

        if(requiredFields($(this).closest('form'))) {
          saveForm($(this));
        }
    });
});
</script>
@endsection