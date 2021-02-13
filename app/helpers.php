<?php

if (!function_exists('get_emoji_regex'))
{
    /**
     * 이모지에 매칭되는 regex 를 반환한다.
     *
     * @see https://stackoverflow.com/a/12824140
     * @return string
     */
    function get_emoji_regex()
    {
        return '[\x{1F600}-\x{1F64F}]|[\x{1F300}-\x{1F5FF}]|[\x{1F680}-\x{1F6FF}]|[\x{2600}-\x{26FF}]|[\x{2700}-\x{27BF}]';
    }
}

if (!function_exists('is_emoji'))
{
    /**
     * 문자를 주면 그게 이모지인지 알려준다.
     *
     * @param string $character
     * @return boolean
     */
    function is_emoji($character)
    {
        return (bool) preg_match('/^'.get_emoji_regex().'$/mu', $character);
    }
}

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