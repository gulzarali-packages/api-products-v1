<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\API\V1\Category;
use App\Models\API\V1\Product;
use App\Http\Resources\API\V1\CategoriesResource;
use App\Http\Resources\API\V1\ProductsResource;
use App\Traits\FileTrait;
use App\Traits\ResponseTrait;

class CategoriesController extends BaseController
{
    use FileTrait,ResponseTrait;
    public function __construct()
    {
        $this->resource_name='Category';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories=Category::paginate(10);
        return CategoriesResource::collection($categories);
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
            'name'=>'required|unique:categories|max:50'
        ]);
        if ($validator->fails()) {
            return json_encode($validator->errors());
        }

        $category=new Category();
        $category->name=$request->name;

        if($request->file('thumb_nail')){
            $thumb_nail=$this->cleanFileName($request->name);
            $extension = $request->file('thumb_nail')->extension();
            $file_name=$thumb_nail.'.'.$extension;
            $request->file('thumb_nail')->storeAs('images/categories',$file_name);
            $category->thumb_nail=$file_name;
        }

        if($category->save()){
            return $this->resourceStored(new CategoriesResource($category));
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
            $category=Category::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->resourceNotFind();
        }
        return new CategoriesResource($category);
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
            $category=Category::findOrFail($id);
            $category->name=$request->name;
            if($request->file('thumb_nail')){
                $thumb_nail=$this->cleanFileName($request->name);
                $extension = $request->file('thumb_nail')->extension();
                $file_name=$thumb_nail.'.'.$extension;
                $request->file('thumb_nail')->storeAs('images/categories',$file_name);
                $category->thumb_nail=$file_name;
            }
            if($category->update()){
                return $this->resourceUpdated(new CategoriesResource($category));
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
            $category=Category::findOrFail($id);
            if($category->delete()){
                return $this->resourceDeleted(new CategoriesResource($category));
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->resourceNotFind();
        }
        return json_encode(['message'=>'error occured while deleting the resource']);
    }

    /**
     * load products based on category
     */
    public function products(Category $category)
    {
        $products = Product::where('category_id', $category->id)->paginate(10);

        return ProductsResource::collection($products);
    } 
}
