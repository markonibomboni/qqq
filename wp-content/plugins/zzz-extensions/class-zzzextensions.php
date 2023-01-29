<?php
/*
Plugin Name: ZZZ Extensions
Plugin URI: https://www.zekovic.rs
Description: Extensions for Q-Agency task
Author: https://www.zekovic.rs
Author URI: https://www.zekovic.rs/
Version: 1.0
Text Domain: zzz-extensions
*/
if ( ! class_exists( 'ZZZExtensions' ) ) {
	class ZZZExtensions {
		private static $instance;

		function __construct() {
			$this->init();
		}

		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		function init() {

			// Include plugin admin assets
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );

			// Include plugin frontend assets
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );

			// include plugin gutenberg blocks
			add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_gutenberg_assets' ) );

			// include plugin gutenberg blocks
			add_action( 'init', array( $this, 'enqueue_gutenberg_functions' ) );

			// Adds menu page in admin
			add_action( 'admin_menu', array( $this, 'backend_panel' ) );

			// Add plugin's body classes
			add_filter( 'body_class', array( $this, 'add_body_classes' ) );

			// Adds custom post type 'Movies'
			add_action( 'init', array( $this, 'add_cpt_movies' ) );

			// Adds custom meta fields for custom post type 'Movies'
			add_action( 'add_meta_boxes', array( $this, 'add_cpt_movies_meta_boxes' ) );

			// Saves custom meta fields for custom post type 'Movies'
			add_action( 'save_post', array( $this, 'save_cpt_movies_meta_boxes' ) );

			// Execute custom functions
			add_action( 'plugins_loaded', array( $this, 'custom_functions' ) );
		}

		function enqueue_admin_assets() {
			wp_enqueue_script( 'zzz-extensions-admin-js', plugin_dir_url( __FILE__ ) . 'assets/zzz-extensions-admin.js', array( 'jquery' ), true );
		}

		function enqueue_assets() {
			wp_enqueue_script( 'zzz-extensions-js', plugin_dir_url( __FILE__ ) . 'assets/zzz-extensions.js', array( 'jquery' ), true );
			wp_enqueue_style( 'zzz-extensions-css', plugin_dir_url( __FILE__ ) . 'assets/zzz-extensions.css', array(), true );
		}

		function enqueue_gutenberg_assets() {
			wp_enqueue_script( 'zzz-extensions-block-js', plugin_dir_url( __FILE__ ) . 'assets/zzz-extensions-block.js', array(
				'wp-blocks',
				'wp-block-editor'
			), true );
		}

		function enqueue_gutenberg_functions() {
			register_block_type( 'zzz-extensions/favorite-movie-quote', array(
					'editor_script'   => 'serverside',
					'render_callback' => 'zzz_favorite_movie_quote_render_callback',
					'attributes'      => array(
						'images' => array(
							'type' => 'array'
						)
					)
				)
			);

			function zzz_favorite_movie_quote_render_callback( $attributes ) {
				return '<div class="zzz-block-holder"><span class="zzz-favorite-quote">' . esc_attr( $attributes['quote'] ) . '</span></div>';
			}
		}

		function add_body_classes( $classes ) {
			$classes[] = 'zzz-extensions';

			return $classes;
		}

		function backend_panel() {
			add_menu_page( 'ZZZ Extensions', 'ZZZ Extensions', 'administrator', __FILE__, 'zzz_page_callback', 'dashicons-carrot' );

			if ( ! function_exists( 'zzz_register_settings' ) ) {
				function zzz_register_settings() {
					register_setting( 'zzz-settings-group', 'zzz_option_email' );
					register_setting( 'zzz-settings-group', 'zzz_option_pass' );
				}
			}
			add_action( 'admin_init', 'zzz_register_settings' );

			function zzz_page_callback() { ?>

				<div class="wrap">
					<h1>ZZZ Extensions</h1>
					<p>Enter email (ahsoka.tano@q.agency) and password(Kryze4President) and 'Save Changes'. Once you've
						saved the changes, 'Create User' button will be shown and you can try creating user with
						existing creadentials.</p>
					<form method="post" action="options.php">
						<?php settings_fields( 'zzz-settings-group' ); ?>
						<?php do_settings_sections( 'zzz-settings-group' ); ?>

						<table class="form-table" role="presentation">
							<tbody>
							<tr>
								<th scope="row">
									<label for="zzz_option_email">Email</label>
								</th>
								<td>
									<input name="zzz_option_email" type="text" id="zzz_option_email"
									       value="<?php echo esc_attr( get_option( 'zzz_option_email' ) ); ?>"
									       class="regular-text ltr">
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="zzz_option_pass">Password</label>
								</th>
								<td>
									<input name="zzz_option_pass" type="text" id="zzz_option_pass"
									       value="<?php echo esc_attr( get_option( 'zzz_option_pass' ) ); ?>"
									       class="regular-text ltr">
								</td>
							</tr>
							</tbody>
						</table>
						<?php submit_button(); ?>
					</form>

					<?php
					$zzz_user = get_option( 'zzz_option_email' );
					$zzz_pass = get_option( 'zzz_option_pass' ); // security issue :)

					if ( ( isset( $zzz_user ) && ! empty( $zzz_user ) ) && ( isset( $zzz_pass ) && ! empty( $zzz_pass ) ) ) { ?>
						<h1>Create User</h1>
						<p>Tries to create a user from saved credentials.</p>
						<form action="" method="post">
							<p class="submit">
								<input type="submit" name="zzzCreateUser" class="button button-primary"
								       value="Create User"/>
							</p>
						</form>

						<?php if ( isset( $_POST['zzzCreateUser'] ) ) {
							// set post fields
							$post = array(
								'email'      => $zzz_user,
								'password'   => $zzz_pass,
								'first_name' => 'Ahsoka',
								'last_name'  => 'Tano',
								'gender'     => 'male',
								'active'     => 'true',
							);

							$ch = curl_init();

							curl_setopt( $ch, CURLOPT_URL, 'https://symfony-skeleton.q-tests.com/api/v2/users' );
							curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
							curl_setopt( $ch, CURLOPT_POST, 1 );
							curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $post ) );

							//local SSL remove
							curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
							curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );

							$headers   = array();
							$headers[] = 'Accept: application/json';
							$headers[] = 'Content-Type: application/json';
							curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );

							// execute!
							$response = curl_exec( $ch );

							// show errors
							if ( curl_errno( $ch ) ) {
								$response = curl_error( $ch );
							}

							// close the connection, release resources used
							curl_close( $ch );
							?>

							<h1>Response</h1>
							<pre style="max-width: 680px; max-height: 320px; background-color: #ccc; overflow: scroll;"><?php echo $response; ?></pre>
							<?php
						}
						?>

						<h1>Login</h1>
						<p>Login a user from saved credentials.</p>
						<form action="" method="post">
							<p class="submit">
								<input type="submit" name="zzzLoginUser" class="button button-primary"
								       value="Login"/>
							</p>
						</form>

						<?php if ( isset( $_POST['zzzLoginUser'] ) ) {
							// set post fields
							$post = array(
								'email'    => $zzz_user,
								'password' => $zzz_pass,
							);

							$ch = curl_init();

							curl_setopt( $ch, CURLOPT_URL, 'https://symfony-skeleton.q-tests.com/api/v2/token' );
							curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
							curl_setopt( $ch, CURLOPT_POST, 1 );
							curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $post ) );

							// local SSL remove
							curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
							curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );

							$headers   = array();
							$headers[] = 'Accept: application/json';
							$headers[] = 'Content-Type: application/json';
							curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );

							// execute!
							$response = curl_exec( $ch );

							// show errors
							if ( curl_errno( $ch ) ) {
								$response = curl_error( $ch );
							}

							// close the connection, release resources used
							curl_close( $ch );
							?>
							<?php
							if ( isset( $response ) && ! empty( $response ) ) { ?>
								<h1>Token Key</h1>
								<?php
								$decoded = @json_decode( $response, true );
								if ( isset( $decoded['token_key'] ) && ! empty( $decoded['token_key'] ) ) { ?>
									<pre><?php echo $decoded['token_key']; ?></pre>
									<form action="" method="post">
										<p class="submit">
											<input type="submit" name="zzzSaveStorage" class="button button-primary"
											       value="Save to Session Storage"
											       onClick="sessionStorage.setItem('zzzTokenObject', JSON.stringify( { expiresAt: '<?php echo date( 'D M d Y H:i:s O' ) ?>', tokenKey: '<?php echo $decoded['token_key'] ?>' } ))"/>
											<input type="submit" name="zzzSaveStorage" class="button button-primary"
											       value="Save to Local Storage"
											       onClick="localStorage.setItem('zzzTokenObject', JSON.stringify( { expiresAt: '<?php echo date( 'D M d Y H:i:s O' ) ?>', tokenKey: '<?php echo $decoded['token_key'] ?>' } ))"/>
										</p>
									</form>
								<?php } ?>
							<?php } ?>

							<h1>Response</h1>
							<pre style="max-width: 680px; max-height: 320px; background-color: #ccc; overflow: scroll;"><?php echo $response; ?></pre>
							<?php
						}
						?>

						<?php if ( isset( $_POST['zzzSaveStorage'] ) ) { ?>
							<h1>Token Key</h1>
							<p>Token successfully saved to storage.</p>
							<?php
						}
					}
					?>
				</div>
				<?php
			}
		}

		function add_cpt_movies() {
			register_post_type( 'movies',
				array(
					'labels'       => array(
						'name'          => esc_html__( 'Movies', 'zzz-extensions' ),
						'singular_name' => esc_html__( 'Movie Item', 'zzz-extensions' ),
						'add_item'      => esc_html__( 'New Movie Item', 'zzz-extensions' ),
						'add_new_item'  => esc_html__( 'Add New Movie Item', 'zzz-extensions' ),
						'edit_item'     => esc_html__( 'Edit Movie Item', 'zzz-extensions' ),
					),
					'public'       => true,
					'has_archive'  => false,
					'rewrite'      => array( 'slug' => 'movies' ),
					'show_in_rest' => true,
					'supports'     => array(
						'author',
						'title',
						'editor',
						'thumbnail',
						'excerpt',
						'page-attributes',
						'comments',
					),
					'menu_icon'    => 'dashicons-video-alt',
				)
			);
		}

		function add_cpt_movies_meta_boxes() {
			add_meta_box(
				'movie_title_box',
				__( 'Movie Title', 'zzz-extensions' ),
				'movie_title_box_content',
				'movies',
				'side',
				'high'
			);

			function movie_title_box_content( $post ) {
				wp_nonce_field( plugin_basename( __FILE__ ), 'movie_title_box_content_nonce' );
				echo '<label for="movie_title"></label>';
				echo '<input type="text" id="movie_title" name="movie_title" value="' . sanitize_text_field( get_post_meta( $post->ID, 'movie_title', true ) ) . '" placeholder="Enter a title" />';
			}
		}

		function save_cpt_movies_meta_boxes( $post_id ) {

			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			if ( ! isset( $_POST['movie_title_box_content_nonce'] ) ) {
				return;
			}

			if ( ! wp_verify_nonce( $_POST['movie_title_box_content_nonce'], plugin_basename( __FILE__ ) ) ) {
				return;
			}

			$movie_title = $_POST['movie_title'];
			update_post_meta( $post_id, 'movie_title', $movie_title );
		}

		function custom_functions() {

			return '';
		}
	}

	ZZZExtensions::get_instance();
}
