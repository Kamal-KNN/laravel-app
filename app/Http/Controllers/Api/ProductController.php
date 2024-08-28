<?php

namespace App\Http\Controllers\Api;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Validator;


class ProductController extends Controller
{
    //

    public function index()
    {
        $products = Product::get();
        if ($products->count() > 0) {
            return ProductResource::collection($products);
        } else {
            return response()->json(['message' => 'No Data Found'], 200);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|string',
            'description' => 'required',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->save();

        // $product = Product::create([
        //     'name' => $request->name,
        //     'price' => $request->price,
        //     'description' => $request->description
        // ]);

        dd($request);

        return response()->json([
            'message' => 'Data created  successfully',
            "data" => new ProductResource($product)
        ], 200);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);

    }

    public function update(Request $request,$id)
    {
        dd($id);

    $product = Product::findOrFail($id);
    


    $validatedData = $request->validate([
        'name' => 'sometimes|required|string|max:255',
        'description' => 'sometimes|string',
        'price' => 'sometimes|required|string',
    ]);


    $product->update($validatedData);


    return response()->json([
        'message' => 'Product updated successfully',
        'product' => $product
    ]);

    }

    public function destroy(Product $product)
    {
$product->delete();
return response()->json([
    'message'=> 'deleted successfully',

],200);

    }
}






