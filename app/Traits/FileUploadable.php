<?php

namespace App\Traits;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait FileUploadable
{
    /**
     * @var string
     */
    protected $uploadPath = 'uploads';

    /**
     * @var string
     */
    public $rule = 'required|mimes:jpg,jpeg,png,pdf,doc,docx|max:5000'; // max 5mb

    /**
     * @return bool
     */
    private function createUploadFolder(): bool
    {
        $public_upload_dir = public_path($this->uploadPath);
        if (!file_exists($public_upload_dir)) {
            mkdir($public_upload_dir, 0777);
            return true;
        }

        return false;

    }

    /**
     * For handle validation file action
     *
     * @param $file
     * @return fileUploadTrait|\Illuminate\Http\RedirectResponse
     */
    private function validateFileAction($file)
    {

        $rules = array('attachment' => $this->rule);
        $file  = array('attachment' => $file);

        $fileValidator = app('validator')->make($file, $rules);

        if ($fileValidator->fails()) {

            $messages = $fileValidator->messages();

            throw new ValidationException($fileValidator);

        }
    }

    /**
     * For Handle validation file
     *
     * @param $files
     * @return fileUploadTrait|\Illuminate\Http\RedirectResponse
     */
    private function validateFile($files)
    {

        if (is_array($files)) {
            foreach ($files as $file) {
                return $this->validateFileAction($file);
            }
        }

        return $this->validateFileAction($files);
    }

    /**
     * For Handle Put File
     *
     * @param $file
     * @return string
     */
    private function putFile($file)
    {
        $originalName = $file->getClientOriginalName();
        $filename = pathinfo($originalName, PATHINFO_FILENAME);
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $cleanName = preg_replace('/[^\p{L}\p{N}\s]/u', '', $filename);
        $fileName = preg_replace('/\s+/', '_', time() . ' ' . $cleanName . '.' . $extension);

        $file->move($this->uploadPath, $fileName);

        return url($this->uploadPath . '/' . $fileName);
    }

    /**
     * For Handle Save File Process
     *
     * @param $files
     * @return array|string
     */
    public function saveFiles($files)
    {
        $data = [];
        if ($files != null){
            $this->validateFile($files);
            $this->createUploadFolder();

            if (is_array($files)) {
                foreach ($files as $file) {
                    $data[] = $this->putFile($file);
                }
            } else {
                return $this->putFile($files);
            }
        }

        return $data;
    }
}
