<div class="row">
    <div class="col-lg-7">
        <p>Activated</p>
    </div>
    <div class="col-lg-5">
        <div class="form-check form-switch">
            <input class="form-check-input" name="isEnabled" type="checkbox" id="flexSwitchCheckDefault"
                   value="1" <?php if ($globalEndpoint->enabled) { ?> checked <?php } ?>>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-7">
        <p>URI</p>
    </div>
    <div class="col-lg-5">
        <input class="form-control" id="disabledInput" type="text"
               value="/apis/<?= $user_uri ?>/<?= $globalEndpoint->endpoint_uri ?>" disabled>
    </div>
</div>
