<?php

namespace App\Repositories\Backend\Master;

use Illuminate\Http\Request;

interface StockItemOpeningInterface
{
    public function getStockItemOpeningOfIndex();

    public function StoreStockItemOpening(Request $request);

    public function getStockItemOpeningId($id);

    public function updateStockItemOpening(Request $request, $id);

    public function deleteStockItemOpening($id);
}
