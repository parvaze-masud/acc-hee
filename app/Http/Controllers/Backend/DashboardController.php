<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\GroupChart;
use App\Models\LegerHead;
use App\Models\StockGroup;
use App\Models\StockItem;
use App\Repositories\Backend\Master\GroupChartRepository;

class DashboardController extends Controller
{
    private $groupChart;

    public function __construct(GroupChartRepository $groupChart)
    {
        $this->groupChart = $groupChart;
    }

    public function index()
    {
        return view('admin.dashboard');
    }

    public function mainIndex()
    {
        $group_chart = GroupChart::count();
        $ledger_head = LegerHead::count();
        $stock_group = StockGroup::count();
        $stock_item = StockItem::count();

        return view('admin.main_dashboard', compact('group_chart', 'ledger_head', 'stock_group', 'stock_item'));
    }
}
