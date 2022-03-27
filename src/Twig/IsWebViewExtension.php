<?php

namespace App\Twig;

use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class IsWebViewExtension extends AbstractExtension
{
    /**
     * @var RequestStack
     */
    private RequestStack $requestStack;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(
        RequestStack $requestStack
    )
    {
        $this->requestStack = $requestStack;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('is_web_view', [$this, 'isWebView']),
        ];
    }

    public function isWebView()
    {
        $request = $this->requestStack->getCurrentRequest();

        if ($request->server->get('HTTP_X_REQUESTED_WITH', null) && $request->server->get('HTTP_X_REQUESTED_WITH') === "com.example.eshopvebview" ){
            return true;
        }
        return false;
    }
}
