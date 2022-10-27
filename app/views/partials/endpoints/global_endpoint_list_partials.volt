<div class="modal fade" id="{{ globalEndpoint.endpoint_uri }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ globalEndpoint.endpoint_name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="{{ globalEndpoint.endpoint_uri }}-nav-base-tab" data-bs-toggle="tab" data-bs-target="#{{ globalEndpoint.endpoint_uri }}-nav-base" type="button" role="tab" aria-controls="{{ globalEndpoint.endpoint_uri }}-nav-base" aria-selected="true">Main</button>
                    {% if globalEndpoint.endpoint_type == 2 %}
                        <button class="nav-link" id="{{ globalEndpoint.endpoint_uri }}-nav-settings-tab" data-bs-toggle="tab" data-bs-target="#{{ globalEndpoint.endpoint_uri }}-nav-settings" type="button" role="tab" aria-controls="{{ globalEndpoint.endpoint_uri }}-nav-settings" aria-selected="false">Settings</button>
                        <button class="nav-link" id="{{ globalEndpoint.endpoint_uri }}-nav-user-groups-tab" data-bs-toggle="tab" data-bs-target="#{{ globalEndpoint.endpoint_uri }}-nav-user-groups" type="button" role="tab" aria-controls="{{ globalEndpoint.endpoint_uri }}-nav-user-groups" aria-selected="false">User groups</button>
                    {% else %}
                        <button class="nav-link" id="{{ globalEndpoint.endpoint_uri }}-nav-authentication-tab" data-bs-toggle="tab" data-bs-target="#{{ globalEndpoint.endpoint_uri }}-nav-authentication" type="button" role="tab" aria-controls="{{ globalEndpoint.endpoint_uri }}-nav-authentication" aria-selected="false">Authentication</button>
                    {% endif %}
                </div>
            </nav>
            <form method="post" action="endpoints/edit?id={{ globalEndpoint.id }}">
                <div class="modal-body">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="{{ globalEndpoint.endpoint_uri }}-nav-base" role="tabpanel" aria-labelledby="{{ globalEndpoint.endpoint_uri }}-nav-base-tab">
                            {{ partial('partials/endpoints/globals/base') }}
                        </div>
                        {% if globalEndpoint.endpoint_type == 2 %}
                            <div class="tab-pane fade" id="{{ globalEndpoint.endpoint_uri }}-nav-settings" role="tabpanel" aria-labelledby="{{ globalEndpoint.endpoint_uri }}-nav-settings-tab">
                                {{ partial('partials/endpoints/globals/settings') }}
                            </div>
                            <div class="tab-pane fade" id="{{ globalEndpoint.endpoint_uri }}-nav-user-groups" role="tabpanel" aria-labelledby="{{ globalEndpoint.endpoint_uri }}-nav-user-groups-tab">
                                {{ partial('partials/endpoints/globals/user_groups') }}
                            </div>
                        {% else %}
                            <div class="tab-pane fade" id="{{ globalEndpoint.endpoint_uri }}-nav-authentication" role="tabpanel" aria-labelledby="{{ globalEndpoint.endpoint_uri }}-nav-authentication-tab">
                                {{ partial('partials/endpoints/globals/authentication') }}
                            </div>
                        {% endif %}
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" name="globalSave" class="btn btn-primary" value="Save">
                </div>
            </form>
        </div>
    </div>
</div>