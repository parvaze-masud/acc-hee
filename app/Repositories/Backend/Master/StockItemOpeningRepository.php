<?php

namespace App\Repositories\Backend\Master;

use App\Models\StockIn;
use App\Models\TransactionMaster;
use App\Services\Tree;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockItemOpeningRepository implements StockItemOpeningInterface
{
    private $tree;

    public function __construct(Tree $tree)
    {
        $this->tree = $tree;
    }

    public function getStockItemOpeningOfIndex()
    {
        // return $this->getStockItemOpeningData();
    }

    public function StoreStockItemOpening($request)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        if (! empty($request->tran_id[0])) {
            $tran_master = TransactionMaster::find($request->tran_id[0]);
            $tran_master->voucher_id = 32;
            $tran_master->transaction_date = date('Y-m-d', strtotime('-1 day', strtotime(company()->financial_year_start)));
            $tran_master->entry_date = date('Y-m-d');
            $tran_master->customer_id = $request->customer_id ?? 0;
            $update_history = json_decode($tran_master->other_details);
            $tran_master->other_details = json_encode($update_history.'<br> Updated On: '.\Carbon\Carbon::now()->format('D, d M Y g:i:s A').', By: '.Auth::user()->user_name.', Ip: '.$ip);
            $tran_master->save();
        }
        if (empty($request->tran_id[0])) {
            $tran_master = new TransactionMaster();
            $tran_master->voucher_id = 32;
            $tran_master->transaction_date = date('Y-m-d', strtotime('-1 day', strtotime(company()->financial_year_start)));
            $tran_master->entry_date = date('Y-m-d');
            $tran_master->customer_id = $request->customer_id ?? 0;
            $tran_master->user_id = auth()->id();
            $tran_master->other_details = json_encode('Created On: '.\Carbon\Carbon::now()->format('D, d M Y g:i:s A').', By: '.Auth::user()->user_name.' Ip: '.$ip);
            $tran_master->user_name = Auth::user()->user_name;
            $tran_master->save();
        }
        $stock_op_insert = [];
        for ($i = 0; $i < count($request->qty); $i++) {
            if (! empty($request->stock_in_id[$i])) {
                StockIn::where('stock_in_id', $request->stock_in_id[$i])->update([
                    'tran_date' => $tran_master->transaction_date,
                    'godown_id' => $request->godown_id,
                    'customer_id' => $request->customer_id,
                    'stock_item_id' => $request->stock_item_id[$i] ?? 0,
                    'qty' => (int) $request->qty[$i] ?? 0,
                    'rate' => (float) $request->rate[$i] ?? 0,
                    'total' => (float) $request->total[$i] ?? 0,
                    'type_in' => 'OP',
                ]);
            } elseif (! empty($request->qty[$i])) {
                $stock_op_insert[] = [
                    'tran_id' => $tran_master->tran_id ?? exit,
                    'tran_date' => $tran_master->transaction_date,
                    'godown_id' => $request->godown_id,
                    'customer_id' => $request->customer_id,
                    'stock_item_id' => $request->stock_item_id[$i] ?? 0,
                    'qty' => (int) $request->qty[$i] ?? 0,
                    'rate' => (float) $request->rate[$i] ?? 0,
                    'total' => (float) $request->total[$i] ?? 0,
                    'type_in' => 'OP',
                ];
            }
        }

        return StockIn::insert($stock_op_insert);
    }

    public function getStockItemOpeningId($id)
    {
        // return StockItemOpening::where('Opening_id',$id)->first();
    }

    public function updateStockItemOpening($request, $id)
    {
        // $stockItemOpening=  StockItemOpening::findOrFail($id);
        // $stockItemOpening->stock_item_id=$request->stock_item_id;
        // $stockItemOpening->setup_date=$request->setup_date;
        // $stockItemOpening->Opening=$request->Opening;
        // $stockItemOpening->user_id=Auth::id();
        // $stockItemOpening->save();
        // return $stockItemOpening;

    }

    public function deleteStockItemOpening($id)
    {

        // return  StockItemOpening::findOrFail($id)->delete();
    }

    public function getTree($godown_id, $customer_id, $tree_id)
    {
        $group_chart = $this->getStockItemOpeningData($godown_id, $customer_id);
        $group_chart_object_to_array = json_decode(json_encode($group_chart, true), true);

        return $this->tree->buildTree($group_chart_object_to_array, $tree_id, 0, 'stock_group_id', 'under', 'stock_item_id');
    }

    public function getTreeSelectOption($godown_id, $customer_id)
    {
        $stock_group = $this->getStockItemOpeningData($godown_id, $customer_id);
        $stock_group_object_to_array = json_decode(json_encode($stock_group, true), true);
        $build_group_tree = $this->tree->buildTree($stock_group_object_to_array, 0, 0, 'stock_group_id', 'under');

        return $this->tree->getTreeViewSelectOption($build_group_tree, 0, 'stock_group_id', 'under', 'group_chart_name');
    }

    public function getStockItemOpeningData($godown_id, $customer_id)
    {
        if (! empty($customer_id)) {
            $tran_id = DB::table('transaction_master')->where('voucher_id', '=', 32)->where('transaction_master.customer_id', $customer_id)->orderBy('tran_id', 'DESC')->first(['tran_id']);
            if (! empty($tran_id)) {
                $tran_id = $tran_id->tran_id;
            } else {
                $tran_id = 0;
            }
        }

        $query = DB::table('stock_item')
            ->select('stock_group.stock_group_id', 'stock_group_name', 'under', 'stock_item.stock_item_id', 'product_name', 'stock_in.qty', 'stock_in.rate', 'stock_in.total', 'unitsof_measure.symbol', 'stock_in_id', 'transaction_master.tran_id', 'transaction_master.user_name', 'transaction_master.other_details')
            ->rightJoin('stock_group', 'stock_item.stock_group_id', '=', 'stock_group.stock_group_id')
            ->leftJoin('unitsof_measure', 'stock_item.unit_of_measure_id', '=', 'unitsof_measure.unit_of_measure_id');
        if (! empty($customer_id)) {
            $query->leftJoin('stock_in', 'stock_item.stock_item_id', '=', DB::raw('stock_in.stock_item_id AND stock_in.type_in="OP" AND stock_in.tran_id="'.$tran_id.'" AND stock_in.godown_id='.$godown_id));
            $query->leftJoin('transaction_master', 'stock_in.tran_id', '=', DB::raw('transaction_master.tran_id AND transaction_master.customer_id='.$customer_id));
        } else {
            $query->leftJoin('stock_in', 'stock_item.stock_item_id', '=', DB::raw('stock_in.stock_item_id AND stock_in.type_in="OP"  AND stock_in.godown_id='.$godown_id));
            $query->leftJoin('transaction_master', 'stock_in.tran_id', '=', 'transaction_master.tran_id');
        }

        return $query->orderBy('stock_group.stock_group_id', 'DESC')
            ->orderBy('stock_item.product_name', 'DESC')
            ->get();
    }
}
