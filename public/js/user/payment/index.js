
function paymentTypeChange(event){
    let totalElement= document.getElementById('total');
    let subTotalElement= document.getElementById('subTotalDiv');
    let subtotalInput= document.getElementById('subTotal').value;
    let discount= document.getElementById('discount').innerText;
    let downPaymentElement= document.getElementById('downPaymentDiv');
    let dowPaymentInput= document.getElementById('downPayment');
    let selectVoucher= document.getElementById('selectVoucher');
    const defaultOption = selectVoucher.querySelector('option[value="0"]');

    //trả full
    if (event.currentTarget.value==='1'){
        $('#downPaymentContainer').addClass('hidden');
        $('#subTotalDivContainer').removeClass('text-gray-500');

        selectVoucher.disabled = false;
        dowPaymentInput.value=0;
        downPaymentElement.innerText=0;
        totalElement.innerText=subTotalElement.innerText-discount;
    }else {
        // trả 20%
        selectVoucher.disabled = true;
        defaultOption.selected =true;

        dowPaymentInput.value=subtotalInput*0.2;
        downPaymentElement.innerText=subtotalInput*0.2;
        $('#downPaymentContainer').removeClass('hidden');
        $('#subTotalDivContainer').addClass('text-gray-500');
        totalElement.innerText=(subTotalElement.innerText)*0.2;
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
    document.getElementById('discount').innerText = price;
    document.getElementById('user_voucher_id').value=userVoucherId;
    let total= document.getElementById('total');
    let subTotal= document.getElementById('subTotal');
    total.innerText=parseFloat(subTotal.value)-parseFloat(price);
}

$(document).ready(function () {
    const defaultOption = selectVoucher.querySelector('option[value="0"]');
    defaultOption.selected =true;
    $('#momoOption').prop('checked', true);
    $('#payment_type').val('1');

// Thiết lập thời gian refresh là 1 phút (60 * 1000 milliseconds)
    const refreshInterval = 60 * 1000;

// Hàm tự động refresh
    setInterval(() => {
        window.location.reload();
    }, refreshInterval);
});

