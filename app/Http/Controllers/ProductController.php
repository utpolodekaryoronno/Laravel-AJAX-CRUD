<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

class ProductController extends Controller
{
    // Products Dashboard
    public function products(){
        $products = Product::latest()->paginate(5);
        return view('products',compact('products'));
    }


    // add Product
    public function addProduct(Request $request){
        $request->validate(
            [
                'name'      =>'required|unique:products',
                'title'     =>'required',
                'price'     =>'required|numeric',
                'image'     => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            ]
        );

        // file upload
        $imageName = null;

        if($request->hasFile('image')){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/products/'), $imageName);
        }

        Product::create([
            'name'  => $request->name,
            'title' => $request->title,
            'price' => $request->price,
            'image' => $imageName
        ]);

        return response()->json([
            'status'=> 'success',
        ]);
    }





     // update Product
     public function updateProduct(Request $request){
        $request->validate([
            'up_name'=>'required|unique:products,name,'.$request->up_id,
            'up_title'=>'required',
            'up_price'=>'required',
            // 'image'=>'nullable',
        ]);

        Product::where('id',$request->up_id)->update([
            'name'=> $request->up_name,
            'title'=> $request->up_title,
            'price'=> $request->up_price,
        ]);

        return response()->json([
            'status'=> 'success',
        ]);
    }

    // Product View
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return response()->json($product);
    }


     // Delete Product
     public function deleteProduct(Request $request){

        // Find the product
        $product = Product::findOrFail($request->product_id);

        // Delete image file if exists
        $imgPath = public_path('uploads/products/' . $product->image);
        if ($product->image && file_exists($imgPath)) {
            unlink($imgPath);
        }

        // Delete product from database
        $product->delete();

        return response()->json([
            'status'=> 'success',
        ]);
     }

     // Pagination controllar
     public function pagination(Request $request){
        $products = Product::latest()->paginate(5);
        return view('pagination_products',compact('products')) ->render();
     }


     // Search controllar

     public function productSearch(Request $request){
        $products = Product::where('name', 'like', '%'.$request->search_string.'%')
                            ->orWhere('price', 'like', '%'.$request->search_string.'%')
                            ->orderBy('id', 'desc')
                            ->paginate(5);
                            // dd($products);


        if ($products->count() >= 1) {
            $dataView = view('pagination_products', compact('products'))->render();
            return response()->json([
                // 'status' => "successful",
                'html' => $dataView, // Include the rendered HTML in the response
            ]);
        } else {
            return response()->json([
                'status' => "nothing_found",
            ]);
        }



     }
}
