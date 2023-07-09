<?php

declare(strict_types=1);

namespace App\View\Components;

use BombenProdukt\Lighty\Extension\GrammarFinder;
use BombenProdukt\Lighty\Extension\ThemeFinder;
use BombenProdukt\Lighty\Lighty as LightyLighty;
use BombenProdukt\Lighty\Parser\DocumentParser;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;
use Throwable;

final class Lighty extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return function (array $data) {
            $cacheKey = \md5('landing:'.$data['attributes']->get('path'));

            return Cache::rememberForever($cacheKey, function () use ($data) {
                $document = (new DocumentParser())->parse(\trim(\file_get_contents($data['attributes']->get('path'))));

                if ($data['attributes']->get('language')) {
                    try {
                        // dd(GrammarFinder::make()->find($data['attributes']->get('language')));
                        $document->setLanguage(GrammarFinder::make()->find($data['attributes']->get('language')));
                    } catch (Throwable) {
                        $document->setLanguage($data['attributes']->get('language'));
                    }
                } else {
                    $document->setLanguage('php');
                }

                if ($data['attributes']->get('theme')) {
                    try {
                        $document->setTheme(ThemeFinder::make()->find($data['attributes']->get('theme')));
                    } catch (Throwable) {
                        $document->setTheme($data['attributes']->get('theme'));
                    }
                } else {
                    $document->setTheme(ThemeFinder::make()->find('GitHub Dark Default'));
                }

                return LightyLighty::highlight($document);
            });
        };
    }
}
