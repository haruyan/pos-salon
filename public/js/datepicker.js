$(function () {
    //Textarea auto growth
    autosize($('textarea.auto-growth'));

    //Bootstrap datepicker plugin
    $('#bs_datepicker_container input').datepicker({
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        autoclose: true,
        container: '#bs_datepicker_container'
    });

    $('#bs_datepicker_component_container').datepicker({
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        autoclose: true,
        container: '#bs_datepicker_component_container'
    });

    $('#bs_datepicker_range_content').datepicker({
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        autoclose: true,
        container: '#bs_datepicker_range_content'
    });
    //
    $('#bs_datepicker_range_container').datepicker({
        autoclose: true,
        container: '#bs_datepicker_range_container'
    });
});
