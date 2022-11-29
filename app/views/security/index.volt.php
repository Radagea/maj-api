<div class="row">
    <div class="col-lg-12">
        <div class="title-of-list-element">
            <h2>IP Filtering</h2>
        </div>
        <div class="add-new-endpoint">
            <i class="bi bi-plus-square" data-bs-toggle="modal" data-bs-target="#add-new-ip-modal"></i>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <p>If you leave it blank every IP address will be accepted.</p>
    </div>
</div>
<div class="row">
    <table class="table table-hover" style="text-align: center">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">IP</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($securityips as $ip) { ?>
                <tr>
                    <td><?= $ip->name ?></td>
                    <td><?= $ip->ip ?></td>
                    <td><a type="button" href="security/deleteip?ip_id=<?= $ip->id ?>" class="btn-close"></a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="add-new-ip-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" action="/security/addip">
                <div class="modal-header">
                    <h5 class="modal-title">Add new IP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-7">
                            <p>Name</p>
                        </div>
                        <div class="col-lg-5">
                            <input class="form-control" name="ip-name" type="text" required placeholder="Server 1">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-7">
                            <p>IP</p>
                        </div>
                        <div class="col-lg-5">
                            <input class="form-control" name="ip-address" type="text" required placeholder="127.0.0.1">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" name="add-ip" class="btn btn-primary" value="Save">
                </div>
            </form>
        </div>
    </div>
</div>