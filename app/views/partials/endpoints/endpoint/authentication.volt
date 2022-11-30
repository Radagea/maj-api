<div class="row">
    <div class="col-lg-7">
        <p>Require auth</p>
    </div>
    <div class="col-lg-5">
        <div class="form-check form-switch">
            <input class="form-check-input" name="isAuthReq" type="checkbox" id="flexSwitchCheckDefault" value="1" {% if  endpoint.auth_req %} checked {% endif %}>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <table class="table" style="text-align:center">
                <thead>
                <tr>
                    <th scope="col">Unique identifier</th>
                    <th scope="col">Group name</th>
                    <th scope="col">GET</th>
                    <th scope="col">POST</th>
                    <th scope="col">PUT</th>
                    <th scope="col">DELETE</th>
                </tr>
                </thead>
                <tbody id="ge-user-group-list">
                {% for group in user_groups %}
                    <tr>
                        <th scope="col">{{ group.unique_identifier }}</th>
                        <th scope="col">{{ group.name }}</th>
                        <th scope="col"><input type="checkbox" name="group-get-{{ endpoint.id }}-{{ group.id }}"></th>
                        <th scope="col"><input type="checkbox" name="group-post-{{ endpoint.id }}-{{ group.id }}"></th>
                        <th scope="col"><input type="checkbox" name="group-put-{{ endpoint.id }}-{{ group.id }}"></th>
                        <th scope="col"><input type="checkbox" name="group-delete-{{ endpoint.id }}-{{ group.id }}" ></th>
                    </tr>
                {% endfor %}
                </tbody>
            </table>
        </div>
    </div>
</div>