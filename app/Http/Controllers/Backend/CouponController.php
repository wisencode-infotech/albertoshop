<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CouponController extends Controller
{
    /**
     * Display a listing of the coupons.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Coupon::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn() // Adds the row index
                ->addColumn('code', function($row) {
                    return $row->code;
                })
                ->addColumn('discount_value', function($row) {
                    return $row->discount_value;
                })
                ->addColumn('valid_from', function($row) {
                    return \Carbon\Carbon::parse($row->valid_from)->format('Y-m-d');
                })
                ->addColumn('valid_until', function($row) {
                    return \Carbon\Carbon::parse($row->valid_until)->format('Y-m-d');
                })
                ->addColumn('usage_limit', function($row) {
                    return $row->usage_limit;
                })
                ->addColumn('discount_type', function($row) {
                    if($row->discount_type == 'percentage')
                    {
                        return '<span class="badge rounded-pill badge-soft-success font-size-12">Percentage</span>';
                    }
                    else
                    {
                        return '<span class="badge rounded-pill badge-soft-danger font-size-12">Flat</span>';
                    }
                })
                ->addColumn('action', function($row) {
                    $btn = '<a href="'.route('backend.coupon.edit', $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>';
                    $btn .= ' <button class="btn btn-danger btn-sm delete" data-id="'.$row->id.'">Delete</button>';
                    return $btn;
                })
                ->rawColumns(['action','discount_type'])
                ->make(true);
        }

        $coupons = Coupon::all(); // Fetch all coupons
        return view('backend.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new coupon.
     */
    public function create()
    {
        return view('backend.coupons.create'); // Return the create view
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'code' => 'required|string|max:20|unique:coupons,code',
            'discount_value' => 'required|numeric|min:0',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after_or_equal:valid_from',
            'usage_limit' => 'nullable|integer|min:0',
            'discount_type' => 'required|in:percentage,flat',
        ]);

        // Create a new coupon
        Coupon::create([
            'code' => $request->code,
            'discount_value' => $request->discount_value,
            'valid_from' => $request->valid_from,
            'valid_until' => $request->valid_until,
            'usage_limit' => $request->usage_limit,
            'discount_type' => $request->discount_type,
        ]);

        return redirect()->route('backend.coupon.index')
                         ->with('success', 'Coupon created successfully.');
    }

    /**
     * Display the specified coupon.
     */
    public function show(Coupon $coupon)
    {
        return view('backend.coupons.show', compact('coupon')); // Return the show view
    }

    /**
     * Show the form for editing the specified coupon.
     */
    public function edit(Coupon $coupon)
    {
        return view('backend.coupons.edit', compact('coupon')); // Return the edit view
    }

    /**
     * Update the specified coupon in storage.
     */
    public function update(Request $request, Coupon $coupon)
    {
        // Validate the request data
        $request->validate([
            'code' => 'required|string|max:20|unique:coupons,code,' . $coupon->id,
            'discount_value' => 'required|numeric|min:0',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after_or_equal:valid_from',
            'usage_limit' => 'nullable|integer|min:0',
            'discount_type' => 'required|in:percentage,flat',
        ]);

        // Update coupon details
        $coupon->update([
            'code' => $request->code,
            'discount_value' => $request->discount_value,
            'valid_from' => $request->valid_from,
            'valid_until' => $request->valid_until,
            'usage_limit' => $request->usage_limit,
            'discount_type' => $request->discount_type,
        ]);

        return redirect()->route('backend.coupon.index')
                         ->with('success', 'Coupon updated successfully.');
    }

    /**
     * Remove the specified coupon from storage.
     */
    public function destroy($id)
    {
        $coupon = Coupon::find($id);

        if ($coupon) {
            $coupon->delete();
            return response()->json(['success' => 'Coupon deleted successfully.']);
        }

        return response()->json(['error' => 'Coupon not found.'], 404);
    }

}
