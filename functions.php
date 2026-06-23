<?php
function woostify_child_enqueue_styles() {

    /*
    ==============================
    PARENT CSS
    ==============================
    */

    wp_enqueue_style(
        'woostify-parent-style',
        get_template_directory_uri() . '/style.css',
        [],
        wp_get_theme('woostify')->get('Version')
    );

    /*
    ==============================
    CHILD CSS
    ==============================
    */

    wp_enqueue_style(
        'woostify-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        ['woostify-parent-style'],
        filemtime(get_stylesheet_directory() . '/style.css')
    );
}

add_action(
    'wp_enqueue_scripts',
    'woostify_child_enqueue_styles',
    999
);





/*
|--------------------------------------------------------------------------
| Shopify Sync Lock Checkbox
|--------------------------------------------------------------------------
*/

add_action(
    'woocommerce_product_options_general_product_data',
    function () {

        woocommerce_wp_checkbox([
            'id'          => '_import_locked',
            'label'       => 'Exclude From Shopify Sync',
            'description' => 'Enable to prevent this product from being updated during Shopify imports.'
        ]);
    }
);

add_action(
    'woocommerce_process_product_meta',
    function ($product_id) {

        $value = isset($_POST['_import_locked'])
            ? 'yes'
            : 'no';

        update_post_meta(
            $product_id,
            '_import_locked',
            $value
        );
    }
);

add_filter( 'woocommerce_related_products', 'custom_related_products_by_width', 10, 3 );

function custom_related_products_by_width( $related_posts, $product_id, $args ) {

    $limit = 4;

    $product = wc_get_product( $product_id );

    if ( ! $product ) {
        return $related_posts;
    }

    // Product Categories
    $category_ids = wc_get_product_term_ids( $product_id, 'product_cat' );

    // Width Attribute
    $width_ids = wc_get_product_terms(
        $product_id,
        'pa_width',
        array(
            'fields' => 'ids',
        )
    );

    $final_ids = array();

    // STEP 1 : Same Category + Same Width
    if ( ! empty( $width_ids ) ) {

        $same_width = get_posts( array(
			'post_type'      => 'product',
			'posts_per_page' => $limit,
			'fields'         => 'ids',
			'post__not_in'   => array( $product_id ),
			'meta_query'     => array(
				array(
					'key'     => '_stock_status',
					'value'   => 'instock',
					'compare' => '='
				)
			),
			'tax_query'      => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'term_id',
					'terms'    => $category_ids,
				),
				array(
					'taxonomy' => 'pa_width',
					'field'    => 'term_id',
					'terms'    => $width_ids,
				),
			),
		) );

        $final_ids = $same_width;
    }

    // STEP 2 : Same Category Any Width
    if ( count( $final_ids ) < $limit ) {

        $remaining = get_posts( array(
			'post_type'      => 'product',
			'posts_per_page' => $limit - count( $final_ids ),
			'fields'         => 'ids',
			'post__not_in'   => array_merge(
				array( $product_id ),
				$final_ids
			),
			'meta_query'     => array(
				array(
					'key'     => '_stock_status',
					'value'   => 'instock',
					'compare' => '='
				)
			),
			'tax_query'      => array(
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'term_id',
					'terms'    => $category_ids,
				),
			),
		) );

        $final_ids = array_merge( $final_ids, $remaining );
    }

    return $final_ids;
}

function grd_new_products_instock_shortcode() {

    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => 8,
        'post_status'    => 'publish',
        'meta_query'     => array(
            array(
                'key'     => '_stock_status',
                'value'   => 'instock',
                'compare' => '='
            )
        ),
        'orderby' => 'date',
        'order'   => 'DESC'
    );

    ob_start();

    $products = new WP_Query($args);

    if ($products->have_posts()) {

        $GLOBALS['woocommerce_loop']['columns'] = 4;

        woocommerce_product_loop_start();

        while ($products->have_posts()) {
            $products->the_post();
            wc_get_template_part('content', 'product');
        }

        woocommerce_product_loop_end();
    }

    wp_reset_postdata();

    return ob_get_clean();
}

add_shortcode('grd_new_products', 'grd_new_products_instock_shortcode');

/**
 * Products Per Page Dropdown
 */
add_action('woocommerce_before_shop_loop', 'grd_products_per_page_dropdown', 25);

function grd_products_per_page_dropdown() {

    $current = isset($_GET['per_page']) ? intval($_GET['per_page']) : 30;

    ?>
    <form class="grd-per-page-form" method="get">
		<span>Show Per Page:</span>
        <select name="per_page" onchange="this.form.submit()">
            <option value="15" <?php selected($current, 15); ?>>15 Products</option>
            <option value="30" <?php selected($current, 30); ?>>30 Products</option>
            <option value="45" <?php selected($current, 45); ?>>45 Products</option>
            <option value="60" <?php selected($current, 60); ?>>60 Products</option>
        </select>

        <?php
        foreach ($_GET as $key => $value) {

            if ($key === 'per_page') {
                continue;
            }

            if (is_array($value)) {
                continue;
            }

            echo '<input type="hidden" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '">';
        }
        ?>

    </form>
    <?php
}

add_filter('loop_shop_per_page', 'grd_custom_products_per_page', 20);

function grd_custom_products_per_page($cols) {

    if (!empty($_GET['per_page'])) {

        $allowed = array(15, 30, 45, 60);

        $per_page = intval($_GET['per_page']);

        if (in_array($per_page, $allowed)) {
            return $per_page;
        }
    }

    return 30;
}

function remote_blog_posts_shortcode($atts) {

    $atts = shortcode_atts(array(
        'limit' => 3,
    ), $atts);

    $limit = intval($atts['limit']);

    // Embedded media for featured image
    $api_url = 'https://www.grdcabinets.com/blog/wp-json/wp/v2/posts?per_page='.$limit.'&_embed';

    $response = wp_remote_get($api_url);

    if (is_wp_error($response)) {
        return '<p>Unable to fetch posts.</p>';
    }

    $body  = wp_remote_retrieve_body($response);
    $posts = json_decode($body);

    if (empty($posts)) {
        return '<p>No posts found.</p>';
    }

    $output = '<div class="custom-remote-blog-grid">';

    foreach ($posts as $post) {

        // Title
        $title = $post->title->rendered;

        // Link
        $link = $post->link;

        // Description
        $description = wp_trim_words(
            wp_strip_all_tags($post->excerpt->rendered),
            18
        );

        // Date
        $day   = date('d', strtotime($post->date));
        $month = date('M', strtotime($post->date));

        // Image
        $image = '';

        if (isset($post->_embedded->{'wp:featuredmedia'}[0]->source_url)) {
            $image = $post->_embedded->{'wp:featuredmedia'}[0]->source_url;
        }

        $output .= '
        <div class="custom-blog-card">

            <div class="custom-blog-image-wrap">

                <a href="'.$link.'" target="_blank">

                    <img src="'.$image.'" alt="'.$title.'" class="custom-blog-image">

                </a>

                <div class="custom-blog-date">
                    <span class="day">'.$day.'</span>
                    <span class="month">'.$month.'</span>
                </div>

            </div>

            <div class="custom-blog-content">

                <h3>
                    <a href="'.$link.'" target="_blank">'.$title.'</a>
                </h3>

                <p>'.$description.'</p>

                <a href="'.$link.'" target="_blank" class="custom-blog-btn">
                    Learn More
                </a>

            </div>

        </div>';
    }

    $output .= '</div>';

    return $output;
}

add_shortcode('remote_blog_posts', 'remote_blog_posts_shortcode');
/** [remote_blog_posts limit="3"] **/



function custom_change_checkout_place_order_text() {

    if ( ! is_checkout() ) {
        return;
    }
    ?>
    <script>
    (function() {

        function changePlaceOrderText() {

            document.querySelectorAll(
                '.wc-block-components-checkout-place-order-button__text'
            ).forEach(function(el) {

                if (el.textContent.trim() === 'Place Order') {
                    el.textContent = 'Submit Order';
                }

            });
        }

        document.addEventListener(
            'DOMContentLoaded',
            changePlaceOrderText
        );

        new MutationObserver(changePlaceOrderText).observe(
            document.body,
            {
                childList: true,
                subtree: true
            }
        );

    })();
    </script>
    <?php
}

add_filter(
    'woocommerce_thankyou_order_received_text',
    'custom_thankyou_order_received_text',
    10,
    2
);

function custom_thankyou_order_received_text($message, $order)
{
    return 'Thank you for your request. Our team will review your submission and contact you shortly.';
}


/*add_action(
    'woocommerce_after_shop_loop_item',
    'show_variation_thumbnails_in_loop',
    15
);*/

function show_variation_thumbnails_in_loop() {

    global $product;

    if (
        ! $product ||
        ! $product->is_type('variable')
    ) {
        return;
    }

    $attributes = $product->get_variation_attributes();

    // Sirf color attribute wale products
    if (
        ! isset($attributes['pa_color']) &&
        ! isset($attributes['color'])
    ) {
        return;
    }

    $variations = $product->get_available_variations();

    if (empty($variations)) {
        return;
    }

    echo '<div class="loop-variation-images">';

    foreach ($variations as $variation) {

        $image_id = $variation['image_id'];

        if (!$image_id) {
            continue;
        }

        echo wp_get_attachment_image(
            $image_id,
            'thumbnail',
            false,
            [
                'class' => 'loop-variation-thumb',
				'data-image' => wp_get_attachment_image_url($image_id, 'woocommerce_thumbnail')
            ]
        );
    }

    echo '</div>';
}

add_action('wp_footer', function() {
?>
<script>
document.addEventListener('click', function(e){

    if(!e.target.classList.contains('loop-variation-thumb')){
        return;
    }

    let thumb = e.target;

    let product = thumb.closest('li.product');

    if(!product){
        return;
    }

    let mainImage = product.querySelector('.product-loop-image');

    if(!mainImage){
        return;
    }

    mainImage.src = thumb.dataset.image;

});
</script>

 <script>
    jQuery(function ($) {

        function updateStockStatusText() {

            $('.wcapf-filter-meta-_stock_status .wcapf-filter-option').each(function () {

                var $text = $(this).find('.wcapf-nav-item-text');

                if (!$text.length) {
                    return;
                }

                var value = $.trim($text.text()).toLowerCase();

                if (value === 'instock') {
                    $text.text('In Stock');
                } 
                else if (value === 'outofstock') {
                    $text.text('Out of Stock');
                }

            });
			
			// Active Filters
			$('.wcapf-active-filter-items .wcapf-active-filter-item .wcapf-nav-item-text').each(function () {

				var $text = $(this);
				var value = $.trim($text.text()).toLowerCase();

				if (value === 'instock') {
					$text.text('In Stock');
				} 
				else if (value === 'outofstock') {
					$text.text('Out of Stock');
				}
			});
			
        }

        updateStockStatusText();

        // AJAX filter reload hone par bhi chale
        $(document).ajaxComplete(function () {
            updateStockStatusText();
        });

    });
    </script>
<?php
});

/**
 * Import Latest Blog Posts From Remote Website
 * Add this code in functions.php
 */

function import_remote_blog_posts() {

    // Remote API URL
    $api_url = 'https://www.grdcabinets.com/blog/wp-json/wp/v2/posts?per_page=10&_embed';

    $response = wp_remote_get($api_url, array(
        'timeout' => 60,
    ));

    if (is_wp_error($response)) {
        return;
    }

    $body  = wp_remote_retrieve_body($response);
    $posts = json_decode($body);

    if (empty($posts)) {
        return;
    }

    foreach ($posts as $remote_post) {
		
        // Remote Post ID
        $remote_id = $remote_post->id;

        // Check if already imported
        $existing_posts = get_posts(array(
            'post_type'  => 'post',
            'meta_key'   => '_remote_post_id',
            'meta_value' => $remote_id,
            'post_status'=> 'any',
            'numberposts'=> 1,
        ));

        // Skip if already exists
        if (!empty($existing_posts)) {
            continue;
        }

        // Post Data
        $title   = wp_strip_all_tags($remote_post->title->rendered);
        $content = $remote_post->content->rendered;
        $excerpt = wp_strip_all_tags($remote_post->excerpt->rendered);

        // Create Post
        $new_post_id = wp_insert_post(array(
            'post_title'   => $title,
            'post_content' => $content,
            'post_excerpt' => $excerpt,
            'post_status'  => 'publish',
            'post_type'    => 'post',
            'post_author'  => 1,
        ));

        // Save Remote ID
        if ($new_post_id) {

            update_post_meta($new_post_id, '_remote_post_id', $remote_id);

            /**
             * Featured Image Import
             */
            if (isset($remote_post->_embedded->{'wp:featuredmedia'}[0]->source_url)) {

                $image_url = $remote_post->_embedded->{'wp:featuredmedia'}[0]->source_url;

                require_once(ABSPATH . 'wp-admin/includes/media.php');
                require_once(ABSPATH . 'wp-admin/includes/file.php');
                require_once(ABSPATH . 'wp-admin/includes/image.php');

                $image_id = media_sideload_image($image_url, $new_post_id, $title, 'id');

                if (!is_wp_error($image_id)) {
                    set_post_thumbnail($new_post_id, $image_id);
                }
            }

            /**
             * Categories Import
             */
            if (!empty($remote_post->categories)) {

                foreach ($remote_post->categories as $cat_id) {

                    $cat_response = wp_remote_get(
                        'https://www.grdcabinets.com/blog/wp-json/wp/v2/categories/' . $cat_id
                    );

                    if (!is_wp_error($cat_response)) {

                        $cat_body = wp_remote_retrieve_body($cat_response);
                        $cat_data = json_decode($cat_body);

                        if (!empty($cat_data->name)) {

                            $term = term_exists($cat_data->name, 'category');

                            if (!$term) {
                                $term = wp_insert_term($cat_data->name, 'category');
                            }

                            if (!is_wp_error($term)) {

                                $term_id = is_array($term)
                                    ? $term['term_id']
                                    : $term;

                                wp_set_post_categories($new_post_id, array($term_id), true);
                            }
                        }
                    }
                }
            }
        }
    }
}

/**
 * Manual Run
 * Example:
 * yourwebsite.com/?import_remote_posts=1
 */

add_action('init', function() {

    if (isset($_GET['import_remote_posts']) && $_GET['import_remote_posts'] == 1) {

        //if (current_user_can('manage_options')) {

            import_remote_blog_posts();

            echo 'Remote posts imported successfully.';
            exit;
        //}
    }
});


/**
 * Daily Cron Job
 */

/*add_action('import_remote_blog_posts_daily_event', 'import_remote_blog_posts');

if (!wp_next_scheduled('import_remote_blog_posts_daily_event')) {

    wp_schedule_event(
        time(),
        'daily',
        'import_remote_blog_posts_daily_event'
    );
}*/

/*
|--------------------------------------------------------------------------
| CREATE WOOCOMMERCE ATTRIBUTES
|--------------------------------------------------------------------------
*/
function wellfor_create_global_attribute(
    $name,
    $label
) {

    global $wpdb;

    $attribute_name = wc_sanitize_taxonomy_name(
        $name
    );

    $exists = $wpdb->get_var(
        $wpdb->prepare(
            "
            SELECT attribute_id
            FROM {$wpdb->prefix}woocommerce_attribute_taxonomies
            WHERE attribute_name = %s
            ",
            $attribute_name
        )
    );

    if (!$exists) {

        wc_create_attribute([

            'name'         => $label,

            'slug'         => $attribute_name,

            'type'         => 'select',

            'order_by'     => 'menu_order',

            'has_archives' => false

        ]);
    }
}


add_action('init', function () {

    if (!function_exists('wc_create_attribute')) {
        return;
    }

    $attributes = [

        'color'             => 'Color',

        'material'          => 'Material',

        'shape'             => 'Shape',

        'width'             => 'Width',

        'height'            => 'Height',

        'depth'             => 'Depth',

        'product_type'      => 'Product Type',

        'installation_type' => 'Installation Type',
		'door_type'  => 'Door Type',
		'frame_type' => 'Frame Type',
		'handle_type'   => 'Handle Type',
		'handle_number' => 'Handle Number',

    ];

    foreach ($attributes as $slug => $label) {

        wellfor_create_global_attribute(
            $slug,
            $label
        );
    }
});


/*
|--------------------------------------------------------------------------
| ATTRIBUTE CONFIG
|--------------------------------------------------------------------------
*/

function wellfor_attribute_config() {

    return [

        'Bathroom Vanities' => [

            'colors' => [
                'ASH',
                'Grey',
                'Lavender',
                'LIGHT WOOD',
                'Navy Blue',
                'Oak',
                'Titanium Grey',
                'Walnut',
                'White'
            ],

            'materials' => [
                'Solid Wood',
                'Solid Wood Plywood'
            ],

            'shapes' => [],

            'widths' => [
                '24',
                '30',
                '36',
                '40',
                '48',
                '60',
                '72',
                '80',
                '84'
            ],

            'heights' => [
                '18.9',
                '20',
                '34',
                '34 1/8',
                '35'
            ],

            'depths' => [
                '18 5/16',
                '22'
            ],

            'product_types' => [
                'Double Sink Vanities',
                'Single Sink Vanity'
            ],

            'installation_types' => [
                'Floating',
                'Freestanding'
            ],
			
			'door_types' => [],

			'frame_types' => [],
			'handle_types' => [],
			'handle_numbers' => [],
        ],

        'Mirrors' => [

            'colors' => [
                //'Aluminum',
                'Brushed Gold',
                'Brushed Nickel',
                'Classic Blue',
                'Gold',
                'Matte Black',
                'Navy Blue',
                'Titanium Grey',
                'White'
            ],

            'materials' => [
                'Aluminum',
                'Wood'
            ],

            'shapes' => [
                'Arched',
                'Oval',
                'Rectangle',
                'Round',
                'Specialty',
                'Square'
            ],

            'widths' => [
                '20',
                '22',
                '24',
                '26',
                '28',
                '30',
                '32',
                '36',
                '38',
                '40',
                '48',
                '55',
                '60',
                '72',
                '84'
            ],

            'heights' => [
                '24',
                '28',
                '30',
                '32',
                '33',
                '34',
                '36',
                '40',
                '42'
            ],

            'depths' => [
                '1.18',
                '1.19',
                '1.2',
                '1.5',
                '1.56',
                '1.57',
                '1.62',
                '1.7',
                '2',
                '2.12',
                '2.18'
            ],

            'product_types' => [
                'Back Light',
                'Backlit and Frontlit',
                'Framed',
                'Frameless',
                'With Lighting',
                'Without Lighting',
                'Wood'
            ],

            'installation_types' => [
                'Wall-mounted'
            ],
			'door_types' => [],
			'frame_types' => [],
			'handle_types' => [],
			'handle_numbers' => [],
        ],
		'Medicine Cabinets' => [

            'colors' => [
                'Black',
                'Chrome Aluminum',
                'Gray',
                'Navy Blue',
                'Matte Black',
                'Titanium Grey',
                'White'
            ],

            'materials' => [
                'Aluminum',
                'Plastic',
                'Solid Wood',
            ],

            'shapes' => [
                'Rectangle',
                'Square'
            ],

            'widths' => [
				'12',
				'16',
				'20',
				'24',
				'26',
				'28',
				'30',
				'32',
				'34',
				'36',
				'40',
				'42',
				'44',
				'48',
				'52',
				'54',
				'55',
				'56',
				'60',
				'64',
				'66',
				'72',
				'80',
				'84',
				'92',
				'96',
				'104'
			],

            'heights' => [
				'24',
				'28',
				'30',
				'32',
				'34',
				'35',
				'36',
				'70'
			],

           'depths' => [
				'3 13/16',
				'4.563',
				'4.62',
				'4.75',
				'4 13/16',
				'5',
				'5.12',
				'5.25',
				'5.39',
				'5.4',
				'5.5',
				'5.9',
				'6.6',
				'6.7',
				'6.8',
				'6.9'
			],

            'product_types' => [
                'Medicine Cabinets with Light',
                'Medicine Cabinets without Light',
                'Wood Medicine Cabinet with Mirror',
            ],

            'installation_types' => [
                'Recessed Mount',
                'Surface Mount',
            ],
			'door_types' => [],
			'frame_types' => [],
			'handle_types' => [],
			'handle_numbers' => [],
        ],
		'Toilets' => [

            'colors' => [
                'Matte Black',
                'Matte Gray',
                'White'
            ],

            'materials' => [
                'Ceramic',
            ],

            'shapes' => [
				'Elongated',
				'Elongated Rectangular'
			],

            /*'widths' => [
					'16.12',
					'20',
					'26.6',
					'27.17',
					'27.2'
				],*/
			'widths' => [
					'15',
					'15.5',
					'15.6',
					'16.12',
					'17.38',
					'26.38',
					'26.6',
					'27.17',
					'27.2'
				],

           /* 'heights' => [
					'6',
					'17.99',
					'18',
					'19.3',
					'19.5',
					'19.68',
					'19.7',
					'20'
				],*/
				
			'heights' => [
				'15.7',
				'17.38',
				'17.99',
				'18',
				'19.29',
				'19.3',
				'19.5',
				'19.7',
				'20'
			],

           /*'depths' => [
					'14.96',
					'15',
					'15.6',
					'17',
					'27.18',
					'27.62'
				],*/
			'depths' => [
				'14.96',
				'15.6',
				'15.94',
				'26.8',
				'27.18',
				'27.2',
				'27.62'
			],

            'product_types' => [],

            'installation_types' => [
                'Floor-mounted',
            ],
			'door_types' => [],
			'frame_types' => [],
			'handle_types' => [],
			'handle_numbers' => [],
        ],
		'Shower Doors' => [

            'colors' => [
				'Brushed Gold',
				'Brushed Nickel',
				'Chrome',
				'Golden',
				'Matte Black',
				'Matte White'
			],

            'materials' => [
                'Tempered Glass',
            ],
			'shapes' => [],
			'depths' => [],
            
			'widths' => [
					'23',
					'24',
					'25',
					'26',
					'27',
					'28',
					'28-28.16',
					'29',
					'30',
					'30-30.16',
					'30-30.75',
					'30-31.5',
					'31',
					'32',
					'32-32.75',
					'32-33.5',
					'33',
					'34',
					'34-34.75',
					'34-35.5',
					'35',
					'36',
					'36-37.5',
					'37',
					'38',
					'39',
					'40',
					'41',
					'42',
					'43',
					'44',
					'44-48',
					'45',
					'46',
					'47',
					'48',
					'49',
					'50',
					'50-54',
					'51',
					'52',
					'53',
					'54',
					'55',
					'56',
					'56-60',
					'57',
					'58',
					'59',
					'60'
				],	
			'heights' => [
					'60',
					'62',
					'68',
					'72',
					'74',
					'75',
					'76'
				],
			'door_types' => [
				'Bi-Fold',
				'Fixed',
				'Hinged',
				'Pivot',
				'Sliding',
			],
			'frame_types' => [
				'Framed',
				'Frameless',
				'Semi-Frameless',
			],
			

            'product_types' => [],

            'installation_types' => [],
			'handle_types' => [],
			'handle_numbers' => [],
        ],
		'Bathroom Faucets' => [

            'colors' => [
					'Black',
					'Black And Gold',
					'Brushed Gold',
					'Brushed Nickel',
					'Brushed Nickel/Matte Black',
					'Chrome',
					'Matte',
					'Matte Black',
					'Oil Rubbed Bronze',
					'Polished Gold',
					'White'
				],

           'materials' => [
					'ABS',
					'Brass',
					'Brass, ABS',
					'Copper',
					'Metal',
					'Metal, ABS',
					'Solid Brass',
					'Stainless Steel',
					'Stainless Steel, Brass'
				],
			'shapes' => [],
			'depths' => [
					'0.96',
					'1.28',
					'1.4',
					'1.65',
					'1.95',
					'1.97',
					'2.05',
					'2.15',
					'2.17',
					'3.94',
					'4.33',
					'4.72',
					'4.9',
					'4.92',
					'5.19',
					'5.2',
					'5.51',
					'5.91',
					'6',
					'6.18',
					'6.22',
					'6.34',
					'6.42',
					'6.49',
					'6.5',
					'6.57',
					'6.7',
					'6.8',
					'6.89',
					'7.09',
					'7.28',
					'7.4',
					'7.41',
					'7.75',
					'7.8',
					'7.99',
					'8.07',
					'8.1',
					'8.11',
					'8.18',
					'8.23',
					'8.46',
					'8.86',
					'9.06',
					'9.25',
					'10.08',
					'10.43',
					'10.7',
					'11',
					'12',
					'12.08',
					'12.9',
					'12.99',
					'13.1',
					'13.77',
					'13.8'
				],
            
			'widths' => [
					'1',
					'1.18',
					'1.5',
					'1.65',
					'1.77',
					'1.8',
					'1.96',
					'1.97',
					'2',
					'2.05',
					'2.13',
					'2.15',
					'2.17',
					'2.36',
					'2.4',
					'2.44',
					'2.6',
					'2.75',
					'2.76',
					'2.95',
					'3',
					'3.15',
					'3.35',
					'3.66',
					'3.76',
					'4.13',
					'4.72',
					'4.8',
					'5.2',
					'5.31',
					'5.51',
					'5.71',
					'5.88',
					'6',
					'6.1',
					'6.29',
					'6.5',
					'6.53',
					'6.6',
					'7',
					'7.08',
					'7.68',
					'7.88'
				],
			'heights' => [
					'2',
					'2.36',
					'2.95',
					'3.48',
					'3.5',
					'3.64',
					'3.66',
					'3.89',
					'4.08',
					'4.33',
					'4.5',
					'4.9',
					'4.98',
					'5',
					'5.28',
					'5.3',
					'5.31',
					'5.43',
					'5.51',
					'5.71',
					'5.91',
					'5.98',
					'6',
					'6.1',
					'6.18',
					'6.3',
					'6.5',
					'6.56',
					'6.57',
					'6.69',
					'6.70',
					'6.88',
					'7.36',
					'7.68',
					'7.76',
					'7.8',
					'7.91',
					'7.99',
					'8',
					'8.23',
					'8.26',
					'8.32',
					'8.50',
					'8.7',
					'8.8',
					'10',
					'12.1',
					'12.2',
					'15.16',
					'42.2',
					'45.28'
				],
				'door_types' => [],
				'frame_types' => [],
							

            'product_types' => [
				'Bridge Kitchen Faucets',
				'Centerset Faucets',
				'Floor-Mount Faucets',
				'Pot Filler Kitchen Faucets',
				'Pull-Down Kitchen Faucets',
				'Single-Hole Faucets',
				'Single-Hole Kitchen Faucets',
				'Tub Faucets',
				'Tub Mounted Faucets',
				'Wall-Mount Faucets',
				'Wall-Mount Kitchen Faucets',
				'Widespread Faucets'
			],

           'installation_types' => [
				'Deck Mount',
				'Deck-Mounted',
				'Floor Mount',
				'Wall Mount'
			],
			'handle_types' => [
				'Cross',
				'Knob',
				'Lever',
				'Single Handle'
			],

			'handle_numbers' => [
				'1',
				'2',
				'3'
			],
        ],
		'Shower System' => [

            'colors' => [
					'Brushed Gold',
					'Brushed Nickel',
					'Chrome',
					'Chrome Plating',
					'Matte Black',
					'Oil Rubbed Bronze',
				],

           'materials' => [
				'304 Stainless Steel',
				'ABS',
				'Brass',
				'Brass, ABS',
				'Stainless Steel',
				'Stainless Steel, ABS',
				'Stainless Steel, Brass',
			],
			'shapes' => [
				'Rectangular',
				'Round',
				'Square'
			],
			'depths' => [
					'7.36',
					'16',
				],
            
			'widths' => [
					'2.5',
					'4',
					'4.72',
					'4.92',
					'5',
					'5.91',
					'6',
					'7.48',
					'7.87',
					'8',
					'9',
					'9.8',
					'9.84',
					'10',
					'10.25',
					'11',
					'12',
					'16',
				],
			'heights' => [
					'2.5',
					'4',
					'4.72',
					'4.92',
					'5',
					'5.91',
					'6',
					'7',
					'7.68',
					'8',
					'9',
					'9.8',
					'9.84',
					'10',
					'11.81',
					'12',
					'19',
					'19.69',
					'21.88',
					'21.94',
					'22',
				],
				'door_types' => [],
				'frame_types' => [],
							

            'product_types' => [
				'Hand Shower with Slide Bars',
				'Shower System with Faucets',
				'Shower Systems',
			],

           'installation_types' => [
				'Ceiling Mount',
				'Concealed In-Wall',
				'Wall Mount',
			],
			'handle_types' => [
				'Cross',
				'Knob',
				'Lever',
			],

			'handle_numbers' => [
				'1',
				'2',
				'3'
			],
        ]
    ];
}


/*
|--------------------------------------------------------------------------
| AUTO DETECT ATTRIBUTE
|--------------------------------------------------------------------------
*/

function wellfor_detect_attribute($text, $keywords) {

    foreach ($keywords as $keyword) {

        if (
            stripos($text, strtolower($keyword)) !== false
        ) {
            return $keyword;
        }
    }

    return '';
}

function wellfor_text_has_word($text, $keyword) {

    return preg_match(
        '/(?<![a-z0-9])' . preg_quote(strtolower($keyword), '/') . '(?![a-z0-9])/i',
        strtolower($text)
    ) === 1;
}

function wellfor_allowed_value($value, $allowed_values) {

    if (empty($value)) {
        return '';
    }

    $value = trim((string) $value);

    foreach ($allowed_values as $allowed_value) {

        if (strcasecmp($value, $allowed_value) === 0) {
            return $allowed_value;
        }
    }

    return '';
}

function wellfor_detect_allowed_attribute($text, $allowed_values) {

    foreach ($allowed_values as $allowed_value) {

        if (wellfor_text_has_word($text, $allowed_value)) {
            return $allowed_value;
        }
    }

    return '';
}

function wellfor_detect_color(
    $title,
    $text,
    $specifications,
    $config,
    $shopify_product_type
) {

    $color_sources = [];

    if (!empty($title)) {
		$color_sources[] = $title;
	}

	if ($shopify_product_type === 'Bathroom Vanities') {

		foreach ([
			'finish',
			'cabinet color',
			'color'
		] as $field) {

			if (!empty($specifications[$field])) {
				$color_sources[] = $specifications[$field];
			}
		}

		/*
		|--------------------------------------------------------------------------
		| Bathroom Vanities
		| Description me quartz, countertop, handle colors aa jate hain
		| Isliye poora description scan nahi karenge
		|--------------------------------------------------------------------------
		*/

	} else {

		foreach ([
			'finish',
			'top color',
			'color'
		] as $field) {

			if (!empty($specifications[$field])) {
				$color_sources[] = $specifications[$field];
			}
		}

		$color_sources[] = $text;
	}

    //$color_sources[] = $text;

    $found_colors = [];

    foreach ($color_sources as $color_source) {

        $source = strtolower($color_source);

        /*
        |--------------------------------------------------------------------------
        | Bathroom Vanities
        |--------------------------------------------------------------------------
        */

        if ($shopify_product_type === 'Bathroom Vanities') {

            /*$source_without_carrara = preg_replace(
                '/\bcarrara\s+white\b/i',
                ' ',
                $source
            );*/
			
			$source_without_carrara = preg_replace(
				[
					'/\bcarrara\s+white\b/i',
					'/\bwith\s+white\b/i',
					'/\bwith\s+carrara\s+white\b/i',
					'/\bwhite\s+quartz\b/i',
					'/\bwhite\s+marble\b/i',
					'/\bwhite\s+engineered\s+stone\b/i',
					'/\bcarrara\s+white\b/i',
				],
				' ',
				$source
			);

            foreach ($config['colors'] as $color) {

                if (
                    strcasecmp($color, 'White') === 0
                    &&
                    !wellfor_text_has_word(
                        $source_without_carrara,
                        'White'
                    )
                ) {
                    continue;
                }

                if (
                    wellfor_text_has_word(
                        $source_without_carrara,
                        $color
                    )
                ) {

                    $found_colors[] = $color;
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Mirrors
        |--------------------------------------------------------------------------
        */

        elseif ($shopify_product_type === 'Mirrors') {

            if (
                wellfor_text_has_word(
                    $source,
                    'Brushed Gold'
                )
            ) {

                $found_colors[] = 'Brushed Gold';
            }

            if (
                wellfor_text_has_word(
                    $source,
                    'Brushed Nickel'
                )
            ) {

                $found_colors[] = 'Brushed Nickel';
            }

            if (
                wellfor_text_has_word(
                    $source,
                    'Black'
                )
            ) {

                $found_colors[] = 'Matte Black';
            }

            /*
            |--------------------------------------------------------------------------
            | Gold only if Brushed Gold not found
            |--------------------------------------------------------------------------
            */

            if (
                wellfor_text_has_word($source, 'Gold')
                &&
                !wellfor_text_has_word($source, 'Brushed Gold')
            ) {

                $found_colors[] = 'Gold';
            }

            foreach ($config['colors'] as $color) {

                if (
                    wellfor_text_has_word(
                        $source,
                        $color
                    )
                ) {

                    $found_colors[] = $color;
                }
            }
        }elseif ($shopify_product_type === 'Medicine Cabinets') {

			if (
				wellfor_text_has_word($source, 'Matte Black')
			) {
				$found_colors[] = 'Matte Black';
			}

			if (
				wellfor_text_has_word($source, 'Chrome')
				||
				wellfor_text_has_word($source, 'Chrome Aluminum')
			) {
				$found_colors[] = 'Chrome Aluminum';
			}

			if (
				wellfor_text_has_word($source, 'Titanium Gray')
				||
				wellfor_text_has_word($source, 'Titanium Grey')
			) {
				$found_colors[] = 'Titanium Grey';
			}

			if (
				wellfor_text_has_word($source, 'Gray')
				||
				wellfor_text_has_word($source, 'Grey')
			) {
				$found_colors[] = 'Gray';
			}

			if (
				wellfor_text_has_word($source, 'Navy')
			) {
				$found_colors[] = 'Navy Blue';
			}

			foreach ($config['colors'] as $color) {

				if (
					wellfor_text_has_word($source, $color)
				) {
					$found_colors[] = $color;
				}
			}
		}elseif ($shopify_product_type === 'Toilets') {

			if (
				wellfor_text_has_word($source, 'Matte Black')
			) {
				$found_colors[] = 'Matte Black';
			}

			if (
				wellfor_text_has_word($source, 'Matte Gray')
				||
				wellfor_text_has_word($source, 'Matte Grey')
			) {
				$found_colors[] = 'Matte Gray';
			}

			if (
				wellfor_text_has_word($source, 'White')
			) {
				$found_colors[] = 'White';
			}
		}elseif ($shopify_product_type === 'Shower Doors') {

			if (wellfor_text_has_word($source, 'Brushed Gold')) {
				$found_colors[] = 'Brushed Gold';
			}

			if (wellfor_text_has_word($source, 'Brushed Nickel')) {
				$found_colors[] = 'Brushed Nickel';
			}

			if (wellfor_text_has_word($source, 'Chrome')) {
				$found_colors[] = 'Chrome';
			}

			if (wellfor_text_has_word($source, 'Golden')) {
				$found_colors[] = 'Golden';
			}

			if (wellfor_text_has_word($source, 'Matte Black')) {
				$found_colors[] = 'Matte Black';
			}

			if (wellfor_text_has_word($source, 'Matte White')) {
				$found_colors[] = 'Matte White';
			}
			
		}elseif ($shopify_product_type === 'Bathroom Faucets') {

			if (wellfor_text_has_word($source, 'Black And Gold')) {
				$found_colors[] = 'Black And Gold';
			}

			if (wellfor_text_has_word($source, 'Brushed Nickel/Matte Black')) {
				$found_colors[] = 'Brushed Nickel/Matte Black';
			}

			if (wellfor_text_has_word($source, 'Brushed Gold')) {
				$found_colors[] = 'Brushed Gold';
			}

			if (wellfor_text_has_word($source, 'Brushed Nickel')) {
				$found_colors[] = 'Brushed Nickel';
			}

			if (wellfor_text_has_word($source, 'Oil Rubbed Bronze')) {
				$found_colors[] = 'Oil Rubbed Bronze';
			}

			if (wellfor_text_has_word($source, 'Polished Gold')) {
				$found_colors[] = 'Polished Gold';
			}

			if (wellfor_text_has_word($source, 'Matte Black')) {
				$found_colors[] = 'Matte Black';
			}

			if (wellfor_text_has_word($source, 'Chrome')) {
				$found_colors[] = 'Chrome';
			}

			if (wellfor_text_has_word($source, 'White')) {
				$found_colors[] = 'White';
			}

			if (
				wellfor_text_has_word($source, 'Black')
				&&
				!wellfor_text_has_word($source, 'Matte Black')
				&&
				!wellfor_text_has_word($source, 'Black And Gold')
				&&
				!wellfor_text_has_word($source, 'Brushed Nickel/Matte Black')
			) {
				$found_colors[] = 'Black';
			}

			if (
				wellfor_text_has_word($source, 'Matte')
				&&
				!wellfor_text_has_word($source, 'Matte Black')
			) {
				$found_colors[] = 'Matte';
			}
			
		}elseif ($shopify_product_type === 'Shower System') {

			if (
				wellfor_text_has_word($source, 'Brushed Nickel')
				&&
				wellfor_text_has_word($source, 'Matte Black')
			) {

				$found_colors[] = 'Brushed Nickel';
				$found_colors[] = 'Matte Black';
			}

			if (wellfor_text_has_word($source, 'Brushed Gold')) {
				$found_colors[] = 'Brushed Gold';
			}

			if (wellfor_text_has_word($source, 'Brushed Nickel')) {
				$found_colors[] = 'Brushed Nickel';
			}

			if (wellfor_text_has_word($source, 'Oil Rubbed Bronze')) {
				$found_colors[] = 'Oil Rubbed Bronze';
			}

			if (wellfor_text_has_word($source, 'Matte Black')) {
				$found_colors[] = 'Matte Black';
			}

			if (wellfor_text_has_word($source, 'Chrome Plating')) {
				$found_colors[] = 'Chrome Plating';
			}

			if (
				wellfor_text_has_word($source, 'Chrome')
				&&
				!wellfor_text_has_word($source, 'Chrome Plating')
			) {
				$found_colors[] = 'Chrome';
			}
		}
    }

    /*
    |--------------------------------------------------------------------------
    | Final Cleanup
    |--------------------------------------------------------------------------
    */

    $found_colors = array_unique(
        array_filter($found_colors)
    );

    $final_colors = [];

    foreach ($found_colors as $color) {

        $allowed = wellfor_allowed_value(
            $color,
            $config['colors']
        );

        if (!empty($allowed)) {
            $final_colors[] = $allowed;
        }
    }

    return array_values(
        array_unique($final_colors)
    );
}

/*function wellfor_detect_color($title, $text, $specifications, $config, $shopify_product_type) {

    $color_sources = [];

    if (!empty($title)) {
        $color_sources[] = $title;
    }

    foreach (['finish', 'top color', 'color'] as $field) {

        if (!empty($specifications[$field])) {
            $color_sources[] = $specifications[$field];
        }
    }

    $color_sources[] = $text;

    foreach ($color_sources as $color_source) {

        $source = strtolower($color_source);

        if ($shopify_product_type === 'Bathroom Vanities') {

            $source_without_carrara = preg_replace(
                '/\bcarrara\s+white\b/i',
                ' ',
                $source
            );

            foreach ($config['colors'] as $color) {

                if (
                    strcasecmp($color, 'White') === 0
                    && !wellfor_text_has_word($source_without_carrara, 'White')
                ) {
                    continue;
                }

                if (wellfor_text_has_word($source_without_carrara, $color)) {
                    return $color;
                }
            }
        }

        if ($shopify_product_type === 'Mirrors') {

            if (wellfor_text_has_word($source, 'Black')) {
                return wellfor_allowed_value('Matte Black', $config['colors']);
            }

            if (wellfor_text_has_word($source, 'Brushed Gold')) {
                return wellfor_allowed_value('Brushed Gold', $config['colors']);
            }

            if (wellfor_text_has_word($source, 'Gold')) {
                return wellfor_allowed_value('Gold', $config['colors']);
            }
        }

        $detected = wellfor_detect_allowed_attribute(
            $source,
            $config['colors']
        );

        if (!empty($detected)) {
            return $detected;
        }
    }

    return '';
}*/

function wellfor_decimal_to_fraction_dimension($value) {

    $value = trim((string) $value);

    if (abs(floatval($value) - 34.125) < 0.01) {
        return '34 1/8';
    }

    if (abs(floatval($value) - 18.3125) < 0.02) {
        return '18 5/16';
    }

    return $value;
}

function wellfor_normalize_dimension_value($value, $allowed_values) {

    if (empty($value)) {
        return '';
    }

    $value = str_replace('"', '', trim((string) $value));
    $value = trim(preg_replace('/\s+/', ' ', $value));
    $value = wellfor_decimal_to_fraction_dimension($value);

    $allowed = wellfor_allowed_value($value, $allowed_values);

    if (!empty($allowed)) {
        return $allowed;
    }

    foreach ($allowed_values as $allowed_value) {

        if (is_numeric($allowed_value) && is_numeric($value)) {

            if (abs(floatval($allowed_value) - floatval($value)) < 0.01) {
                return $allowed_value;
            }
        }
    }

    return '';
}

function wellfor_allowed_attribute_values($shopify_product_type, $taxonomy) {

    $config = wellfor_attribute_config();

    if (empty($config[$shopify_product_type])) {
        return [];
    }

    $map = [
        'pa_color'             => 'colors',
        'pa_material'          => 'materials',
        'pa_shape'             => 'shapes',
        'pa_width'             => 'widths',
        'pa_height'            => 'heights',
        'pa_depth'             => 'depths',
        'pa_product_type'      => 'product_types',
        'pa_installation_type' => 'installation_types',
		'pa_door_type'         => 'door_types',
        'pa_frame_type'        => 'frame_types',
		'pa_handle_type'       => 'handle_types',
		'pa_handle_number'     => 'handle_numbers',
    ];

    if (empty($map[$taxonomy])) {
        return [];
    }

    return $config[$shopify_product_type][$map[$taxonomy]] ?? [];
}


/*
|--------------------------------------------------------------------------
| NORMALIZE MATERIAL
|--------------------------------------------------------------------------
*/

function wellfor_normalize_material(
    $material_text,
    $shopify_product_type = ''
) {

    if (empty($material_text)) {
        return '';
    }

    $material_text = strtolower(
        $material_text
    );

    if ($shopify_product_type === 'Bathroom Vanities') {

        if (
            stripos($material_text, 'solid wood') !== false
            && stripos($material_text, 'plywood') !== false
        ) {
            return 'Solid Wood Plywood';
        }

        if (stripos($material_text, 'solid wood') !== false) {
            return 'Solid Wood';
        }

        return '';
    }

    if ($shopify_product_type === 'Mirrors') {

        if (wellfor_text_has_word($material_text, 'Aluminum')) {
            return 'Aluminum';
        }

        if (wellfor_text_has_word($material_text, 'Wood')) {
            return 'Wood';
        }

        return '';
    }
	
	if ($shopify_product_type === 'Medicine Cabinets') {

		if (
			stripos($material_text, 'solid wood') !== false
			|| stripos($material_text, 'wood') !== false
		) {
			return 'Solid Wood';
		}

		if (
			stripos($material_text, 'plastic') !== false
			|| stripos($material_text, 'abs') !== false
		) {
			return 'Plastic';
		}

		if (
			stripos($material_text, 'aluminum') !== false
			|| stripos($material_text, 'aluminium') !== false
		) {
			return 'Aluminum';
		}

		return '';
	}
	
	if ($shopify_product_type === 'Toilets') {

		if (
			stripos($material_text, 'ceramic') !== false
		) {
			return 'Ceramic';
		}

		return '';
	}
	
	if ($shopify_product_type === 'Shower Doors') {

		if (
			stripos($material_text, 'tempered glass') !== false
			||
			stripos($material_text, 'glass') !== false
		) {
			return 'Tempered Glass';
		}

		return '';
	}
	
	if ($shopify_product_type === 'Bathroom Faucets') {

		if (
			stripos($material_text, 'stainless steel') !== false
			&&
			stripos($material_text, 'brass') !== false
		) {
			return 'Stainless Steel, Brass';
		}

		if (
			stripos($material_text, 'brass') !== false
			&&
			stripos($material_text, 'abs') !== false
		) {
			return 'Brass, ABS';
		}

		if (
			stripos($material_text, 'metal') !== false
			&&
			stripos($material_text, 'abs') !== false
		) {
			return 'Metal, ABS';
		}

		if (
			stripos($material_text, 'solid brass') !== false
		) {
			return 'Solid Brass';
		}

		if (
			stripos($material_text, 'stainless steel') !== false
		) {
			return 'Stainless Steel';
		}

		if (
			stripos($material_text, 'brass') !== false
		) {
			return 'Brass';
		}

		if (
			stripos($material_text, 'copper') !== false
		) {
			return 'Copper';
		}

		if (
			stripos($material_text, 'metal') !== false
		) {
			return 'Metal';
		}

		if (
			stripos($material_text, 'abs') !== false
		) {
			return 'ABS';
		}

		return '';
	}
	
	if ($shopify_product_type === 'Shower System') {

		if (
			stripos($material_text, '304 stainless steel') !== false
		) {
			return '304 Stainless Steel';
		}

		if (
			stripos($material_text, 'stainless steel') !== false
			&&
			stripos($material_text, 'brass') !== false
		) {
			return 'Stainless Steel, Brass';
		}

		if (
			stripos($material_text, 'stainless steel') !== false
			&&
			stripos($material_text, 'abs') !== false
		) {
			return 'Stainless Steel, ABS';
		}

		if (
			stripos($material_text, 'brass') !== false
			&&
			stripos($material_text, 'abs') !== false
		) {
			return 'Brass, ABS';
		}

		if (
			stripos($material_text, 'brass') !== false
		) {
			return 'Brass';
		}

		if (
			stripos($material_text, 'stainless steel') !== false
		) {
			return 'Stainless Steel';
		}

		if (
			stripos($material_text, 'abs') !== false
		) {
			return 'ABS';
		}

		return '';
	}


    return '';
}

/*
|--------------------------------------------------------------------------
| EXTRACT ATTRIBUTES
|--------------------------------------------------------------------------
*/

function wellfor_extract_attributes(
    $title,
    $description = '',
    $shopify_product_type = ''
) {

    $all_config = wellfor_attribute_config();

    if (empty($all_config[$shopify_product_type])) {

        return [
            'color'             => [],
            'material'          => '',
            'shape'             => '',
            'width'             => '',
            'height'            => '',
            'depth'             => '',
            'product_type'      => [],
            'installation_type' => [],
			'door_type'         => [],
			'frame_type'        => [],
			'handle_type'       => '',
			'handle_number'     => '',
        ];
    }

    $config = $all_config[$shopify_product_type];

    /*
    |--------------------------------------------------------------------------
    | CLEAN TEXT
    |--------------------------------------------------------------------------
    */

    $clean_description = html_entity_decode(
        wp_strip_all_tags($description)
    );

    $clean_description = str_replace(

        [
            '”',
            '“',
            '′',
            '″',
            '×'
        ],

        [
            '"',
            '"',
            "'",
            '"',
            'x'
        ],

        $clean_description
    );

    $text = strtolower(
        $title . ' ' . $clean_description
    );

    /*
    |--------------------------------------------------------------------------
    | DEFAULT ATTRIBUTES
    |--------------------------------------------------------------------------
    */

    $attributes = [

        'color'             => [],
        'material'          => '',
        'shape'             => '',
        'width'             => '',
        'height'            => '',
        'depth'             => '',
        'product_type'      => [],
        'installation_type' => [],
		'door_type'         => [],
		'frame_type'        => [],
		'handle_type'       => '',
		'handle_number'     => '',

    ];

    /*
    |--------------------------------------------------------------------------
    | EXTRACT SPECIFICATIONS
    |--------------------------------------------------------------------------
    */

    $specifications = [];

    preg_match_all(
        '/([a-zA-Z\s\(\)\*]+)\s*:\s*([^\n]+)/',
        $clean_description,
        $matches,
        PREG_SET_ORDER
    );

    foreach ($matches as $match) {

        $key = trim(
            strtolower($match[1])
        );

        $value = trim($match[2]);

        $specifications[$key] = $value;
    }

    /*
    |--------------------------------------------------------------------------
    | COLOR
    |--------------------------------------------------------------------------
    */

    $attributes['color'] = wellfor_detect_color(
        $title,
        $text,
        $specifications,
        $config,
        $shopify_product_type
    );

    /*
    |--------------------------------------------------------------------------
    | MATERIAL
    |--------------------------------------------------------------------------
    */

    if ($shopify_product_type === 'Bathroom Vanities') {

        $attributes['material'] = wellfor_normalize_material(
            $text,
            $shopify_product_type
        );
    } else {

        $material_fields = [
            'cabinet material',
            'frame material',
            'material',
            'handle material'
        ];

        foreach ($material_fields as $field) {

            if (!empty($specifications[$field])) {

                $attributes['material'] = wellfor_normalize_material(
                    $specifications[$field],
                    $shopify_product_type
                );

                break;
            }
        }

        if (empty($attributes['material'])) {

            $attributes['material'] = wellfor_normalize_material(
                $text,
                $shopify_product_type
            );
        }
    }

    $attributes['material'] = wellfor_allowed_value(
        $attributes['material'],
        $config['materials']
    );

    /*
    |--------------------------------------------------------------------------
    | SHAPE
    |--------------------------------------------------------------------------
    */

    if ($shopify_product_type === 'Mirrors') {

        if (!empty($specifications['shape'])) {

            $attributes['shape'] = wellfor_detect_allowed_attribute(
                $specifications['shape'],
                $config['shapes']
            );
        }

        if (empty($attributes['shape'])) {

            $attributes['shape'] = wellfor_detect_allowed_attribute(
                $text,
                $config['shapes']
            );
        }
    }
	
	

    /*
    |--------------------------------------------------------------------------
    | DIMENSIONS
    |--------------------------------------------------------------------------
    */

    $dimension_text = '';

    $dimension_fields = [
        'sizes',
		'dimensions',
		'product size',
		'product dimensions',
		'overall dimensions',
		'nominal dimension(w*d*h)',
		'nominal dimensions',
		'vanity top dimensions'
    ];

    foreach ($dimension_fields as $field) {

        if (!empty($specifications[$field])) {

            $dimension_text = strtolower(
                $specifications[$field]
            );

            break;
        }
    }

    if (empty($dimension_text)) {

        $dimension_text = strtolower($text);
    }
	
	

    /*
    |--------------------------------------------------------------------------
    | WIDTH DEPTH HEIGHT
    | 30" W × 18.31" D × 34.25" H
    |--------------------------------------------------------------------------
    */

    if (
        preg_match(
            '/(\d+(?:\.\d+)?(?:\s+\d+\/\d+)?)\s*(?:in\.?|")\s*w\s*[x×]\s*(\d+(?:\.\d+)?(?:\s+\d+\/\d+)?)\s*(?:in\.?|")\s*d\s*[x×]\s*(\d+(?:\.\d+)?(?:\s+\d+\/\d+)?)\s*(?:in\.?|")\s*h/i',
            $dimension_text,
            $matches
        )
    ) {

        $attributes['width']  = $matches[1];
        $attributes['depth']  = $matches[2];
        $attributes['height'] = $matches[3];
    }

    /*
    |--------------------------------------------------------------------------
    | NOMINAL DIMENSION FORMAT
    | 60W*22D*0.79H inches
    |--------------------------------------------------------------------------
    */

    elseif (
        preg_match(
            '/(\d+(?:\.\d+)?(?:\s+\d+\/\d+)?)\s*w\s*\*\s*(\d+(?:\.\d+)?(?:\s+\d+\/\d+)?)\s*d\s*\*\s*(\d+(?:\.\d+)?(?:\s+\d+\/\d+)?)\s*h/i',
            $dimension_text,
            $matches
        )
    ) {

        $attributes['width']  = $matches[1];
        $attributes['depth']  = $matches[2];
        $attributes['height'] = $matches[3];
    }elseif (
		preg_match(
			'/(\d+(?:\.\d+)?)\s*\*\s*(\d+(?:\.\d+)?)\s*d\s*\*\s*((?:\d+\s+\d+\/\d+)|(?:\d+\/\d+)|(?:\d+(?:\.\d+)?))\s*h/i',
			$dimension_text,
			$matches
		)
	) {

		$attributes['width'] = $matches[1];
		$attributes['depth'] = $matches[2];
		$attributes['height'] = $matches[3];
	}

    /*
    |--------------------------------------------------------------------------
    | WIDTH HEIGHT
    |--------------------------------------------------------------------------
    */

    elseif (
        preg_match(
            '/(\d+(?:\.\d+)?(?:\s+\d+\/\d+)?)\s*(?:in\.?|")\s*w\s*[x×]\s*(\d+(?:\.\d+)?(?:\s+\d+\/\d+)?)\s*(?:in\.?|")\s*h/i',
            $dimension_text,
            $matches
        )
    ) {

        $attributes['width']  = $matches[1];
        $attributes['height'] = $matches[2];
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPLE 32" x 36"
    |--------------------------------------------------------------------------
    */

    elseif (
        preg_match(
            '/(\d+(?:\.\d+)?(?:\s+\d+\/\d+)?)\s*(?:in\.?|")\s*[x×]\s*(\d+(?:\.\d+)?(?:\s+\d+\/\d+)?)\s*(?:in\.?|")/i',
            $dimension_text,
            $matches
        )
    ) {

        $attributes['width']  = $matches[1];
        $attributes['height'] = $matches[2];
    }

    /*
    |--------------------------------------------------------------------------
    | INDIVIDUAL WIDTH
    |--------------------------------------------------------------------------
    */

    if (
        empty($attributes['width']) &&
        preg_match(
            '/(\d+(?:\.\d+)?(?:\s+\d+\/\d+)?)\s*(?:in\.?|")\s*w/i',
            $dimension_text,
            $matches
        )
    ) {

        $attributes['width'] = $matches[1];
    }

    /*
    |--------------------------------------------------------------------------
    | INDIVIDUAL DEPTH
    |--------------------------------------------------------------------------
    */

    if (
        empty($attributes['depth']) &&
        preg_match(
            '/(\d+(?:\.\d+)?(?:\s+\d+\/\d+)?)\s*(?:in\.?|")\s*d/i',
            $dimension_text,
            $matches
        )
    ) {

        $attributes['depth'] = $matches[1];
    }

    /*
    |--------------------------------------------------------------------------
    | INDIVIDUAL HEIGHT
    |--------------------------------------------------------------------------
    */

    if (
        empty($attributes['height']) &&
        preg_match(
            '/(\d+(?:\.\d+)?(?:\s+\d+\/\d+)?)\s*(?:in\.?|")\s*h/i',
            $dimension_text,
            $matches
        )
    ) {

        $attributes['height'] = $matches[1];
    }
	
	/*
	|--------------------------------------------------------------------------
	| BATHROOM VANITY WIDTH FROM TITLE
	|--------------------------------------------------------------------------
	*/

	if (
		$shopify_product_type === 'Bathroom Vanities'
		//&& empty($attributes['width'])
	) {

		if (
			preg_match(
				'/\b(24|30|36|40|48|60|72|80|84)\s*(?:-| )?(?:inch|inches|in\.|")?\b/i',
				$title,
				$matches
			)
		) {

			$attributes['width'] = $matches[1];
		}
		
	}elseif ($shopify_product_type === 'Mirrors') {

		preg_match_all(
			'/\b(\d+(?:\.\d+)?)\s*(?:-| )?(?:inches|inch|in\.|″|")?/i',
			$title,
			$matches
		);

		if (!empty($matches[1])) {

			foreach ($matches[1] as $dimension) {

				if (
					empty($attributes['width']) &&
					in_array($dimension, $config['widths'], true)
				) {

					$attributes['width'] = $dimension;
					continue;
				}

				if (
					empty($attributes['height']) &&
					in_array($dimension, $config['heights'], true)
				) {

					$attributes['height'] = $dimension;
					break;
				}
			}
		}
	}elseif ($shopify_product_type === 'Medicine Cabinets') {

		preg_match_all(
			'/\b(\d+(?:\.\d+)?)\s*(?:-| )?(?:inches|inch|in\.|″|")?/i',
			$title,
			$matches
		);

		if (!empty($matches[1])) {

			foreach ($matches[1] as $dimension) {

				if (
					empty($attributes['width']) &&
					in_array($dimension, $config['widths'], true)
				) {

					$attributes['width'] = $dimension;
					continue;
				}

				if (
					empty($attributes['height']) &&
					in_array($dimension, $config['heights'], true)
				) {

					$attributes['height'] = $dimension;
					break;
				}
			}
		}
	}elseif ($shopify_product_type === 'Toilets') {

		preg_match_all(
			'/\b(\d+(?:\.\d+)?)\s*(?:-| )?(?:inches|inch|in\.|″|")?/i',
			$title,
			$matches
		);

		if (!empty($matches[1])) {

			foreach ($matches[1] as $dimension) {

				if (
					empty($attributes['width']) &&
					in_array($dimension, $config['widths'], true)
				) {

					$attributes['width'] = $dimension;
					continue;
				}

				if (
					empty($attributes['height']) &&
					in_array($dimension, $config['heights'], true)
				) {

					$attributes['height'] = $dimension;
					break;
				}
			}
		}
	}elseif ($shopify_product_type === 'Shower Doors') {

			$normalized_title = str_replace(
				['–', '—'],
				'-',
				$title
			);

			if (
				preg_match(
					'/(\d+)(?:\s*-\s*(\d+))?\s*(?:in\.?|inch(?:es)?|")?\s*W\b/i',
					$normalized_title,
					$matches
				)
			) {
			
				// Range: 56-60 => 60
				if (!empty($matches[2])) {
					$attributes['width'] = $matches[2];
				}
				// Single: 60 => 60
				else {
					$attributes['width'] = $matches[1];
				}
			}

			if (
				preg_match(
					'/x\s*(\d+)(?:\s*-\s*(\d+))?\s*(?:in\.?|inch(?:es)?|")?\s*H\b/i',
					$normalized_title,
					$matches
				)
			) {

				// Agar kabhi range aa jaye 70-72 H
				if (!empty($matches[2])) {
					$attributes['height'] = $matches[2];
				} else {
					$attributes['height'] = $matches[1];
				}
			}
		}elseif ($shopify_product_type === 'Bathroom Faucets') {

				$source = wp_strip_all_tags($description);

				/*
				==========================================================
				HEIGHT
				Priority:
				Overall Height > Total Height > Faucet Height > Spout Height
				==========================================================
				*/

				$height_patterns = [
						'/Overall\s+Height.*?(\d+(?:\.\d+)?)/is',
						'/Total\s+Height.*?(\d+(?:\.\d+)?)/is',
						'/Faucet\s+Height.*?(\d+(?:\.\d+)?)/is',
						'/Spout\s+Height.*?(\d+(?:\.\d+)?)/is',
					];

				foreach ($height_patterns as $pattern) {

					if (preg_match($pattern, $source, $matches)) {
						$attributes['height'] = $matches[1];
						break;
					}
				}
				
				/*
				==========================================================
				DEPTH
				==========================================================
				*/

				if (
					preg_match(
						'/Spout\s+Reach.*?(\d+(?:\.\d+)?)/is',
						$source,
						$matches
					)
				) {
					$attributes['depth'] = $matches[1];
				}

				/*
				==========================================================
				DIMENSIONS
				Examples:
				Product Dimensions: 13.18 x 9.37 x 13.18 inches
				Package Dimensions: 14.1 x 7.2 x 4 inches
				Dimensions: 5.91 x 2.36 x 4.33
				==========================================================
				*/

				if (
					preg_match(
						'/(?:Package|Product)?\s*Dimensions?\s*:\s*(\d+(?:\.\d+)?)\s*[x×\*]\s*(\d+(?:\.\d+)?)\s*[x×\*]\s*(\d+(?:\.\d+)?)/i',
						$source,
						$matches
					)
				) {

					if (empty($attributes['width'])) {
						$attributes['width'] = $matches[1];
					}

					if (empty($attributes['height'])) {
						$attributes['height'] = $matches[2];
					}

					if (empty($attributes['depth'])) {
						$attributes['depth'] = $matches[3];
					}
				}

				/*
				==========================================================
				OVERALL DIMENSIONS
				Example:
				Overall Dimensions: 7.87" H x 6.1" W x 5.9" D
				==========================================================
				*/

				if (
					empty($attributes['width']) ||
					empty($attributes['height']) ||
					empty($attributes['depth'])
				) {

					if (
						preg_match(
							'/(\d+(?:\.\d+)?)\s*"?\s*H\s*x\s*(\d+(?:\.\d+)?)\s*"?\s*W\s*x\s*(\d+(?:\.\d+)?)\s*"?\s*D/i',
							$source,
							$matches
						)
					) {

						if (empty($attributes['height'])) {
							$attributes['height'] = $matches[1];
						}

						if (empty($attributes['width'])) {
							$attributes['width'] = $matches[2];
						}

						if (empty($attributes['depth'])) {
							$attributes['depth'] = $matches[3];
						}
					}
				}
				
				
			}
	
	
	

    $attributes['width'] = wellfor_normalize_dimension_value(
        $attributes['width'],
        $config['widths']
    );

    $attributes['height'] = wellfor_normalize_dimension_value(
        $attributes['height'],
        $config['heights']
    );

    $attributes['depth'] = wellfor_normalize_dimension_value(
        $attributes['depth'],
        $config['depths']
    );

    /*
    |--------------------------------------------------------------------------
    | PRODUCT TYPE AND INSTALLATION TYPE
    |--------------------------------------------------------------------------
    */

    if ($shopify_product_type === 'Bathroom Vanities') {

        /*if (wellfor_text_has_word($text, 'double sink')) {
            $attributes['product_type'][] = 'Double Sink Vanities';
        } else {
            $attributes['product_type'][] = 'Single Sink Vanity';
        }*/

		if ((float)$attributes['width'] > 48) {
			$attributes['product_type'][] = 'Double Sink Vanities';
		} else {
			$attributes['product_type'][] = 'Single Sink Vanity';
		}

        if (wellfor_text_has_word($text, 'floating')) {
            $attributes['installation_type'][] = 'Floating';
        }elseif (
            wellfor_text_has_word($text, 'freestanding')
            || preg_match('/\bfree\s+standing\b/i', $text)
        ) {
            $attributes['installation_type'][] = 'Freestanding';
        }
    }

    if ($shopify_product_type === 'Mirrors') {

        if (
            wellfor_text_has_word($text, 'backlit')
            && wellfor_text_has_word($text, 'frontlit')
        ) {
            $attributes['product_type'][] = 'Backlit and Frontlit';
        } elseif (wellfor_text_has_word($text, 'backlit')) {
            $attributes['product_type'][] = 'Back Light';
        }

        if (wellfor_text_has_word($text, 'led')) {
            $attributes['product_type'][] = 'With Lighting';
        } else {
            $attributes['product_type'][] = 'Without Lighting';
        }

        if (wellfor_text_has_word($text, 'Wood')) {
            $attributes['product_type'][] = 'Wood';
        }

        if (wellfor_text_has_word($text, 'Frameless')) {
            $attributes['product_type'][] = 'Frameless';
        } elseif (wellfor_text_has_word($text, 'Framed')) {
            $attributes['product_type'][] = 'Framed';
        }
		
		if (
			!in_array('Framed', $attributes['product_type'])
			&&
			!in_array('Frameless', $attributes['product_type'])
		) {
			$attributes['product_type'][] = 'Framed';
		}

        $attributes['installation_type'][] = 'Wall-mounted';
    }
	
		if ($shopify_product_type === 'Medicine Cabinets') {

		/*
		|--------------------------------------------------------------------------
		| SHAPE
		|--------------------------------------------------------------------------
		*/

		if (
			!empty($attributes['width'])
			&&
			!empty($attributes['height'])
		) {

			if (
				abs(
					floatval($attributes['width'])
					-
					floatval($attributes['height'])
				) < 0.5
			) {

				$attributes['shape'] = 'Square';

			} else {

				$attributes['shape'] = 'Rectangle';
			}
		}

		/*
		|--------------------------------------------------------------------------
		| PRODUCT TYPE
		|--------------------------------------------------------------------------
		*/

		if (
			preg_match(
				'/\b(led|lighted|backlit|frontlit|illuminated)\b/i',
				$text
			)
		) {

			$attributes['product_type'][] ='Medicine Cabinets with Light';

		} elseif (
			stripos($text, 'solid wood') !== false
			||
			stripos($text, 'wood frame') !== false
			||
			stripos($text, 'wood cabinet') !== false
			||
			stripos($text, 'wooden') !== false
		) {

			$attributes['product_type'][] ='Wood Medicine Cabinet with Mirror';

		} else {

			$attributes['product_type'][] ='Medicine Cabinets without Light';
		}

		/*
		|--------------------------------------------------------------------------
		| INSTALLATION
		|--------------------------------------------------------------------------
		*/

		if (
			stripos($text, 'recessed') !== false
		) {

			$attributes['installation_type'][] = 'Recessed Mount';
		}

		if (
			stripos($text, 'surface mount') !== false
			||
			stripos($text, 'surface-mounted') !== false
			||
			stripos($text, 'wall mount') !== false
			||
			stripos($text, 'wall-mounted') !== false
			||
			stripos($text, 'wall mounted') !== false
			||
			stripos($text, 'surface installation') !== false
		) {

			$attributes['installation_type'][] ='Surface Mount';
		}

		if (empty($attributes['installation_type'])) {

			$attributes['installation_type'][] = 'Surface Mount';
		}
	}
	
	if ($shopify_product_type === 'Toilets') {

		if (
			stripos($text, 'elongated rectangular') !== false
		) {

			$attributes['shape'] = 'Elongated Rectangular';

		} elseif (
			stripos($text, 'elongated') !== false
		) {

			$attributes['shape'] = 'Elongated';
		}
		
		 $attributes['installation_type'][] = 'Floor-mounted';
	}
	
	if ($shopify_product_type === 'Shower Doors') {

		/*
		|--------------------------------------------------------------------------
		| DOOR TYPE
		|--------------------------------------------------------------------------
		*/

		if (
			stripos($text, 'bi-fold') !== false
			||
			stripos($text, 'bifold') !== false
			||
			stripos($text, 'folding') !== false
		) {

			$attributes['door_type'][] = 'Bi-Fold';

		} elseif (
			stripos($text, 'pivot') !== false
		) {

			$attributes['door_type'][] = 'Pivot';

		} elseif (
			stripos($text, 'hinged') !== false
		) {

			$attributes['door_type'][] = 'Hinged';

		} elseif (
			stripos($text, 'sliding') !== false
			||
			stripos($text, 'bypass') !== false
		) {

			$attributes['door_type'][] = 'Sliding';

		} elseif (
			stripos($text, 'fixed') !== false
			||
			stripos($text, 'walk-in') !== false
			||
			stripos($text, 'shower screen') !== false
		) {

			$attributes['door_type'][] = 'Fixed';
		}

		/*
		|--------------------------------------------------------------------------
		| FRAME TYPE
		|--------------------------------------------------------------------------
		*/

		if (
			stripos($text, 'semi-frameless') !== false
		) {

			$attributes['frame_type'][] = 'Semi-Frameless';

		} elseif (
			stripos($text, 'frameless') !== false
		) {

			$attributes['frame_type'][] = 'Frameless';

		} elseif (
			stripos($text, 'framed') !== false
		) {

			$attributes['frame_type'][] = 'Framed';
		}

		/*
		|--------------------------------------------------------------------------
		| DEFAULTS
		|--------------------------------------------------------------------------
		*/

		if (empty($attributes['door_type'])) {

			$attributes['door_type'][] = 'Sliding';
		}

		if (empty($attributes['frame_type'])) {

			$attributes['frame_type'][] = 'Frameless';
		}
	}
	
	
	if ($shopify_product_type === 'Bathroom Faucets') {

		/*
		|--------------------------------------------------------------------------
		| PRODUCT TYPE
		|--------------------------------------------------------------------------
		*/

		foreach ($config['product_types'] as $product_type) {

			if (
				stripos($text, $product_type) !== false
			) {

				$attributes['product_type'][] = $product_type;
				break;
			}
		}

		/*
		|--------------------------------------------------------------------------
		| INSTALLATION TYPE
		|--------------------------------------------------------------------------
		*/

		if (
			stripos($text, 'deck mount') !== false
			||
			stripos($text, 'deck-mounted') !== false
			||
			stripos($text, 'deck mounted') !== false
		) {

			$attributes['installation_type'][] = 'Deck Mount';

		} elseif (
			stripos($text, 'wall mount') !== false
			||
			stripos($text, 'wall-mounted') !== false
			||
			stripos($text, 'wall mounted') !== false
		) {

			$attributes['installation_type'][] = 'Wall Mount';

		} elseif (
			stripos($text, 'floor mount') !== false
			||
			stripos($text, 'floor-mounted') !== false
			||
			stripos($text, 'floor mounted') !== false
		) {

			$attributes['installation_type'][] = 'Floor Mount';
		}

		/*
		|--------------------------------------------------------------------------
		| HANDLE TYPE
		|--------------------------------------------------------------------------
		*/

		if (
			stripos($text, 'single handle') !== false
			||
			stripos($text, 'single lever') !== false
		) {

			$attributes['handle_type'] = 'Single Handle';

		} elseif (
			stripos($text, 'lever') !== false
		) {

			$attributes['handle_type'] = 'Lever';

		} elseif (
			stripos($text, 'knob') !== false
		) {

			$attributes['handle_type'] = 'Knob';

		} elseif (
			stripos($text, 'cross') !== false
		) {

			$attributes['handle_type'] = 'Cross';
		}

		/*
		|--------------------------------------------------------------------------
		| HANDLE NUMBER
		|--------------------------------------------------------------------------
		*/

		if (
			preg_match(
				'/\bnumber\s+of\s+handles?\s*[:\-]?\s*([123])\b/i',
				$text,
				$matches
			)
		) {

			$attributes['handle_number'] = $matches[1];
		}
		
		if (empty($attributes['handle_number'])) {

			if (
				stripos($text, 'double handle') !== false
				||
				stripos($text, 'dual handle') !== false
				||
				stripos($text, 'two handles') !== false
				||
				stripos($text, '2 handles') !== false
				||
				stripos($text, 'dual-handle') !== false
				||
				stripos($text, '2 handle') !== false
			) {

				$attributes['handle_number'] = '2';

			} elseif (
				stripos($text, 'single handle') !== false
				||
				stripos($text, '1 handle') !== false
			) {

				$attributes['handle_number'] = '1';
			}
		}

		/*
		|--------------------------------------------------------------------------
		| DEFAULTS
		|--------------------------------------------------------------------------
		*/

		if (empty($attributes['installation_type'])) {

			$attributes['installation_type'][] = 'Deck Mount';
		}
	}
	
	
	if ($shopify_product_type === 'Shower System') {

		/*
		|--------------------------------------------------------------------------
		| PRODUCT TYPE
		|--------------------------------------------------------------------------
		*/

		if (
			stripos($text, 'hand shower') !== false
			&&
			stripos($text, 'slide bar') !== false
		) {

			$attributes['product_type'][] =
				'Hand Shower with Slide Bars';

		} elseif (

			stripos($text, 'faucet') !== false
			||
			stripos($text, 'tub spout') !== false

		) {

			$attributes['product_type'][] =
				'Shower System with Faucets';

		} else {

			$attributes['product_type'][] =
				'Shower Systems';
		}


		/*
		|--------------------------------------------------------------------------
		| INSTALLATION TYPE
		|--------------------------------------------------------------------------
		*/

		if (
			stripos($text, 'ceiling mount') !== false
			||
			stripos($text, 'ceiling-mounted') !== false
			||
			stripos($text, 'ceiling mounted') !== false
		) {

			$attributes['installation_type'][] =
				'Ceiling Mount';
		}

		if (
			stripos($text, 'concealed') !== false
			||
			stripos($text, 'in-wall') !== false
			||
			stripos($text, 'built-in') !== false
		) {

			$attributes['installation_type'][] =
				'Concealed In-Wall';
		}

		if (
			stripos($text, 'wall mount') !== false
			||
			stripos($text, 'wall-mounted') !== false
			||
			stripos($text, 'wall mounted') !== false
		) {

			$attributes['installation_type'][] =
				'Wall Mount';
		}


		/*
		|--------------------------------------------------------------------------
		| SHAPE
		|--------------------------------------------------------------------------
		*/

		if (
			stripos($text, 'rectangular') !== false
			||
			preg_match('/\d+(\.\d+)?\s*[x×]\s*\d+(\.\d+)?/i', $text)
		) {

			$attributes['shape'] = 'Rectangular';

		} elseif (

			stripos($text, 'square') !== false

		) {

			$attributes['shape'] = 'Square';

		} elseif (

			stripos($text, 'round') !== false

		) {

			$attributes['shape'] = 'Round';
		}


		/*
		|--------------------------------------------------------------------------
		| HANDLE TYPE
		|--------------------------------------------------------------------------
		*/

		if (stripos($text, 'cross handle') !== false) {

			$attributes['handle_type'] = 'Cross';

		} elseif (stripos($text, 'knob') !== false) {

			$attributes['handle_type'] = 'Knob';

		} elseif (

			stripos($text, 'lever') !== false
			||
			stripos($text, 'single handle') !== false

		) {

			$attributes['handle_type'] = 'Lever';
		}


		/*
		|--------------------------------------------------------------------------
		| HANDLE NUMBER
		|--------------------------------------------------------------------------
		*/

		if (
			preg_match(
				'/([123])\s*(?:handles?|handle)/i',
				$text,
				$matches
			)
		) {

			$attributes['handle_number'] = $matches[1];
		}
	}

    $attributes['product_type'] = array_values(
        array_unique(
            array_filter(
                array_map(
                    function ($type) use ($config) {
                        return wellfor_allowed_value($type, $config['product_types']);
                    },
                    $attributes['product_type']
                )
            )
        )
    );

    /*$attributes['installation_type'] = wellfor_allowed_value(
        $attributes['installation_type'],
        $config['installation_types']
    );*/
	$attributes['installation_type'] = array_values(
		array_unique(
			array_filter(
				array_map(
					function ($type) use ($config) {

						return wellfor_allowed_value(
							$type,
							$config['installation_types']
						);

					},
					(array) $attributes['installation_type']
				)
			)
		)
	);
	
	$attributes['door_type'] = array_values(
		array_unique(
			array_filter(
				array_map(
					function ($type) use ($config) {
						return wellfor_allowed_value(
							$type,
							$config['door_types']
						);
					},
					(array) $attributes['door_type']
				)
			)
		)
	);

	$attributes['frame_type'] = array_values(
		array_unique(
			array_filter(
				array_map(
					function ($type) use ($config) {
						return wellfor_allowed_value(
							$type,
							$config['frame_types']
						);
					},
					(array) $attributes['frame_type']
				)
			)
		)
	);
	
	
	/*
	|--------------------------------------------------------------------------
	| DEFAULT ATTRIBUTE VALUES
	|--------------------------------------------------------------------------
	*/

	if ($shopify_product_type === 'Bathroom Vanities') {

		if (empty($attributes['width'])) {
			$attributes['width'] = '24';
		}

		if (empty($attributes['depth'])) {
			$attributes['depth'] = '22';
		}

		if (empty($attributes['color'])) {
			$attributes['color'] = ['White'];
		}

		// Always force material
		$attributes['material'] = 'Solid Wood';

		if (empty($attributes['installation_type'])) {
			$attributes['installation_type'][] = 'Freestanding';
		}

		// Width based sink type
		if ((float)$attributes['width'] > 48) {
			$attributes['product_type'] = ['Double Sink Vanities'];
		} else {
			$attributes['product_type'] = ['Single Sink Vanity'];
		}
	}

	if ($shopify_product_type === 'Mirrors') {

		if (empty($attributes['width'])) {
			$attributes['width'] = '22';
		}

		if (empty($attributes['height'])) {
			$attributes['height'] = '34';
		}

		if (empty($attributes['color'])) {
			$attributes['color'] = ['Brushed Nickel'];
		}

		if (empty($attributes['material'])) {
			$attributes['material'] = 'Aluminum';
		}

		if (empty($attributes['shape'])) {
			$attributes['shape'] = 'Rectangle';
		}

		if (empty($attributes['product_type'])) {
			$attributes['product_type'] = ['Framed'];
		}
	}
	
	if ($shopify_product_type === 'Medicine Cabinets') {

		if (empty($attributes['width'])) {
			$attributes['width'] = '24';
		}

		if (empty($attributes['height'])) {
			$attributes['height'] = '30';
		}

		if (empty($attributes['depth'])) {
			$attributes['depth'] = '5';
		}

		if (empty($attributes['color'])) {
			$attributes['color'] = ['White'];
		}

		if (empty($attributes['material'])) {
			$attributes['material'] = 'Aluminum';
		}

		if (empty($attributes['shape'])) {
			$attributes['shape'] = 'Rectangle';
		}

		if (empty($attributes['product_type'])) {
			$attributes['product_type'] = [
				'Medicine Cabinets without Light'
			];
		}

		if (empty($attributes['installation_type'])) {
			$attributes['installation_type'][] =
				'Surface Mount';
		}
	}
	
	if ($shopify_product_type === 'Toilets') {

		if (empty($attributes['width'])) {
			$attributes['width'] = '27.2';
		}

		if (empty($attributes['height'])) {
			$attributes['height'] = '20';
		}

		if (empty($attributes['depth'])) {
			$attributes['depth'] = '15.6';
		}

		if (empty($attributes['color'])) {
			$attributes['color'] = ['White'];
		}

		if (empty($attributes['material'])) {
			$attributes['material'] = 'Ceramic';
		}

		if (empty($attributes['installation_type'])) {
			$attributes['installation_type'][] = 'Floor-mounted';
		}
	}
	
	if ($shopify_product_type === 'Shower Doors') {
		
				
		if (empty($attributes['height'])) {
			$attributes['height'] = '72';
		}
		
		if (empty($attributes['width'])) {
			$attributes['width'] = '56';
		}
		
		if (empty($attributes['color'])) {
			$attributes['color'] = ['Chrome'];
		}

		if (empty($attributes['material'])) {
			$attributes['material'] = 'Tempered Glass';
		}

		if (empty($attributes['door_type'])) {
			$attributes['door_type'] = ['Sliding'];
		}

		if (empty($attributes['frame_type'])) {
			$attributes['frame_type'] = ['Frameless'];
		}
	}
	
	if ($shopify_product_type === 'Bathroom Faucets') {

		if (empty($attributes['width'])) {
			$attributes['width'] = '6';
		}

		if (empty($attributes['height'])) {
			$attributes['height'] = '6';
		}

		if (empty($attributes['depth'])) {
			$attributes['depth'] = '7';
		}

		if (empty($attributes['color'])) {
			$attributes['color'] = ['Matte Black'];
		}

		if (empty($attributes['material'])) {
			$attributes['material'] = 'Brass';
		}

		if (empty($attributes['product_type'])) {
			$attributes['product_type'] = [
				'Single-Hole Faucets'
			];
		}

		if (empty($attributes['installation_type'])) {
			$attributes['installation_type'][] =
				'Deck Mount';
		}

		if (empty($attributes['handle_type'])) {
			$attributes['handle_type'] = 'Lever';
		}

		if (empty($attributes['handle_number'])) {
			$attributes['handle_number'] = '1';
		}
	}
	
	if ($shopify_product_type === 'Shower System') {

		if (empty($attributes['color'])) {
			$attributes['color'] = ['Matte Black'];
		}

		if (empty($attributes['material'])) {
			$attributes['material'] = '304 Stainless Steel';
		}

		if (empty($attributes['shape'])) {
			$attributes['shape'] = 'Square';
		}

		if (empty($attributes['width'])) {
			$attributes['width'] = '10';
		}

		if (empty($attributes['height'])) {
			$attributes['height'] = '10';
		}

		if (empty($attributes['depth'])) {
			$attributes['depth'] = '7.36';
		}

		if (empty($attributes['product_type'])) {
			$attributes['product_type'] = ['Shower Systems'];
		}

		if (empty($attributes['installation_type'])) {
			$attributes['installation_type'][] = 'Wall Mount';
		}

		if (empty($attributes['handle_type'])) {
			$attributes['handle_type'] = 'Lever';
		}

		if (empty($attributes['handle_number'])) {
			$attributes['handle_number'] = '1';
		}
	}

    return $attributes;
}

/*
|--------------------------------------------------------------------------
| SAVE TAXONOMY TERM
|--------------------------------------------------------------------------
*/

function wellfor_save_product_attribute(
    $product_id,
    $taxonomy,
    $value,
    $shopify_product_type = ''
) {

    if (
        empty($product_id) ||
        empty($taxonomy) ||
        empty($value)
    ) {
        return;
    }

    $allowed_values = wellfor_allowed_attribute_values(
        $shopify_product_type,
        $taxonomy
    );

    if (!empty($allowed_values)) {

        $value = str_replace('"', '', trim((string) $value));

        $value = wellfor_allowed_value(
            $value,
            $allowed_values
        );

        if (empty($value)) {
            return;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE TERM
    |--------------------------------------------------------------------------
    */

    if (!term_exists($value, $taxonomy)) {

        wp_insert_term(
            $value,
            $taxonomy
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ASSIGN TERM
    |--------------------------------------------------------------------------
    */

    wp_set_object_terms(
        $product_id,
        $value,
        $taxonomy,
       //  false
	    //$taxonomy === 'pa_product_type'
		in_array(
			$taxonomy,
			[
				'pa_product_type',
				'pa_color',
				'pa_installation_type'
			]
		)
    );

    /*
    |--------------------------------------------------------------------------
    | GET ATTRIBUTES
    |--------------------------------------------------------------------------
    */

    $product_attributes = get_post_meta(
        $product_id,
        '_product_attributes',
        true
    );

    if (
        empty($product_attributes)
        ||
        !is_array($product_attributes)
    ) {

        $product_attributes = [];
    }

    /*
    |--------------------------------------------------------------------------
    | ATTRIBUTE ID
    |--------------------------------------------------------------------------
    */

    $attribute_name = str_replace(
        'pa_',
        '',
        $taxonomy
    );

    $attribute_id = wc_attribute_taxonomy_id_by_name(
        $attribute_name
    );

    /*
    |--------------------------------------------------------------------------
    | SAVE ATTRIBUTE
    |--------------------------------------------------------------------------
    */

    $product_attributes[$taxonomy] = [

        'id'           => $attribute_id,

        'name'         => $taxonomy,

        'position'     => 0,

        'is_visible'   => 1,

        'is_variation' => 0,

        'is_taxonomy'  => 1

    ];

    update_post_meta(
        $product_id,
        '_product_attributes',
        $product_attributes
    );
}

function import_wellfor_products($page = 1) {
	
		global $wpdb;
		
		
		
		set_time_limit(0);
		
		$failed_products = get_posts([
			'post_type'   => 'product',
			'post_status' => 'any',
			'numberposts' => -1,
			'meta_key'    => '_import_status',
			'meta_value'  => 'processing'
		]);

		foreach ($failed_products as $failed_product) {

			$started =
				get_post_meta(
					$failed_product->ID,
					'_import_started_at',
					true
				);

			if (
				strtotime($started)
				<
				strtotime('-2 hours')
			) {

				wp_delete_post(
					$failed_product->ID,
					true
				);
			}
		}

		ini_set('memory_limit', '1024M');

		ignore_user_abort(true);

		add_filter(
			'intermediate_image_sizes_advanced',
			'__return_empty_array'
		);
		
		$limit =  250;
		$url = "https://www.wellfor.com/products.json?limit=".$limit."&page=".$page;
		//echo $url; die;
		echo '<br>Importing Page : '.$page.'<br>'; 

		$response = wp_remote_get($url, [
			'timeout' => 300
		]);


		if (is_wp_error($response)) {
			return 'API Error';
		}

		$body = wp_remote_retrieve_body($response);

		$data = json_decode($body, true);

		/*if (empty($data['products'])) {
			return 'No Products Found';
		}*/
		
		if (empty($data['products'])) {
			$wpdb->update(
				'wellfor_import_status',
				[
					'current_page'        => 1,
					'last_completed_date' => date('Y-m-d'),
					'is_running'          => 0
				],
				[
					'id' => 1
				]
			);

			return 'IMPORT COMPLETED';
		}

		require_once(ABSPATH . 'wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/media.php');
		require_once(ABSPATH . 'wp-admin/includes/image.php');

		$allowed_types = [
			'Mirrors',
			'Bathroom Vanities',
			'Medicine Cabinets',
			'Toilets',
			'Shower Doors',
			'Bathroom Faucets',
			'Bathtubs',
			'Shower System',
		];
		
		$category_map = [
			'Mirrors'            => 'mirrors',
			'Bathroom Vanities'  => 'bathroom-vanities',
			'Medicine Cabinets'  => 'medicine-cabinets',
			'Toilets'            => 'toilets',
			'Shower Doors'       => 'shower-doors',
			'Bathroom Faucets'   => 'bathroom-faucets',
			'Bathtubs'   => 'bathtubs',
			'Shower System'   => 'shower-systems',
		];


	/*$testingdata = array();
	foreach ($data['products'] as $product) {
		$product_type = trim($product['product_type']);

		if ($product_type == "Shower System") {
			$title       = wp_strip_all_tags($product['title']);
			$description = $product['body_html'];
			$testingdata[$product['id']]['title'] = $title;
			$testingdata[$product['id']]['description'] = $description;
		}
	}
	echo '<pre>'; print_r($testingdata);
	die('passs');*/
	
		$a = 1;
		$staticProductIds = array('7473841111232'); 
	
	foreach ($data['products'] as $product) {
		
		

		try {
			
			if (!in_array($product['id'] , $staticProductIds)) {  
				continue;
			}
			//echo '<pre>product'; print_r($product); die;
			$product_type = trim($product['product_type']);

			if (!in_array($product_type, $allowed_types)) {
				continue;
			}
			
			wellfor_log(
				'PRODUCT START => ' .
				$product['id']
			);
			
			$title       = wp_strip_all_tags($product['title']);
			$description = $product['body_html'];
			$handle      = $product['handle'];
			$vendor      = $product['vendor'];
			
			 /*
			|--------------------------------------------------------------------------
			| ATTRIBUTES
			|--------------------------------------------------------------------------
			*/

			$attributes = wellfor_extract_attributes(
				$title,
				$description,
                $product_type
			);
			
			echo '<pre>product'; print_r($product);
			echo '<pre>attributes'; print_r($attributes); die;
			
			/******************* comment new code ********/
			
			/*
			=========================================
			CHECK PRODUCT EXIST
			=========================================
			*/

			$existing = get_posts([
				'post_type'   => 'product',
				'meta_key'    => 'shopify_product_id',
				'meta_value'  => $product['id'],
				'numberposts' => 1,
				'post_status' => 'any'
			]);
			
			if (!empty($existing)) {

				$existing_product_id = $existing[0]->ID;

				$import_status =
					get_post_meta(
						$existing_product_id,
						'_import_status',
						true
					);
					
				$import_locked = get_post_meta(
							$existing_product_id,
							'_import_locked',
							true
						);

				if ($import_locked === 'yes') {

					//echo '<br>Skipped Locked Product : '. $existing_product_id; die('1');

					continue;
				}

				if ($import_status == 'processing') {

					$started = get_post_meta(
						$existing_product_id,
						'_import_started_at',
						true
					);

					if (
						!empty($started)
						&&
						strtotime($started)
						< strtotime('-2 hours')
					) {

						wp_delete_post(
							$existing_product_id,
							true
						);

						$existing = [];
					}
				}
			}

			if (!empty($existing)) {

				$product_id = $existing[0]->ID;

				wp_update_post([
					'ID'           => $product_id,
					'post_title'   => $title,
					'post_content' => $description,
				]);

			} else {

				$product_id = wp_insert_post([
					'post_title'   => $title,
					'post_content' => $description,
					'post_status'  => 'publish',
					'post_type'    => 'product'
				]);
			}

			if (!$product_id) {
				continue;
			}
			
			update_post_meta(
				$product_id,
				'_import_status',
				'processing'
			);

			update_post_meta(
				$product_id,
				'_import_started_at',
				current_time('mysql')
			);

			/*
			=========================================
			SAVE META
			=========================================
			*/

			update_post_meta($product_id, 'shopify_product_id', $product['id']);
			update_post_meta($product_id, 'shopify_handle', $handle);
			update_post_meta($product_id, 'vendor', $vendor);
			
			/*
			=========================================
			SAVE BRAND
			=========================================
			*/

			if (
				!empty($vendor) &&
				strtolower(trim($vendor)) != 'self-collected'
			) {

				if (!term_exists($vendor, 'product_brand')) {

					wp_insert_term(
						$vendor,
						'product_brand'
					);
				}

				wp_set_object_terms(
					$product_id,
					$vendor,
					'product_brand'
				);
			}

			/*
			=========================================
			CATEGORY
			=========================================
			*/

			/*$term = term_exists($product_type, 'product_cat');

			if (!$term) {
				$term = wp_insert_term($product_type, 'product_cat');
			}

			if (!is_wp_error($term)) {

				wp_set_object_terms(
					$product_id,
					intval($term['term_id']),
					'product_cat'
				);
			}*/
			
			$category_slug = $category_map[$product_type] ?? sanitize_title($product_type);

			$term = get_term_by(
				'slug',
				$category_slug,
				'product_cat'
			);

			if (!$term) {

				$new_term = wp_insert_term(
					$product_type,
					'product_cat',
					[
						'slug' => $category_slug
					]
				);

				if (!is_wp_error($new_term)) {

					$term = get_term(
						$new_term['term_id'],
						'product_cat'
					);
				}
			}

			if ($term) {

				wp_set_object_terms(
					$product_id,
					$term->term_id,
					'product_cat'
				);
			}
			
			 /*
			|--------------------------------------------------------------------------
			| SAVE ATTRIBUTES
			|--------------------------------------------------------------------------
			*/
			
			wp_delete_object_term_relationships(
				$product_id,
				[
					'pa_product_type',
					'pa_installation_type',
					'pa_door_type',
					'pa_frame_type',
					'pa_handle_type',
					'pa_handle_number'
				]
			);

			/*if (!empty($attributes['color'])) {

				wellfor_save_product_attribute(
						$product_id,
						'pa_color',
						$attributes['color'],
						$product_type
					);
			}*/
			
			if (!empty($attributes['color'])) {

				foreach ($attributes['color'] as $color) {

					wellfor_save_product_attribute(
						$product_id,
						'pa_color',
						$color,
						$product_type
					);
				}
			}

			if (!empty($attributes['material'])) {

				wellfor_save_product_attribute(
					$product_id,
					'pa_material',
					$attributes['material'],
						$product_type
				);
			}

			if (!empty($attributes['shape'])) {

				wellfor_save_product_attribute(
					$product_id,
					'pa_shape',
					$attributes['shape'],
						$product_type
				);
			}

			if (!empty($attributes['width'])) {

				wellfor_save_product_attribute(
					$product_id,
					'pa_width',
					$attributes['width'] . '"',
						$product_type
				);

				update_post_meta(
					$product_id,
					'width_number',
					$attributes['width']
				);
			}

			if (!empty($attributes['height'])) {

				wellfor_save_product_attribute(
						$product_id,
						'pa_height',
						$attributes['height'] . '"',
						$product_type
					);

				update_post_meta(
					$product_id,
					'height_number',
					$attributes['height']
				);
			}

			if (!empty($attributes['depth'])) {

				wellfor_save_product_attribute(
						$product_id,
						'pa_depth',
						$attributes['depth'] . '"',
						$product_type
					);

				update_post_meta(
					$product_id,
					'depth_number',
					$attributes['depth']
				);
			}

			if (!empty($attributes['product_type'])) {

				foreach (
					$attributes['product_type']
					as $type
				) {

					wellfor_save_product_attribute(
						$product_id,
						'pa_product_type',
						$type,
						$product_type
					);
				}
			}
			
			/*if (!empty($attributes['installation_type'])) {

				wellfor_save_product_attribute(
					$product_id,
					'pa_installation_type',
					$attributes['installation_type'],
					$product_type
				);
			}*/
			
			if (!empty($attributes['installation_type'])) {

				foreach ($attributes['installation_type'] as $type) {

					wellfor_save_product_attribute(
						$product_id,
						'pa_installation_type',
						$type,
						$product_type
					);
				}
			}
			
			if (!empty($attributes['door_type'])) {

				foreach ($attributes['door_type'] as $type) {

					wellfor_save_product_attribute(
						$product_id,
						'pa_door_type',
						$type,
						$product_type
					);
				}
			}

			if (!empty($attributes['frame_type'])) {

				foreach ($attributes['frame_type'] as $type) {

					wellfor_save_product_attribute(
						$product_id,
						'pa_frame_type',
						$type,
						$product_type
					);
				}
			}
			
			if (!empty($attributes['handle_type'])) {

				wellfor_save_product_attribute(
					$product_id,
					'pa_handle_type',
					$attributes['handle_type'],
					$product_type
				);
			}

			if (!empty($attributes['handle_number'])) {

				wellfor_save_product_attribute(
					$product_id,
					'pa_handle_number',
					$attributes['handle_number'],
					$product_type
				);
			}

			/*
			=========================================
			CHECK DEFAULT TITLE
			=========================================
			*/

			$is_simple_product = false;

			if (
				count($product['variants']) == 1 &&
				strtolower($product['variants'][0]['title']) == 'default title'
			) {
				$is_simple_product = true;
			}

			/*
			=========================================
			SIMPLE PRODUCT
			=========================================
			*/

			if ($is_simple_product) {

				wp_set_object_terms($product_id, 'simple', 'product_type');

				$variant = $product['variants'][0];

				update_post_meta($product_id, '_sku', $variant['sku']);
				update_post_meta($product_id, '_price', $variant['price']);
				update_post_meta($product_id, '_regular_price', $variant['price']);

				if ($variant['available']) {
					update_post_meta($product_id, '_stock_status', 'instock');
				} else {
					update_post_meta($product_id, '_stock_status', 'outofstock');
				}

				//delete_post_meta($product_id, '_product_attributes');

			} else {

				/*
				=========================================
				VARIABLE PRODUCT
				=========================================
				*/

				wp_set_object_terms($product_id, 'variable', 'product_type');
				/*
				|--------------------------------------------------------------------------
				| REMOVE OLD VARIATIONS
				|--------------------------------------------------------------------------
				*/

				/*$old_variations = get_posts([
					'post_type'   => 'product_variation',
					'post_parent' => $product_id,
					'numberposts' => -1,
					'post_status' => 'any'
				]);

				foreach ($old_variations as $old_variation) {

					wp_delete_post(
						$old_variation->ID,
						true
					);
				}*/
				
				
				
				$shopify_skus = [];

				foreach ($product['variants'] as $variant) {

					if (!empty($variant['sku'])) {
						$shopify_skus[] = $variant['sku'];
					}
				}
				
				$existing_variations = get_posts([
								'post_type'   => 'product_variation',
								'post_parent' => $product_id,
								'numberposts' => -1,
								'post_status' => 'any'
							]);
				foreach ($existing_variations as $existing_variation) {

					$existing_sku = get_post_meta(
						$existing_variation->ID,
						'_sku',
						true
					);

					if (
						!empty($existing_sku) &&
						!in_array($existing_sku, $shopify_skus)
					) {

						update_post_meta(
							$existing_variation->ID,
							'_stock_status',
							'outofstock'
						);
					}
				}


				$attribute_values = [];

				foreach ($product['variants'] as $variant) {

					if (
						!empty($variant['option1']) &&
						strtolower($variant['option1']) != 'default title'
					) {
						$attribute_values[] = $variant['option1'];
					}
				}

				$attribute_values = array_unique($attribute_values);
				
				/*
				=========================================
				SHOPIFY OPTION NAME
				=========================================
				*/

				$option_name = !empty($product['options'][0]['name'])
					? trim($product['options'][0]['name'])
					: 'Color';

				$attribute_slug = wc_sanitize_taxonomy_name(
					$option_name
				);

				$taxonomy = 'pa_' . $attribute_slug;

				/*update_post_meta($product_id, '_product_attributes', [
					'handle-color' => [
						'name'         => 'Handle Color',
						'value'        => implode('|', $attribute_values),
						'position'     => 0,
						'is_visible'   => 1,
						'is_variation' => 1,
						'is_taxonomy'  => 0
					]
				]);*/
				
				$product_attributes = get_post_meta(
					$product_id,
					'_product_attributes',
					true
				);

				if (
					empty($product_attributes) ||
					!is_array($product_attributes)
				) {
					$product_attributes = [];
				}
				
				/*
				|--------------------------------------------------------------------------
				| REMOVE OLD VARIATION ATTRIBUTES
				|--------------------------------------------------------------------------
				*/

				foreach ($product_attributes as $key => $attr) {

					if (
						isset($attr['is_variation']) &&
						$attr['is_variation'] == 1
					) {

						unset($product_attributes[$key]);
					}
				}

				/*$product_attributes['pa_color'] = [

					'name'         => 'pa_color',

					'value'        => '',

					'position'     => 0,

					'is_visible'   => 1,

					'is_variation' => 1,

					'is_taxonomy'  => 1

				];*/
				
				/*$product_attributes['handle-color'] = [

						'name'         => 'Handle Color',

						'value'        => implode('|', $attribute_values),

						'position'     => count($product_attributes),

						'is_visible'   => 1,

						'is_variation' => 1,

						'is_taxonomy'  => 0
					];*/
					
				/*foreach ($attribute_values as $color_value) {

					if (!term_exists($color_value, 'pa_color')) {

						wp_insert_term(
							$color_value,
							'pa_color'
						);
					}
				}

				wp_set_object_terms(
					$product_id,
					$attribute_values,
					'pa_color'
				);

				$attribute_id =
					wc_attribute_taxonomy_id_by_name(
						'color'
					);

				$product_attributes['pa_color'] = [

					'id'           => $attribute_id,

					'name'         => 'pa_color',
					
					'value'        => '',
					
					'position'     => count($product_attributes),

					'is_visible'   => 1,

					'is_variation' => 1,

					'is_taxonomy'  => 1
				];*/
				
				/*
				=========================================
				CREATE ATTRIBUTE IF NOT EXISTS
				=========================================
				*/

				$attribute_id = wc_attribute_taxonomy_id_by_name(
					$attribute_slug
				);

				if (!$attribute_id) {

					wc_create_attribute([

						'name'         => $option_name,
						'slug'         => $attribute_slug,
						'type'         => 'select',
						'order_by'     => 'menu_order',
						'has_archives' => false

					]);

					delete_transient(
						'wc_attribute_taxonomies'
					);

					$attribute_id =
						wc_attribute_taxonomy_id_by_name(
							$attribute_slug
						);
				}

				/*
				=========================================
				SAVE TERMS
				=========================================
				*/

				foreach ($attribute_values as $attribute_value) {

					if (
						!term_exists(
							$attribute_value,
							$taxonomy
						)
					) {

						wp_insert_term(
							$attribute_value,
							$taxonomy
						);
					}
				}

				wp_set_object_terms(
					$product_id,
					$attribute_values,
					$taxonomy
				);

				/*$attribute_id =
					wc_attribute_taxonomy_id_by_name(
						$attribute_slug
					);*/

				$product_attributes[$taxonomy] = [

					'id'           => $attribute_id,

					'name'         => $taxonomy,

					'value'        => '',

					'position'     => count($product_attributes),

					'is_visible'   => 1,

					'is_variation' => 1,

					'is_taxonomy'  => 1
				];
				
				
				
				
				

				update_post_meta(
					$product_id,
					'_product_attributes',
					$product_attributes
				);

				/*
				=========================================
				VARIATIONS
				=========================================
				*/
				
				$parent_in_stock = false;
				foreach ($product['variants'] as $variant) {

					$sku   = $variant['sku'];
					$price = $variant['price'];
					//$color = $variant['option1'];
					$variation_value = $variant['option1'];

					$existing_variation = get_posts([
						'post_type'   => 'product_variation',
						'meta_key'    => '_sku',
						'meta_value'  => $sku,
						'numberposts' => 1,
						'post_status' => 'any'
					]);

					if (!empty($existing_variation)) {

						$variation_id = $existing_variation[0]->ID;

						wp_update_post([
							'ID'          => $variation_id,
							'post_title'  => $title .' - ' . $variation_value,
							'post_parent' => $product_id
						]);

					} else {

						$variation_id = wp_insert_post([
							'post_title'  => $title . ' - ' . $variation_value,
							'post_status' => 'publish',
							'post_parent' => $product_id,
							'post_type'   => 'product_variation'
						]);
					}

					if ($variation_id) {

						update_post_meta($variation_id, '_sku', $sku);

						update_post_meta($variation_id, '_price', $price);

						update_post_meta($variation_id, '_regular_price', $price);

						if ($variant['available']) {
							update_post_meta($variation_id, '_stock_status', 'instock');
							$parent_in_stock = true;
						} else {
							update_post_meta($variation_id, '_stock_status', 'outofstock');
						}

						update_post_meta(
							$variation_id,
							'attribute_' . $taxonomy,
							sanitize_title($variation_value)
						);
						
						/*
						|--------------------------------------------------------------------------
						| VARIATION IMAGE
						|--------------------------------------------------------------------------
						*/

						/*if (!empty($variant['image_id'])) {

							global $wpdb;

							$attachment_id = $wpdb->get_var(
								$wpdb->prepare(
									"
									SELECT post_id
									FROM {$wpdb->postmeta}
									WHERE meta_key = '_shopify_image_id'
									AND meta_value = %s
									LIMIT 1
									",
									$variant['image_id']
								)
							);

							if ($attachment_id) {

								update_post_meta(
									$variation_id,
									'_thumbnail_id',
									$attachment_id
								);
							}
						}*/
						
						$image_id = '';

						if (!empty($variant['featured_image']['id'])) {

							$image_id = $variant['featured_image']['id'];

						} elseif (!empty($variant['image_id'])) {

							$image_id = $variant['image_id'];
						}

						if (!empty($image_id)) {

							update_post_meta(
								$variation_id,
								'_shopify_variation_image_id',
								$image_id
							);
						}
					}
					
					

				}
				
				/*update_post_meta(
					$product_id,
					'_stock_status',
					$parent_in_stock ? 'instock' : 'outofstock'
				);

				$product_obj = wc_get_product($product_id);

				if ($product_obj) {

					$product_obj->set_stock_status(
						$parent_in_stock ? 'instock' : 'outofstock'
					);

					$product_obj->save();
				}
				
				wc_delete_product_transients($product_id);
				wc_update_product_lookup_tables($product_id);*/
				
				$stock_status = $parent_in_stock ? 'instock' : 'outofstock';

					update_post_meta(
						$product_id,
						'_stock_status',
						$stock_status
					);

					update_post_meta(
						$product_id,
						'_manage_stock',
						'no'
					);

					//global $wpdb;

					$wpdb->update(
						$wpdb->wc_product_meta_lookup,
						[
							'stock_status' => $stock_status
						],
						[
							'product_id' => $product_id
						]
					);

					wc_delete_product_transients(
						$product_id
					);

					wc_update_product_lookup_tables(
						$product_id
					);

				 
			}

			 /*
        =========================================
        IMAGES
        =========================================
        */

        $existing_gallery = get_post_meta(
            $product_id,
            '_product_image_gallery',
            true
        );

        $gallery_ids = !empty($existing_gallery)
            ? explode(',', $existing_gallery)
            : [];

        /*
        =========================================
        ONLY IMPORT IF GALLERY EMPTY
        =========================================
        */

        if ((empty($existing_gallery) || !has_post_thumbnail($product_id)  ) &&  !empty($product['images'])){
        //if (!empty($product['images'])){

            delete_post_meta(
                $product_id,
                '_product_image_gallery'
            );

            $gallery_ids = [];

            foreach ($product['images'] as $index => $img) { 

                $image_url = $img['src'];

                //global $wpdb;

                $attachment_id = $wpdb->get_var("
                    SELECT post_id
                    FROM {$wpdb->postmeta}
                    WHERE meta_key = '_source_url'
                    AND meta_value = '{$image_url}'
                    LIMIT 1
                ");
	//echo 'attachment_id=====>'.$attachment_id; die;
                /*
                =========================================
                IMPORT IMAGE IF NOT EXISTS
                =========================================
                */

                if (!$attachment_id) {

                    $attachment_id = media_sideload_image(
                        $image_url,
                        $product_id,
                        $title,
                        'id'
                    );
				
                    if (!is_wp_error($attachment_id)) {

                        update_post_meta(
                            $attachment_id,
                            '_source_url',
                            $image_url
                        );
					 }
					
					if (!is_wp_error($attachment_id) && $attachment_id) {
						
						update_post_meta(
							$attachment_id,
							'_shopify_image_id',
							$img['id']
						);
						
						/* echo 'Attachment ID: '.$attachment_id;
							echo '<br>';

							echo 'Shopify Image ID: '.$img['id'];
							echo '<br>';

							echo get_post_meta(
								$attachment_id,
								'_shopify_image_id',
								true
							);

							die;*/
					}
                   
                }

                if (!is_wp_error($attachment_id) && $attachment_id) {

                    /*
                    =========================================
                    FIRST IMAGE = FEATURED IMAGE ONLY
                    =========================================
                    */

                    if ($index == 0) {

                        set_post_thumbnail(
                            $product_id,
                            $attachment_id
                        );

                    } else {

                        /*
                        =========================================
                        OTHER IMAGES = GALLERY
                        =========================================
                        */

                        $gallery_ids[] = $attachment_id;
                    }
                }

                /*
                =========================================
                REDUCE SERVER LOAD
                =========================================
                */

                usleep(300000);
            }
			
			$gallery_ids = array_unique($gallery_ids);

            update_post_meta(
                $product_id,
                '_product_image_gallery',
                implode(',', $gallery_ids)
            );
			
			

		}
		
		/*
			|--------------------------------------------------------------------------
			| ASSIGN VARIATION IMAGES
			|--------------------------------------------------------------------------
			*/

			$variations = get_posts([
				'post_type'   => 'product_variation',
				'post_parent' => $product_id,
				'numberposts' => -1
			]);
			
			foreach ($variations as $variation) {

				$shopify_image_id = get_post_meta(
					$variation->ID,
					'_shopify_variation_image_id',
					true
				);
				//echo '<pre>shopify_image_id'; print_r($shopify_image_id); die;
				if (empty($shopify_image_id)) {
					continue;
				}

				//global $wpdb;

				$attachment_id = $wpdb->get_var(
					$wpdb->prepare(
						"
						SELECT post_id
						FROM {$wpdb->postmeta}
						WHERE meta_key = '_shopify_image_id'
						AND meta_value = %s
						LIMIT 1
						",
						$shopify_image_id
					)
				);

				if ($attachment_id) {

					update_post_meta(
						$variation->ID,
						'_thumbnail_id',
						$attachment_id
					);
					
					/*$variation_obj = new WC_Product_Variation(
						$variation->ID
					);

					$variation_obj->set_image_id(
						$attachment_id
					);

					$variation_obj->save();*/
				}
			}
			
			/**********************************************/
		/*echo '<pre>variations'; print_r($variation); 
		echo '<pre>shopify_image_id'; print_r($shopify_image_id); 
		echo '<pre>attachment_id'; print_r($attachment_id); 
		 die;*/
		 
		 update_post_meta(
			$product_id,
			'_import_status',
			'completed'
		);

		update_post_meta(
			$product_id,
			'_import_completed_at',
			current_time('mysql')
		);
		
		wellfor_log(
			'PRODUCT END => ' .
			$product['id']
		);
		
		$product_obj = wc_get_product($product_id);

		if ($product_obj) {

			$product_obj->save();

			wc_delete_product_transients(
				$product_id
			);
		} 
		if (class_exists('\Automattic\WooCommerce\Internal\ProductAttributesLookup\LookupDataStore')) {

			$lookup = wc_get_container()->get(
				\Automattic\WooCommerce\Internal\ProductAttributesLookup\LookupDataStore::class
			);

			$lookup->on_product_changed($product_id);
		}
		
		//die('passs111');
		$a++;
		
		//if($a >=10){
			
		//}
	}catch (Throwable $e) {

        wellfor_log(
            'PRODUCT ERROR : '
            . $product['id']
            . ' - '
            . $e->getMessage()
        );

        continue;
    }
	
	}
	
	remove_filter(
		'intermediate_image_sizes_advanced',
		'__return_empty_array'
	);
	
	//wp_cache_flush();
    return 'Products Imported Successfully';
}

add_action('init', function () {

    if (isset($_GET['wellfor_product_imports'])) {

        $page = isset($_GET['page'])
            ? intval($_GET['page'])
            : 1;

        echo import_wellfor_products($page);

        exit;
    }
});

/*
add_action('init', function () {

    if (!isset($_GET['wellfor_cron'])) {
        return;
    }
	die('stopped');
	register_shutdown_function(function () {

		$error = error_get_last();

		if ($error) {

			wellfor_log(
				'FATAL ERROR => ' .
				print_r($error, true)
			);
		}
	});

	wellfor_log('CRON STARTED');

	//
	$current_hour = (int) current_time('H');

	if ($current_hour >= 7) {
		//exit('Outside import window');
	}

    global $wpdb;

    $status = $wpdb->get_row(
        "SELECT * FROM wellfor_import_status WHERE id = 1"
    );

    if (!$status) {

        wellfor_log(
            'WELLFOR IMPORT ERROR : Status record not found'
        );

        exit('Import status record not found');
    }
	
    $today = current_time('Y-m-d');

    

    if ($status->last_completed_date == $today) {

        exit('Already completed today');
    }

    
	if ( $status->is_running == 1 &&  !empty($status->updated_at) 
		&&  strtotime($status->updated_at) < strtotime('-20 minutes')) {

		$wpdb->update(
			'wellfor_import_status',
			[
				'is_running' => 0
			],
			[
				'id' => 1
			]
		);

		wellfor_log('STALE LOCK RELEASED');

		$status->is_running = 0;
	}

    if (
        $status->is_running == 1
        &&
        !empty($status->updated_at)
        &&
        strtotime($status->updated_at) > strtotime('-20 minutes')
    ) {

        exit('Import already running');
    }

    
    $wpdb->update(
        'wellfor_import_status',
        [
            'is_running' => 1,
            'updated_at' => current_time('mysql')
        ],
        [
            'id' => 1
        ]
    );

    $page = intval($status->current_page);

    wellfor_log(
        'WELLFOR IMPORT START PAGE : ' . $page
    );

    try {

        $result = import_wellfor_products($page);

        

        if (
            stripos(
                $result,
                'IMPORT COMPLETED'
            ) !== false
        ) {

            $wpdb->update(
                'wellfor_import_status',
                [
                    'current_page'        => 1,
                    'last_completed_date' => $today,
                    'is_running'          => 0,
                    'updated_at'          => current_time('mysql')
                ],
                [
                    'id' => 1
                ]
            );

            wellfor_log(
                'WELLFOR IMPORT COMPLETED'
            );

        } else {

           
            $wpdb->update(
                'wellfor_import_status',
                [
                    'current_page' => ($page + 1),
                    'is_running'   => 0,
                    'updated_at'   => current_time('mysql')
                ],
                [
                    'id' => 1
                ]
            );

            wellfor_log(
                'WELLFOR IMPORT PAGE COMPLETED : '
                . $page
            );
        }

        echo $result;

    } catch (Throwable $e) {

        

        $wpdb->update(
            'wellfor_import_status',
            [
                'is_running' => 0,
                'updated_at' => current_time('mysql')
            ],
            [
                'id' => 1
            ]
        );

        wellfor_log(
            'WELLFOR IMPORT ERROR : '
            . $e->getMessage()
            . ' | FILE : '
            . $e->getFile()
            . ' | LINE : '
            . $e->getLine()
        );

        echo 'Import Error';
    }

    exit;
});*/


function wellfor_log($message)
{
    $log_dir = WP_CONTENT_DIR . '/logs';

    // logs folder create karo agar na ho
    if (!file_exists($log_dir)) {
        wp_mkdir_p($log_dir);
    }

    // Daily log file
    $log_file = $log_dir . '/wellfor-' . current_time('Y-m-d') . '.log';

    error_log(
        '[' . current_time('mysql') . '] ' . $message . PHP_EOL,
        3,
        $log_file
    );
}

/*function wellfor_log($message)
{
    $log_file = WP_CONTENT_DIR . '/wellfor-import.log';

    error_log(
        '[' . current_time('mysql') . '] ' . $message . PHP_EOL,
        3,
        $log_file
    );
}*/

add_action('wp_footer', 'custom_change_checkout_place_order_text', 999);
