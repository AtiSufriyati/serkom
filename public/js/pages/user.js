
var general = {};
$(document).ready(function(){
    var route_url = $('input[name=route_url]').val();
    $('.menu-'+route_url).addClass('active');
    general.form    = 'form-user';
    general.url     = "./user/submit";
    if (cekElement('#'+general.form)){
        let settingValidation = {};
        settingValidation.submitHandler = function(form){
            var formData = $(form).serialize();
            var promise = requestAjax('post',general.url, formData, '#'+general.form);
            promise.then((response) => {
                myLoad('end','#'+general.form);
                if (response.respon == 'success') {
                    myAlert(response.respon, response.message);
                    $('#modal-form-user').modal('hide');
                    search(1);
                }
                else {
                    myAlert(response.respon, response.message);
                }
            })
            .fail((response) => {
                myLoad('end', '#'+general.form);
                errorMessage(response);
            });

            return false;

        }
        $('#'+general.form).validate(settingValidation);
    }
    $(document).on('click', '.pagination a', function (event) {
        event.preventDefault();
        var page = $(this).prop('href').split('page=')[1];
        search(page);
    });
});

function btn_action(data){
    var action = data.getAttribute("data-action");
    if(action == 'search'){
        search(1);
    }else if(action == 'add'){
        $('#modal-form-user').modal('show');
        $('input[name=action]').val(action);
        $('.modal-title').html('ADD USER');
        $('input[name=Username]').empty().prop('readonly',false);
        $('input[name=Email]').empty().prop('readonly',false);
        $('input[name=Phone]').empty().prop('readonly',false);
        $('input[name=AdminName]').empty().prop('readonly',false);
        $('.btn-submit').removeClass('d-none');
    }else if(action == 'view'){
        $('#modal-form-user').modal('show');
        $('input[name=action]').val(action);
        $('.modal-title').html('VIEW USER');
        $('input[name=Username]').empty().prop('readonly',true);
        $('input[name=Email]').empty().prop('readonly',true);
        $('input[name=Phone]').empty().prop('readonly',true);
        $('input[name=AdminName]').empty().prop('readonly',true);
        $('input[name=IndexLevel]').empty().prop('readonly',true);
        $('.btn-submit').addClass('d-none');
        var id = data.getAttribute('data-id');
        $('input[name=IndexUser]').val(id);
        get_user(id);
    }else if(action == 'edit'){
        $('#modal-form-user').modal('show');
        $('input[name=action]').val(action);
        $('.modal-title').html('EDIT USER');
        $('input[name=Username]').empty().prop('readonly',true);
        $('input[name=Email]').empty().prop('readonly',false);
        $('input[name=Phone]').empty().prop('readonly',true);
        $('input[name=AdminName]').empty().prop('readonly',false);
        $('input[name=IndexLevel]').empty().prop('readonly',false);
        $('.btn-submit').removeClass('d-none');
        var id = data.getAttribute('data-id');
        $('input[name=IndexUser]').val(id);
        get_user(id);
    }
}
function btn_close(param){
    $(param).modal('hide');
}

function get_user(id){
    let url = './user/get_user';
    let data = {
        IndexUser: id,
    }
    let promise = requestGet(url, data, '.load-modal');
    promise.done((response) => {
        $.each(response.User, function (key, result) {
            $('input[name=Username]').val(result.UserName);
            $('input[name=Email]').val(result.Email);
            $('input[name=Phone]').val(result.Phone);
            $('input[name=AdminName]').val(result.AdminName);
            $('input[name=IndexLevel]').val(result.IndexLevel);

        });
        myLoad('end', '.load-modal');
    }).fail((response) => {
        myLoad('end', '.load-modal');
        errorMessage(response);
    });
}

function search(page){
    let url = './user';
    let data = {
        page: page ? page : 1,
        keyword: $('input[name=keyword]').val(),
    }
    let promise = requestGet(url, data, '.table-user');
    promise.done((response) => {
        console.log(response);
        myLoad('end', '.table-user');
        $('#content-table').empty().html(response);
    }).fail((response) => {
        myLoad('end', '.table-user');
        errorMessage(response);
    });
}


