
var general = {};
$(document).ready(function(){
    var route_url = $('input[name=route_url]').val();
    $('.menu-'+route_url).addClass('active');
    general.form    = 'form-level';
    general.url     = "./level/submit";

    // $("#"+general.form).validate();
    if (cekElement('#'+general.form)){
        let settingValidation = {};
        settingValidation.submitHandler = function(form){
            var formData = $(form).serialize();
            var promise = requestAjax('post',general.url, formData, '#'+general.form);
            promise.then((response) => {
                myLoad('end','#'+general.form);
                if (response.respon == 'success') {
                    myAlert(response.respon, response.message);
                    $('#modal-form-level').modal('hide');
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
        $('#modal-form-level').modal('show');
        $('input[name=action]').val(action);
        $('.modal-title').html('ADD LEVEL');
        $('input[name=LevelID]').val('').prop('readonly',false);
        $('input[name=LevelName]').val('').prop('readonly',false);
        $('.btn-submit').removeClass('d-none');
    }else if(action == 'view'){
        $('#modal-form-level').modal('show');
        $('input[name=action]').val(action);
        $('.modal-title').html('VIEW LEVEL');
        $('input[name=LevelID]').val('').prop('readonly',true);
        $('input[name=LevelName]').val('').prop('readonly',true);
        $('.btn-submit').addClass('d-none');
        var id = data.getAttribute('data-id');
        $('input[name=IndexLevel]').val(id);
        get_level(id);
    }else if(action == 'edit'){
        $('#modal-form-level').modal('show');
        $('input[name=action]').val(action);
        $('.modal-title').html('EDIT LEVEL');
        $('input[name=LevelID]').val('').prop('readonly',true);
        $('input[name=LevelName]').val('').prop('readonly',false);
        $('.btn-submit').removeClass('d-none');
        var id = data.getAttribute('data-id');
        $('input[name=IndexLevel]').val(id);
        get_level(id);
    }
}
function btn_close(param){
    $(param).modal('hide');
}

function get_level(id){
    let url = './level/get_level';
    let data = {
        IndexLevel: id,
    }
    let promise = requestGet(url, data, '.load-modal');
    promise.done((response) => {
        $.each(response.Level, function (key, result) {
            console.log(result);
            $('input[name=LevelID]').val(result.LevelID);
            $('input[name=LevelName]').val(result.LevelName);
        });
        myLoad('end', '.load-modal');
    }).fail((response) => {
        myLoad('end', '.load-modal');
        errorMessage(response);
    });
}

function search(page){
    let url = './level';
    let data = {
        page: page ? page : 1,
        keyword: $('input[name=keyword]').val(),
    }
    let promise = requestGet(url, data, '.table-level');
    promise.done((response) => {
        myLoad('end', '.table-level');
        $('#content-table').empty().html(response);
    }).fail((response) => {
        myLoad('end', '.table-level');
        errorMessage(response);
    });
}


