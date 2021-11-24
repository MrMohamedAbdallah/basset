<?php

use Illuminate\Support\Str;

Blade::directive('loadStyleOnce', function ($parameter) {
    return "<?php Assets::echoCss({$parameter}); ?>";
});

Blade::directive('loadScriptOnce', function ($parameter) {
    return "<?php Assets::echoJs({$parameter}); ?>";
});

Blade::directive('loadOnce', function ($parameter) {
    // determine if it's a CSS or JS file
    $cleanParameter = Str::of($parameter)->trim("'")->trim('"')->trim('`');
    $filePath = Str::of($cleanParameter)->before('?')->before('#');

    // mey be useful to get the second parameter
    // if (Str::contains($parameter, ',')) {
    //     $secondParameter = Str::of($parameter)->after(',')->trim(' ');
    // }

    if (substr($filePath, -3) == '.js') {
        return "<?php Assets::echoJs({$parameter}); ?>";
    }

    if (substr($filePath, -4) == '.css') {
        return "<?php Assets::echoCss({$parameter}); ?>";
    }

    // it's a block start
    return "<?php if(! Assets::isLoaded('".$cleanParameter."')) { Assets::markAsLoaded('".$cleanParameter."');  ?>";
});

Blade::directive('endLoadOnce', function () {
    return '<?php } ?>';
});
