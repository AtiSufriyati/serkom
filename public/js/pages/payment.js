
var general = {};
$(document).ready(function(){
    var route_url = $('input[name=route_url]').val();
    $('.menu-'+route_url).addClass('active');
    general.form    = 'form-payment';
    general.url     = "./payment/submit";

    // $("#"+general.form).validate();
    if (cekElement('#'+general.form)){
        let settingValidation = {};
        settingValidation.submitHandler = function(form){
            alert('submit');
            var formData = $(form).serialize();
            var promise = requestAjax('post',general.url, formData, '#'+general.form);
            promise.then((response) => {
                myLoad('end','#'+general.form);
                if (response.respon == 'success') {
                    myAlert(response.respon, response.message);
                    $('#modal-form-payment').modal('hide');
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
    }else if(action == 'search-usage'){
        get_usage();
    }
    else if(action == 'add'){
        $('#modal-form-payment').modal('show');
        $('input[name=action]').val(action);
        $('.modal-title').html('ADD PAYMENT');
        $('input[name=PriceID]').empty().prop('readonly',false);
        $('input[name=Energy]').empty().prop('readonly',false);
        $('input[name=PricePerKWH]').empty().prop('readonly',false);
        $('.btn-submit').removeClass('d-none');
    }
    // else if(action == 'view'){
    //     $('#modal-form-payment').modal('show');
    //     $('input[name=action]').val(action);
    //     $('.modal-title').html('VIEW PAYMENT');
    //     $('input[name=PriceID]').empty().prop('readonly',true);
    //     $('input[name=Energy]').empty().prop('readonly',true);
    //     $('input[name=PricePerKWH]').empty().prop('readonly',true);
    //     $('.btn-submit').addClass('d-none');
    //     var id = data.getAttribute('data-id');
    //     $('input[name=IndexPrice]').val(id);
    //     get_payment(id);
    // }else if(action == 'edit'){
    //     $('#modal-form-payment').modal('show');
    //     $('input[name=action]').val(action);
    //     $('.modal-title').html('EDIT PAYMENT');
    //     $('input[name=PriceID]').empty().prop('readonly',true);
    //     $('input[name=Energy]').empty().prop('readonly',false);
    //     $('input[name=PricePerKWH]').empty().prop('readonly',false);
    //     $('.btn-submit').removeClass('d-none');
    //     var id = data.getAttribute('data-id');
    //     $('input[name=IndexPrice]').val(id);
    //     get_payment(id);
    // }
}
function btn_close(param){
    $(param).modal('hide');
}

// function get_payment(id){
//     let url = './payment/get_payment';
//     let data = {
//         IndexPrice: id,
//     }
//     let promise = requestGet(url, data, '.load-modal');
//     promise.done((response) => {
//         $.each(response.Price, function (key, result) {
//             $('input[name=PriceID]').val(result.PriceID);
//             $('input[name=Energy]').val(result.Energy);
//             $('input[name=PricePerKWH]').val(result.PricePerKWH);
//         });
//         myLoad('end', '.load-modal');
//     }).fail((response) => {
//         myLoad('end', '.load-modal');
//         errorMessage(response);
//     });
// }

function search(page){
    let url = './payment';
    let data = {
        page: page ? page : 1,
        keyword: $('input[name=keyword]').val(),
    }
    let promise = requestGet(url, data, '.table-payment');
    promise.done((response) => {
        myLoad('end', '.table-payment');
        $('#content-table').empty().html(response);
    }).fail((response) => {
        myLoad('end', '.table-payment');
        errorMessage(response);
    });
}


function get_usage(){
    var url = './payment/get_usage';
    var data = {
        CustomerID: $('input[name=search_customerid]').val(),
    }
    var promise = requestGet(url, data, '.table-usage');
    promise.done((response) => {
        console.log(response.Usage);
        $.each(response.Usage, function (key, result) {
            var AdminCharge = 2500;
            var Price = (result.EndMeter-result.StartMeter)*result.PricePerKWH;
            var TotalPayment = AdminCharge +parseFloat(Price);
            $('input[name=CustomerID]').val(result.CustomerID);
            $('input[name=CustomerName]').val(result.CustomerName);
            $('input[name=AdminCharge]').val(formatCurrency(AdminCharge));
            $('input[name=Periode]').val(result.Month + '/' + result.Year);
            $('input[name=StandMeter]').val(result.StartMeter + ' - ' + result.EndMeter);
            $('input[name=PriceDaya]').val(result.PriceID + ' - ' + result.Energy);
            $('input[name=Price]').val(formatCurrency(Price));
            $('input[name=TotalPayment]').val(formatCurrency(TotalPayment));
            $('#Status').text(result.Status);
            $('input[name=IndexBill]').val(result.IndexBill);
            if(result.Status == 'PAID'){
                $('#div_btn_submit').addClass('d-none');
            }else{
                $('#div_btn_submit').removeClass('d-none');
            }
        });
        myLoad('end', '.table-usage');
    }).fail((response) => {
        myLoad('end', '.table-usage');
        errorMessage(response);
    });
}

function viewPayment(data){
    $('#modal-form-viewpayment').modal('show');
        // $('input[name=action]').val(action);
        // $('.modal-title').html('ADD PAYMENT');
        // $('input[name=PriceID]').empty().prop('readonly',false);
        // $('input[name=Energy]').empty().prop('readonly',false);
        // $('input[name=PricePerKWH]').empty().prop('readonly',false);
        // $('.btn-submit').removeClass('d-none');


    var Index = data.getAttribute('data-index');
    var url = './payment/get_payment';
    var data = {
        IndexPayment: Index,
    }
    var promise = requestGet(url, data, '.table-usage');
    promise.done((response) => {
        $.each(response.Payment, function (key, result) {
            console.log(result);
            var AdminCharge = 2500;
            var Price = (result.EndMeter-result.StartMeter)*result.PricePerKWH;
            var TotalPayment = AdminCharge +parseFloat(Price);
            $('input[name=view_CustomerID]').val(result.CustomerID);
            $('input[name=view_CustomerName]').val(result.CustomerName);
            $('input[name=view_AdminCharge]').val(formatCurrency(AdminCharge));
            $('input[name=view_Periode]').val(result.Month + '/' + result.Year);
            $('input[name=view_StandMeter]').val(result.StartMeter + ' - ' + result.EndMeter);
            $('input[name=view_PriceDaya]').val(result.PriceID + ' - ' + result.Energy);
            $('input[name=view_Price]').val(formatCurrency(Price));
            $('input[name=view_TotalPayment]').val(formatCurrency(TotalPayment));
            $('#Status').text(result.Status);
            $('input[name=view_IndexBill]').val(result.IndexBill);
        });
        myLoad('end', '.table-usage');
    }).fail((response) => {
        myLoad('end', '.table-usage');
        errorMessage(response);
    });
}

function PrintPayment(){
    let div = '#printArea'
    var printContents = document.getElementById('printArea').innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}


