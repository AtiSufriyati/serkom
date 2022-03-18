
<div id="modal-form-payment" class="modal fade" data-keyboard="false" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">ADD PAYMENT</h5>
            </div>
            <div class="load-modal">
                <form id="form-payment" action="#">
                    <input type="hidden" class="action" name="action" value="">
                    <input type="hidden" class="indexpayment" name="IndexPayment" value="">
                    <div class="modal-body">
                        <div class="row">
                            <!-- <div class="col-md-2 col-sm-2 col-xs-12 div-name">
                                <div class="form-group">
                                    <label class="d-block font-weight-semibold">Month<span class="text-danger ml-1">*</span></label>
                                    <select class="form-control month" name="Month" disabled>
                                        <option value="FEBRUARY" selected>FEBRUARY</option>
                                    </select>
                                </div>
                            </div> -->
                            <div class="col-md-4 col-sm-4 col-xs-12 div-name">
                                <div class="form-group">
                                    <label class="d-block font-weight-semibold">Customer ID<span class="text-danger ml-1">*</span></label>
                                    <input type="text" class="form-control search_customerid" placeholder="Customer ID" name="search_customerid" required>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3 div-name">
                                <div class="form-group">
                                    <label class="d-block font-weight-semibold"><span class="text-danger ml-1">&nbsp;</span></label>
                                    <button type="button" class="btn btn-success" id="btn-search" onclick="btn_action(this);" data-action="search-usage"><b>SEARCH</b></button>
                                </div>
                            </div>
                        </div>
                        <hr>


                        <div class="row">
                            <!-- class table-borderless dipakai untuk membuat table tanpa border -->
                            <table class="table table-borderless">
                                <tr>
                                    <td style="width:20%">CUSTOMER ID</td>
                                    <td style="width:2%">:</td>
                                    <td style="width:33%"><input type="text" style="background-color:transparent;border:none;" name="CustomerID" readonly></td>
                                    <td style="width:25%">BL/TH</td>
                                    <td style="width:2%">:</td>
                                    <td style="width:25%"><input type="text" style="background-color:transparent;border:none;" name="Periode" readonly></td>
                                </tr>
                                <tr>
                                    <td>NAMA</td>
                                    <td>:</td>
                                    <td><input type="text" style="background-color:transparent;border:none;" name="CustomerName" readonly></td>
                                    <td>STAND METER</td>
                                    <td>:</td>
                                    <td><input type="text" style="background-color:transparent;border:none;" name="StandMeter" readonly></td>
                                </tr>
                                <tr>
                                    <td>PRICE/DAYA</td>
                                    <td>:</td>
                                    <td><input type="text" style="background-color:transparent;border:none;" name="PriceDaya" readonly></td>
                                    <td colspan="3" class="text-center"><label id="Status"></label></td>
                                </tr>
                                <tr>
                                    <td>RP TAG PLN</td>
                                    <td>:</td>
                                    <td><input type="text" style="background-color:transparent;border:none;" name="Price" readonly></td>
                                </tr>
                                <tr>
                                    <td>ADMIN CHARGE</td>
                                    <td>:</td>
                                    <td><input type="text" style="background-color:transparent;border:none;" name="AdminCharge" readonly></td>
                                </tr>
                                <tr>
                                    <td>TOTAL PAYMENT</td>
                                    <td>:</td>
                                    <td><input type="text" style="background-color:transparent;border:none;" name="TotalPayment" readonly></td>
                                </tr>
                            </table>
                        </div>
                        <input type='hidden' name="IndexBill">
                    </div>
                    <div class="modal-footer d-flex justify-content-center align-items-center">
                        <div class="d-none" id="div_btn_submit">
                            <button type="submit"  class="btn btn-info btn-submit">Submit</button>
                        </div>
                        <button type="button"  class="btn btn-danger" onclick="btn_close('#modal-form-payment');">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div id="modal-form-viewpayment" class="modal fade" data-keyboard="false" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">VIEW PAYMENT</h5>
            </div>
            <div class="load-modal">
                <form id="form-viewpayment" action="#">
                    <input type="hidden" class="action" name="action" value="">
                    <input type="hidden" class="indexpayment" name="IndexPayment" value="">
                    <div class="modal-body">
                        <div class="row" id="printArea">
                            <table class="table table-borderless">
                                <tr>
                                    <td style="width:20%">CUSTOMER ID</td>
                                    <td style="width:2%">:</td>
                                    <td style="width:33%"><input type="text" style="background-color:transparent;border:none;" name="view_CustomerID" readonly></td>
                                    <td style="width:25%">BL/TH</td>
                                    <td style="width:2%">:</td>
                                    <td style="width:25%"><input type="text" style="background-color:transparent;border:none;" name="view_Periode" readonly></td>
                                </tr>
                                <tr>
                                    <td>NAMA</td>
                                    <td>:</td>
                                    <td><input type="text" style="background-color:transparent;border:none;" name="view_CustomerName" readonly></td>
                                    <td>STAND METER</td>
                                    <td>:</td>
                                    <td><input type="text" style="background-color:transparent;border:none;" name="view_StandMeter" readonly></td>
                                </tr>
                                <tr>
                                    <td>PRICE/DAYA</td>
                                    <td>:</td>
                                    <td><input type="text" style="background-color:transparent;border:none;" name="view_PriceDaya" readonly></td>
                                    <td colspan="3" class="text-center"><label id="Status"></label></td>
                                </tr>
                                <tr>
                                    <td>RP TAG PLN</td>
                                    <td>:</td>
                                    <td><input type="text" style="background-color:transparent;border:none;" name="view_Price" readonly></td>
                                </tr>
                                <tr>
                                    <td>ADMIN CHARGE</td>
                                    <td>:</td>
                                    <td><input type="text" style="background-color:transparent;border:none;" name="view_AdminCharge" readonly></td>
                                </tr>
                                <tr>
                                    <td>TOTAL PAYMENT</td>
                                    <td>:</td>
                                    <td><input type="text" style="background-color:transparent;border:none;" name="view_TotalPayment" readonly></td>
                                </tr>
                            </table>
                        </div>
                        <input type='hidden' name="view_IndexBill">
                    </div>
                    <div class="modal-footer d-flex justify-content-center align-items-center">
                        <button type="button"  class="btn btn-success btn-submit" onclick="PrintPayment()">Print</button>
                        <button type="button"  class="btn btn-danger" onclick="btn_close('#modal-form-viewpayment');">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

