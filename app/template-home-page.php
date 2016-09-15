<?php

/**

 * The template for displaying the home page.

 *

 * Template Name: Home page

 *

 * @package bluegreen

 */



if ( ! defined( 'ABSPATH' ) ) {

	exit; // Exit if accessed directly

}



function __filter_page_class( $classes = array() ) {

	$classes[] = 'page-home';



	return $classes;

}



add_filter( 'page_class', '__filter_page_class' );



// Start layout.

get_header(); ?>



<?php include 'inc/top-banners.php'; ?>



	<!-- /* Support */ -->

	<section class="support">



		<div class="row clearfix" data-equalizer data-equalize-on="medium">



			<div class="support__order-now small-12 medium-2 large-2 columns" data-equalizer-watch>

				<a href="" title="Đặt hàng ngay"><?php echo __( 'Đặt hàng ngay', 'bg' ); ?></a>

			</div>



			<div class="support__call small-12 medium-5 large-4 large-offset-1 columns" data-equalizer-watch>

				<div class="inner">

					<span class="title"><?php echo __( 'Hãy gọi cho chúng tôi số Hotline', 'bg' ); ?></span>

					<?php $contact_phone = get_post_meta( $post->ID, 'contact_phone', true ); ?>

					<a href="callto:<?php echo esc_attr( $contact_phone ); ?>"

					   title="<?php echo esc_attr( $contact_phone ); ?>"><?php echo esc_html( $contact_phone ); ?></a>

				</div>

			</div>



			<div class="support__chat small-12 medium-5 large-4 large-offset-1 columns" data-equalizer-watch>

				<div class="inner">

					<span class="title"><?php echo __( 'Hoặc chat trực tuyến', 'bg' ); ?></span>

					<?php $contact_skype = get_post_meta( $post->ID, 'contact_skype', true ); ?>

					<a href="skype:<?php echo $contact_skype ?>?chat"

					   title="<?php echo esc_attr( $contact_skype ) ?>"><?php echo esc_html( $contact_skype ) ?></a>

				</div>

			</div>



		</div>



	</section>

	<!-- /* Products */ -->

<?php

/**

 * Functions hooked in to homepage action

 *

 * @hooked storefront_homepage_content      - 10

 * @hooked storefront_product_categories    - 20

 * @hooked storefront_recent_products       - 30

 * @hooked storefront_featured_products     - 40

 * @hooked storefront_popular_products      - 50

 * @hooked storefront_on_sale_products      - 60

 * @hooked storefront_best_selling_products - 70

 */

//do_action( 'homepage' ); ?>



	<section class="products">



		<div class="row">

			<div class="small-12 medium-12 columns heading__wrapper">

				<h2 class="heading heading--short"><?php echo __( 'Sản phẩm', 'bg' ) ?></h2>

			</div>

		</div>



		<!-- Highlight products -->

		<?php

		$atts = shortcode_atts( array(

			'per_page' => '12',

			'orderby'  => 'date',

			'order'    => 'desc',

			'category' => '',  // Slugs

			'operator' => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.

		), $atts, 'featured_products' );



		$meta_query   = WC()->query->get_meta_query();

		$meta_query[] = array(

			'key'   => '_featured',

			'value' => 'yes'

		);



		$query_args = array(

			'post_type'           => 'product',

			'post_status'         => 'publish',

			'ignore_sticky_posts' => 1,

			'posts_per_page'      => $atts['per_page'],

			'orderby'             => $atts['orderby'],

			'order'               => $atts['order'],

			'meta_query'          => $meta_query

		);



		global $woocommerce_loop;



		$products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $query_args, $atts, $loop_name ) );

		ob_start();



		if ( $products->have_posts() ) {

			?>



			<div class="products__list row" data-equalizer data-equalize-on="medium">



				<?php while ( $products->have_posts() ) : $products->the_post(); ?>



					<?php wc_get_template_part( 'content', 'product' ); ?>



				<?php endwhile; // end of the loop. ?>



			</div>



			<?php

		}



		woocommerce_reset_loop();

		wp_reset_postdata();



		?>

	</section>



	<!-- /* Intro Green & Blue Company */ -->

	<section class="introGB">



		<figure>

			<?php if ( $image = get_post_meta( $post->ID, 'intro_image', true ) ) : ?>

				<img src="<?php echo get_post_meta( $post->ID, 'intro_image', true ); ?>" alt="" class="hide-for-small">

				<img src="<?php echo get_template_directory_uri(); ?>/assets/images/home/bg-intro-mobile.jpg" alt="" class="show-for-small">

			<?php endif; ?>



			<figcaption>

				<h3 class="heading color-white"><?php echo esc_html( get_post_meta( $post->ID, 'intro_title', true ) ) ?></h3>

				<p class="description"><?php echo esc_html( get_post_meta( $post->ID, 'intro_caption', true ) ) ?></p>

			</figcaption>

		</figure>



		<div class="row">

			<!-- <div class="small-12 medium-12 columns"></div> -->

			<div class="small-12 medium-12 columns heading__wrapper">

				<h4 class="heading heading--short"><?php echo get_post_meta( $post->ID, 'ack_title', true ); ?></h4>

			</div>

			<div class="small-12 medium-12 columns clearfix">

				<div class="quote-text"><?php echo apply_filters( 'the_content', limit_string( get_post_meta( $post->ID, 'ack_text', true ), 650, '...' ) ); ?>

					<?php if ( ! empty( get_post_meta( $post->ID, 'ack_link', true ) ) ) : ?>

						<a href="<?php echo esc_attr( get_post_meta( $post->ID, 'ack_link', true ) ); ?>"

						   title="<?php echo esc_attr( __( 'Đọc tiếp  >>', 'bg' ) ); ?>"><?php echo __( 'Đọc tiếp  >>', 'bg' ); ?></a>

					<?php endif; ?>

				</div>

			</div>

		</div>

	</section>



	<!-- /* Recommendation */ -->

	<section class="recommendation">

		<div class="inner">

			<div class="row">

				<div class="small-12 medium-12 columns heading__wrapper">

					<h4 class="heading color-white">Khuyến cáo bởi:</h4>

				</div>

				<div class="small-12 medium-6 columns clearfix">

					<div class="recommendation__img">

						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/home/who-oms.png" alt="WHO/OMS">

					</div>

					<div class="recommendation__info">

						<span class="recommendation__name">WHO/OMS</span>

						<p class="recommendation__description">Tổ chức Y tế thế giới (WHO/OMS) công nhận tảo Spirulina là thực phẩm bảo vệ sức khỏe tốt nhất của loài người trong thế kỉ 21.</p>

					</div>

				</div>

				<div class="small-12 medium-6 columns clearfix">

					<div class="recommendation__img">

						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/home/fda.png" alt="FDA">

					</div>

					<div class="recommendation__info">

						<span class="recommendation__name">FDA</span>

						<p class="recommendation__description">Cơ quan quản lí thực phẩm và dược phẩm Hoa Kì (FDA) công nhận tảo Spirulina là một trong những nguồn protein tốt nhất.</p>

					</div>

				</div>

			</div>

		</div>

	</section>



<?php include 'inc/order-now.php'; ?>



<?php get_footer();