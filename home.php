<?php
/**
 * Blog Template
 *
 * @since   1.0.0
 * @package Responsive
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Blog Template
 *
 * @file           home.php
 * @package        Responsive
 * @author         CyberChimps
 * @copyright      2020 CyberChimps
 * @license        license.txt
 * @version        Release: 1.1.0
 * @filesource     wp-content/themes/responsive/home.php
 * @link           http://codex.wordpress.org/Templates
 * @since          available since Release 1.0
 */

get_header();

//Responsive\responsive_wrapper_top(); // before wrapper content hook.

//$blog_pagination = '' === responsive_blog_pagination() ? 'default' : responsive_blog_pagination();
// Elementor `archive` location.
//if ( ( ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) && ! ( function_exists( 'rea_theme_template_render_at_location' ) && rea_theme_template_render_at_location( 'archive' ) ) ) ) {
	//Responsive\responsive_wrapper();
	?>
<div id="tabs">
    <ul class="tab-links">
        <?php 
        $categories = get_categories();
        foreach ($categories as $category) {
            echo '<li><a href="#" data-category="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</a></li>';
        }
        ?>
    </ul>

    <div class="tab-content">
        <div id="post-container"></div>
        <button id="load-more" data-paged="1" style="display:none;">Load More</button>
		<div id="overlay" style="display:none;"></div>
		<div id="loader" style="display:none;">
			<svg width="50" height="50" viewBox="0 0 50 50">
				<circle cx="25" cy="25" r="20" stroke="#007bff" stroke-width="5" fill="none" />
				<circle cx="25" cy="25" r="20" stroke="#ccc" stroke-width="5" fill="none" stroke-dasharray="31.4159" stroke-dashoffset="31.4159">
					<animateTransform attributeName="transform" attributeType="XML" type="rotate" from="0 25 25" to="360 25 25" dur="1s" repeatCount="indefinite" />
					<animate attributeName="stroke-dashoffset" from="31.4159" to="0" dur="1s" repeatCount="indefinite" />
				</circle>
			</svg>
		</div>

        <button id="clear-button" style="display:none;">Clear</button>
    </div>
</div>

<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function($) {
    function loadPosts(category, paged) {
        $('#loader').show();
        $.ajax({
            type: 'POST',
            url: my_ajax_object.ajax_url,
            data: {
                action: 'my_filter_posts',
                category: category,
                paged: paged,
            },
            success: function(response) {
                $('#loader').hide();
                if (paged === 1) {
                    $('#post-container').html(response);
                } else {
                    $('#post-container').append(response);
                }
                $('#load-more').data('paged', paged + 1).show();
                $('#clear-button').show();
            },
            error: function() {
                $('#loader').hide();
                alert('An error occurred.');
            }
        });
    }

    $('.tab-links a').click(function(e) {
        e.preventDefault();
        const category = $(this).data('category');
        $('#post-container').empty();
        $('#load-more').data('paged', 1).hide();
        loadPosts(category, 1);
    });

    $('#load-more').click(function() {
        const category = $('.tab-links .active a').data('category');
        const paged = $(this).data('paged');
        loadPosts(category, paged);
    });

    $('#clear-button').click(function() {
        $('#post-container').empty();
        $('#load-more').data('paged', 1).hide();
        $(this).hide();
    });

    // Initialize with the first category if needed
    if ($('.tab-links a').length > 0) {
        const firstCategory = $('.tab-links a').first().data('category');
        loadPosts(firstCategory, 1);
    }
});
</script>
<style>
.tab-links {
    list-style: none;
    padding: 0;
    display: flex;
}

.tab-links li {
    margin-right: 10px;
}

.tab-links a {
    text-decoration: none;
    padding: 10px 15px;
    background-color: #eee;
    border-radius: 5px;
}

.tab-links a:hover, .tab-links .active a {
    background-color: #ccc;
}

#loader {
    display: none;
    text-align: center;
    margin: 20px 0;
}

</style>
	<?php
	//get_sidebar();
	//Responsive\responsive_wrapper_close();
//}
	//Responsive\responsive_wrapper_end(); // after wrapper hook.
	get_footer();
?>
