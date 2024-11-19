<div class="modal fade" id="modal-pricing">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitle">Setting Your Yard's Price</h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="mx-3 mt-2 text-gray-500 text-sm hover:text-black transition-all duration-300 flex items-center">
                <svg class="m-1 mr-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                The yard rental price will be by default if you do not set the price for each different time period
            </div>
            <hr class="mt-2">
            <form method="POST" id="form-pricing">
                @csrf
                <input type="hidden" value="" name="yardId" id="yardId">
                <div class="modal-body">

{{--                    default price--}}
                    <div class="relative flex">
                        <div>
                            <div class="mb-1">Default</div>
                            <label for="" id="pricing-label" class="m-2">Price</label>
                            <x-text-input class="w-16" type="" name="defaultPrice"/>&nbsp;VND
                        </div>


                        @if($currentBoss->is_open_all_day)
                            <div class="text-[16px] absolute right-0">OPENING : ALL DAY</div>
                        @else
                            <div class="text-[16px] absolute right-0">OPENING : {{$timeOpen}} - {{$timeClose}}</div>
                        @endif
                        <hr class="my-2 mt-4">
                    </div>

{{--                    Monday to Friday--}}
                    <div class="flex items-center">
                        <div class="mb-2 pt-1">Monday to Friday</div>
                        <x-circle-plus-button class="mx-2" onclick="addTimeSlot('mon-fri-time-container','mon-fri-template')" type="button"></x-circle-plus-button>
                        <x-clear-with-tooltip-button onclick="clearAllTime('mon-fri-time-container')"></x-clear-with-tooltip-button>

                    </div>

                    <div class="mt-2" id="mon-fri-time-container">
                        <div class="form-group flex items-center relative" id="mon-fri-time-group">
                            <x-input-label for="" id="pricing-label" class="mx-2">From</x-input-label>
                            <x-time-input  name="mon-fri-from-time-1" step="3600"/>
                            <label for="" id="pricing-label" class="mx-2">To</label>
                            <x-time-input name="mon-fri-to-time-1" />
                            <label for="" id="pricing-label" class="mx-2">Price</label>
                            <x-text-input class="w-16" type="" placeholder="000000" name="mon-fri-price-1"/>&nbsp;VND
                            <x-circle-minus-button class="absolute right-2" onclick="monToFriMinus(this)" type="button"></x-circle-minus-button>
                        </div>
                    </div>
                    <hr class="my-2">

{{--                    Weekend--}}
                    <div class="flex items-center">
                        <div>Weekend</div>
                        <x-circle-plus-button class="mx-2" onclick="addTimeSlot('weekend-time-container','weekend-template')" type="button"></x-circle-plus-button>
                        <x-clear-with-tooltip-button onclick="clearAllTime('weekend-time-container')"></x-clear-with-tooltip-button>
                    </div>
                    <div class="mt-2" id="weekend-time-container">
                        <div class="form-group flex items-center w-full relative" id="weekend-time-group">
                            <x-input-label for="" id="pricing-label" class="mx-2">From</x-input-label>
                            <x-time-input name="weekend-from-time-1"/>
                            <label for="" id="pricing-label" class="mx-2">To</label>
                            <x-time-input name="weekend-to-time-1"/>
                            <label for="" id="pricing-label" class="mx-2">Price</label>
                            <x-text-input class="w-16" type="" placeholder="000000" name="weekend-price-1"/>&nbsp;VND
                            <x-circle-minus-button class="absolute right-2" onclick="weekendMinus(this)" type="button"></x-circle-minus-button>
                        </div>
                    </div>

                    <hr>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default mr-1" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" onclick="">Confirm</button>
                </div>
            </form>
        </div>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </symbol>
        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
        </symbol>
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </symbol>
    </svg>

    <template id="mon-fri-template">
        <div class="form-group flex items-center relative" id="mon-fri-time-group">
            <x-input-label for="" id="pricing-label" class="mx-2">From</x-input-label>
            <x-time-input  name="mon-fri-from-time-" step="3600"/>
            <label for="" id="pricing-label" class="mx-2">To</label>
            <x-time-input name="mon-fri-to-time-" />
            <label for="" id="pricing-label" class="mx-2">Price</label>
            <x-text-input class="w-16" type="" placeholder="000000" name="mon-fri-price-"/>&nbsp;VND
            <x-circle-minus-button class="absolute right-2" onclick="monToFriMinus(this)" type="button"></x-circle-minus-button>
        </div>
    </template>
    <template id="weekend-template">
        <div class="form-group flex items-center relative" id="weekend-time-group">
            <x-input-label for="" id="pricing-label" class="mx-2">From</x-input-label>
            <x-time-input name="weekend-from-time-"/>
            <label for="" id="pricing-label" class="mx-2">To</label>
            <x-time-input name="weekend-to-time-"/>
            <label for="" id="pricing-label" class="mx-2">Price</label>
            <x-text-input class="w-16" type="" placeholder="000000" name="weekend-price-"/>&nbsp;VND
            <x-circle-minus-button class="absolute right-2" onclick="weekendMinus(this)" type="button"></x-circle-minus-button>
        </div>
    </template>

</div>


