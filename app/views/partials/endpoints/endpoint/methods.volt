<div class="row">
    <div class="col-lg-7">
        <p>Enable GET</p>
    </div>
    <div class="col-lg-5">
        <div class="form-check form-switch">
            <input class="form-check-input" name="isGetEnabled" type="checkbox" id="flexSwitchCheckDefault" value="1" {% if endpoint.enabled_get %} checked {% endif %}>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-7">
        <p>Enable POST</p>
    </div>
    <div class="col-lg-5">
        <div class="form-check form-switch">
            <input class="form-check-input" name="isPostEnabled" type="checkbox" id="flexSwitchCheckDefault" value="1" {% if endpoint.enabled_post %} checked {% endif %}>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-7">
        <p>Enable PUT</p>
    </div>
    <div class="col-lg-5">
        <div class="form-check form-switch">
            <input class="form-check-input" name="isPutEnabled" type="checkbox" id="flexSwitchCheckDefault" value="1" {% if endpoint.enabled_put %} checked {% endif %}>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-7">
        <p>Enable DELETE</p>
    </div>
    <div class="col-lg-5">
        <div class="form-check form-switch">
            <input class="form-check-input" name="isDeleteEnabled" type="checkbox" id="flexSwitchCheckDefault" value="1" {% if endpoint.enabled_delete %} checked {% endif %}>
        </div>
    </div>
</div>