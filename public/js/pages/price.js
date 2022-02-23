
var general = {};
$(document).ready(function(){
    var route_url = $('input[name=route_url]').val();
    $('.menu-'+route_url).addClass('active');
    general.form    = 'form-price';
    general.url     = "./price/submit";

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
                    $('#modal-form-price').modal('hide');
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
        $('#modal-form-price').modal('show');
        $('input[name=action]').val(action);
        $('.modal-title').html('ADD PRICE');
        $('input[name=PriceID]').empty().prop('readonly',false);
        $('input[name=Energy]').empty().prop('readonly',false);
        $('input[name=PricePerKWH]').empty().prop('readonly',false);
        $('.btn-submit').removeClass('d-none');
    }else if(action == 'view'){
        $('#modal-form-price').modal('show');
        $('input[name=action]').val(action);
        $('.modal-title').html('VIEW PRICE');
        $('input[name=PriceID]').empty().prop('readonly',true);
        $('input[name=Energy]').empty().prop('readonly',true);
        $('input[name=PricePerKWH]').empty().prop('readonly',true);
        $('.btn-submit').addClass('d-none');
        var id = data.getAttribute('data-id');
        $('input[name=IndexPrice]').val(id);
        get_price(id);
    }else if(action == 'edit'){
        $('#modal-form-price').modal('show');
        $('input[name=action]').val(action);
        $('.modal-title').html('EDIT PRICE');
        $('input[name=PriceID]').empty().prop('readonly',true);
        $('input[name=Energy]').empty().prop('readonly',false);
        $('input[name=PricePerKWH]').empty().prop('readonly',false);
        $('.btn-submit').removeClass('d-none');
        var id = data.getAttribute('data-id');
        $('input[name=IndexPrice]').val(id);
        get_price(id);
    }
}
function btn_close(param){
    $(param).modal('hide');
}

function get_price(id){
    let url = './price/get_price';
    let data = {
        IndexPrice: id,
    }
    let promise = requestGet(url, data, '.load-modal');
    promise.done((response) => {
        $.each(response.Price, function (key, result) {
            $('input[name=PriceID]').val(result.PriceID);
            $('input[name=Energy]').val(result.Energy);
            $('input[name=PricePerKWH]').val(result.PricePerKWH);
        });
        myLoad('end', '.load-modal');
    }).fail((response) => {
        myLoad('end', '.load-modal');
        errorMessage(response);
    });
}

function search(page){
    let url = './price';
    let data = {
        page: page ? page : 1,
        keyword: $('input[name=keyword]').val(),
    }
    let promise = requestGet(url, data, '.table-price');
    promise.done((response) => {
        myLoad('end', '.table-price');
        $('#content-table').empty().html(response);
    }).fail((response) => {
        myLoad('end', '.table-price');
        errorMessage(response);
    });
}


