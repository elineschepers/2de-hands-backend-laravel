<?php

namespace App\Http\Controllers;

use App\Http\Resources\Offers\OfferListResource;
use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function index(Request $request)
    {
        $offers = Offer::with('media');

        // If there is a search query, get them first and then filter the results
        if ($request->has('q')) {
            $search_results = Offer::search($request->q);

            $offers = $offers->whereIn('uuid', $search_results->keys());
        }

        $offers = $offers->filter($request)->paginate(12);

        return OfferListResource::collection($offers);
    }

    public function show($uuid): OfferListResource
    {
        $offer = Offer::with('media', 'user', 'courses', 'courses.programs')->firstUUID($uuid);

        return new OfferListResource($offer);
    }
}
