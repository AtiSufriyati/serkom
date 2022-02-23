
<div id="modal-form-price" class="modal fade" data-keyboard="false" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">ADD PRICE</h5>
            </div>
            <div class="load-modal">
                <form id="form-price" action="#">
                    <input type="hidden" class="action" name="action" value="">
                    <input type="hidden" class="indexprice" name="IndexPrice" value="">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12 div-name">
                                <div class="form-group">
                                    <label class="d-block font-weight-semibold">Price ID<span class="text-danger ml-1">*</span></label>
                                    <input type="text" class="form-control" placeholder="Price ID" name="PriceID" required>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3 div-name">
                                <div class="form-group">
                                    <label class="d-block font-weight-semibold">Energy<span class="text-danger ml-1">*</span></label>
                                    <input type="text" class="form-control" placeholder="Energy" name="Energy" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12 div-name">
                                <div class="form-group">
                                    <label class="d-block font-weight-semibold">PricePerKWH<span class="text-danger ml-1">*</span></label>
                                    <input type="text" class="form-control" placeholder="PricePerKWH" name="PricePerKWH">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center align-items-center">
                        <button type="submit"  class="btn btn-info btn-submit">Submit</button>
                        <button type="button"  class="btn btn-danger" onclick="btn_close('#modal-form-price');">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>