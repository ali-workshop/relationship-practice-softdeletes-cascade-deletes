<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        
        // $products=Product::all();
        // laod the relation
        
            $products=Product::with('category')->get();
        return view('product.index',[
            'products'=>$products,
              
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $categories=Category::all();
        return view('product.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product_data=$request->validate([
            'name'=>['required','string','max:8'],
            'quintity'=>['integer','min:0'],
            'category_id'=>['required','integer','exists:categories,id'],

        ]);

        $product=new Product();
        $product->name=$request->name;
        $product->quintity=$request->quintity;
        $product->category_id=$request->category_id;
        $product->avaliable=false;
        if($product->quintity>0){
            $product->avaliable=true;  
        }
        
        $product->save();
        
        // another way : Category::creat($product_data);

        return redirect()
        ->route('products.index')
        ->with('success','the product is added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('product.show',['product'=>$product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('product.edit',['product'=>$product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
       

        
        
        $product_data=$request->validate([
            'name'=>['required','string','max:8'],
            'quintity'=>['integer','min:0'],

        ]);

        $product=Product::find($product->id);
        $product->name=$request->name;
        $product->quintity=$request->quintity;
        $product->avaliable=false;
        if($product->quintity>0){
            $product->avaliable=true;  
        }
        
        $product->save();
        

        // another way : Product::creat($product_data);

        return redirect()
        ->route('products.index')
        ->with('success','the product is updated successfully');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()
        ->route('products.index')
        ->with('success','the product is Deleted successfully');
     
    }
}
