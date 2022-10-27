<div class="row">
    <div class="col-lg-12">
        <h2>Global endpoint</h2>
    </div>
</div>

{{ partial('partials/endpoints/global_endpoint_list') }}

<div class="row">
    <div class="col-lg-12">
        <div class="title-of-list-element">
            <h2>Endpoints <span class="endpoint-count">{{ endpointCount }}/15</span></h2>
        </div>
        <div class="add-new-endpoint">
            {% if endpointCount < 15 %}
                <i class="bi bi-plus-square" data-bs-toggle="modal" data-bs-target="#create-new-endpoint-modal"></i>
            {% endif %}
        </div>
    </div>
</div>

{{ partial('partials/endpoints/new_endpoint') }}

{{ partial('partials/endpoints/endpoint_list') }}
