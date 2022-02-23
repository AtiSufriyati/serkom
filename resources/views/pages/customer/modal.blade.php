
<div id="modal-form-customer" class="modal fade" data-keyboard="false" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">ADD CUSTOMER</h5>
            </div>
            <div class="load-modal">
                <form id="form-customer" action="#">
                    <input type="hidden" class="action" name="action" value="">
                    <input type="hidden" class="indexcustomer" name="IndexCustomer" value="">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12 div-name">
                                <div class="form-group">
                                    <label class="d-block font-weight-semibold">Name<span class="text-danger ml-1">*</span></label>
                                    <input type="text" class="form-control" placeholder="Name" name="CustomerName" required>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 div-name">
                                <div class="form-group">
                                    <label class="d-block font-weight-semibold">Username<span class="text-danger ml-1">*</span></label>
                                    <input type="text" class="form-control" placeholder="Username" name="Username" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 div-name">
                                <div class="form-group">
                                    <label class="d-block font-weight-semibold">Address<span class="text-danger ml-1">*</span></label>
                                    <textarea rows="2" class="form-control" name="Address" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 div-name">
                                <div class="form-group">
                                    <label class="d-block font-weight-semibold">KWH No<span class="text-danger ml-1">*</span></label>
                                    <input type="text" class="form-control" placeholder="KWH No" name="KWHNo" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center align-items-center">
                        <button type="submit"  class="btn btn-info btn-submit">Submit</button>
                        <button type="button"  class="btn btn-danger" onclick="btn_close('#modal-form-customer');">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>