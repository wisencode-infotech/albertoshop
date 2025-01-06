<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use App\Models\Order;
use App\Models\OrderAddress;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use PDF;


class OrderController extends Controller
{
    protected $order_service;

    public function __construct(OrderService $order_service)
    {
        $this->order_service = $order_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $status_filter = $request->input('status_filter');

            $query = Order::query();
            if ($status_filter) {
                $query->where('status', $status_filter);
            }

            $data = $query->latest()->get();

            return Datatables::of($data)
                ->addIndexColumn() // Adds the row index
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" name="order_ids[]" value="' . $row->id . '" class="order-checkbox">';
                })
                ->addColumn('user_name', function ($row) {
                    return $row->user->name ?? '';
                })
                ->addColumn('status', function ($row) {
                    $status = config('general.order_statuses.' . $row->status);
                    $status_color = config('general.order_statuses_color.' . $row->status);
                    return '<span class="badge rounded-pill badge-soft-' . $status_color . ' font-size-12">' . $status . '</span>';
                })
                ->addColumn('amount', function ($row) {
                    return $row->total_price . ' ' .$row->currency->symbol;
                })
                ->addColumn('action', function ($row) {
                    $all_statuses = config('general.order_statuses');
                    $current_status = $row->status;
                    $btn = '<div class="d-flex align-items-center">';

                    $btn .= '<select class="form-control change_status form-control-sm" style="width: auto; margin-right: 5px;">';
                    foreach ($all_statuses as $key => $value) {
                        $selected = $key == $current_status ? 'selected' : '';
                        $btn .= '<option data-order-id = '.$row->id.' value="' . $key . '" ' . $selected . '>' . $value . '</option>';
                    }
                    $btn .= '</select>';
                    $btn .= '<a href="' . route('backend.order.show', $row) . '" class="edit btn btn-primary btn-sm">View</a>';
                    $status = config('general.order_statuses.' . $row->status);
                    if ($status == 'Pending') {
                        $btn .= '&nbsp' . '<a href="' . route('backend.order.update.status', $row) . '" class="update-order-status btn btn-warning btn-sm">Export & Accept</a>';
                    }
                    return $btn;
                })
                ->rawColumns(['action', 'user_name', 'status', 'checkbox'])
                ->make(true);
        }

        $categories = Order::all(); // Fetch all orders
        return view('backend.orders.index', compact('categories'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    { 
        $extra_information = json_decode($order->extra_information, true);
        $all_statuses = config('general.order_statuses');
        $status = config('general.order_statuses.' . $order->status);
        $status_color = config('general.order_statuses_color.' . $order->status);
        return view('backend.orders.show', compact('order', 'status', 'status_color', 'extra_information', 'all_statuses'));
    }

    public function downloadPdf(Order $order)
    { 
        $export_name = $order->order_number.'.pdf';

        $pdf = PDF::loadView('backend.orders.pdf.order-info-pdf', [
            'order' => $order
        ]);

        // Return the generated PDF in the browser
        return $pdf->stream($export_name);

    }

    public function updateStatus(Order $order)
    {
        $this->order_service->setRecord($order);
        $this->order_service->updateStatus(2);

        return response()->json([
            'order' => $order,
            'success' => 200,
            'message' => 'Order Accepted successfully.',
        ]);
    }

    public function bulkExport(Request $request)
    {
        $options = [];

        $action = $request->action ?? 'default'; // multi-orders-with-view

        $options['action'] = $action;

        $orders = Order::query();

        if ($request->has('status') && is_numeric($request->status)) {
            $orders->where('status', (int) $request->status);

            $options['export_as'] = 'pending-orders-' . date('YmdHis') . '.pdf';
        }
        
        $orders = $orders->get();

        foreach($orders as $order) {
            $this->order_service->setRecord($order);
            $this->order_service->updateStatus(2);
        }

        return $this->bulkExportWithMultiOrders($orders, $options);
    }

    public function bulkExportWithMultiOrders($orders, $options = [])
    {
        $export_name = $options['export_as'] ?? 'exported-orders.pdf';

        $pdf = PDF::loadView('backend.orders.pdf.orders-info-pdf', [
                'orders' => $orders
            ]);

        // Return the generated PDF in the browser
        return $pdf->stream($export_name);
    }

    public function bulkUpdate(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'string', // Accept strings since they may be comma-separated
            'order_status' => 'required|integer|in:1,2,3,4,5,6', // Ensure order status is valid
        ]);

        // Since order_ids could be an array with one element containing "10,11"
        // Check if the first element contains a comma
        if (isset($validated['order_ids'][0]) && strpos($validated['order_ids'][0], ',') !== false) {
            // Split the string into an array of IDs
            $orderIds = explode(',', $validated['order_ids'][0]);
        } else {
            // If it's not a comma-separated string, use the existing array
            $orderIds = $validated['order_ids'];
        }

        // Convert string IDs to integers
        $orderIds = array_map('intval', $orderIds);

        // Retrieve orders based on the IDs from the request
        $orders = Order::whereIn('id', $orderIds)->get();

        // Update the status for each order
        foreach ($orders as $order) {
            // $order->status = $validated['order_status'];
            // $order->save();
            $this->order_service->setRecord($order);
            $this->order_service->updateStatus($validated['order_status']); 

        }

        return response()->json(['status' => 200, 'message' => 'Order statuses updated successfully.']);
    }

    public function changeStatus(Request $request)
    {
        $selected_status = $request->selected_status ?? '';
        $order_id = $request->order_id ?? '';
        
        if($selected_status)
        {
            $order = Order::find($order_id);
            $this->order_service->setRecord($order);
            $this->order_service->updateStatus($selected_status); 
        }

        return response()->json(['status' => 200, 'message' => 'Order statuses updated successfully.']);
    }

}
