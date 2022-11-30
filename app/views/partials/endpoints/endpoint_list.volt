<div class="row row-cols-1 row-cols-md-3 g-4">
    {% for endpoint in endpointsTest %}
        <div class="col">
            <div class="card custom-endpoint-card {% if endpoint.enabled %} custom-endpoint-card--active {% else %} custom-endpoint-card--inactive {% endif %}" data-bs-toggle="modal" data-bs-target="#{{ endpoint.endpoint_uri }}">
                <div class="card-body">
                    <h5 class="card-title">{{ endpoint.endpoint_name }}</h5>
                    <p class="card-text">
                        {{ endpoint.description }}
                    </p>
                </div>
            </div>
        </div>

        {{ partial('partials/endpoints/endpoint_modal') }}
    {% endfor %}
</div>
