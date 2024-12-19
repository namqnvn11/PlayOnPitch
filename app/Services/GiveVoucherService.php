<?php

namespace App\Services;

use App\Models\User_voucher;
use App\Models\Voucher;
use Illuminate\Support\Str;

class GiveVoucherService
{
    protected $user_id;

    /**
     * Khởi tạo service với user_id
     */
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * Tạo và tặng voucher cho người dùng
     */
    public function giveVoucher()
    {
        // Kiểm tra nếu user_id không hợp lệ
        if (!$this->user_id) {
            throw new \InvalidArgumentException('User ID is required');
        }

        User_voucher::create([
            'user_id' => $this->user_id,
            'voucher_id' => '9999',
        ]);
    }
}
