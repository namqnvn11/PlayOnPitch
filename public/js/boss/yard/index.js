$(document).ready(function () {
    $(document).on('click', '.js-on-create', function () {
        var _modal = $('#modal-edit');
        $('#form-data')[0].reset();
        $('.error-message').remove();
        _modal.find('h4').text('Add new');
        fetchDistricts($('#province_id').attr('province-id')).then(()=>{
                $('select[name="district"]').val($('#district_id').attr('district-id'));
        }
        );
        _modal.modal('show');
    });

    $(document).on('click', '.js-on-open-time', function () {
        var _modal = $('#modal-open-time');
        $('.error-message').remove();
        _modal.modal('show');
    });

    $(document).on('keydown', function(event) {
        if (event.key === "Escape" || event.keyCode === 27) {
            $('#modal-confirm').modal('hide');
            // $('#modal-edit').modal('hide');
            // $('#modal-pricing').modal('hide');
        }
    });

    saveData();
    pricing();
    setOpenTime()
});
$(document).ready(function () {
    $('#province_id').on('change', function () {
        var provinceId = $(this).val();
        fetchDistricts(provinceId);
    });
});
function fetchDistricts(provinceId) {
    return new Promise((resolve,reject)=>{
        if (provinceId) {
            $.ajax({
                url: getDistrictsUrl,
                type: 'GET',
                data: { province_id: provinceId },
                success: function (data) {
                    $('#district_id').empty();
                    $('#district_id').append('<option value="">Select District</option>');
                    $.each(data, function (key, district) {
                        $('#district_id').append('<option value="' + district.id + '">' + district.name + '</option>');
                    });
                    resolve();
                },
                error: function () {
                    Notification.showError('Error when retrieving district data.');
                    reject();
                }
            });
        } else {
            $('#district_id').empty();
            $('#district_id').append('<option value="">Select District</option>');
        }
    })
}

function showModalPricing(id) {
    var _modal = $('#modal-pricing');
    var _form =$('#form-pricing');
    _form.find('input').not('[name="_token"]').val('');
    _form.find('input[name="yardId"]').val(id);

    //load old data
    var url= GET_TIME_SETTING_URL+'/'+id;
    $.ajax({
        url: url,
        type: 'GET',
        dataType: "json",
        success: function (response) {
            if (response.isTimeSet){
                let monFri= response.MonFri;
                let weekend= response.Weekend;//=> array of date time setting

                if (monFri.length!==0){
                    loadOldTimeSetting(monFri, 'mon-fri-time-container',"mon-fri-template");
                }
                if (weekend.length!==0){
                    loadOldTimeSetting(weekend,'weekend-time-container',"weekend-template");
                }
            }else {
                makeFormEmpty()
            }
            _form.find('input[name="defaultPrice"]').val(response.defaultPrice);
        },

        cache: false,
        contentType: false,
        processData: false
    });

    _modal.modal('show');
}
function makeFormEmpty(){
    emptydata=[
        {
            id:'',
            start_time:'',
            end_time:'',
            price_per_hour:'',
        }
    ]
    loadOldTimeSetting(emptydata,"mon-fri-time-container","mon-fri-template");
    loadOldTimeSetting(emptydata,"weekend-time-container","weekend-template");
}
function loadOldTimeSetting(timeSlots,containerId,templateId){
    const container = document.getElementById(containerId);
    container.innerHTML='';
    const template = document.getElementById(templateId);
    timeSlots.forEach((timesLot,index)=>{
        const newGroup = template.content.cloneNode(true);

        // tạo name cho các input
        ['1', '3', '5'].forEach(i => {
            newGroup.children[0].children[i].name += index;
        });

        //thêm trường id để lưu giá trị của timeslot id
        timesLotIdElement=document.createElement('input');
        timesLotIdElement.setAttribute('type','hidden');
        idInputName=(containerId==="weekend-time-container")? 'weekend-time-slot-id-'+index:'mon-fri-time-slot-id-'+index
        timesLotIdElement.setAttribute('name',idInputName)
        timesLotIdElement.setAttribute('value',timesLot.id);
        newGroup.children[0].appendChild(timesLotIdElement);

        //gắn dữ liệu cũ vào các input
        //trường From
        newGroup.children[0].children[1].value = removeSeconds(timesLot.start_time);
        //trường To
        newGroup.children[0].children[3].value = removeSeconds(timesLot.end_time);
        //Price
        newGroup.children[0].children[5].value = timesLot.price_per_hour;

        container.appendChild(newGroup);
    })
}
function removeSeconds(timeString) {
    return timeString.replace(/:00$/, '');
}
 function viewDetail(event) {
    var _modal = $('#modal-edit');
    var url = event.currentTarget.getAttribute('data-url');
    $('.error-message').remove();
    $('#form-data')[0].reset();
    _modal.find('h4').text('Edit');
    $.ajax({
        url: url,
        type: 'GET',
        dataType: "json",
        success: function (response) {
            if (response.success) {
                var data = response.data;
                $('input[name="id"]').val(data.id);
                $('select[name="yard_name"]').val(data.yard_name);
                $('select[name="yard_type"]').val(data.yard_type);
                $('textarea[name="description"]').val(data.description);
                $('select[name="province"]').val(response.province.id);
                fetchDistricts($('#province_id').val())
                    .then(()=>{
                        $('select[name="district"]').val(response.district.id);
                        $('#modal-edit').modal('show');
                    }).catch(()=>{
                    Notification.showError('Error when retrieving district data.');
                })
            } else {
                Notification.showError(response.message);
            }
        },

        cache: false,
        contentType: false,
        processData: false
    });

    _modal.modal('show');
}

function setOpenTime(){
    $('form#form-open-time').submit(function (e){
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: SET_OPEN_TIME_URL,
            type: 'POST',
            dataType:"json",
            data: formData,
            success: function (response) {
                if (response.success) {
                    Notification.showSuccess(response.message);
                    // Reset form
                    $("form#form-open-time")[0].reset();
                    $('#modal-open-time').modal('hide');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1200);
                }else{
                    Notification.showError(response.message);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) { // Xử lý lỗi validate
                    let errors = xhr.responseJSON.errors;
                    console.log(errors)
                    // Xóa các thông báo lỗi cũ
                    $('.error-message').remove();

                    // Hiển thị các lỗi mới
                    $.each(errors, function(field, messages) {
                        messages.forEach(function(message) {
                            Notification.showError(message);
                        });
                    });

                } else {
                    // Các lỗi khác
                    console.error("AJAX error:", xhr);
                    Notification.showError("An error occurred: " + xhr.statusText);
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    })
}

function pricing() {
    $("form#form-pricing").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: TIME_SETTING_URL+'/'+this[1].value,
            type: 'POST',
            dataType:"json",
            data: formData,
            success: function (response) {
                if (response.success) {
                    Notification.showSuccess(response.message);
                    // Reset form
                    $("form#form-pricing")[0].reset();
                    $('#modal-pricing').modal('hide');
                }else{
                    Notification.showError(response.message);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) { // Xử lý lỗi validate
                    let errors = xhr.responseJSON.errors;
                    console.log(errors);
                    // Xóa các thông báo lỗi cũ
                    $('.error-message').remove();

                    // Hiển thị các lỗi mới
                    $.each(errors, function(field, messages) {
                        messages.forEach(function(message) {
                            $(`input[name="${field}"]`).after(`<span class="error-message" style="color: red; display: block; position: absolute; bottom:0px">${message}</span>`);
                        });
                    });
                } else {
                    // Các lỗi khác
                    console.error("AJAX error:", xhr);
                    Notification.showError("An error occurred: " );
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
}

function saveData() {
    $("form#form-data").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: STORE_URL,
            type: 'POST',
            dataType: "json",
            data: formData,
            success: function(response) {
                if (response.success) {
                    Notification.showSuccess(response.message);
                    $('#modal-edit').modal('hide');
                    // Reset form
                    $("form#form-data")[0].reset();

                    setTimeout(() => {
                        window.location.reload();
                    }, 1200);
                } else {
                    Notification.showError(response.message);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) { // Xử lý lỗi validate
                    let errors = xhr.responseJSON.errors;
                    // Xóa các thông báo lỗi cũ
                    $('.error-message').remove();

                    // Hiển thị các lỗi mới
                    $.each(errors, function(field, messages) {
                        messages.forEach(function(message) {
                            $(`textarea[name="${field}"]`).after(`<span class="error-message" style="color: red;">${message}</span>`);
                            $(`select[name="${field}"]`).after(`<span class="error-message" style="color: red;">${message}</span>`);
                        });
                    });
                } else {
                    // Các lỗi khác
                    console.error("AJAX error:", xhr);
                    Notification.showError("An error occurred: " + xhr.statusText);
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
}

function showModalBlock(yardId) {
    const form = document.getElementById('form-block');
    document.getElementById('confirmLabel').innerHTML='Are you sure you want to block this Yard?'
    document.getElementById('modalTitle').innerHTML='Block Yard';
    document.getElementById('yardId').value= yardId;
    form.action = `/boss/yard/block/${yardId}`;
    $('#modal-confirm').modal('show');
}
function showModalUnBlock(yardId){
    const form = document.getElementById('form-block');
    form.action = `/boss/yard/unblock/${yardId}`;
    document.getElementById('confirmLabel').innerHTML='Are you sure you want to unblock this Yard?'
    document.getElementById('modalTitle').innerHTML='Unblock Yard';
    document.getElementById('yardId').value= yardId;
    $('#modal-confirm').modal('show');
}
function filter(){
    document.getElementById('filterForm').submit();
}

function blockUnBlockSubmit(event){
    event.preventDefault();
    const form = document.getElementById('form-block');
    var formData = new FormData(form);
    let yardId= document.getElementById('yardId').value;
    let submitURL= document.getElementById('modalTitle').innerHTML==='Block Yard' ? BLOCK_URL : UNBLOCK_URL;
    submitURL= submitURL+'/'+yardId;
    $.ajax({
        url: submitURL,
        type: 'POST',
        dataType: "json",
        data: formData,
        success: function(response) {
            if (response.success) {
                Notification.showSuccess(response.message);
                $('#modal-confirm').modal('hide');
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                Notification.showError(response.message);
            }
        },
        error: function(xhr) {
            console.log(xhr.status);
            Notification.showError("An error occurred: " + xhr.statusText);
        },
        cache: false,
        contentType: false,
        processData: false
    });
}

var countId=2

function checkInputIsFilled(container){
    const lastChild= container.lastElementChild;
    const inputs = lastChild.querySelectorAll('input[name]');
    for (let i=0; i<=2;i++) {
        if (inputs[i].value.trim() === '') {
            return false; // Trả về false nếu phát hiện input bị trống
        }
    }
    return true;
}

function addTimeSlot(containerId, templateId, isClear = false) {
    const container = document.getElementById(containerId);
    const template = document.getElementById(templateId);
    // Create a new group from the template

    const newGroup = template.content.cloneNode(true);

    //add name for input time(1,3) and price(5)
    function appendNewGroup() {
        const newGroup = template.content.cloneNode(true);
        ['1', '3', '5'].forEach(index => {
            newGroup.children[0].children[index].name += countId;
        });
        container.appendChild(newGroup);
        countId++;
    }

    if (isClear) {
        appendNewGroup();
    } else {
        if (checkInputIsFilled(container)) {
            appendNewGroup();
        } else {
            Notification.showError('Please fill the time and price before adding new rows');
        }
    }
    countId++;
}


function monToFriMinus(button){
    const container = document.getElementById('mon-fri-time-container');
    let containerChildCount=container.children.length;
    const group = button.closest('.form-group');

    if (group) {
        if (containerChildCount !== 1){
            group.remove();
        }
    }
}
function weekendMinus(button){
    const container = document.getElementById('weekend-time-container');
    let containerChildCount=container.children.length;
    const group = button.closest('.form-group');
    if (group) {
        if (containerChildCount !== 1){
            group.remove();
        }
    }
}

function clearAllTime(containerId){
    const container= document.getElementById(containerId);
    let templateId= containerId==='mon-fri-time-container'? 'mon-fri-template':'weekend-template'
    container.innerHTML='';
    addTimeSlot(containerId,templateId,true);
}

function openAllDay(event) {
    let open= document.getElementById('time-open');
    let close= document.getElementById('time-close');
    if (event.currentTarget.checked) {
        open.value = '';
        open.disabled = true;
        close.value = '';
        close.disabled = true;
    } else {
        open.removeAttribute('disabled');
        close.removeAttribute('disabled');
        open.value=open.getAttribute('time');
        close.value=close.getAttribute('time');
    }
}

