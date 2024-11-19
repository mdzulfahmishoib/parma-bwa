<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->orderBy('id', 'desc')->get();
        return view('admin.products.index', [
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'about' => 'required|string',
            'photo' => 'required|image|mimes:png,jpg,jpeg,svg|max:5120',
        ]); 

        DB::beginTransaction();

        try {
            if($request->hasFile('photo')){
                $iconPath = $request->file('photo')->store('product_photos', 'public');
                $validated['photo'] = $iconPath;
            }
            $validated['slug'] = Str::slug($request->name);
            // obat sakit -> obat-sakit
            $newProduct = Product::create($validated);

            DB::commit();

            return redirect()->route('admin.products.index');

        } catch(\Exception $e){
            DB::rollBack();

            $error = ValidationException::withMessages([
                'system_error' => ['System error!' . $e->getMessage()],
            ]);
            throw $error;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'price' => 'sometimes|string|max:255',
            'category_id' => 'sometimes|integer',
            'about' => 'sometimes|string',
            'photo' => 'sometimes|image|mimes:png,jpg,jpeg,svg|max:5120',
        ]); 

        DB::beginTransaction();

        try {
            if($request->hasFile('photo')){
                $iconPath = $request->file('photo')->store('product_photos', 'public');
                $validated['photo'] = $iconPath;
            }
            $validated['slug'] = Str::slug($request->name);
            // obat sakit -> obat-sakit
            $product->update($validated);

            DB::commit();

            return redirect()->route('admin.products.index');

        } catch(\Exception $e){
            DB::rollBack();

            $error = ValidationException::withMessages([
                'system_error' => ['System error!' . $e->getMessage()],
            ]);
            throw $error;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try{
            $product->delete();
            return redirect()->back();
        } catch(\Exception $e){
            DB::rollBack();

            $error = ValidationException::withMessages([
                'system_error' => ['System error!' . $e->getMessage()],
            ]);
            throw $error;
        }
    }
}
