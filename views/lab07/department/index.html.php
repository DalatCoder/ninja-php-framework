{% extends lab07/layout.html.php %}

{% block title %}Danh sách văn phòng hiện tại{% endblock %}

{% block content %}

<h1 class="h3 my-5">Danh sách các văn phòng hiện có</h1>

<div class="row my-2">
    <div class="col-md-5">
        <form action="">
            <div class="mb-3">
                <label for="department-name" class="form-label">Tên VP</label>
                <input type="text" id="department-name" class="form-control">
            </div>
            <div class="mb-3">
                <button class="btn btn-primary" id="btn-add-new-department">Thêm mới</button>
            </div>
        </form>
    </div>
</div>

<table class="table">
    <thead>
    <tr>
        <th scope="col">Id</th>
        <th scope="col">Tên</th>
        <th scope="col">Số nhân viên</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody id="department-container">
    <?php foreach ($departments as $department): ?>
        <tr>
            <th scope="row"><?= $department->id ?></th>
            <td><?= $department->name ?></td>
            <td><?= count($department->get_employees()) ?></td>
            <td>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

{% endblock %}

<script>
    window.addEventListener('DOMContentLoaded', function () {
        var addNewDepartmentButton = document.getElementById('btn-add-new-department');
        var newDepartmentDivContainer = document.getElementById('department-container');

        addNewDepartmentButton.addEventListener('click', function (e) {
            e.preventDefault();
            addNewDepartmentButton.disabled = true;
            addNewDepartmentButton.innerHTML = 'Đang thêm...';

            var department_name = document.getElementById('department-name').value;
            var form = new FormData();
            form.append('department[name]', department_name);

            fetch('/department/create', {
                method: 'POST',
                body: form
            })
            .then(res => res.json())
            .then(result => {
                if (result.status === 'success') {

                    var newDepartmentId = result.data.id;
                    var newDepartmentTitle = result.data.title;

                    var html = `
                        <tr>
                            <th scope="row">${newDepartmentId}</th>
                            <td>${newDepartmentTitle}</td>
                            <td>0</td>
                            <td></td>
                        </tr>
                    `;

                    newDepartmentDivContainer.insertAdjacentHTML('afterbegin', html);
                }
                console.log(result);

                document.getElementById('department-name').value = '';
                addNewDepartmentButton.disabled = false;
                addNewDepartmentButton.innerHTML = 'Thêm';
            })
        })

    })
</script>
