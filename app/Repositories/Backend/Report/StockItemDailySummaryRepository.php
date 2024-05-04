<?php

namespace App\Repositories\Backend\Report;

use Illuminate\Support\Facades\DB;

class StockItemDailySummaryRepository implements StockItemDailySummaryInterface
{
    public function getStockItemDailySummaryOfIndex($request = null)
    {
        if (isset($request)) {
            $from_date = $request->from_date;
            $to_date = $request->to_date;
            $stock_item_id = $request->stock_item_id;
            $godown = $request->godown_id == 0 ? '' : "stock.godown_id=$request->godown_id AND";
        }

        $current_stock = DB::select("SELECT   transaction_master.invoice_no,
                                             transaction_master.tran_id,
                                             transaction_master.transaction_date,
                                             stock.id,
                                             (
                                                SELECT current_stock.current_rate
                                                FROM   stock AS current_stock
                                                WHERE  current_stock.id=Max(stock.id)) AS current_stock_rate,
                                             Sum(inwards_qty)                              AS inwards_qty,
                                             Sum(inwards_value)                            AS inwards_value,
                                             Sum(outwards_qty)                             AS outwards_qty,
                                             Sum(outwards_value)                           AS outwards_value ,
                                             current_qty,
                                             current_rate,
                                             current_value
                                    FROM      transaction_master
                                    LEFT JOIN stock
                                    ON        transaction_master.tran_id=stock.tran_id
                                    WHERE     $godown stock.stock_item_id=$stock_item_id
                                    AND       transaction_master.transaction_date BETWEEN '$from_date' AND       '$to_date'
                                    GROUP BY  year(transaction_master.transaction_date),
                                            month(transaction_master.transaction_date),day(transaction_master.transaction_date)
                       ");
        $oppening_stock = DB::select("SELECT Sum(opening_value.stock_total_value_sum_opening) AS
                                                total_stock_total_out_opening,
                                                SUM(op_qty) AS  total_stock_total_opening_qty
                                        FROM   (SELECT ( Ifnull(Sum(stock.inwards_qty), 0) - Ifnull(
                                                    Sum(stock.outwards_qty), 0)
                                                        ) * ( (
                                                                Ifnull( Sum(stock.inwards_value), 0)
                                                                + Ifnull(Sum(stock.outwards_value), 0) ) / (
                                                                            Ifnull(Sum(stock.inwards_qty), 0)
                                                                            + Ifnull(Sum(stock.outwards_qty),
                                                                            0) ) ) AS stock_total_value_sum_opening,
                                                                            ( Ifnull(Sum(stock.inwards_qty), 0) - Ifnull(
                                                    Sum(stock.outwards_qty), 0)
                                                            ) AS op_qty
                                                FROM   transaction_master
                                                        INNER JOIN stock
                                                                ON transaction_master.tran_id = stock.tran_id
                                                WHERE   $godown stock.stock_item_id=$stock_item_id AND
                                                        transaction_master.transaction_date < '$from_date'
                                                GROUP  BY stock.stock_item_id) AS opening_value
                                                                    ");

        return $stock = ['current_stock' => $current_stock, 'oppening_stock' => $oppening_stock];

    }
}
