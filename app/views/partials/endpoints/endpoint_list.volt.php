<div class="row row-cols-1 row-cols-md-3 g-4">
    <?php foreach ($endpointsTest as $endpoint) { ?>
        <div class="col">
            <div class="card custom-endpoint-card <?php if ($endpoint->enabled) { ?> custom-endpoint-card--active <?php } else { ?> custom-endpoint-card--inactive <?php } ?>" data-bs-toggle="modal" data-bs-target="#<?= $endpoint->endpoint_uri ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $endpoint->endpoint_name ?></h5>
                    <p class="card-text">
                        <?= $endpoint->description ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" aria-hidden="true" id="<?= $endpoint->endpoint_uri ?>">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="post" action="endpoints/edit?id=<?= $endpoint->id ?>">
                        <div class="modal-header">
                            <h5 class="modal-title"><?= $endpoint->endpoint_name ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-7">
                                    <p>Endpoint name</p>
                                </div>
                                <div class="col-lg-5">
                                    <input class="form-control" name="endpoint-name" type="text" required value="<?= $endpoint->endpoint_name ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-7">
                                    <p>Activated</p>
                                </div>
                                <div class="col-lg-5">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" name="isEnabled" type="checkbox" id="flexSwitchCheckDefault" value="1" <?php if ($endpoint->enabled) { ?> checked <?php } ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-7">
                                    <p>Require auth</p>
                                </div>
                                <div class="col-lg-5">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" name="isAuthReq" type="checkbox" id="flexSwitchCheckDefault" value="1" <?php if ($endpoint->auth_req) { ?> checked <?php } ?>>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-7">
                                    <p>Dataset</p>
                                </div>
                                <div class="col-lg-5">
                                    <div class="form-check form-switch">
                                        Choose dataset... (later...)
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-7">
                                    <p>URI</p>
                                </div>
                                <div class="col-lg-5">
                                    <input class="form-control" name="endpoint-uri" type="text" value="<?= $endpoint->endpoint_uri ?>">
                                    <small id="endpoint-uri-help" class="form-text text-muted">If you leave it empty we will generate automatically</small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-7">
                                    <p>Current URI</p>
                                </div>
                                <div class="col-lg-5">
                                    <input class="form-control" name="endpoint-uri" type="text" value="/apis/<?= $user_uri ?>/<?= $endpoint->endpoint_uri ?>" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-7">
                                    <p>Description</p>
                                </div>
                                <div class="col-lg-5">
                                    <textarea class="form-control" name="endpoint-desc" rows="3" style="resize: none" maxlength="120"><?= $endpoint->description ?></textarea>
                                    <small id="endpoint-uri-help" class="form-text text-muted">Max 120 character</small>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" name="endpointDelete" class="btn btn-danger" value="Delete">
                            <input type="submit" name="endpointSave" class="btn btn-primary" value="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
