
<div id="modal-form-user" class="modal fade" data-keyboard="false" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">ADD USER</h5>
            </div>
            <div class="load-modal">
                <form id="form-user" action="#">
                    <input type="hidden" class="action" name="action" value="">
                    <input type="hidden" class="indexuser" name="IndexUser" value="">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12 div-name">
                                <div class="form-group">
                                    <label class="d-block font-weight-semibold">Username<span class="text-danger ml-1">*</span></label>
                                    <input type="text" class="form-control" placeholder="Username" name="Username" required>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3 div-name">
                                <div class="form-group">
                                    <label class="d-block font-weight-semibold">Admin Name<span class="text-danger ml-1">*</span></label>
                                    <input type="text" class="form-control" placeholder="Admin Name" name="AdminName" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12 div-name">
                                <div class="form-group">
                                    <label class="d-block font-weight-semibold">Email<span class="text-danger ml-1">*</span></label>
                                    <input type="text" class="form-control" placeholder="Email" name="Email">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 div-name">
                                <div class="form-group">
                                    <label class="d-block font-weight-semibold">Phone Number<span class="text-danger ml-1">*</span></label>
                                    <input type="text" class="form-control" placeholder="Phone Number" name="Phone" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12 div-name">
                                <div class="form-group">
                                    <label class="d-block font-weight-semibold">Level<span class="text-danger ml-1">*</span></label>
                                    <input type="text" class="form-control" placeholder="Level" name="IndexLevel" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center align-items-center">
                        <button type="submit"  class="btn btn-info btn-submit">Submit</button>
                        <button type="button"  class="btn btn-danger" onclick="btn_close('#modal-form-user');">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>