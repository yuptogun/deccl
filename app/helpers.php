<?php

if (!function_exists('is_valid_url'))
{
    /**
     * 문자열을 주면 그게 유효한 URL 이 맞는지 알려준다.
     *
     * @param string $string
     * @return boolean
     */
    function is_valid_url($string)
    {
        return filter_var($string, FILTER_VALIDATE_URL);
    }
}

if (! function_exists('mix'))
{
    /**
     * Get the path to a versioned Mix file.
     *
     * @param string $path
     * @param string $manifestDirectory
     * @return string
     *
     * @throws \Exception
     */
    function mix($path, $manifestDirectory = '')
    {
        static $manifest;
        $publicFolder = '/public';
        $rootPath = base_path();
        $publicPath = $rootPath . $publicFolder;
        if ($manifestDirectory && ! strpos($manifestDirectory, '/') !== 0) {
            $manifestDirectory = "/{$manifestDirectory}";
        }
        if (! $manifest) {
            $manifestPath = ($rootPath . $manifestDirectory.'/public/mix-manifest.json');
            // dd($manifestPath);
            if (! file_exists($manifestPath)) {
                throw new Exception('The Mix manifest does not exist.');
            }
            $manifest = json_decode(file_get_contents($manifestPath), true);
        }
        if (!strpos($path, '/') !== 0) {
            $path = "/{$path}";
        }
        // $path = $path;
        if (! array_key_exists($path, $manifest)) {
            throw new Exception(
                "Unable to locate Mix file: {$path}. Please check your ".
                'webpack.mix.js output paths and try again.'
            );
        }
        return file_exists($publicPath . ($manifestDirectory.'/hot'))
            ? env('APP_URL').$manifest[$path]
            : $manifestDirectory.$manifest[$path];
    }
}