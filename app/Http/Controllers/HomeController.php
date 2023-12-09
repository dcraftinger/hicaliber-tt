<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertySearchRequest;
use App\Models\Property;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(
        PropertySearchRequest $request,
    ): \Inertia\Response {
        $searchFilters = $request->all(array_keys($request->validated()));
        $searchResults = Property::filtered($searchFilters)->paginate();

        return Inertia::render('HomePage', [
            'results' => $searchResults,
            'filters' => $searchFilters,
        ]);
    }
}
