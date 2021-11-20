{% extends lab07/layout.html.php %}

{% block title %}Danh sách nhân viên hiện tại{% endblock %}

{% block content %}

<form action="" method="POST">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <h1 class="h3 my-5">Thêm nhân viên mới</h1>

            <div>
                <div class="row g-3">
                    <div class="form-floating mb-3 col-md-8">
                        <input type="text" class="form-control" id="surname" placeholder="Họ đệm"
                               name="employee[surname]"
                               autocomplete="off">
                        <label for="surname">Họ đệm</label>
                    </div>
                    <div class="form-floating mb-3 col-md-4">
                        <input type="text" class="form-control" id="name" name="employee[name]" placeholder="Tên"
                               autocomplete="off">
                        <label for="name">Tên</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingInput" name="employee[email]"
                               placeholder="Email"
                               autocomplete="off">
                        <label for="floatingInput">Email</label>
                    </div>
                    <div class="form-floating">
                        <input type="text" class="form-control" id="phone" name="employee[phone]"
                               placeholder="Điện thoại">
                        <label for="phone">Điện thoại</label>
                    </div>
                    <div class="mb-3">
                        <button class="btn-primary btn me-2" name="submit">Thêm nhân viên</button>
                        <a href="/employee" class="btn-secondary btn">Quay về</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <h2 class="h3 my-5">Danh sách phòng ban</h2>

            <div action="">
                <div style="max-height: 120px; overflow-y: scroll">
                    <?php foreach ($departments as $department): ?>
                        <div class="form-check">
                            <input value="<?= $department->id ?>" class="form-check-input" type="radio" name="employee[department_id]"
                                   id="department-<?= $department->id ?>">
                            <label class="form-check-label" for="department-<?= $department->id ?>">
                                <?= $department->name ?>
                            </label>
                        </div>
                        <div id="new-department-container"></div>
                    <?php endforeach; ?>
                </div>
                <div class="mb-3 mt-5">
                    <label class="form-label" for="new-department">Thêm mới</label>
                    <input type="text" class="form-control" id="new-department">
                </div>
                <div class="mb-3">
                    <button class="btn btn-success" id="add-new-department" type="submit">Thêm</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var newDepartmentInputElement = document.getElementById('new-department');
        var addNewDepartmentButtonElement = document.getElementById('add-new-department');
        var newDepartmentDivContainer = document.getElementById('new-department-container');

        addNewDepartmentButtonElement.addEventListener('click', function (e) {
            e.preventDefault();

            addNewDepartmentButtonElement.disabled = true;
            addNewDepartmentButtonElement.innerHTML = 'Đang thêm...';

            var form = new FormData();
            form.append('department[name]', newDepartmentInputElement.value);

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
                            <div class="form-check">
                                <input value="${newDepartmentId}" class="form-check-input" type="radio" name="employee[department_id]" id="department-${newDepartmentId}" checked>
                                <label class="form-check-label" for="department-${newDepartmentId}">
                                    ${newDepartmentTitle}
                                </label>
                            </div>
                        `;

                        newDepartmentDivContainer.insertAdjacentHTML('afterend', html);
                    }
                    console.log(result);

                    newDepartmentInputElement.value = '';
                    addNewDepartmentButtonElement.disabled = false;
                    addNewDepartmentButtonElement.innerHTML = 'Thêm';
                })
                .catch(err => {
                    console.log(err);
                    alert('Error: ' + err.message);

                    addNewDepartmentButtonElement.disabled = false;
                    addNewDepartmentButtonElement.innerHTML = 'Thêm';
                })
        })
    })
</script>

{% endblock %}
