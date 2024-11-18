<?php

use PhpCsFixer\Fixer\Import\OrderedImportsFixer;

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var')
;

return (new PhpCsFixer\Config())
    ->setUsingCache(true)
    ->setRules([
        '@PSR2'                      => true,
        '@PSR12'                     => true,
        '@PSR12:risky'               => true,
        '@Symfony'                   => true,
        '@Symfony:risky'             => true,
        '@DoctrineAnnotation'        => true,
        'concat_space'               => ['spacing' => 'one'],
        'array_syntax'               => ['syntax' => 'short'],
        'list_syntax'                => ['syntax' => 'short'],
        'phpdoc_align'               => ['align' => 'left'],
        'phpdoc_no_empty_return'     => false,
        'phpdoc_summary'             => false,
        'ordered_imports'            => [
            'sort_algorithm' => OrderedImportsFixer::SORT_ALPHA,
            'imports_order'  => [
                OrderedImportsFixer::IMPORT_TYPE_CONST,
                OrderedImportsFixer::IMPORT_TYPE_FUNCTION,
                OrderedImportsFixer::IMPORT_TYPE_CLASS,
            ],
        ],
        'class_definition'           => ['multi_line_extends_each_single_line' => true],
        'ternary_to_null_coalescing' => true,
        'yoda_style'                 => false,
        'compact_nullable_type_declaration'  => true,
        'visibility_required'        => true,
        'no_superfluous_phpdoc_tags' => ['allow_mixed' => true],
        'phpdoc_to_comment' => false,
    ])
    ->setRiskyAllowed(true)
    ->setFinder($finder)
;
