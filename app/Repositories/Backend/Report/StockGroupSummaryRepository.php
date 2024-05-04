<?php

namespace App\Repositories\Backend\Report;

use App\Services\Tree;
use Illuminate\Support\Facades\DB;

class StockGroupSummaryRepository implements StockGroupSummaryInterface
{
    private $tree;

    public function __construct(Tree $tree)
    {
        $this->tree = $tree;
    }

    public function getStockGroupSummaryOfIndex($request = null)
    {

        if (isset($request)) {
            $from_date = $request->from_date;
            $to_date = $request->to_date;
            $godown = $request->godown_id == 0 ? '' : "godowns.godown_id=$request->godown_id AND";
            $current_stock_godown = $request->godown_id == 0 ? '' : " WHERE stock.godown_id=$request->godown_id";
            $stock_group_id = explode('-', $request->stock_group_id, 2);
        }
        if ($stock_group_id[0] == 0) {
            $inner_join_item_in = '';
            $stock_group_in = '';
            $group_id = '';
        } else {

            $data_tree_group = DB::select("with recursive tree as(
                                            SELECT stock_group.stock_group_id FROM stock_group  WHERE FIND_IN_SET(stock_group.stock_group_id,$stock_group_id[0])
                                            UNION ALL
                                            SELECT E.stock_group_id FROM tree H JOIN stock_group E ON H.stock_group_id=E.under
                                        )SELECT * FROM tree");
            $string_tree_group = implode(',', array_column(json_decode(json_encode($data_tree_group, true), true), 'stock_group_id'));
            $inner_join_item_in = 'INNER JOIN stock_item ON stock.stock_item_id=stock_item.stock_item_id';
            $stock_group_in = "stock_item.stock_group_id IN($string_tree_group) AND";
            $group_id = "WHERE stock_group.stock_group_id IN($string_tree_group)";
        }
        if ($request->godown_id == 0) {
            $data = DB::select(
                                   "SELECT    stock_group.stock_group_id,
                                                stock_group.stock_group_name,
                                                stock_group.under,
                                                stock_item.stock_item_id,
                                                stock_item.product_name,
                                                t.stock_qty_in,
                                                t.stock_qty_out,
                                                t.stock_total_in,
                                                t.stock_total_out,
                                                op_in.stock_qty_in_opening,
                                                op_in.stock_qty_out_opening,
                                                op_in.stock_total_in_opening,
                                                op_in.stock_total_out_opening,
                                                t.stock_qty_in                AS stock_in_sum_qty,
                                                t.stock_qty_out               AS stock_out_sum_qty,
                                                op_in.stock_qty_in_opening    AS stock_in_sum_qty_op,
                                                op_in.stock_qty_out_opening   AS stock_out_sum_qty_op,
                                                t.stock_total_in              AS stock_total_sum_in,
                                                t.stock_total_out             AS stock_total_sum_out,
                                                (
                                                        IFNULL(op_in.stock_qty_in_opening, 0) - IFNULL(op_in.stock_qty_out_opening, 0)
                                                    ) * (
                                                        (
                                                            IFNULL(op_in.stock_total_in_opening, 0) + IFNULL(op_in.stock_total_out_opening, 0)
                                                        ) / (
                                                            IFNULL(op_in.stock_qty_in_opening, 0) + IFNULL(op_in.stock_qty_out_opening, 0)
                                                        )
                                                    ) AS stock_total_value_sum_opening,
                                                current_stock.current_rate,
                                                ((((Ifnull(op_in.stock_qty_in_opening,0)-Ifnull(op_in.stock_qty_out_opening,0))+Ifnull(t.stock_qty_in,0))-Ifnull(t.stock_qty_out,0))*current_stock.current_rate) AS sum_current_value
                                    FROM      stock_group
                                    LEFT JOIN stock_item
                                    ON        stock_group.stock_group_id=stock_item.stock_group_id
                                    LEFT JOIN
                                                (
                                                        SELECT     Sum(stock.inwards_qty)    AS stock_qty_in,
                                                                    Sum(stock.inwards_value)  AS stock_total_in,
                                                                    Sum(stock.outwards_qty)   AS stock_qty_out,
                                                                    Sum(stock.outwards_value) AS stock_total_out,
                                                                    stock.stock_item_id       AS product_id
                                                        FROM       transaction_master
                                                        INNER JOIN stock
                                                        ON         transaction_master.tran_id=stock.tran_id
                                                        INNER JOIN godowns
                                                        ON         stock.godown_id=godowns.godown_id $inner_join_item_in
                                                        WHERE      $godown $stock_group_in transaction_master.transaction_date BETWEEN '$from_date' AND        '$to_date'
                                                        GROUP BY   stock.stock_item_id) AS t
                                    ON        stock_item.stock_item_id=t.product_id
                                    LEFT JOIN
                                                (
                                                        SELECT     sum(stock.inwards_qty)   AS stock_qty_in_opening,
                                                                    sum(stock.inwards_value) AS stock_total_in_opening,
                                                                    sum(stock.outwards_qty)  AS stock_qty_out_opening,
                                                                    sum(stock.outwards_value)  AS stock_total_out_opening,
                                                                    stock.stock_item_id      AS product_id_opening
                                                        FROM       transaction_master
                                                        INNER JOIN stock
                                                        ON         transaction_master.tran_id=stock.tran_id
                                                        INNER JOIN godowns
                                                        ON         stock.godown_id=godowns.godown_id $inner_join_item_in
                                                        WHERE      $stock_group_in $godown transaction_master.transaction_date<'$from_date'
                                                        GROUP BY   stock.stock_item_id) AS op_in
                                    ON        stock_item.stock_item_id=op_in.product_id_opening
                                    LEFT JOIN
                                                (
                                                    SELECT t1.stock_item_id,
                                                            t1.current_qty,
                                                            t1.current_rate
                                                    FROM   (
                                                                    SELECT   stock.stock_item_id,
                                                                                stock.current_qty,
                                                                                stock.current_rate,
                                                                                row_number() over(partition BY `stock_item_id` ORDER BY `id` DESC) rn
                                                                    FROM     stock $current_stock_godown ) AS t1
                                                    WHERE  t1.rn=1 ) AS current_stock
                                    ON        stock_item.stock_item_id=current_stock.stock_item_id $group_id
                                ORDER BY  stock_group.stock_group_id DESC
                                "
            );
        } else {
            $data = DB::select(

                                 "  SELECT      stock_group.stock_group_id,
                                                stock_group.stock_group_name,
                                                stock_group.under,
                                                stock_item.stock_item_id,
                                                stock_item.product_name,
                                                t.stock_qty_in,
                                                t.stock_qty_out,
                                                t.stock_total_in,
                                                t.stock_total_out,
                                                op_in.stock_qty_in_opening,
                                                op_in.stock_qty_out_opening,
                                                op_in.stock_total_in_opening,
                                                op_in.stock_total_out_opening,
                                                t.stock_qty_in                AS stock_in_sum_qty,
                                                t.stock_qty_out               AS stock_out_sum_qty,
                                                op_in.stock_qty_in_opening    AS stock_in_sum_qty_op,
                                                op_in.stock_qty_out_opening   AS stock_out_sum_qty_op,
                                                t.stock_total_in              AS stock_total_sum_in,
                                                t.stock_total_out             AS stock_total_sum_out,
                                                (
                                                        IFNULL(op_in.stock_qty_in_opening, 0) - IFNULL(op_in.stock_qty_out_opening, 0)
                                                    ) * (
                                                        (
                                                            IFNULL(op_in.stock_total_in_opening, 0) + IFNULL(op_in.stock_total_out_opening, 0)
                                                        ) / (
                                                            IFNULL(op_in.stock_qty_in_opening, 0) + IFNULL(op_in.stock_qty_out_opening, 0)
                                                        )
                                                    ) AS stock_total_value_sum_opening,
                                                GodownWiseRateCal(stock_item.stock_item_id,$request->godown_id) AS current_rate,

                                                ((((Ifnull(op_in.stock_qty_in_opening,0)-Ifnull(op_in.stock_qty_out_opening,0))+Ifnull(t.stock_qty_in,0))-Ifnull(t.stock_qty_out,0))*GodownWiseRateCal(stock_item.stock_item_id,$request->godown_id)) AS sum_current_value
                                    FROM      stock_group
                                    LEFT JOIN stock_item
                                    ON        stock_group.stock_group_id=stock_item.stock_group_id
                                    LEFT JOIN
                                                (
                                                        SELECT      Sum(stock.inwards_qty)    AS stock_qty_in,
                                                                    Sum(stock.inwards_value)  AS stock_total_in,
                                                                    Sum(stock.outwards_qty)   AS stock_qty_out,
                                                                    Sum(stock.outwards_value) AS stock_total_out,
                                                                    stock.stock_item_id       AS product_id
                                                        FROM       transaction_master
                                                        INNER JOIN stock
                                                        ON         transaction_master.tran_id=stock.tran_id
                                                        INNER JOIN godowns
                                                        ON         stock.godown_id=godowns.godown_id $inner_join_item_in
                                                        WHERE      $godown $stock_group_in transaction_master.transaction_date BETWEEN '$from_date' AND        '$to_date'
                                                        GROUP BY   stock.stock_item_id) AS t
                                    ON        stock_item.stock_item_id=t.product_id
                                    LEFT JOIN
                                                (
                                                        SELECT      sum(stock.inwards_qty)   AS stock_qty_in_opening,
                                                                    sum(stock.inwards_value) AS stock_total_in_opening,
                                                                    sum(stock.outwards_qty)  AS stock_qty_out_opening,
                                                                    sum(stock.outwards_value)  AS stock_total_out_opening,
                                                                    stock.stock_item_id      AS product_id_opening
                                                        FROM       transaction_master
                                                        INNER JOIN stock
                                                        ON         transaction_master.tran_id=stock.tran_id
                                                        INNER JOIN godowns
                                                        ON         stock.godown_id=godowns.godown_id $inner_join_item_in
                                                        WHERE      $stock_group_in $godown transaction_master.transaction_date<'$from_date'
                                                        GROUP BY   stock.stock_item_id) AS op_in
                                    ON        stock_item.stock_item_id=op_in.product_id_opening   $group_id
                                ORDER BY  stock_group.stock_group_id DESC
                                "
            );

        }
        $group_chart_object_to_array = json_decode(json_encode($data, true), true);
        $tree_data = $this->tree->buildTree($group_chart_object_to_array, $stock_group_id[1] ?? 0, 0, 'stock_group_id', 'under', 'stock_item_id');

        return $this->calculateGroupTotals($tree_data);
    }

    // stock  group calculation
    public function calculateGroupTotals($arr)
    {
        foreach ($arr as &$obj) {
            if (isset($obj['children'])) {
                $obj['children'] = $this->calculateGroupTotals($obj['children']);
                $obj['stock_qty_in'] = array_sum(array_column($obj['children'], 'stock_qty_in')) + $obj['stock_qty_in'] ?? 0;
                $obj['stock_qty_out'] = array_sum(array_column($obj['children'], 'stock_qty_out')) + $obj['stock_qty_out'] ?? 0;
                $obj['stock_qty_in_opening'] = array_sum(array_column($obj['children'], 'stock_qty_in_opening')) + $obj['stock_qty_in_opening'] ?? 0;
                $obj['stock_qty_out_opening'] = array_sum(array_column($obj['children'], 'stock_qty_out_opening')) + $obj['stock_qty_out_opening'] ?? 0;
                $obj['stock_total_sum_in'] = array_sum(array_column($obj['children'], 'stock_total_sum_in')) + $obj['stock_total_sum_in'] ?? 0;
                $obj['stock_total_sum_out'] = array_sum(array_column($obj['children'], 'stock_total_sum_out')) + $obj['stock_total_sum_out'] ?? 0;
                $obj['stock_total_value_sum_opening'] = array_sum(array_column($obj['children'], 'stock_total_value_sum_opening')) + $obj['stock_total_value_sum_opening'] ?? 0;
                $obj['sum_current_value'] = array_sum(array_column($obj['children'], 'sum_current_value')) + $obj['sum_current_value'] ?? 0;
            }
        }

        return $arr;
    }
}
