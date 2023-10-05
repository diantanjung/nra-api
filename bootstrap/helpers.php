<?php

if (!function_exists('config_path')) {
    /**
     * Get the configuration path.
     *
     * @param  string $path
     * @return string
     */
    function config_path($path = '')
    {
        return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
    }
}

if (!function_exists('public_path')) {
    /**
     * Get the path to the public folder.
     *
     * @param  string $path
     * @return string
     */
    function public_path($path = '')
    {
        return app()->basePath() . '/public' . ($path ? '/' . $path : $path);
    }
}

if (!function_exists('indo_number')) {
    /**
     * Get the indonesian number format.
     *
     * @param  int $number
     * @param  int $decimal
     * @return string
     */
    function indo_number($number, $decimal = 2)
    {
        return number_format($number, $decimal, ',', '.');
    }
}

if (!function_exists('rupiah')) {
    /**
     * Get the indonesian rupiah format.
     *
     * @param  int $number
     * @param  int $decimal
     * @return string
     */
    function rupiah($number, $decimal = 2)
    {
        return "Rp. " . indo_number($number, $decimal);
    }
}

if (!function_exists('responseError')) {
    function responseError($message, $status = 400, $data = [])
    {
        return response()->json(['message' => $message, 'status' => $status, 'data' => $data], $status);
    }
}

if (!function_exists('responseSuccess')) {
    function responseSuccess($data, $message = 'sukses', $status = 200)
    {
        return response()->json(['message' => $message, 'status' => $status, 'data' => $data], $status);
    }
}

if (!function_exists('randomString')) {
    function randomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (!function_exists('indo_day')) {
    /**
     * Get the indonesian day format.
     *
     * @param  int $number
     * @param  bool $is_short
     * @return string
     */
    function indo_day($day_number, $is_short = false)
    {
        $listDay = [1 => "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"];
        $day_name = $listDay[$day_number];
        if ($is_short) {
            $day_name = substr($day_name, 0, 3);
        }

        return $day_name;
    }
}
