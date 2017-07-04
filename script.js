$(document).ready(function () {

    //add new field subject
    $('#id_add').click(function () {
        var html = "";
        html += "<div class='form-group row  fitem'>";
        html += "<div class='col-md-3'>";
        html += "<span class='pull-xs-right text-nowrap'></span>";
        html += "<label class='col-form-label d-inline ' for='id_txtAdd'>";
        html += "Subject name";
        html += "</label>";
        html += "</div>";
        html += "<div class='col-md-9 form-inline felement' data-fieldtype='text'>";
        html += "<input type='text' class='form-control' name='txtAdd' id='id_txtAdd' value=''>";
        html += "<div class='form-control-feedback' id='id_error_txtAdd' style='display: none;'></div></div>";

        $('#mform1').append(html);
        $(this).attr( 'disabled', true );
    });
});