<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\CommentResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $products = Product::with('categories', 'images', 'comments')->paginate(10);
        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $product = Product::create($request->validated());
        $product->categories()->sync($request->categories);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_images', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product->load('categories', 'images', 'comments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        $product->categories()->sync($request->categories);

        if ($request->hasFile('images')) {
            $product->images()->delete();
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_images', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }
        return new ProductResource($product->load('categories', 'images'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // delete images
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $product->delete();
        return response()->json(null, 204);
    }

    public function showProducts(Product $product)
    {
        $product->load('categories', 'comments');
        return response()->json([
            'data' => $product,
        ]);
    }
    public function addComment(Request $request, Product $product)
    {
        $request->validate([
            'body' => 'required|string|max:500',
        ]);
        $authenticatedUser = Auth::user();
        if (!$authenticatedUser) {
            return response()->json(['message' => 'Unauthenticated. Please log in.'], 401);
        }
        
        $comment = new Comment();
        $comment->product_id = $product->id;
        $comment->user_id = $authenticatedUser->id;
        $comment->user_name = $authenticatedUser->name;
        $comment->body = $request->body;
        $comment->save();

        return new CommentResource($comment);
    }
}
