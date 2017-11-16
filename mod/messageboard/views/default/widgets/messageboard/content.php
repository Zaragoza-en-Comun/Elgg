<?php
/**
 * Messageboard widget view
 */

$widget = elgg_extract('entity', $vars);
$owner = $widget->getOwnerEntity();

if (elgg_is_logged_in()) {
	echo elgg_view_form('messageboard/add', ['name' => 'elgg-messageboard']);
}

$num_display = (int) $widget->num_display ?: 4;

echo elgg_list_annotations([
	'annotations_name' => 'messageboard',
	'guid' => $owner->guid,
	'limit' => $num_display,
	'pagination' => false,
	'reverse_order_by' => true,
]);

if ($owner instanceof ElggGroup) {
	$url = "messageboard/group/{$owner->guid}/all";
} else {
	$url = "messageboard/owner/{$owner->username}";
}

$more_link = elgg_view('output/url', [
	'href' => $url,
	'text' => elgg_echo('messageboard:viewall'),
	'is_trusted' => true,
]);

echo "<div class=\"elgg-widget-more\">$more_link</div>";

elgg_require_js('elgg/messageboard');
