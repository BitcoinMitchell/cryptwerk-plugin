<?php

$finder = (new PhpCsFixer\Finder)
	->in([__DIR__ . '/modules/cryptwerk'])
	->exclude('vendor');

return (new PhpCsFixer\Config())
	->setRules([
		'@Symfony'                     => true,
		'@Symfony:risky'               => true,
		'array_syntax'                 => ['syntax' => 'short'],
		'binary_operator_spaces'       => false,
		'blank_line_after_opening_tag' => false,
		'cast_spaces'                  => ['space' => 'single'],
		'combine_nested_dirname'       => true,
		'concat_space'                 => false,
		'fopen_flags'                  => false,
		'native_function_invocation'   => false,
		'native_constant_invocation'   => false,
		'phpdoc_summary'               => false,
		'protected_to_private'         => false,
		'psr_autoloading'              => false,
		'yoda_style'                   => true,
	])
	->setRiskyAllowed(true)
	// PHP CS Fixer 3.95 supports syntax through 8.5; CI also lint-runs on 8.6.
	->setUnsupportedPhpVersionAllowed(true)
	->setUsingCache(true)
	->setIndent("\t")
	->setFinder($finder);
