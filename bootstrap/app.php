<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

if (! function_exists('mb_strimwidth')) {
    function mb_strimwidth(string $string, int $start, int $width, string $trim_marker = '', ?string $encoding = null): string
    {
        $encoding = $encoding ?? 'UTF-8';
        if (mb_strwidth($string, $encoding) <= $width) {
            return $string;
        }
        $markerWidth = mb_strwidth($trim_marker, $encoding);
        $targetWidth = $width - $markerWidth;
        if ($targetWidth < 0) {
            return $trim_marker;
        }
        $result = '';
        $currentWidth = 0;
        $len = mb_strlen($string, $encoding);
        for ($i = $start; $i < $len; $i++) {
            $char = mb_substr($string, $i, 1, $encoding);
            $w = mb_strwidth($char, $encoding);
            if ($currentWidth + $w > $targetWidth) {
                break;
            }
            $result .= $char;
            $currentWidth += $w;
        }

        return $result.$trim_marker;
    }
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
