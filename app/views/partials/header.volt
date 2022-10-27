<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link{% if router.getControllerName() == 'index' or router.getControllerName() == '' %} active{% endif %}" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link{% if router.getControllerName() == 'endpoints' %} active{% endif %}" href="/endpoints">Endpoints</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link{% if router.getControllerName() == 'datasets' %} active{% endif %}" href="/datasets">Datasets</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link{% if router.getControllerName() == 'security' %} active{% endif %}" href="/security">Security</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link{% if router.getControllerName() == 'apicaller' %} active{% endif %}" href="/api-caller">API Caller</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                {% if session.has('username') %}
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">Logout {{ session.get('username') }} </a>
                    </li>
                {% endif %}
            </ul>
        </div>
    </div>
</nav>
