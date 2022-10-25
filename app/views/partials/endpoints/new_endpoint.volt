<div class="modal fade" id="create-new-endpoint-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" action="/endpoints/create">
                <div class="modal-header">
                    <h5 class="modal-title">Create new endpoint</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-7">
                            <p>Endpoint name</p>
                        </div>
                        <div class="col-lg-5">
                            <input class="form-control" name="endpoint-name" type="text" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-7">
                            <p>Activated</p>
                        </div>
                        <div class="col-lg-5">
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="isEnabled" type="checkbox" id="flexSwitchCheckDefault" value="1" checked>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-7">
                            <p>Require auth</p>
                        </div>
                        <div class="col-lg-5">
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="isAuthReq" type="checkbox" id="flexSwitchCheckDefault" value="1" checked>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-7">
                            <p>Dataset</p>
                        </div>
                        <div class="col-lg-5">
                            <div class="form-check form-switch">
                                Choose dataset... (later...){# TODO implement dataset selector when datasets can create#}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-7">
                            <p>URI</p>
                        </div>
                        <div class="col-lg-5">
                            <input class="form-control" name="endpoint-uri" type="text">
                            <small id="endpoint-uri-help" class="form-text text-muted">If you leave it empty we will generate automatically</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-7">
                            <p>Description</p>
                        </div>
                        <div class="col-lg-5">
                            <textarea class="form-control" name="endpoint-desc" rows="3" style="resize: none" maxlength="120"></textarea>
                            <small id="endpoint-uri-help" class="form-text text-muted">Max 120 character</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" name="createEndpoint" class="btn btn-primary" value="Save">
                </div>
            </form>
        </div>
    </div>
</div>