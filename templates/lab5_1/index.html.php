<div class="container">
    <h1 class="text-center my-5">Máy tính AJAX</h1>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="">
                <div class="mb-3">
                    <label class="form-label">Số 1</label>
                    <input type="text" name="" id="so_1" class="form-control" autocomplete="off">
                </div>
                <div class="mb-3">
                    <label class="form-label">Số 2</label>
                    <input type="text" name="" id="so_2" class="form-control" autocomplete="off">
                </div>
                <div class="mb-3">
                    <label class="form-label">Phép tính</label>
                    <select name="" id="phep_tinh" class="form-select">
                        <option value="">Chọn phép tính</option>
                        <option value="+">+</option>
                        <option value="-">-</option>
                        <option value="*">*</option>
                        <option value="/">/</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kết quả</label>
                    <input type="text" name="" id="ket_qua" class="form-control" readonly>
                </div>
                <hr>
                <div class="mb-3">
                    <button class="btn btn-primary w-100" type="button" id="btn_calculate">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                        <span class="form-label">Tính toán</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var calculateButtonElement = document.getElementById('btn_calculate')
    var firstOperandInputElement = document.getElementById('so_1')
    var secondOperandInputElement = document.getElementById('so_2')
    var operatorSelectElement = document.getElementById('phep_tinh')
    var resultInputElement = document.getElementById('ket_qua')

    function enableCalculateButton() {
        calculateButtonElement.disabled = false
        calculateButtonElement.querySelector('.spinner-border').hidden = true
        calculateButtonElement.querySelector('.form-label').innerHTML = 'Tính toán'
    }

    function disableCalculateButton() {
        calculateButtonElement.disabled = true
        calculateButtonElement.querySelector('.spinner-border').hidden = false
        calculateButtonElement.querySelector('.form-label').innerHTML = 'Đang tính...'
    }

    function showResult(result) {
        resultInputElement.value = result
    }

    function clearFormInput() {
        calculateButtonElement.value = ''
        firstOperandInputElement.value = ''
        secondOperandInputElement.value = ''
        operatorSelectElement.value = ''

        operatorSelectElement.querySelectorAll('option').forEach(function(option) {
            option.removeAttribute('selected')
        })
    }

    function handleOnCalculateButtonPress() {
        var firstOperand = firstOperandInputElement.value ?? 0
        var secondOperand = secondOperandInputElement.value ?? 0
        var operator = operatorSelectElement.value ?? null

        if (!operator) return alert('Chọn phép tính')

        var ajaxData = {
            first_operand: firstOperand,
            second_operand: secondOperand,
            operator: operator
        }

        console.log(ajaxData)

        var ajaxUrl = '/'
        var ajaxMethod = 'POST'

        sendAjax(ajaxData, ajaxUrl, ajaxMethod)
    }

    function sendAjax(data, url, method) {

        disableCalculateButton()

        fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                console.log(result)
                if (result.status === "success") {
                    showResult(result.data.result)
                } else {
                    alert('Error: ' + result.message)
                }

                enableCalculateButton()
            })
            .catch(err => {
                alert('Error! ' + err.message)
                enableCalculateButton()
                console.log(err)
            })
    }

    window.addEventListener('DOMContentLoaded', function() {
        calculateButtonElement.onclick = handleOnCalculateButtonPress
    })
</script>
