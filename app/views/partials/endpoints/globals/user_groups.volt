<div class="row">
    <div class="col-lg-12" >
        <div id="group-errors">

        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Unique identifier</th>
                    <th scope="col">Group name</th>
                    <th scope="col">Default</th>
                    <th scope="col">Count</th>
                    <th scope="col">#</th>
                </tr>
            </thead>
            <tbody id="table-rows-user-group">
                {% for group in user_groups  %}
                    <tr>
                        <th scope="row">{{ group.unique_identifier }}</th>
                        <td><input type="text" class="form-control" name="{{ group.unique_identifier }}-name" value="{{ group.name }}"></td>
                        <td><input class="form-check-input" type="radio" name="default-user-group-radio" value="{{ group.unique_identifier }}" {% if group.is_default %}checked{% endif %}></td>
                        <td>{{ group.count }}</td>
                        <td><button type="button" class="btn-close" id="{{ group.unique_identifier }}" name="remove-group-element" aria-label="Close"></button></td>
                    </tr>
                {% endfor %}
            </tbody>
        </table>
        <input type="hidden" name="new-groups" id="new-groups" value="">
        <input type="hidden" name="deleted-old-groups" id="deleted-old-groups" value="">
        <input type="hidden" name="old-groups" id="old-groups" value="{{ old_groups_id }}">
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <button class="btn btn-primary float-end" id="addGroup">Add user group</button>
    </div>
</div>