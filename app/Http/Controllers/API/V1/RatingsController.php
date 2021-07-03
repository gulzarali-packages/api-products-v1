<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\V1\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\API\V1\Rating;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\API\V1\RatingResource;
use App\Traits\ResponseTrait;

class RatingsController extends BaseController
{
    use ResponseTrait;
    public function __construct()
    {
        $this->resource_name='Rating';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'rating'=>'required|between:0,5|max:50'
        ]);
        if ($validator->fails()) {
            return json_encode($validator->errors());
        }

        $rating=new Rating();
        $rating->comments=$request->comments;
        $rating->rating=$request->rating;
        $rating->product_id=$request->product_id;

        if($rating->save()){
            return $this->resourceStored(new RatingResource($rating));
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
            $rating=Rating::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->resourceNotFind();
        }
        return new RatingResource($rating);
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
        $validator = Validator::make($request->all(), [
            'rating'=>'required|between:0,5|max:50'
        ]);
        if ($validator->fails()) {
            return json_encode($validator->errors());
        }

        $rating=Rating::findOrFail($id);
        $rating->comments=$request->comments;
        $rating->rating=$request->rating;
        $rating->product_id=$request->product_id;

        if($rating->update()){
            return $this->resourceUpdated(new RatingResource($rating));
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
            $rating=Rating::findOrFail($id);
            if($rating->delete()){
                return $this->resourceDeleted(new RatingResource($rating));
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->resourceNotFind();
        }
        return json_encode(['message'=>'error occured while deleting the resource']);
    }
}
