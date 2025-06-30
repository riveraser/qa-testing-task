<?php
/**
 * Plugin Name:       QA Applicants Test
 * Plugin URI:        https://premium.wpmudev.org
 * Description:       Testing QA
 * Version:           1.0.0
 * Author:            Ivan ivanic
 * Author URI:        https://wpmudev.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       qa-test
 * Domain Path:       /languages
 *
 * @package           Qa_Test
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! defined( 'QTSLUG' ) ) {
	define( 'QTSLUG', 'qa_test' );
}


add_action( 'admin_menu', 'qa_test_plugin_admin_add_page' );
add_action( 'admin_init', 'qa_test_plugin_admin_init' );

// phpcs:ignore Squiz.Commenting.FunctionComment.Missing
function qa_test_plugin_admin_add_page() {
	add_options_page( 'QA Test Page', 'QA Test', 'manage_options', 'qa-test-settings', 'qa_test_plugin_options_page' );
}

// phpcs:ignore Squiz.Commenting.FunctionComment.Missing
function qa_test_plugin_options_page() {
	?>
	<style>
		.qatrequired {
			color: red;
		}
	</style>
	<div class="wrap">
		<h1>QA Test</h1>
		<div class="card">
			<h2 class="title">How to do test</h2>
			<p>You can enter various options here. Do any tests you need to ensure all fields are working properly.</p>
			<p>In test results submit a description of all the tests you have done and results as pass or fail. You can
				provide multiple tests for single field.</p>
		</div>
	</div>
	<div>
		<form action="options.php" method="post"> <?php settings_fields( 'qa_test_options' ); ?>
			<?php do_settings_sections( 'plugin' ); ?>
			<p><span class="qatrequired">*</span> - required fields</span></p> <input name="Submit" type="submit"
				value="<?php esc_attr_e( 'Save Changes' ); ?>" />
		</form>
	</div>
	<?php
}

// phpcs:ignore Squiz.Commenting.FunctionComment.Missing
function qa_test_plugin_admin_init() {
	$fields = array(
		array( 'fullname', 'Full Name <span class="qatrequired">*</span>' ),
		array( 'nickname', 'Nickname <span class="qatrequired">*</span>' ),
		array( 'address', 'Address' ),
		array( 'dob_d', 'Date of Birth Day' ),
		array( 'dob_m', 'Date of Birth Month' ),
		array( 'dob_y', 'Date of Birth Year' ),
		array( 'email', 'Email Address <span class="qatrequired">*</span>' ),
		array( 'web', 'Website' )
	);

	register_setting( 'qa_test_options', 'qa_test_options', 'plugin_options_validate' );
	add_settings_section( 'plugin_main', 'Settings', 'qa_test_main_plugin_section_text', 'plugin' );
	foreach ( $fields as $field ) {
		$fn = sprintf( '%s_%s_field', QTSLUG, $field[0] );
		$n  = sprintf( '%s_%s', QTSLUG, $field[0] );
		add_settings_field( $n, $field[1], $fn, 'plugin', 'plugin_main' );
	}
}

// phpcs:ignore Squiz.Commenting.FunctionComment.Missing
function qa_test_main_plugin_section_text() {
	echo '';
}

// phpcs:ignore Squiz.Commenting.FunctionComment.Missing
function qa_test_output_field( $name, $type, $values = array(), $tip = '' ) {
	$options = get_option( 'qa_test_options' );

	if ( 'select' !== $type ) {
		$name_options = esc_attr( $options[ $name ] );
		$name         = esc_attr( $name );

		// Vars already escaped.
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo "<input id='$name' name='qa_test_options[$name]' size='40' type='$type' value='{$name_options}' />";
		if ( '' !== $tip ) {
			echo '<p style="font-size: 10px">' . esc_html( $tip ) . '</p>';
		}
		return;
	}
	?>

	<select id="<?php echo esc_attr( $name ); ?>" name="qa_test_options[<?php echo esc_attr( $name ); ?>]" value="<?php echo esc_attr( $options[ $name ] ); ?>">
		<option value="">Choose...</option>
		<?php foreach ( $values as $value => $label ) : ?>
			<option value="<?php echo esc_attr( $value ); ?>" <?php echo intval( $options['qa_test_dob_m'] ) === intval( $value ) ? 'selected' : ''; ?>>
				<?php echo esc_html( $label ); ?>
			</option>
		<?php endforeach; ?>
	</select>
	<?php
}

// phpcs:ignore Squiz.Commenting.FunctionComment.Missing
function qa_test_fullname_field() {
	qa_test_output_field( 'qa_test_fullname', 'text' );
}

// phpcs:ignore Squiz.Commenting.FunctionComment.Missing
function qa_test_address_field() {
	qa_test_output_field( 'qa_test_address', 'text' );
}

// phpcs:ignore Squiz.Commenting.FunctionComment.Missing
function qa_test_nickname_field() {
	qa_test_output_field( 'qa_test_nickname', 'text' );
}

// phpcs:ignore Squiz.Commenting.FunctionComment.Missing
function qa_test_email_field() {
	qa_test_output_field( 'qa_test_email', 'text' );
}

// phpcs:ignore Squiz.Commenting.FunctionComment.Missing
function qa_test_web_field() {
	qa_test_output_field( 'qa_test_web', 'text', array(), 'Website address including protocol' );
}

// phpcs:ignore Squiz.Commenting.FunctionComment.Missing
function qa_test_dob_d_field() {
	qa_test_output_field( 'qa_test_dob_d', 'number' );
}

// phpcs:ignore Squiz.Commenting.FunctionComment.Missing
function qa_test_dob_m_field() {
	qa_test_output_field(
		'qa_test_dob_m',
		'select',
		array(
			'1'  => 'January',
			'2'  => 'February',
			'3'  => 'March',
			'4'  => 'April',
			'5'  => 'May',
			'6'  => 'June',
			'7'  => 'July',
			'8'  => 'August',
			'9'  => 'September',
			'11' => 'November',
			'12' => 'December',
		)
	);
}

// phpcs:ignore Squiz.Commenting.FunctionComment.Missing
function qa_test_dob_y_field() {
	qa_test_output_field( 'qa_test_dob_y', 'text' );
}

// phpcs:ignore Squiz.Commenting.FunctionComment.Missing
function plugin_options_validate( $input ) {
	
	$options = get_option( 'qa_test_options' );
	if ( preg_match( '/[0-9]/', $input['qa_test_fullname'] ) ) {
		add_settings_error( 'qa_test_fullname', 'fullname', 'Full Name consist of only letters and dots.', 'error' );
	}
	if ( '' !== $input['qa_test_email'] && is_email( $input['qa_test_email'] ) === false ) {
		add_settings_error( 'qa_test_email', 'email', 'Email is not valid.', 'error' );
	}
	if ( '' !== $input['qa_test_web'] && filter_var( $input['qa_test_web'], FILTER_VALIDATE_URL ) === false ) {
		add_settings_error( 'qa_test_web', 'web', 'Website is not valid.', 'error' );
	}
	if ( preg_match( '/[$\-_\[\]{}\+,]/', $input['qa_test_fullname'] ) ) {
		add_settings_error( 'qa_test_fullname', 'fullname', 'Full Name consist of only letters and dots.', 'error' );
	}
	if ( trim( $input['qa_test_fullname'] ) === '' ) {
		add_settings_error( 'qa_test_fullname', 'fullname', 'Full Name is a required field', 'error' );
	}
	if ( trim( $input['qa_test_address'] ) === '' ) {
		add_settings_error( 'qa_test_address', 'address', 'Address is a required field', 'error' );
	}
	if ( trim( ( $input['qa_test_dob_y'] ) !== '' && intval( $input['qa_test_dob_y'] ) < 1970 || intval( $input['qa_test_dob_y'] ) > 2017 ) ) {
		add_settings_error( 'qa_test_dob_y', 'dob_y', 'Date of Birth Year must be between 1900 and 2017', 'error' );
	}
	$options['qa_test_fullname'] = $input['qa_test_fullname'];
	$options['qa_test_address']  = $input['qa_test_address'];
	$options['qa_test_email']    = $input['qa_test_email'];

	if ( '' === $options['qa_test_web'] ) {
		$options['qa_test_web'] = $input['qa_test_web'];
	}

	$options['qa_test_dob_m'] = $input['qa_test_dob_m'];
	$options['qa_test_dob_d'] = $input['qa_test_dob_d'];
	$options['qa_test_dob_y'] = $input['qa_test_dob_y'];
	return $options;
}
