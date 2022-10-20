<div class="row row-cols-1 row-cols-md-3 g-4">
    {% for endpoint in endpointsTest %}
        <div class="col">
            <div class="card custom-endpoint-card {% if endpoint['enabled'] %} custom-endpoint-card--active {% else %} custom-endpoint-card--inactive {% endif %}">
                <div class="card-body">
                    <h5 class="card-title">{{ endpoint['title'] }}</h5>
                    <p class="card-text">
                        {{ endpoint['desc'] }}
                    </p>
                </div>
            </div>
        </div>
    {% endfor %}
</div>