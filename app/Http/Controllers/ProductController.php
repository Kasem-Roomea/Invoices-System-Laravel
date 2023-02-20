<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\section;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:المنتجات', ['only' => ['index','store']]);
        $this->middleware('permission:اضافة منتج', ['only' => ['create','store']]);
        $this->middleware('permission:تعديل منتج', ['only' => ['edit','update']]);
        $this->middleware('permission:حذف منتج', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = section::all();
        $products = product::all();
        return view('products.products' , compact('sections' , 'products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'Product_name.required' => 'أسم المنتج مطلوب',
            'Product_name.unique' => 'أسم المنتج مسجل مسبقا',
            'Product_name.max' => 'أسم المنتج يحتوي على أحرف اكتر من المطلوب',
            'description.max' => 'الملاحظات تحتوي على عدد أحرف اكتر من المطلوب',
        ];
        $rule =[
            'Product_name'=>'required|unique:products,product_name|max:255',
            'description'=>'max:255'
        ];
        $validated = $request->validate($rule , $messages);


        product::create([
            'product_name'=> $request->Product_name,
            'description'=> $request->description,
            'section_id'=> $request->section_id,
        ]);

        session()->flash("Add" , "تم أضافة المنتج بنجاح");
        return redirect('/products');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $productUpdate = $request -> product_name;
        $messages = [
            'product_name.required' => 'أسم المنتج مطلوب',
            'product_name.unique' => 'أسم المنتج مسجل مسبقا',
            'product_name.max' => 'أسم المنتج يحتوي على أحرف اكتر من المطلوب',
            'description.max' => 'الملاحظات تحتوي على عدد أحرف اكتر من المطلوب',
        ];
        $rule =[
            'product_name'=>'required|unique:products,product_name|max:255',
            'description'=>'max:255',
        ];
        $validated = $request->validate($rule , $messages);
        $product= product::find($request->pro_id);
        $id_section = section::where('section_name', $request->section_name)->first()->id;

        $product->update([
            "product_name"=> $request -> product_name ,
            "section_id"=>  $id_section ,
            "description"=> $request -> description,
        ]);
        session()->flash('edit' , "تم التعديل بنجاح");
        return redirect('/products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $Products = Product::findOrFail($request->pro_id);
        $Products->delete();
        session()->flash('delete', 'تم حذف المنتج بنجاح');
        return back();
    }
}
