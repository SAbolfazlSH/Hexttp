<?php

namespace Hexttp;

/**
 * @method static Response get(string $url, array|string $body = [], string[] $headers = [], array $options = [])
 * @method static Response post(string $url, array|string $body = [], string[] $headers = [], array $options = [])
 * @method static Response put(string $url, array|string $body = [], string[] $headers = [], array $options = [])
 * @method static Response delete(string $url, array|string $body = [], string[] $headers = [], array $options = [])
 * @method static Response options(string $url, array|string $body = [], string[] $headers = [], array $options = [])
 * @method static Response patch(string $url, array|string $body = [], string[] $headers = [], array $options = [])
 * @method static Response head(string $url, array|string $body = [], string[] $headers = [], array $options = [])
 * @method static Response connect(string $url, array|string $body = [], string[] $headers = [], array $options = [])
 * @method static Response trace(string $url, array|string $body = [], string[] $headers = [], array $options = [])
 */
class Request {
    static function __callStatic($name, $args) {
        if(in_array($name, ['get', 'post', 'put', 'delete', 'options', 'patch', 'head', 'connect', 'trace'])) {
            return static::request($name, $args[0], $args[1] ?? [], $args[2] ?? [], $args[3] ?? []);
        }
    }

    private static function request($method, $url, $body, $headers) {
        $c = curl_init();
        curl_setopt($c, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_POSTFIELDS, http_build_query($body));
        curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($c);
        $info = curl_getinfo($c);
        curl_close($c);
        return new Response($res, $info);
    }
}