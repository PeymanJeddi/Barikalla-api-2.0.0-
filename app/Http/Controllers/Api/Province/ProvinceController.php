<?php

namespace App\Http\Controllers\Api\Province;

use App\Http\Controllers\Controller;
use App\Http\Resources\Common\KindResource;
use App\Models\Kind;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/province",
     * operationId="provinceList",
     * tags={"Province"},
     * summary="Get provinces list",
     * security={ {"sanctum": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Your request has been successfully completed.",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="bool", example="true"),
     *       @OA\Property(property="message", type="string", example="Your request has been successfully completed."),
     *       @OA\Property(property="data"),
     *        )
     *     ),
     * )
     */
    public function province()
    {
        $provinces = Kind::findByKey('province')->get();
        return sendResponse('Provinces', KindResource::collection($provinces));
    }

    /**
     * @OA\Get(
     * path="/api/province/{province_id}",
     * operationId="cityList",
     * tags={"Province"},
     * summary="Get cities list",
     * security={ {"sanctum": {} }},
     * @OA\Parameter(name="province_id",in="path",description="14",required=true),
     * @OA\Response(
     *    response=200,
     *    description="Your request has been successfully completed.",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="bool", example="true"),
     *       @OA\Property(property="message", type="string", example="Your request has been successfully completed."),
     *       @OA\Property(property="data"),
     *        )
     *     ),
     * )
     */
    public function city(Kind $kind)
    {
        $cities = $kind->childs;
        return sendResponse('Cities', KindResource::collection($cities));
    }
}
