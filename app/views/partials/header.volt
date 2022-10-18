<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item {% if router.getControllerName() == 'index' or router.getControllerName() == '' %} active {% endif %}">
                <a class="nav-link" href="/">Home</a>
            </li>
            <li class="nav-item {% if router.getControllerName() == 'endpoints' %} active {% endif %}">
                <a class="nav-link" href="/endpoints">Endpoints</a>
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
</nav>