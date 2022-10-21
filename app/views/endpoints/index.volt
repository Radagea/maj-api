<div class="row">
    <div class="col-lg-12">
        <h2>Global endpoint</h2>
    </div>
</div>

{{ partial('partials/endpoints/global_endpoint_list') }}

<div class="row">
    <div class="col-lg-12">
        <div class="title-of-list-element">
            <h2>Endpoints</h2>
        </div>
        <div class="add-new-endpoint">
            <i class="bi bi-plus-square" data-bs-toggle="modal" data-bs-target="#create-new-endpoint-modal"></i>
        </div>
    </div>
</div>

{{ partial('partials/endpoints/new_endpoint') }}

{{ partial('partials/endpoints/endpoint_list') }}