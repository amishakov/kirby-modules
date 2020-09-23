<?php

use Kirby\Cms\Section;

$blueprints = [];
foreach ($moduleRegistry['blueprints'] as $blueprint => $file) {
	if(Str::startsWith($blueprint, 'pages/module.')) {
		$blueprints[] = str_replace('pages/', '', $blueprint);
	}
}
$default = array_search('module.' . option('medienbaecker.modules.default', 'text'), $blueprints);
if($default !== false) {
	$module_text = $blueprints[$default];
	unset($blueprints[$default]);
	array_unshift($blueprints, $module_text);
}

$base = Section::$types['pages'];

return array_replace_recursive($base, [
	'props' => [
		'create' => function ($create = null) use ($blueprints) {
			return $create ?? $blueprints;
		},
		'empty' => function ($empty = 'modules.empty') {
			return I18n::translate($empty);
		},
		'headline' => function ($headline = 'modules') {
			return I18n::translate($headline);
		},
		'info' => function(string $info = '{{ page.moduleName }}') {
			return $info;
		},
		'image' => false,
		'parent' => function($parent = null) {
			return $this->model()->find('modules')
				? 'page.find("modules")'
				: $parent;
		}
	]
]);