<?php

namespace PiEdgePy;

/**
 * Instantiate a Router object to make requests.
 *
 * The Router object determines the rules for the
 * requests and their response via anonymous
 * functions defined in the 'index.php' files.
 *
 * @since 1.0.0
 */
class Router
{
    /**
     * Router attributes, all privates.
     *
     * @since 1.0.0
     * @var string $base_req Router base URI, default value '/'.
     */
    private string $base_req;

    function __construct(string $base_req = '/') {
        $this->base_req = $base_req;
    }

    /**
     * Set a Router rule for a request using the GET method.
     *
     * It executes an anonymous function when it receives a request
     * from a GET method.
     *
     * @since 1.0.0
     *
     * @see route
     *
     * @param string $req Requested URI.
     * @param callable $res Anonymous function to execute as response.
     * @return self Self reference for method chaining.
     */
    function get(string $req, callable $res):self {
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
            $this->route($req, $res);
        return $this;
    }

    function post(string $req, callable $res):self {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
            $this->route($req, $res);
        return $this;
    }

    function put(string $req, callable $res):self {
        if ($_SERVER['REQUEST_METHOD'] === 'PUT')
            $this->route($req, $res);
        return $this;
    }

    function del(string $req, callable $res):self {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE')
            $this->route($req, $res);
        return $this;
    }

    function all(string $req, callable $res):self {
        $this->route($req, $res);
        return $this;
    }

    /**
     * Remove unnecessary slashes from the request.
     *
     * @since 1.0.0
     *
     * @see route
     *
     * @param string $req Requested URI.
     * @return string Cleaned request, without unnecessary slashes.
     */
    private function cleanRequest(string $req):string {
        $new_req = preg_replace('/\/+/', '/', $this->base_req . $req);
        if (in_array($new_req, ['', '/']))
            return '/';
        $last_char = substr($new_req, -1);
        return $last_char !== '/' ? $new_req : rtrim($new_req, $last_char);
    }

    private function route(string $req, callable $res):void {
        $route = $this->cleanRequest($req);
        $uri = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
        if (!$uri)
            return;
        if ($uri === $route)
            $this->response($res);
    }

    private function response(callable $response):void {
        if (is_callable($response))
            call_user_func($response);
        die;
    }
}
