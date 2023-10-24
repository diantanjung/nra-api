<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /**
     * Store a upload.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'file' => 'required|file|mimes:pdf,doc,docx,jpeg,png,jpg|max:5120',
        ]);

        $file_name = randomString(20) . '_' . time() . '.' . $request->file->extension();
        Storage::disk('public')->put($file_name, file_get_contents($request->file));

        // $cdn_url = config('filesystems.disks.do.cdn_endpoint') . "/" . $file_name;
        return responseSuccess($file_name);
    }
}
