<div class="row">
    <div class="col-lg-12">
        <h2>Global endpoint</h2>
    </div>
</div>

{% for globalEndpoint in globalEndpoints %}
    <div class="row">
        <div class="col-lg-12">
            <div class="one-of-all clear" data-bs-toggle="modal" data-bs-target="#{{ globalEndpoint.endpoint_uri }}">
                <div class="title-of-list-element">
                    <h4>{{ globalEndpoint.endpoint_name }}</h4>
                </div>
                <div class="turn-on-section">
                    <div class="indicator {% if globalEndpoint.enabled %} green {% else %} red {% endif %}"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="{{ globalEndpoint.endpoint_uri }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" action="endpoints/edit?id={{ globalEndpoint.id }}">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ globalEndpoint.endpoint_name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-7">
                                <p>Activated</p>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" name="isEnabled" type="checkbox" id="flexSwitchCheckDefault" value="1" {% if  globalEndpoint.enabled %} checked {% endif %}>
                                </div>
                            </div>
                        </div>
                        {% if globalEndpoint.endpoint_type !=  2 %}
                            <div class="row">
                                <div class="col-lg-7">
                                    <p>Require authentication</p>
                                </div>
                                <div class="col-lg-5">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" name="isAuthReq" type="checkbox" id="flexSwitchCheckDefault" value="1" {% if  globalEndpoint.auth_req %} checked {% endif %}>
                                    </div>
                                </div>
                            </div>
                        {% endif %}
                        <div class="row">
                            <div class="col-lg-7">
                                <p>URI</p>
                            </div>
                            <div class="col-lg-5">
                                <input class="form-control" id="disabledInput" type="text" value="/apis/{{ user_uri }}/{{ globalEndpoint.endpoint_uri }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="globalSave" class="btn btn-primary" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>
{% endfor %}