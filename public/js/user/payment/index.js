
function paymentTypeChange(event){
    let totalElement= document.getElementById('total');
    let subTotalElement= document.getElementById('subTotalDiv');
    let subtotalInput= document.getElementById('subTotal').value;
    let discount= document.getElementById('discount').innerText;
    let downPaymentElement= document.getElementById('downPaymentDiv');
    let dowPaymentInput= document.getElementById('downPayment');
    let selectVoucher= document.getElementById('selectVoucher');
    let defaultOption = selectVoucher.querySelector('option[value="0"]');


    //trả full
    if (event.currentTarget.value==='1'){
        $('#downPaymentContainer').addClass('hidden');
        $('#subTotalDivContainer').removeClass('text-gray-500');

        if (selectVoucher){
            selectVoucher.disabled = false;
        }
        dowPaymentInput.value=0;
        downPaymentElement.innerText=0;
        totalElement.innerText=numberFormat(convertStringToNumber(subTotalElement.innerText)-discount);
    }else {
        // trả 20%
        if (selectVoucher){
            selectVoucher.disabled = true;
            defaultOption.selected =true;
        }
        dowPaymentInput.value=(subtotalInput*0.2);
        downPaymentElement.innerText=numberFormat(subtotalInput*0.2);
        $('#downPaymentContainer').removeClass('hidden');
        $('#subTotalDivContainer').addClass('text-gray-500');
        totalElement.innerText=numberFormat(convertStringToNumber(subTotalElement.innerText)*0.2);
        document.getElementById('discount').innerText='0';
        document.getElementById('user_voucher_id').value=0
    }

}

function  paymentMethodChange(){
    const form = document.getElementById('form_payment');
    const stripeCheckbox = document.querySelector('input[value="stripe"]');
    const momoCheckbox = document.querySelector('input[value="momo"]');
    const stripeContainer = document.getElementById('stripeContainer');
    const momoContainer = document.getElementById('momoContainer');
    if (stripeCheckbox.checked) {
        form.action =STRIPE_URL;
        stripeContainer.classList.add('border-green-500');
        momoContainer.classList.remove('border-green-500');
    } else if (momoCheckbox.checked) {
        form.action = MOMO_URL;
        momoContainer.classList.add('border-green-500');
        stripeContainer.classList.remove('border-green-500');
    }
}

function chooseStripe(){
    $('#stripeOption').prop('checked', true);
    paymentMethodChange();
}
function chooseMomo(){
    $('#momoOption').prop('checked', true);
    paymentMethodChange();
}



function voucherSelectOnchange(selectElement) {
    const userVoucherId=selectElement.value;
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const price = selectedOption.getAttribute('price')??0;
    document.getElementById('discount').innerText = numberFormat(parseFloat(price));
    document.getElementById('user_voucher_id').value=userVoucherId;
    let total= document.getElementById('total');
    let subTotal= document.getElementById('subTotal');
    total.innerText=numberFormat(parseFloat(subTotal.value)-parseFloat(price));
}

$(document).ready(function () {
    let selectVoucher= document.getElementById('selectVoucher')??null;
    let reservationId= document.getElementById('reservationId').value;
    if (selectVoucher){
        const defaultOption = selectVoucher.querySelector('option[value="0"]');
        defaultOption.selected =true;
    }
    $('#momoOption').prop('checked', true);
    $('#payment_type').val('1');

    console.log(reservationId);
    // Kiểm tra xem bộ đếm ngược đã được lưu trong localStorage chưa
    let timeRemaining = localStorage.getItem('timeRemaining-'+reservationId) ? parseInt(localStorage.getItem('timeRemaining-'+reservationId)) : 10*60;

    const countdownElement = document.getElementById('countdown');

    function updateCountdown() {
        const minutes = Math.floor(timeRemaining / 60);
        const seconds = timeRemaining % 60;
        countdownElement.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

        if (timeRemaining > 0) {
            timeRemaining--;
            localStorage.setItem('timeRemaining-'+reservationId, timeRemaining);
        } else {
            localStorage.clear();
            //hủy thanh toán
            document.getElementById('form-cancel').submit();
        }
    }
    setInterval(updateCountdown, 1000);
});

//thêm dấu chấm vào số tiền vs 1000-> 1.000
function numberFormat(number) {
    if (typeof number !== 'number') {
        throw new Error('Input must be a number');
    }
    let numberStr = number.toString();

    if (numberStr.endsWith('000')) {
        return numberStr.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }
    return numberStr.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

function convertStringToNumber(input) {
    // Loại bỏ dấu phẩy bằng cách sử dụng phương thức replace
    const sanitizedString = input.replace(/,/g, '');
    // Chuyển đổi chuỗi thành số
    const result = Number(sanitizedString);

    // Kiểm tra kết quả và trả về
    if (isNaN(result)) {
      console.log('convert string to number error')
    }
    return result;
}


