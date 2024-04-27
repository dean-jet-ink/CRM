<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::groupBy('id')
            ->selectRaw('id, customer_name, sum(subtotal) as total, status, created_at')
            ->paginate(50);

        return Inertia::render('Purchases/Index', ['orders' => $orders]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::select('id', 'name', 'price')
            ->where('is_selling', true)->get();

        return Inertia::render('Purchases/Create', ['items' => $items]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseRequest $request)
    {
        DB::beginTransaction();

        try {
            $purchase = Purchase::create([
                'customer_id' => $request->customer_id,
                'status' => $request->status,
            ]);

            foreach ($request->items as $item) {
                $purchase->items()->attach(
                    $purchase->id,
                    [
                        'item_id' => $item['id'],
                        'quantity' => $item['quantity']
                    ]
                );
            }

            DB::commit();

            return to_route('dashboard');
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        $items = Order::where('id', $purchase->id)->get();

        $order = Order::selectRaw('id, customer_name, sum(subtotal) as total, status, created_at, updated_at')
            ->where('id', $purchase->id)
            ->groupBy('id', 'customer_name', 'status', 'created_at', 'updated_at')
            ->get();

        return Inertia::render('Purchases/Show', ['items' => $items, 'order' => $order]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        $purchasedItems = $purchase->items()->get();

        $order = Order::selectRaw('id, customer_id, customer_name, sum(subtotal) as total, status, created_at, updated_at')
            ->where('id', $purchase->id)
            ->groupBy('id', 'customer_name', 'status', 'created_at', 'updated_at')
            ->get();

        return Inertia::render('Purchases/Edit', ['items' => $purchasedItems, 'order' => $order]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePurchaseRequest $request, Purchase $purchase)
    {
        DB::beginTransaction();

        try {
            $purchase->update([
                'status' => $request->status
            ]);

            $newItems = [];
            foreach ($request->items as $item) {
                $newItems[$item['id']] = ['quantity' => $item['quantity']];
            }

            $purchase->items()->sync($newItems);

            DB::commit();

            return to_route('purchases.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return Inertia::render('Dashboard')
                ->with(['message' => '更新に失敗しました: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}
