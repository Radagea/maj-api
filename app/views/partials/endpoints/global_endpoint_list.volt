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

    {{ partial('partials/endpoints/global_endpoint_list_partials') }}
{% endfor %}
