
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
                                    <input type="text" class="form-control" placeholder="Customer ID" name="CustomerID" required>
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
                            <table class="table table-bordered">
                                <tr>
                                    <td style="width:15%">CUSTOMER ID</td>
                                    <td style="width:2%">:</td>
                                    <td style="width:38%"><input type="text" style="background-color:transparent;" name="CustomerID"></td>
                                    <td style="width:15%">BL/TH</td>
                                    <td style="width:2%">:</td>
                                    <td style="width:28%"><input type="text" style="background-color:transparent;outline:none" name="Periode" value="FEB/2022"></td>
                                </tr>
                                <tr>
                                    <td>NAMA</td>
                                    <td>:</td>
                                    <td><input type="text" style="background-color:transparent;" name="CustomerName"></td>
                                    <td>STAND METER</td>
                                    <td>:</td>
                                    <td><input type="text" style="background-color:transparent;" name="StandMeter"></td>
                                </tr>
                                <tr>
                                    <td>TARIF/DAYA</td>
                                    <td>:</td>
                                    <td><input type="text" style="background-color:transparent;" name="TarifDaya"></td>
                                </tr>
                                <tr>
                                    <td>RP TAG PLN</td>
                                    <td>:</td>
                                    <td><input type="text" style="background-color:transparent;" name="Price"></td>
                                </tr>
                                <tr>
                                    <td>ADMIN BANK</td>
                                    <td>:</td>
                                    <td><input type="text" style="background-color:transparent;" name="AdminBank"></td>
                                </tr>
                                <tr>
                                    <td>TOTAL BAYAR</td>
                                    <td>:</td>
                                    <td><input type="text" style="background-color:transparent;" name="TotalPrice"></td>
                                </tr>
                            </table>
                        </div>

                        <!-- <div class="row">
                            <div class="col-md-12">
                                <table class="table table-hover table-bordered table-usage">
                                    <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">CUSTOMER ID</th>
                                            <th class="text-center">MONTH</th>
                                            <th class="text-center">START METER</th>
                                            <th class="text-center">END METER</th>
                                            <th class="text-center">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody id="usage_list">
                                    </tbody>
                                </table>
                            </div>
                        </div> -->
                        
                    </div>
                    <div class="modal-footer d-flex justify-content-center align-items-center">
                        <button type="submit"  class="btn btn-info btn-submit">Submit</button>
                        <button type="button"  class="btn btn-danger" onclick="btn_close('#modal-form-payment');">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>