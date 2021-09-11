<?php

namespace PhpTask\Lib\Kernel;

class Request
{
    protected function __construct()
    {
    }

    /**
     * Returns an instance of \PhpTask\Lib\Kernel\Request.
     * 
     * @return PhpTask\Lib\Kernel\Request
     */
    public static function createFromJson($json)
    {
        $queryString = $_GET;

        $request = new self();
        $request = self::fillFromJsonBody($request, $json);
        $request = self::fillFromArray($request, $queryString);

        return $request;
    }

    /**
     * Returns an instance of \PhpTask\Lib\Kernel\Request.
     * 
     * @return PhpTask\Lib\Kernel\Request
     */
    
    public static function createFromPostData()
    {
        $postData = $_POST;
        $queryString = $_GET;

        $request = new self();
        $request = self::fillFromArray($request, $postData);
        $request = self::fillFromArray($request, $queryString);

        return $request;
    }

    /**
     * @return PhpTask\Lib\Kernel\Request
     */
    private static function fillFromJsonBody($request, $jsonBody)
    {
        if ($jsonBody == null) return $request;
        $data = json_decode($jsonBody, true);
        $request = self::fillFromArray($request, $data);
        return $request;
    }

    /**
     * @return PhpTask\Lib\Kernel\Request
     */
    private static function fillFromArray($request, $array)
    {
        foreach ($array as $key => $value) {
            $request->$key = $value;
        }
        return $request;
    }
}
