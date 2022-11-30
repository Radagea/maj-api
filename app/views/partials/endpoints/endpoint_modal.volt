<div class="modal fade" tabindex="-1" aria-hidden="true" id="{{ endpoint.endpoint_uri }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ endpoint.endpoint_name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-base-tab-{{ endpoint.id }}" data-bs-toggle="tab" data-bs-target="#nav-base-{{ endpoint.id }}" type="button" role="tab" aria-controls="nav-base-{{ endpoint.id }}" aria-selected="true">Main</button>
                    <button class="nav-link" id="nav-authentication-tab-{{ endpoint.id }}" data-bs-toggle="tab" data-bs-target="#nav-authentication-{{ endpoint.id }}" type="button" role="tab" aria-controls="nav-authentication-{{ endpoint.id }}" aria-selected="false">Authentication</button>
                    <button class="nav-link" id="nav-methods-tab-{{ endpoint.id }}" data-bs-toggle="tab" data-bs-target="#nav-methods-{{ endpoint.id }}" type="button" role="tab" aria-controls="nav-methods-{{ endpoint.id }}" aria-selected="false">Methods</button>
                </div>
            </nav>
            <form method="post" action="endpoints/edit?id={{ endpoint.id }}">
                <div class="modal-body">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-base-{{ endpoint.id }}" role="tabpanel" aria-labelledby="nav-base-tab-{{ endpoint.id }}">
                            {{ partial('partials/endpoints/endpoint/main') }}
                        </div>
                        <div class="tab-pane fade" id="nav-authentication-{{ endpoint.id }}" role="tabpanel" aria-labelledby="nav-authentication-tab-{{ endpoint.id }}">
                            {{ partial('partials/endpoints/endpoint/authentication') }}
                        </div>
                        <div class="tab-pane fade" id="nav-methods-{{ endpoint.id }}" role="tabpanel" aria-labelledby="nav-methods-tab-{{ endpoint.id }}">
                            {{ partial('partials/endpoints/endpoint/methods') }}
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