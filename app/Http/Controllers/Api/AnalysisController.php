<?php

namespace App\Http\Controllers\Api;

use App\Enums\DurationEnum;
use App\Enums\TypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\AggregateService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class AnalysisController extends Controller
{
    public function index(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $type = TypeEnum::tryFrom($request->type);

        $sub_query = Order::betweenDate($start_date, $end_date)
            ->where('status', true)
            ->groupBy('id', 'created_at')
            ->orderBy('created_at');

        if ($type === TypeEnum::AGGREGATE) {
            $duration = DurationEnum::tryFrom($request->duration);
            list($data, $dates, $totals) = AggregateService::aggregateByDuration($sub_query, $duration);
        }

        if ($type === TypeEnum::DECILE)
        {
            
        }


        return response()->json([
            'data' => $data,
            'dates' => $dates,
            'totals' => $totals
        ], Response::HTTP_OK);
    }
}
