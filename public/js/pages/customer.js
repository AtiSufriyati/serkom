
var general = {};
$(document).ready(function(){
    var route_url = $('input[name=route_url]').val();
    $('.menu-'+route_url).addClass('active');
    
    general.form    = 'form-customer';
    general.url     = "./customer/submit";
    
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
                    $('#modal-form-customer').modal('hide');
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
        $('#modal-form-customer').modal('show');
        $('input[name=action]').val(action);
        $('.modal-title').html('ADD CUSTOMER');
        $('input[name=CustomerID]').empty().prop('readonly',false);
        $('input[name=CustomerName]').empty().prop('readonly',false);
        $('textarea[name=Address]').empty().prop('readonly',false);
        $('input[name=KWHNo]').empty().prop('readonly',false);
        $('.btn-submit').removeClass('d-none');
    }else if(action == 'view'){
        $('#modal-form-customer').modal('show');
        $('input[name=action]').val(action);
        $('.modal-title').html('VIEW CUSTOMER');
        // $('input[name=CustomerID]').empty().prop('readonly',true);
        $('input[name=Username]').empty().prop('readonly',true);
        $('input[name=CustomerName]').empty().prop('readonly',true);
        $('textarea[name=Address]').empty().prop('readonly',true);
        $('input[name=KWHNo]').empty().prop('readonly',true);
        $('.btn-submit').addClass('d-none');
        var id = data.getAttribute('data-id');
        $('input[name=IndexCustomer]').val(id);
        get_customer(id);
    }else if(action == 'edit'){
        $('#modal-form-customer').modal('show');
        $('input[name=action]').val(action);
        $('.modal-title').html('EDIT CUSTOMER');
        // $('input[name=CustomerID]').empty().prop('readonly',true);
        $('input[name=Username]').empty().prop('readonly',true);
        $('input[name=CustomerName]').empty().prop('readonly',false);
        $('textarea[name=Address]').empty().prop('readonly',false);
        $('input[name=KWHNo]').empty().prop('readonly',false);
        $('.btn-submit').removeClass('d-none');
        var id = data.getAttribute('data-id');
        $('input[name=IndexCustomer]').val(id);
        get_customer(id);
    }
}
function btn_close(param){
    $(param).modal('hide');
}

function get_customer(id){
    let url = './customer/get_customer';
    let data = {
        IndexCustomer: id,
    }
    let promise = requestGet(url, data, '.load-modal');
    promise.done((response) => {
        $.each(response.Customer, function (key, result) {
            $('input[name=CustomerID]').val(result.CustomerID);
            $('input[name=Username]').val(result.UserName);
            $('input[name=CustomerName]').val(result.CustomerName);
            $('textarea[name=Address]').text(result.Address);
            $('input[name=KWHNo]').val(result.KWHNo);
        });
        myLoad('end', '.load-modal');
    }).fail((response) => {
        myLoad('end', '.load-modal');
        errorMessage(response);
    });
}

function search(page){
    let url = './customer';
    let data = {
        page: page ? page : 1,
        keyword: $('input[name=keyword]').val(),
    }
    let promise = requestGet(url, data, '.table-customer');
    promise.done((response) => {
        console.log(response);
        myLoad('end', '.table-customer');
        $('#content-table').empty().html(response);
    }).fail((response) => {
        myLoad('end', '.table-customer');
        errorMessage(response);
    });
}


