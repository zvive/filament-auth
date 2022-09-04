<?php

declare(strict_types=1);

namespace FilamentAuth\Http\Middleware;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Lab404\Impersonate\Services\ImpersonateManager;
use Closure;
use StdClass;

class ImpersonatingMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only touch illuminate responses (avoid binary, etc)
        if (!$response instanceof Response || !\app(ImpersonateManager::class)->isImpersonating()) {
            return $response;
        }

        return $request->wantsJson()
        ? $this->setJsonContent($response) :
        $response->setContent(
            \str_replace(
                '</body>',
                $this->getHtmlContent($request).'</body>',
                // @phpstan-ignore-next-line
                $response->getContent()
            )
        );
    }

    protected function getHtmlContent($request) : string
    {
        return \view('filament-auth::impersonating-banner', [
            'isFilament' => Str::startsWith($request->path(), \config('filament.path')),
        ])->render();
    }

    protected function setJsonContent(Response $response) : Response
    {
        $data = $response->getResponseData($response);
        if ($data === false || !\is_object($data)) {
            return $response;
        }

        $data->impersonating = true;

        return $this->setResponseData($response, $data);
    }

    protected function getResponseData(Response $response)
    {
        if ($response instanceof JsonResponse) {
            return $response->getData() ?: new StdClass();
        }

        $content = $response->getContent();

        return \json_decode($content) ?: false;
    }

    protected function setResponseData(Response $response, $data)
    {
        if ($response instanceof JsonResponse) {
            return $response->setData($data);
        }

        $content = \json_encode($data, JsonResponse::DEFAULT_ENCODING_OPTIONS);

        return $response->setContent($content);
    }
}
