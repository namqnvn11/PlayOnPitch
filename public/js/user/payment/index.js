
function paymentTypeChange(event){
    let totalElement= document.getElementById('total');
    let subTotalElement= document.getElementById('subTotalDiv');
    let subtotalInput= document.getElementById('subTotal').value;
    let discount= document.getElementById('discount').innerText;
    let downPaymentElement= document.getElementById('downPaymentDiv');
    let dowPaymentInput= document.getElementById('downPayment');
    //trả full
    if (event.currentTarget.value==='1'){
        $('#downPaymentContainer').addClass('hidden');
        $('#subTotalDivContainer').removeClass('text-gray-500');

        dowPaymentInput.value=0;
        downPaymentElement.innerText=0;
        totalElement.innerText=subTotalElement.innerText-discount;
    }else {
        // trả 20%
        dowPaymentInput.value=subtotalInput*0.2;
        downPaymentElement.innerText=subtotalInput*0.2;
        $('#downPaymentContainer').removeClass('hidden');
        $('#subTotalDivContainer').addClass('text-gray-500');
        totalElement.innerText=(subTotalElement.innerText-discount)*0.2;

    }

}


// $("form#form_payment").submit(function(e){
//     e.preventDefault();
//
//     // Danh sách reservationId
//     let reservationIdList = [1, 2, 4];
//
//     // Tạo FormData từ form
//     var formData = new FormData(this);
//
//     // Thêm reservationIdList vào formData (chuyển sang JSON string)
//     formData.append('reservationIdList', JSON.stringify(reservationIdList));
//
//     // Thực hiện AJAX request
//     $.ajax({
//         url: TEST_URL,  // Thay TEST_URL bằng URL thực tế
//         type: 'POST',
//         dataType: "json",
//         data: formData,
//         cache: false,
//         contentType: false,
//         processData: false,
//         success: function(response) {
//             console.log('Success:', response);
//         },
//         error: function(error) {
//             console.error('Error:', error);
//         }
//     });
// });

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

$(document).ready(function () {
    $('#momoOption').prop('checked', true);
    $('#payment_type').val('1');
});
