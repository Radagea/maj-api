<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link<?php if ($this->router->getControllerName() == 'index' || $this->router->getControllerName() == '') { ?> active<?php } ?>" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?php if ($this->router->getControllerName() == 'endpoints') { ?> active<?php } ?>" href="/endpoints">Endpoints</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?php if ($this->router->getControllerName() == 'datasets') { ?> active<?php } ?>" href="/datasets">Datasets</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?php if ($this->router->getControllerName() == 'security') { ?> active<?php } ?>" href="/security">Security</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?php if ($this->router->getControllerName() == 'apicaller') { ?> active<?php } ?>" href="/api-caller">API Caller</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if ($this->session->has('username')) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">Logout <?= $this->session->get('username') ?> </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>
