{% extends lab07/layout.html.php %}

{% block title %}Danh sách nhân viên hiện tại{% endblock %}

{% block content %}

<h1 class="h3 my-5">Danh sách các nhân viên hiện có</h1>

<div class="row justify-content-end my-2">
    <div class="col">
        <a href="/employee/create" class="btn btn-primary me-2">Thêm mới</a>
        <a href="/department" class="btn btn-secondary" target="_blank">Cơ quan</a>
    </div>
</div>

<table class="table">
    <thead>
    <tr>
        <th scope="col">Id</th>
        <th scope="col">Tên</th>
        <th scope="col">Họ đệm</th>
        <th scope="col">Email</th>
        <th scope="col">Điện thoại</th>
        <th scope="col">Cơ quan</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>

    <?php foreach ($employees as $employee): ?>
        <tr id="employee-<?= $employee->id ?>">
            <th scope="row"><?= $employee->id ?></th>
            <td><?= $employee->name ?></td>
            <td><?= $employee->surname ?></td>
            <td><?= $employee->email ?></td>
            <td><?= $employee->phone ?></td>
            <td><?= $employee->get_department()->name ?? '--' ?></td>
            <td>
                <a href="/employee/show?id=<?= $employee->id ?>" class="btn btn-light me-2">Xem</a>
                <a href="/employee/edit?id=<?= $employee->id ?>" class="btn btn-warning me-2">Sửa</a>
                <a href="/employee/destroy?id=<?= $employee->id ?>"
                   data-employee="<?php echo htmlspecialchars(json_encode($employee), ENT_QUOTES, 'UTF-8'); ?>"
                   class="btn btn-danger btn-delete-employee">Xóa</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

{% endblock %}

<script>
    window.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-delete-employee').forEach(function (buttonElement) {
            buttonElement.addEventListener('click', function (e) {
                e.preventDefault();

                var employeeRaw = e.currentTarget.dataset.employee;
                var employee = JSON.parse(employeeRaw);
                
                var result = confirm('Bạn có chắc chắn muốn xóa nhân viên: ' + employee.surname + ' ' + employee.name + ' hay không?');
                if (!result)
                    return false;
                
                var formData = new FormData();
                formData.append('id', employee.id);

                fetch('/employee/destroy', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(result => {
                    document.getElementById('employee-' + employee.id).remove()
                })
                .catch(err => {
                    alert(err.message)
                })
            })
        })
    })
</script>
