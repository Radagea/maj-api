<div class="row">
    <div class="col-lg-7">
        <p>Endpoint name</p>
    </div>
    <div class="col-lg-5">
        <input class="form-control" name="endpoint-name" type="text" required value="{{ endpoint.endpoint_name }}">
    </div>
</div>
<div class="row">
    <div class="col-lg-7">
        <p>Activated</p>
    </div>
    <div class="col-lg-5">
        <div class="form-check form-switch">
            <input class="form-check-input" name="isEnabled" type="checkbox" id="flexSwitchCheckDefault" value="1" {% if  endpoint.enabled %} checked {% endif %}>
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
        <input class="form-control" name="endpoint-uri" type="text" value="{{ endpoint.endpoint_uri }}">
        <small id="endpoint-uri-help" class="form-text text-muted">If you leave it empty we will generate automatically</small>
    </div>
</div>
<div class="row">
    <div class="col-lg-7">
        <p>Current URI</p>
    </div>
    <div class="col-lg-5">
        <input class="form-control" name="endpoint-uri" type="text" value="/apis/{{ user_uri }}/{{ endpoint.endpoint_uri }}" disabled>
    </div>
</div>
<div class="row">
    <div class="col-lg-7">
        <p>Description</p>
    </div>
    <div class="col-lg-5">
        <textarea class="form-control" name="endpoint-desc" rows="3" style="resize: none" maxlength="120">{{ endpoint.description }}</textarea>
        <small id="endpoint-uri-help" class="form-text text-muted">Max 120 character</small>
    </div>
</div>