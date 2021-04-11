<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ReviewStoreRequest;
use App\Http\Requests\Api\ReviewUpdateRequest;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $reviews = Review::all();

        return view('review.index', compact('reviews'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('review.create');
    }

    /**
     * @param \App\Http\Requests\Api\ReviewStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReviewStoreRequest $request)
    {
        $review = Review::create($request->validated());

        $request->session()->flash('review.id', $review->id);

        return redirect()->route('review.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Review $review
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Review $review)
    {
        return view('review.show', compact('review'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Review $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Review $review)
    {
        return view('review.edit', compact('review'));
    }

    /**
     * @param \App\Http\Requests\Api\ReviewUpdateRequest $request
     * @param \App\Models\Review $review
     * @return \Illuminate\Http\Response
     */
    public function update(ReviewUpdateRequest $request, Review $review)
    {
        $review->update($request->validated());

        $request->session()->flash('review.id', $review->id);

        return redirect()->route('review.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Review $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Review $review)
    {
        $review->delete();

        return redirect()->route('review.index');
    }
}
