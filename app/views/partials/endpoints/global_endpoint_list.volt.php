<?php foreach ($globalEndpoints as $globalEndpoint) { ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="one-of-all clear" data-bs-toggle="modal" data-bs-target="#<?= $globalEndpoint->endpoint_uri ?>">
                <div class="title-of-list-element">
                    <h4><?= $globalEndpoint->endpoint_name ?></h4>
                </div>
                <div class="turn-on-section">
                    <div class="indicator <?php if ($globalEndpoint->enabled) { ?> green <?php } else { ?> red <?php } ?>"></div>
                </div>
            </div>
        </div>
    </div>

    <?= $this->partial('partials/endpoints/global_endpoint_list_partials') ?>
<?php } ?>
