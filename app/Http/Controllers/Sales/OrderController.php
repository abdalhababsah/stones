<?php

namespace App\Http\Controllers\Sales;
use App\DataTables\Sales\OrdersDataTable;
use App\Http\Requests\Order\UpdateShippingDetailsRequest;
use App\Http\Requests\Order\UpdateProductQuantityRequest;
use App\Http\Requests\Order\UpdateOrderStatusRequest;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductVariant;
use App\Models\OrderProductVariant;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use App\Models\OrderProduct;
use PDF;
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(OrdersDataTable $dataTable)
    {
        return $dataTable->render('pages.sales.orders.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with([
            'customer', 
            'orderProducts.product',
            'orderProducts.orderProductVariants.productVariant.variantType'
        ])->find($id);
    
        if (!$order) {
            return response()->json(['message' => 'Order not found.', 'status' => 422], 422);
        }
    
        $orderDetails = [];
        $totalOrderPrice = 0;
    
        foreach ($order->orderProducts as $orderProduct) {
            $productBasePrice = $orderProduct->product->price;
            $variantsTotalPrice = 0;
            $variantsDetails = [];
    
            foreach ($orderProduct->orderProductVariants as $variant) {
                $variantPrice = $variant->productVariant->price;
                $variantsTotalPrice += $variantPrice;
                $variantsDetails[] = [
                    'type' => $variant->productVariant->variantType->name_en,
                    'value' => $variant->productVariant->option_value,
                    'price' => $variantPrice
                ];
            }
    
            $unitPrice = $productBasePrice + $variantsTotalPrice;
            $productTotalPrice = $orderProduct->quantity * $unitPrice;
    
            $orderDetails[] = [
                'productName' => $orderProduct->product->name_en,
                'productPrice' => $productBasePrice,
                'variants' => $variantsDetails,
                'quantity' => $orderProduct->quantity,
                'unitPrice' => $unitPrice,
                'totalPrice' => $productTotalPrice
            ];
    
            $totalOrderPrice += $productTotalPrice;
        }
    
        $shippingRate = 0.00;
        $finalTotalPrice = $totalOrderPrice + $shippingRate;
    
        return view('pages.sales.orders.order-details', compact('order', 'orderDetails', 'finalTotalPrice', 'shippingRate'));
    }
    
    
    
    
    
    
    
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $order = Order::find($id);
    
        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'Order not found.');
        }
    
        return view('pages.sales.orders.edit-order', compact('order'));
    }

    





    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function updateProductQuantity(UpdateProductQuantityRequest $request, $orderId, $productId)
    {
        $orderProduct = OrderProduct::where('order_id', $orderId)->where('product_id', $productId)->firstOrFail();
        
        if ($request->quantity <= 0) {
            $orderProduct->delete();
            return response()->json(['message' => 'Product removed from order successfully.']);
        } else {
            $orderProduct->update(['quantity' => $request->quantity]);
            return response()->json(['message' => 'Product quantity updated successfully.']);
        }
    }
    
    public function getOrderDetails($orderId) {
        $order = Order::with([
            'orderProducts.product',
            'orderProducts.orderProductVariants.productVariant.variantType'
        ])->find($orderId);
    
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
    
        $allStatuses = OrderStatus::all(['id', 'name_en'])->toArray(); 
    
        return response()->json(['order' => $order, 'allStatuses' => $allStatuses]);
    }
    
    
    


    public function updateOrderStatus(UpdateOrderStatusRequest $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->order_status_id = $request->order_status_id;
        $order->save();
    
            return response()->json(['message' => 'Order status updated successfully.']);
        }




    public function deleteProduct($orderId, $productId)
        {
            $orderProduct = OrderProduct::where('order_id', $orderId)->where('product_id', $productId)->firstOrFail();
            $orderProduct->delete();
            return response()->json(['message' => 'Product removed from order successfully.']);
        }


    public function updateShippingDetails(UpdateShippingDetailsRequest $request, Order $order)
        {
            $order->update($request->validated());

            return response()->json([
                'message' => 'Shipping details updated successfully.',
            ]);
        }
    public function updateVariantPrice(Request $request, $orderId, $variantId)
        {
            $request->validate([
                'price' => 'required|numeric|min:0',
            ]);

            $variant = ProductVariant::findOrFail($variantId);
            $variant->price = $request->price;
            $variant->save();

            return response()->json(['message' => 'Variant price updated successfully.', 'price' => $variant->price]);
        }


    public function generateBill($orderId)
        {
            $order = Order::with([
                'customer', 
                'orderProducts.product',
                'orderProducts.orderProductVariants.productVariant.variantType'
            ])->find($orderId);

            if (!$order) {
                return abort(404, 'Order not found.');
            }

            $shippingPrice = 0.00; 

            $totalOrderPrice = 0;

            // Calculate each product's price, including variants
            foreach ($order->orderProducts as $orderProduct) {
                $productBasePrice = $orderProduct->product->price;
                $variantsTotalPrice = 0;
                foreach ($orderProduct->orderProductVariants as $variant) {
                    $variantsTotalPrice += $variant->productVariant->price;
                }

                $unitPrice = $productBasePrice + $variantsTotalPrice;
                $orderProduct->unit_price = $unitPrice;

                $productTotalPrice = $orderProduct->quantity * $unitPrice;
                $orderProduct->product_total_price = $productTotalPrice;

                $totalOrderPrice += $productTotalPrice;
            }

            $finalTotalPrice = $totalOrderPrice + $shippingPrice;

            $data = compact('order', 'shippingPrice', 'finalTotalPrice', 'totalOrderPrice');

            $pdf = PDF::loadView('pages.sales.orders.bill', $data);

            return $pdf->download('order-bill-' . $orderId . '.pdf');
        }



    public function getVariantsForProduct($orderId, $productId)
        {
            $existingVariantIds = OrderProductVariant::query()
            ->join('order_products', 'order_product_variants.order_product_id', '=', 'order_products.id')
            ->where('order_products.order_id', $orderId)
            ->where('order_products.product_id', $productId)
            ->pluck('order_product_variants.product_variant_id')
            ->toArray();

        // dd($existingVariantIds);

            $availableVariants = ProductVariant::where('product_id', $productId)
                                ->whereNotIn('id', $existingVariantIds)
                                ->with('variantType')
                                ->get();

            return response()->json($availableVariants);
        }



    public function addVariantsToProduct(Request $request, $orderId)
        {
            $validated = $request->validate([
                'product_id' => 'required|integer',
                'variant_ids' => 'required|array',
                'variant_ids.*' => 'integer|exists:product_variants,id'
            ]);

            $orderProduct = OrderProduct::where('order_id', $orderId)->where('product_id', $validated['product_id'])->firstOrFail();

            foreach ($validated['variant_ids'] as $variantId) {
                OrderProductVariant::create([
                    'order_product_id' => $orderProduct->id,
                    'product_variant_id' => $variantId
                ]);
            }

            return response()->json(['message' => 'Variants added successfully.']);
        }
    public function deleteVariant($orderId, $variantId)
        {
            $orderProductVariant = OrderProductVariant::whereHas('orderProduct', function ($query) use ($orderId) {
                $query->where('order_id', $orderId);
            })->where('product_variant_id', $variantId)->first();

            if (!$orderProductVariant) {
                return response()->json(['message' => 'Variant not found in this order.'], 404);
            }

            $orderProductVariant->delete();

            return response()->json(['message' => 'Variant removed from the order successfully.']);
        }

}
