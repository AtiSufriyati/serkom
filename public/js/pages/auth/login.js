
var general = {};
$(document).ready(function(){
    general.form    = 'form-login';
    general.url     = "./login/dologin";
   
});

function submit_login(){
    var formData    = $('#'+general.form).serializeArray();
    // var email = $('input[name=email]').val();
    // var password = $('input[name=password]').val();
    console.log(formData);
    $.ajax({
        url: general.url,
        type: "POST",
        data: formData,
        dataType: 'json',
        cache: false,
        beforeSend: function (){
            myLoad('start', '#'+general.form);
        },
        success: function (p_respon) {
            console.log(p_respon);
            if (p_respon.respon == 'success') {
                window.location.href = p_respon.url;
            } else {
                alert('failed');
                // myAlert(p_respon.respon, p_respon.message);
            }
            myLoad('end', '#'+general.form);
        },
        error: function (response) {
            errorMessage(response);
            myLoad('end', '#'+general.form);
        }
    });


    // var promise     = requestAjax('post', general.url, formData,'#form-login');
    // console.log(promise);
    // promise.then((response) => {
    //     // console.log(response);
    //     if(response.respon == 'register') {
    //         myAlert(response.respon, response.message);
    //     }
    //     else if (response.respon == 'success') {
    //         if(act == 'reset'){
    //             window.location.href = response.url;
    //         } else {
    //             myAlert(response.respon, response.message, response.url);
    //         }
    //     } else{
    //         myAlert(response.respon, response.message);
    //     }
    //     myLoad('end', '#'+general.form);
    // })
    // .fail((response) => {
    //     myLoad('end', '#'+general.form);
    //     console.log(response);
    // });
    // return false;
}

