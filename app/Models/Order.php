<?php

namespace App\Models;

use App\Models\Scopes\Subtotal;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope(new Subtotal);
    }

    public function scopeBetweenDate($query, $startDate = null, $endDate = null)
    {
        if (is_null($startDate) && is_null($endDate)) {
            return $query;
        }

        if (!is_null($startDate) && is_null($endDate)) {
            return $query->where('created_at', '>=', $startDate);
        }

        // endDateはYYYY-MM-DD 00:00:00のため、$endDateの日の情報を含めることができない
        // そのため、1日プラスする
        $addedEndDate = Carbon::parse($endDate)->addDay();

        if (is_null($startDate)) {
            return $query->where('created_at', '<=', $addedEndDate);
        }

        return $query->whereBetween('created_at', [$startDate, $addedEndDate]);
    }
}
