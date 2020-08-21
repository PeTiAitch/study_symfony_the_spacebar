<?php

namespace App\Twig;

use App\Service\MarkdownHelper;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    

    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('cached_markdown', [AppRuntime::class, 'processMarkdown'], ['is_safe' => ['html']]),
            new TwigFilter('trunkate', [$this, 'trunkate'])
        ];
    }

    // public function getFunctions(): array
    // {
    //     return [
    //         new TwigFunction('function_name', [$this, 'doSomething']),
    //     ];
    // }

    // This is from me, because the tutorial uses TwigExtension library and it's not supported any more
    public function trunkate(string $text, int $maxLength = 30)
    {
        if (mb_strpos(trim($text), ' ') == false) {
            return $text;
        }

        if (mb_strlen($text) <= $maxLength) {
            return $text;
        }

        $text = mb_substr($text, 0, mb_strrpos(mb_substr($text, 0, $maxLength + 1), ' ')) . '...';

        return $text;
    }
    
}
