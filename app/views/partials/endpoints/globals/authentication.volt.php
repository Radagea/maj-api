<?php if ($globalEndpoint->endpoint_type != 2) { ?>
    <div class="row">
        <div class="col-lg-10">
            <p>Require authentication</p>
        </div>
        <div class="col-lg-2">
            <div class="form-check form-switch">
                <input class="form-check-input" name="isAuthReq" type="checkbox" id="flexSwitchCheckDefault" value="1" <?php if ($globalEndpoint->auth_req) { ?> checked <?php } ?>>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <table class="table" style="text-align:center">
                <thead>
                <tr>
                    <th scope="col">Unique identifier</th>
                    <th scope="col">Group name</th>
                    <th scope="col">Allowed</th>
                </tr>
                </thead>
                <tbody id="ge-user-group-list">
                    <?php foreach ($user_groups as $group) { ?>
                        <tr>
                            <th scope="col"><?= $group->unique_identifier ?></th>
                            <th scope="col"><?= $group->name ?></th>
                            <th scope="col"><input type="checkbox" name="group-allow-<?= $globalEndpoint->id ?>-<?= $group->id ?>" <?php if (in_array($group->id, $globalEndpoint->group_settings)) { ?> checked <?php } ?>></th>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } ?>