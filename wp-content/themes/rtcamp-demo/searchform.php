<?php 
$style = apply_filters('search_style','default');
$icon = apply_filters('search_icon','<i class="fa fa-search"></i>');
$form = '<form role="search" method="get" class="search-form '.$style.'" action="' . esc_url( home_url( '/' ) ) . '">'.
	'<input type="search" class="search-field" placeholder="' . esc_attr__( 'Search &hellip;', 'wan' ) . '" value="' . get_search_query() . '" name="s" />'.
	'<button>'.$icon.'<span>'.esc_attr__('Search','wan').'</span></button>
</form>';
echo $form;
?>
