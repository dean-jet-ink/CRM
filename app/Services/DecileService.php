<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DecileService
{
  public static function decile($sub_query)
  {
    // 1. 購入ごとの合計金額
    $totalPerPurchaseQuery = DB::query()->fromSub($sub_query, 'sub')
      ->selectRaw('id, customer_id, customer_name, SUM(subtotal) as totalPerPurchase')
      ->groupBy('id', 'customer_id', 'customer_name');

    // 2. 顧客毎の合計金額(降順)
    $totalPerCustomerQuery = DB::query()->fromSub($totalPerPurchaseQuery, 'purchase_total')
      ->selectRaw('customer_id, customer_name, SUM(totalPerPurchase) as total')
      ->groupBy('customer_id', 'customer_name')
      ->orderByDesc('total');

    // 3. 顧客の購入金額順に連番作成
    DB::statement('SET @row_num = 0');
    $totalPerCustomerWithRowNumQuery = DB::query()->fromSub($totalPerCustomerQuery, 'customer_total')
      ->selectRaw('@row_num := @row_num + 1 AS row_num, customer_id, customer_name, total');

    // 4. デシルの作成
    $count = $totalPerCustomerWithRowNumQuery->count();
    $decile = ceil($count / 10);

    $decileDivisions = [];
    $tmpDivision = 0;
    for ($i = 1; $i <= 10; $i++) {
      array_push($decileDivisions, $tmpDivision + 1);
      $tmpDivision += $decile;
      array_push($decileDivisions, $tmpDivision);
    }

    $decileQuery = DB::query()->fromSub($totalPerCustomerWithRowNumQuery, 'customer_total_with_rownum')
      ->selectRaw('
            customer_id,
            customer_name,
            total,
            row_num,
            CASE
                WHEN row_num >= ? AND row_num <= ? THEN 1
                WHEN row_num >= ? AND row_num <= ? THEN 2
                WHEN row_num >= ? AND row_num <= ? THEN 3
                WHEN row_num >= ? AND row_num <= ? THEN 4
                WHEN row_num >= ? AND row_num <= ? THEN 5
                WHEN row_num >= ? AND row_num <= ? THEN 6
                WHEN row_num >= ? AND row_num <= ? THEN 7
                WHEN row_num >= ? AND row_num <= ? THEN 8
                WHEN row_num >= ? AND row_num <= ? THEN 9
                WHEN row_num >= ? AND row_num <= ? THEN 10
            END AS decile
        ', $decileDivisions);

    // dd($decileQuery->get());

    // 5. 分割ごとの合計金額、平均金額
    $calcDecileQuery = DB::query()->fromSub($decileQuery, 'd')
      ->selectRaw('
                decile,
                SUM(total) AS summation,
                ROUND(AVG(total)) AS average
            ')->groupBy('decile');

    // dd($calcDecileQuery->get());

    // 6. 構成比
    $total = DB::query()->fromSub($totalPerCustomerQuery, 'customer_total')
      ->selectRaw('SUM(total) AS total_all')->first()->total_all;

    // dd($total);

    DB::statement('SET @total = ' . (float)$total);
    $compositionQuery = DB::query()->fromSub($calcDecileQuery, 'calc')
      ->selectRaw('
                decile,
                summation,
                average,
                ROUND(summation / @total * 100, 1) AS ratio
            ');

    return $compositionQuery->get();
  }
}
