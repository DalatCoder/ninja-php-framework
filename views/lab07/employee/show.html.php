{% extends lab07/layout.html.php %}

{% block title %}Thông tin chi tiết nhân viên{% endblock %}

{% block content %}

<form action="" method="POST">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <h1 class="h3 my-5">Thông tin nhân viên #<?= $employee->id ?></h1>

            <div>
                <div class="row g-3">
                    <div class="form-floating mb-3 col-md-8">
                        <input type="text" class="form-control" id="surname" placeholder="Họ đệm"
                               name="employee[surname]"
                               autocomplete="off" value="<?= $employee->surname ?>">
                        <label for="surname">Họ đệm</label>
                    </div>
                    <div class="form-floating mb-3 col-md-4">
                        <input type="text" class="form-control" id="name" name="employee[name]" placeholder="Tên"
                               autocomplete="off" value="<?= $employee->name ?>">
                        <label for="name">Tên</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingInput" name="employee[email]"
                               placeholder="Email"
                               autocomplete="off" value="<?= $employee->email ?>">
                        <label for="floatingInput">Email</label>
                    </div>
                    <div class="form-floating">
                        <input type="text" class="form-control" id="phone" name="employee[phone]"
                               placeholder="Điện thoại" value="<?= $employee->phone ?>">
                        <label for="phone">Điện thoại</label>
                    </div>
                    <div class="form-floating">
                        <input type="text" class="form-control" id="phone" name="employee[phone]"
                               placeholder="Điện thoại" value="<?= $employee->get_department()->name ?? '--' ?>">
                        <label for="phone">Phòng ban</label>
                    </div>
                    <div class="mb-3">
                        <a href="/employee" class="btn btn-secondary">Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

{% endblock %}
