
<div id="modal-form-level" class="modal fade" data-keyboard="false" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">ADD LEVEL</h5>
            </div>
            <div class="load-modal">
                <form id="form-level" action="#">
                    <input type="hidden" class="action" name="action" value="">
                    <input type="hidden" class="indexlevel" name="IndexLevel" value="">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12 div-name">
                                <div class="form-group">
                                    <label class="d-block font-weight-semibold">Level ID<span class="text-danger ml-1">*</span></label>
                                    <input type="text" class="form-control" placeholder="Price ID" name="LevelID" required>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3 div-name">
                                <div class="form-group">
                                    <label class="d-block font-weight-semibold">Level Name<span class="text-danger ml-1">*</span></label>
                                    <input type="text" class="form-control" placeholder="Level Name" name="LevelName" required>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                    <div class="modal-footer d-flex justify-content-center align-items-center">
                        <button type="submit"  class="btn btn-info btn-submit">Submit</button>
                        <button type="button"  class="btn btn-danger" onclick="btn_close('#modal-form-level');">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>