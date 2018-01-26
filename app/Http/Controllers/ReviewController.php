<?php

namespace App\Http\Controllers;

use App\Exceptions\ProductNotBelongsToUser;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class ReviewController extends Controller
{

    /**
     * ReviewController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except('index','show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        return ReviewResource::collection($product->reviews);
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
    public function store(ReviewRequest $request,Product $product)
    {
        $this->reviewUserCheck($product);
        $review = new Review($request->all());
        $product->reviews()->save($review);
        return response([
            'data'=> new ReviewResource($review)
        ],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product,Review $review)
    {
        return $review;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Product $product, Review $review)
    {
        $this->reviewUserCheck($product);
        $review->update($request->all());
        return response([
            'data'=> new ReviewResource($review)
        ],Response::HTTP_CREATED);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product,Review $review)
    {
        $this->reviewUserCheck($product);
        $review->delete();
        return response(null,Response::HTTP_NO_CONTENT);

    }

    public function reviewUserCheck($product){
        if (Auth::id() !== $product->user_id){
            throw new ProductNotBelongsToUser;
        }
    }
}
