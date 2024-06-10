/**date picker**/
$(function () {  
            from = $("#dob")
            .datepicker({
                dateFormat: 'dd-mm-yy',
                minDate: 0,
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 2
            })
});
$(function () {
            from = $("#joidate")
            .datepicker({   
                dateFormat: 'dd-mm-yy',
                minDate: 0,
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 2
            })
});
$(function () {
            from = $("#theraphydate")
            .datepicker({       
                dateFormat: 'dd-mm-yy',
                minDate: 0,
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 2
            })
});
/**date picker**/
/**data table**/
$(document).ready(function () {
    $('#example4').DataTable();
});
/**data table**/
/**validation engine**/
$(document).ready(function () {
    // binds form submission and fields to the validation engine
    $('.validation_form').validationEngine('validate');
});
$(document).ready(function () {
    "use strict";
    // HTML5 WYSIWYG Editor
    //jQuery('textarea').wysihtml5({color: true, html: true});
    jQuery('.validation_form').validationEngine({validateNonVisibleFields: false,
        updatePromptsPosition: true});
});
/** validation engine**/
/**tool tip**/

$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

/** tool tip**/
/**delete **/
$(document).on('click', '.delete', function (e) {
    var form = $(this);
    e.preventDefault();
    swal({
        title: "Are you sure?",
        text: "Are you sure want to delete?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Yes, I am sure!',
        cancelButtonText: "No, cancel it!",
        closeOnConfirm: false,
        closeOnCancel: true,
    },
            function (isConfirm) {
                if (isConfirm) {
                    window.location.href = form.attr('href');
                }
            });
});
/**delete **/
/*csv,excel,pdf*/
$(document).ready(function() {
    $('#tableExport').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            //'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    } );
} );






