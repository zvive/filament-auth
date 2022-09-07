<?php

declare(strict_types=1);

require_once __DIR__.'/vendor/autoload.php';

use Zvive\Fixer\SharedConfig;
use Zvive\Fixer\Rulesets\ZviveRuleset;
use Zvive\Fixer\Finders\LaravelPackageFinder;

$finder = LaravelPackageFinder::create(__DIR__)->notName('*.stub');
$rules  = [
    '@PSR12'                 => true,
    'ordered_class_elements' => [
        'order' => [
            'use_trait',
            'case',
            'constant',
            'property',
            'construct',
            'destruct',
            'magic',
            'phpunit',
            'method_abstract',
            'method',
        ],
        'sort_algorithm' => 'none',
    ],
    'phpdoc_to_comment' => ['ignored_tags' => ['internal', 'var', 'mixin', 'todo']],
];

return SharedConfig::create($finder, new ZviveRuleset($rules));
