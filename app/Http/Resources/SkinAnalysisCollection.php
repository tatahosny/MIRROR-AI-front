<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SkinAnalysisCollection extends ResourceCollection
{
    /**
     * The resource that this resource collects.
     */
    public $collects = SkinAnalysisResource::class;

    /**
     * Transform the resource collection into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
        ];
    }

    /**
     * Customize pagination response.
     */
    public function paginationInformation(Request $request, array $paginated, array $default): array
    {
        return [
            'meta' => [
                'current_page' => $paginated['current_page'],
                'last_page'    => $paginated['last_page'],
                'per_page'     => $paginated['per_page'],
                'total'        => $paginated['total'],
            ],
            'links' => [
                'first' => $paginated['first_page_url'],
                'last'  => $paginated['last_page_url'],
                'prev'  => $paginated['prev_page_url'],
                'next'  => $paginated['next_page_url'],
            ],
        ];
    }
}
