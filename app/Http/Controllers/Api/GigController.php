<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gig;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class GigController extends Controller
{
    /**
     * List gigs with basic pagination and optional filtering.
     * GET /api/gigs
     */
    public function index(Request $request): JsonResponse
    {
        $query = Gig::query();

        if ($request->filled('category')) {
            $query->where('category', $request->string('category'));
        }

        if ($request->filled('seller_id')) {
            $query->where('seller_id', $request->integer('seller_id'));
        }

        $gigs = $query->orderByDesc('created_at')->paginate(
            perPage: $request->integer('per_page', 10)
        );

        return response()->json($gigs);
    }

    /**
     * Show a single gig.
     * GET /api/gigs/{gig}
     */
    public function show(Gig $gig): JsonResponse
    {
        return response()->json($gig);
    }

    /**
     * Create a new gig.
     * POST /api/gigs
     */
    public function store(Request $request): JsonResponse
    {
        $data = $this->validateData($request);

        $gig = Gig::create($data);

        return response()->json($gig, 201);
    }

    /**
     * Update an existing gig.
     * PUT /api/gigs/{gig}
     */
    public function update(Request $request, Gig $gig): JsonResponse
    {
        $data = $this->validateData($request, isUpdate: true);

        $gig->update($data);

        return response()->json($gig);
    }

    /**
     * Delete a gig.
     * DELETE /api/gigs/{gig}
     */
    public function destroy(Gig $gig): JsonResponse
    {
        $gig->delete();

        return response()->json(null, 204);
    }

    /**
     * Shared validation logic for create/update.
     */
    protected function validateData(Request $request, bool $isUpdate = false): array
    {
        $rules = [
            'title'       => [$isUpdate ? 'sometimes' : 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price'       => [$isUpdate ? 'sometimes' : 'required', 'numeric', 'min:0'],
            'category'    => [$isUpdate ? 'sometimes' : 'required', 'string', 'max:255'],
            'seller_id'   => [$isUpdate ? 'sometimes' : 'required', 'integer'],
        ];

        return $request->validate($rules);
    }
}
