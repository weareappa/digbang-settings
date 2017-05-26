@extends('backoffice::edit')

@section('head.stylesheets')
    <style>
        .form-group.form-datetime {
            padding: 0;
        }
        .bootstrap-timepicker {
            position: static;
        }
    </style>
@stop

@section('body.javascripts')
    <script type='text/javascript'>
        (function ($) {
            'use strict';

            $(document).ready(function () {
                $('.array-setting').each(function () {
                    $(this).select2({
                        closeOnSelect: true,
                        width: "resolve",
                        allowClear: true,
                        tags: $(this).val().split(',')
                    });
                });

                $('.form-date').datepicker('option', {
                    closeText: "Cerrar",
                    prevText: "Anterior",
                    nextText: "Siguiente",
                    currentText: "Hoy",
                    monthNames: ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"],
                    monthNamesShort: ["ene", "feb", "mar", "abr", "may", "jun", "jul", "ago", "sep", "oct", "nov", "dic"],
                    dayNames: ["domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado"],
                    dayNamesShort: ["dom", "lun", "mar", "mié", "jue", "vie", "sáb"],
                    dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                    weekHeader: "Sm",
                    dateFormat: "dd/mm/yy",
                    firstDay: 0,
                    isRTL: false,
                    showMonthAfterYear: false,
                    yearSuffix: ""
                });

                const nullField = $('#null');
                if(nullField.is(':checked')) {
                    $('#value').parents('.form-group').css('display', 'none');
                }
                nullField.on('change', function(){
                    $('#value').parents('.form-group').css('display', nullField.is(':checked') ? 'none' : '');
                });
            });
        })(jQuery);
    </script>
@stop
