<link href="<?= asset('css/spectrum.css') ?>" rel="stylesheet">
<link href='<?= asset('css/fullcalendar/main.min.css') ?>' rel='stylesheet' />
<link href='<?= asset('css/fullcalendar/daygrid.min.css') ?>' rel='stylesheet' />
<link href='<?= asset('css/fullcalendar/list.min.css') ?>' rel='stylesheet' />
<link href='<?= asset('css/fullcalendar/timegrid.min.css') ?>' rel='stylesheet' />
<style type="text/css">
ol.breadcrumb li span{
    display: inline-block;
    color: #ccc;
    padding: 0 5px;
}

.panel-heading .btn{
    margin-left: 10px;
}

#events_calendar{
    width: 1000px;
    margin: 0 auto;
}

.fc-scroller {
    overflow-y: hidden !important;
}

.fc-view table{
    background: white;
}

span.event-tooltip {
    display: block;
    background: #22222266;
    border-radius: 5px;
    padding: 6px;
    position: absolute;
}

.sp-replacer{
    display: block !important;
}

.sp-preview{
    width: calc(100% - 20px);
}

.sp-picker-container{
    display: none;
}

textarea{
    min-height: 100px;
}

#table-view{
    width: 100%;
    margin: 10px;
}

#table-view tr td {
    border-bottom: 1px dashed #dadada;
    font-size: 13px;
    padding-top: 15px;
    padding-bottom: 5px;
}

#table-view tr td:nth-child(2){
    font-weight: 600;
}

.dataTables_wrapper{
    margin: 0 !important;
}

.m-0{
    margin: 0 !important;
}

.table > thead > tr > th {
    border-bottom: 1px solid rgba(0, 0, 0, 0.3) !important;
    height: auto !important;
    min-height: 20px !important;
}

.table > tbody > tr.even {
    background: #ddd !important;
}

.delete_btn i{
    color: #ff0000;
}

.tip-color{
    width: 20px;
    height: 20px;
}

.data-center .tip-color{
    margin: 0 auto;
}

.division{
    border-top: 1px solid rgba(0,0,0,.125);
    padding-top: 15px;
    margin-top: 15px;
    width: 100%;
    float: none;
}

.border-required{
    border: 2px solid #ff0000;
}

.d-none{
    display: none;
}

.form-text{
    color: #ff0000;
}

.calendar-nav{
    width: 1000px;
    margin: 30px auto 0 !important;
}
</style>