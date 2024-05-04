<?php

namespace App\Repositories\Backend\Voucher;

use Illuminate\Http\Request;

interface VoucherContraInterface
{
    public function getVoucherContraOfIndex();

    public function StoreVoucherContra(Request $request);

    public function getVoucherContraId($id);

    public function updateVoucherContra(Request $request, $id);

    public function deleteVoucherContra($id);
}
