<?php

namespace App\Http\Controllers\API\Traits;

use Illuminate\Support\Facades\Validator;

/**
 * Tarit for standard Api Response
 * [
 * 'data',
 * 'message',
 * 'status'
 * ]
 */
trait ApiResponseTrait
{
    public $paginateNumber = 10;

    public function ApiResponse($data = [] , $message = null, $code = 200)
    {
            $array =
            [
                'data'    => $data,
                'message' => $message,
                'status'  => in_array($code ,$this->successCode())? true : false
            ];

            return response()->json($array,$code);
    } // end of api response

    public function successCode()
    {

        return [
            200 ,201 ,202
        ];

    } // end of success code

    public function notFoundResponse()
    {

        return $this->ApiResponse(null , __('Not Found') , 404);

    } // end of not found response

    public function apiValidation($request , $array)
    {

        $validate = Validator::make($request->all() , $array);

        if ($validate->fails())
        {
            return $this->ApiResponse(null , $validate->errors() , 422);
        }

    } // end of api validate


    public function ApiPaginationResponse($data = [] , $message = null, $code = 200)
    {
        $array =
        [
            'data'    => [
                'body' => $data->items(),
                'pagination' => [
                    'current_page' => $data->currentPage(),
                    'last_page' => $data->lastPage(),
                    'per_page' => $data->perPage(),
                    'total' => $data->total(),
                ] ,
                   'links' => [
                       'next_page_url' => $data->nextPageUrl(),
                       'prev_page_url' => $data->previousPageUrl(),
                   ],
            ],

            'message' => $message,
            'status'  => in_array($code ,$this->successCode())? true : false
        ];

        return response()->json($array,$code);
    } // end of api response

}


