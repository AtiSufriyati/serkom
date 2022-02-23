const darqo = {};
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    if (cekElement(".search-keyword")){
        $('.search-keyword').focus();
    }

    if (cekElement(".pickadate")){
        $('.pickadate').pickadate({
            selectMonths: true,
            selectYears: true,
            format: 'dd-mm-yyyy'
        });
    }

    if (cekElement(".datepicker")){
        $( ".datepicker" ).datepicker({
            dateFormat: "dd-mm-yy",
            changeMonth: true,
            changeYear: true,
            yearRange: "-5:+10"
        });
    }

    if (cekElement("#editor-full")){
        CKEDITOR.replace('editor-full', {
            language: 'en-gb',
            extraPlugins: 'forms',
            height: 100,
            toolbarCanCollapse : true,
            toolbarStartupExpanded  : false
        });
    }

    if (cekElement(".keyFontUp")){
        $('.keyFontUp').bind("keyup focusout", function () {
            this.value = this.value.toLocaleUpperCase();
        });
    }

    if (cekElement(".keyFontLow")){
        $('.keyFontLow').bind("keyup focusout", function () {
            this.value = this.value.toLocaleUpperCase();
        });
    }

    if (cekElement(".onlyNumber")){
        $('.onlyNumber').keypress(function(event) {
            $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
    }

    if (cekElement(".onlyText")){
        $('.onlyText').bind('keyup focusout',function(){
            this.value = this.value.replace(/[^a-zA-Z@'\-\s]/g, '');
        });
    }

    if (cekElement(".FormatKey")){
        $('.FormatKey').keyup(function(event){
            // Allow arrow keys & Period
            if (event.which >= 37 && event.which <= 40) return;
            // if(event.which == 190 || event.which == 110) return;

            // Format Number
            $(this).val(function(index, value)
            {
                number = value.replace(/[^0-9'.']/g, "");
                if (number.match(/\./g))
                {
                    if (number.match(/\./g).length > 1) {
                        return;
                    }
                    else {
                        n = number.search(/\./);
                        numberSplit = number.substr(0, n);
                        firstNumber = numberSplit.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        lastNumber = number.substr(n, 3);
                        return firstNumber + lastNumber;
                    }
                }
                else {
                    return number.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }

            });
        });
    }

    if (cekElement('#icon-eye-password')){

        $(document).on("click", "#icon-eye-password" , function(event){

            event.preventDefault();
            var x = document.getElementById("v_password");

            if (x.type === "password") {
                x.type = "text";
                $('#icon-eye-password').html('<i class="mdi mdi-eye password-icon"></i>');
            }
            else {
                x.type = "password";
                $('#icon-eye-password').html('<i class="mdi mdi-eye-off password-icon"></i>');
            }
        });
    }

    if (cekElement(".datepicker-birthdate")){
        $( ".datepicker-birthdate" ).datepicker({
            dateFormat: "dd-mm-yy",
            changeMonth: true,
            changeYear: true,
            defaultDate: new Date(),
            yearRange: "-60:+0",
            maxDate: '0'
        });
    }

    if (cekElement(".select2-search")){
        $('.select2-search').select2().on('change', function () {
            $(this).valid();
        });
    }

    if (cekElement(".select")){
        $('.select').select2({
            minimumResultsForSearch: Infinity
        });
    }

    if (cekElement(".tokenfield")){
        $('.tokenfield').tokenfield();
    }

    darqo.config = {
        validator: {
            ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
            errorClass: 'validation-invalid-label',
            successClass: 'validation-valid-label',
            validClass: 'validation-valid-label',
            highlight: function (element, errorClass) {
                $(element).removeClass(errorClass);
            },
            unhighlight: function (element, errorClass) {
                $(element).removeClass(errorClass);
            },
            // success: function(label) {
            //     label.addClass('validation-valid-label').text('Success.'); // remove to hide Success message
            // },
            // Different components require proper error label placement
            errorPlacement: function (error, element) {

                // Unstyled checkboxes, radios
                if (element.parents().hasClass('form-check')) {
                    error.appendTo(element.parents('.form-check').parent());
                }

                else if (element.parents().hasClass('custom-control')) {
                    error.appendTo(element.parents('.custom-control').parent().parent().parent());
                }

                // Input with icons and Select2
                else if (element.parents().hasClass('form-group-feedback') || element.hasClass('select2-hidden-accessible')) {
                    error.appendTo(element.parent());
                }

                // Input group, styled file input
                else if (element.parent().is('.uniform-uploader, .uniform-select') || element.parents().hasClass('input-group')) {
                    error.appendTo(element.parent().parent());
                }

                // Other elements
                else {
                    error.insertAfter(element);
                }
            },
        }
    };

    $.validator.setDefaults(darqo.config.validator);
});

function myLoad(mode, param){
    if(mode == 'start'){
        // setTimeout(() => { //di live selalu load kalo pake time out
            $(param).block({
                message: '<i class="mdi mdi-spin mdi-loading"></i>',
                overlayCSS: {
                    backgroundColor: '#fff',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        // }, 300);
    }
    else{
        $(param).unblock();
    }
}

function errorMessage(error){
    if(document.readyState == 'complete' ){
        if(notEmpty(error.status))
        {
            if(error.status == 422)
            {
                //validation
                errorValidation(error);
            }
            else
            {
                if (error.status != 0) {
                    var msg = "SOMETHING WENT WRONG<br /> PLEASE TRY AGAIN...";
                    myAlert('failed', msg);
                    console.error(error);
                }
            }
        }
        else
        {
            if (error.status != 0) {
                var msg = "SOMETHING WENT WRONG<br /> PLEASE TRY AGAIN...";
                myAlert('failed', msg);
                console.error(error);
            }
        }
    }
}

function myAlert(type, message, url){
    if(url=="" || url=="undefined"){
        var url="";
    }

    if (typeof swal == 'undefined'){
        console.warn('Warning - sweet_alert.min.js is not loaded.');
        return;
    }
    // Defaults
    var setCustomDefaults = function(){
        swal.setDefaults({
            buttonsStyling: false,
            confirmButtonClass: 'btn btn-warning btn-sm',
            cancelButtonClass: 'btn btn-light btn-sm'
        });
    }
    setCustomDefaults();

    if (type == "register"){
        swal({
            title: "Good Job !",
            text: message,
            // type: "success",
            imageUrl: config.asset+`/assets/images/icon_confetti_05.png`,
            imageWidth: 100,
            imageHeight: 100,
            imageAlt: 'Custom image',
            animation: false,
            allowOutsideClick: false,
            showCloseButton: true,
            onClose: resendEmail
        }).then(function() {
            if(url){
                window.location.href = url;
            }
        });
    } else if (type == "success"){
        
        swal({
            title: "Good Job !",
            text: message,
            type: "success",
            allowOutsideClick: false,
            showCloseButton: true
        }).then(function() {
            if(url){
                window.location.href = url;
            }
        });
    }
    else if (type == "error" || type == "failed" || type == 'unauthorized'){
        swal({
            title: "Oops...",
            text: message,
            type: "error",
            allowOutsideClick: false,
            showCloseButton: true
        }).then(function() {
            if(url){
                window.location.href = url;
            }
        });
    }
    else if (type == "info"){
        swal({
            title: "For your information",
            text: message,
            type: "info",
            allowOutsideClick: false,
            showCloseButton: true
        }).then(function() {
            if(url){
                window.location.href = url;
            }
        });
    }
    else if (type == "warning"){
        swal({
            title: "For your information",
            text: message,
            type: "warning",
            allowOutsideClick: false,
            showCloseButton: true
        }).then(function() {
            if(url){
                window.location.href = url;
            }
        });
    }
}

///////////////////////////////////////
function cekElement(param){
    if($(param).length > 0){
        return true;
    }
    return false
}

function cekTypeInput(form,isType){
    var hasil = 0;
    $(form+' :input').each(function() {
        if(typeof($(this).attr('type'))!== undefined){
            if($(this).attr('type')==isType){
                hasil++;
            }
        }
    });

    if(hasil*1>0){
        return true;
    }else{
        return false;
    }
}
function isEmpty(obj){
    for(var key in obj) {
        if(obj.hasOwnProperty(key))
            return false;
    }
    return true;
}
function requestAjax(method, action, data, div=null){
    isMethod = method.toUpperCase();
    if(cekTypeInput(div,'file'))
    {
        return $.ajax({
            url: action,
            type: isMethod,
            data: data,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(){
                if(notEmpty(div)){
                    myLoad('start',div);
                }
            }
        });
    }
    else
    {
        return $.ajax({
            url: action,
            type: isMethod,
            data: data,
            dataType: 'json',
            cache: false,
            beforeSend: function(){
                if(notEmpty(div)){
                    myLoad('start',div);
                }
            }
        });
    }
}
function requestGet(url, data = null, div =null){
    if(isEmpty(data)){
        return $.ajax({
            url: url,
            type: "GET",
            dataType: 'json',
            cache: false,
            beforeSend: function(){
                if(notEmpty(div)){
                    myLoad('start',div);
                }
            }
        });
    }
    else{
        return $.ajax({
            url: url,
            type: "GET",
            data: data,
            dataType: 'json',
            cache: false,
            beforeSend: function(){
                if(notEmpty(div)){
                    myLoad('start',div);
                }
            }
        });
    }
}

function notEmpty(string){
    var v = false;
    if (string != null && string != '' && string != 'undefined') {
        v = true;
    }
    return v;
}

function myConfirmation(message){
    var setCustomDefaults = function() {
        swal.setDefaults({
            buttonsStyling: false,
            confirmButtonClass: 'btn btn-warning btn-sm mr-2',
            cancelButtonClass: 'btn btn-light btn-sm'
        });
    }
    setCustomDefaults();
    var msg = (notEmpty(message)) ? message : null;
    return swal({
        title: 'Are you sure?',
        text: msg,
        type: 'question',
        showCancelButton: true,
        confirmButtonText: 'YES',
        cancelButtonText: 'NO',
        // showLoaderOnConfirm: true,
        // closeOnConfirm: false,

    });
}

function resendEmail(){
    if($( window ).width() >= 801){   
        $('.card-registerresend').css('margin-bottom', '215px');
    }
    $('.register-account').hide();
    $('.resend-email').show();
    $('.resend-email').css('margin-top', '20px');
    $('input[name=act]').val('resendemail');
    $('.div-firstname').empty();
    $('.div-lastname').empty();
    $('.div-mobilephone').empty();
    $('.div-tnc').empty();
    $('.div-email-form').hide();
    $("<h4 style='color:#f48221; text-align:center;'><p>Didn't received an email confirmation?</p></h4><p><br>Make sure to check your inbox or spam folders or you can request another confirmation email by clicking the button below</p>").appendTo(".div-email");
}

$(document).on("click", ".sidebar-item" , function(event){
    var route_url = $('input[name=route_url]').val();
    $('.menu-'+route_url).addClass('active');
});
