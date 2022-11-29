let new_groups = 0;
let new_groups_arr = [];
let old_groups_arr = [];
let deleted_old_groups_arr = [];

$(document).ready(function () {
    if ($("#old-groups").val().length) {
        const values = $("#old-groups").val();
        old_groups_arr = values.split(",");
    }

    $("#addGroup").click(function (event) {
        event.preventDefault();
        makeRow();
    });

    function makeRow() {
        const newGroupId = "new-"+new_groups;
        const html_skeleton = `
            <tr>
                <th scope="row"></th>
                <td><input type="text" class="form-control" name="${newGroupId}-name" value=""></td>
                <td><input class="form-check-input" type="radio" name="default-user-group-radio" value="${newGroupId}"></td>
                <td>0</td>
                <td><button type="button" class="btn-close" id="${newGroupId}" name="remove-group-element-new" aria-label="Close"></button></td>
            </tr>
        `;
        $("#table-rows-user-group").append(html_skeleton);
        new_groups++;
        new_groups_arr.push(newGroupId);
        $("#new-groups").val(new_groups_arr);
    }

    $(document).on("click","[name='remove-group-element']", function() {
        $("#group-errors").empty();
        const id = $(this).attr('id');
        const default_group = $("[name='default-user-group-radio']:checked").val();
        if (id == default_group) {
            putError('You cant delete the default user group select another');
        } else {
            const index = old_groups_arr.indexOf(id);
            if (index > -1) {
                old_groups_arr.splice(index, 1);
            }
            $("#old-groups").val(old_groups_arr);
            deleted_old_groups_arr.push(id);
            $("#deleted-old-groups").val(deleted_old_groups_arr);
            $(this).parent().parent().remove();
        }
    });

    $(document).on("click","[name='remove-group-element-new']", function() {
        const id = $(this).attr('id');
        const index = new_groups_arr.indexOf(id);
        if (index > -1) {
            new_groups_arr.splice(index, 1);
        }
        $("#new-groups").val(new_groups_arr);

        $(this).parent().parent().remove();
    });

    function putError(message) {
        const html = `<div class="alert alert-danger">${message}</div>`
        $("#group-errors").append(html);
    }
});