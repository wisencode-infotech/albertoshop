<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Mail\StockReminderMail;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductUnit;
use App\Models\StockReminder;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Product::latest();

            if (__isFranchise()) {
                $data = $data->whereIn('public_visibility', [1, 0]);
            }

            $data = $data->get();

            return Datatables::of($data)
                ->addIndexColumn() // Adds the row index
                ->addColumn('category', function($row) {
                    return $row->category->name;
                })
                ->addColumn('name', function($row) {
                    return $row->name;
                })
                 ->addColumn('price', function($row) {
                    return $row->price. ' ' . __appCurrencySymbol();;
                })
                ->addColumn('status', function($row) {
                    if($row->status == '1')
                    {
                        return '<span class="badge rounded-pill badge-soft-success font-size-12">Active</span>';
                    }
                    else
                    {
                        return '<span class="badge rounded-pill badge-soft-danger font-size-12">InActive</span>'; 
                    }
                })
                ->addColumn('public_visibility', function($row) {
                    if ($row->public_visibility == '1') {

                        return '<span class="badge rounded-pill badge-soft-success font-size-12">Public</span>';

                    } else if($row->public_visibility == '0') {

                        return '<span class="badge rounded-pill badge-soft-warning font-size-12">Private</span>'; 

                    } else {

                        return '<span class="badge rounded-pill badge-soft-danger font-size-12">Hidden</span>'; 
                    }
                })
                ->addColumn('is_home', function($row) {
                    if ($row->is_home == '1') {

                        return '<span class="badge rounded-pill badge-soft-success font-size-12">Yes</span>';

                    } else {

                        return '<span class="badge rounded-pill badge-soft-danger font-size-12">No</span>'; 
                    }
                })
                ->addColumn('action', function($row) {

                    if (__currentUserRole() == 'admin') {

                        $btn = '<a href="'.route('backend.product.edit', $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>';

                        $btn .= ' <button class="btn btn-danger btn-sm delete" data-id="'.$row->id.'">Delete</button>';
                    } else {
                        $btn = '<a href="'.route('backend.franchise-product.edit', $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>';
                    }
                    
                    return $btn;
                })
                ->rawColumns(['action', 'status', 'public_visibility', 'is_home'])
                ->make(true);
        }

        $products = Product::get(); // Fetch all products
        return view('backend.products.index', compact('products'));
    }

    public function create()
    {
        $units = ProductUnit::all();
        $categories = Category::where('parent_id','!=', null)->get();
        return view('backend.products.create', compact('units', 'categories')); // Return the create view
    }

    public function store(StoreProductRequest $request)
    {
        $validatedData = $request->validated();

        // Generate a unique slug
        $slug = Str::slug($request->name);
        $slug = $this->generateUniqueSlug($slug);

        $product = new Product();
        $product->name = $request->name;
        $product->short_description = $request->short_description;
        $product->slug = $slug;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->category_id = $request->category_id;
        $product->public_visibility = $request->public_visibility;
        $product->is_home = $request->is_home;
        $product->seo_title = $request->seo_title;
        $product->seo_description = $request->seo_description;
        $product->seo_keywords = $request->seo_keywords;
        $product->og_title = $request->og_title;
        $product->og_description = $request->og_description;
        $product->og_image = $request->og_image;
        $product->canonical_url = $request->canonical_url;
        $product->unit_id = $request->unit_id;
        $product->save();

        // Check if images were uploaded
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Store image in products/{product_id}/
                $path = $image->store('products/' . $product->id, 'public');
                
                // Save image path to product_images table
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);

                $product->makePrimaryImage();
            }
        }

        // Check if all variations are empty
        $variationsNotEmpty = collect($request->variations)->contains(function ($variation) {
            return !is_null($variation['name']) || !is_null($variation['price']) || !is_null($variation['stock']);
        });

        if (!empty($variationsNotEmpty)) {
            foreach ($request->variations as $variation) {
                $product->variations()->create([
                    'name' => $variation['name'],
                    'price' => $variation['price'] ?? null,
                    'stock' => $variation['stock'] ?? null
                ]);
            }
        }

        return redirect()->route('backend.product.index')->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit($id)
    {
        $product = Product::where('id', $id)->first();
        
        $units = ProductUnit::all();
        $categories = Category::where('parent_id','!=', null)->get();
        return view('backend.products.edit', compact('product', 'units', 'categories')); // Return the edit view
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        $old_stock = $product->stock;

        $validatedData = $request->validated();

        // Check if the product name has changed
        // if ($request->name !== $product->name) {
        //     $slug = Str::slug($request->name);
        //     $product->slug = $this->generateUniqueSlug($slug); // Update slug only if the name has changed
        // }

        $product->name = $request->name;
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->category_id = $request->category_id;
        $product->public_visibility = $request->public_visibility;
        $product->is_home = $request->is_home;
        $product->unit_id = $request->unit_id;
        $product->seo_title = $request->seo_title;
        $product->seo_description = $request->seo_description;
        $product->seo_keywords = $request->seo_keywords;
        $product->og_title = $request->og_title;
        $product->og_description = $request->og_description;
        $product->og_image = $request->og_image;
        $product->canonical_url = $request->canonical_url;
        $product->slug = $request->slug;
        $product->save();

        // Check if images were uploaded
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Store image in products/{product_id}/
                $path = $image->store('products/' . $product->id, 'public');
                
                // Save image path to product_images table
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);

                $product->makePrimaryImage();
            }
        }

        // Check if all variations are empty
        $variationsNotEmpty = collect($request->variations)->contains(function ($variation) {
            return !is_null($variation['name']) || !is_null($variation['price']) || !is_null($variation['stock']);
        });

        if (!empty($variationsNotEmpty)) {
            // Get current product variations from the database
            $existingVariations = $product->variations()->pluck('id')->toArray();
            $requestVariationIds = array_filter(array_column($request->variations, 'id')); // Filter out any null/undefined IDs from the request
        
            // Find variations that are no longer in the request and delete them
            $variationsToDelete = array_diff($existingVariations, $requestVariationIds);
            $product->variations()->whereIn('id', $variationsToDelete)->delete();
        
            // Loop through the variations from the request
            foreach ($request->variations as $variation) {
                // Check if variation has an ID (exists in the database)
                if (isset($variation['id'])) {
                    // Update existing variation
                    $productVariation = $product->variations()->find($variation['id']);

                    if ($productVariation) {

                        $old_variant_stock = $productVariation->stock;

                        $productVariation->update([
                            'name' => $variation['name'],
                            'price' => $variation['price'] ?? null,
                            'stock' => $variation['stock'] ?? null
                        ]);

                        $variation_changes = $productVariation->getChanges();

                        if( !empty($variation_changes) && array_filter($variation_changes) ) {
                            if (isset($variation_changes['stock']) && $variation_changes['stock'] > 0 && $old_variant_stock == 0) {
                                
                                $reminders = StockReminder::where('product_id', $product->id)->where('product_variation_id', $productVariation->id)->get();
                
                                foreach ($reminders as $reminder) {
                                    // Send an email notification to each user
                                    Mail::to($reminder->email)->queue(new StockReminderMail($product, $productVariation));
                
                                    $reminder->delete();
                                }
                            }
                        }
                    }
                } else {
                    // Create new variation (doesn't have an ID)
                    $product->variations()->create([
                        'name' => $variation['name'],
                        'price' => $variation['price'] ?? null,
                        'stock' => $variation['stock'] ?? null
                    ]);
                }
            }
        } else {
            // If not a variation product, ensure all variations are deleted
            $product->variations()->delete();
        }

        $changes = $product->getChanges();

        if( !empty($changes) && array_filter($changes) ) {
            if (isset($changes['stock']) && $changes['stock'] > 0 && $old_stock == 0) {
                // Fetch all emails for users who have reminders for this product
                $reminders = StockReminder::where('product_id', $product->id)->get();

                foreach ($reminders as $reminder) {
                    // Send an email notification to each user
                    Mail::to($reminder->email)->queue(new StockReminderMail($product));

                    $reminder->delete();
                }
            }
        }

        return redirect()->route('backend.product.edit', $product)->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return response()->json(['success' => 'Product deleted successfully.']);
        }
        return response()->json(['error' => 'Product not found.'], 404);
    }

    public function removeImage(Request $request)
    {

        $image = ProductImage::findOrFail($request->image_id);

        $product = $image->product;

        // Assuming the image file needs to be deleted from the storage
        if (Storage::exists($image->image_url)) {
            Storage::delete($image->image_url);
        }

        $image->delete();

        $product->makePrimaryImage();

        return response()->json(['success' => true, 'message' => 'Image removed successfully.']);
    }

    private function generateUniqueSlug($slug)
    {
        $originalSlug = $slug;
        $count = 1;

        // Keep checking if the slug exists and append a number if it does
        while (Product::where('slug', $slug)->withTrashed()->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    public function destroyImage(ProductImage $image)
    {

        $product = $image->product;

        // Delete the image file from storage
        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        $product->makePrimaryImage();

        return response()->json(['success' => true]);
    }

    public function makePrimaryImage(ProductImage $image) {
        $product = $image->product;
        ProductImage::where('product_id', $product->id)->update([
            'is_primary' => '0'
        ]);
        $image->is_primary = '1';
        $image->save();
        return response()->json(['success' => true, 'message' => 'Primary image saved']);
    }
}
