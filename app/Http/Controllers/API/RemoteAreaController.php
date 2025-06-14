<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RemoteAreaResource;
use App\Http\Controllers\API\Traits\ApiResponseTrait;

class RemoteAreaController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        $remoteAreas = config('remote_areas');

        $data = collect($remoteAreas)->map(function ($areas, $emirate) {
            return ['emirate' => $emirate, 'areas' => $areas];
        })->values();

        return $this->ApiResponse(RemoteAreaResource::collection($data), 'success', 200);
    }
}
