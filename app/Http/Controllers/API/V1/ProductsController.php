<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use \Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\API\V1\Product;
use App\Http\Resources\API\V1\ProductsResource;
use App\Traits\FileTrait;
use App\Traits\ResponseTrait;

class ProductsController extends Controller
{
    use FileTrait,ResponseTrait;
    public function __construct()
    {
        $this->resource_name='Product';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=Product::with('rating')->paginate(10);
        // $foreach
        // return $products;

        return ProductsResource::collection($products);
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
        $validator = Validator::make($request->all(), [
            'name'=>'required|unique:products|max:50',
            'description'=>'max:300',
            'monthly_rent'=>'between:0,99.99|required',
            'refundable_deposit'=>'between:0,99.99',
            'category_id'=>'required|integer',
            'refundable_deposit'=>'required'
        ]);
        if ($validator->fails()) {
            return json_encode($validator->errors());
        }

        $product=new Product();
        $product->name=$request->name;
        $product->description=$request->description;
        $product->monthly_rent=$request->monthly_rent;
        $product->refundable_deposit=$request->refundable_deposit;
        $product->size=$request->size;
        $product->discount=$request->discount;
        $product->category_id=$request->category_id;

        if($request->file('thumb_nail')){
            $thumb_nail=$this->cleanFileName($request->name);
            $extension = $request->file('thumb_nail')->extension();
            $file_name=$thumb_nail.'.'.$extension;
            $request->file('thumb_nail')->storeAs('images/products',$file_name);
            $product->thumb_nail=$file_name;
        }

        if($product->save()){
            return $this->resourceStored(new ProductsResource($product));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $product=Product::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->resourceNotFind();
        }
        return new ProductsResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $product=Product::findOrFail($id);
            $product->name=$request->name;
            $product->description=$request->description;
            $product->monthly_rent=$request->monthly_rent;
            $product->refundable_deposit=$request->refundable_deposit;
            $product->size=$request->size;
            $product->discount=$request->discount;
            $product->category_id=$request->category_id;

            if($request->file('thumb_nail')){
                $thumb_nail=$this->cleanFileName($request->name);
                $extension = $request->file('thumb_nail')->extension();
                $file_name=$thumb_nail.'.'.$extension;
                $request->file('thumb_nail')->storeAs('images/products',$file_name);
                $product->thumb_nail=$file_name;
            }

            if($product->update()){
                return $this->resourceUpdated(new ProductsResource($product));
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->resourceNotFind();
        }
        return json_encode(['message'=>'error occured while updating the resource']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $product=Product::findOrFail($id);
            if($product->delete()){
                return $this->resourceDeleted(new ProductsResource($product));
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->resourceNotFind();
        }
        return json_encode(['message'=>'error occured while deleting the resource']);
    }
}
