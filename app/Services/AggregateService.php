<?php

namespace App\Services;

use App\Enums\DurationEnum;
use Illuminate\Support\Facades\DB;

class AggregateService
{
  public static function aggregateByDuration($sub_query, DurationEnum $duration)
  {
    $date_format = '';
    switch ($duration) {
      case DurationEnum::DAY:
        $date_format = '%Y-%m-%d';
        break;
      case DurationEnum::MONTH:
        $date_format = '%Y-%m';
        break;
      case DurationEnum::YEAR:
        $date_format = '%Y';
        break;
      default:
        $date_format = '%Y-%m-%d';
    }

    $sub_query->selectRaw('SUM(subtotal) as totalPerPurchase, DATE_FORMAT(created_at, ?) as date', [$date_format]);

    $data = DB::query()->fromSub($sub_query, 'sub')
      ->selectRaw('date, SUM(totalPerPurchase) AS total')
      ->groupBy('date')
      ->get();

    $dates = $data->pluck('date');
    $totals = $data->pluck('total');

    return [$data, $dates, $totals];
  }
}
