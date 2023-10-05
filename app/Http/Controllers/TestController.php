<?php

namespace App\Http\Controllers;

use App\Jobs\WhatsappNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function woowa(Request $request): JsonResponse
    {
        if ($request->no == "") {
            return responseError("param no tidak ada", 400);
        }

        $message = 'test kirim pesan via woowa dari server pada ' . date('d-m-Y H:i:s') . ' ke nomor ' . $request->no;
        $data = ['phone' => $request->no, 'message' => $message];

        dispatch(new WhatsappNotification($data));
        return responseSuccess($data);
    }
}
