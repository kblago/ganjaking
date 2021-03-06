<?php
/**
 * This file belongs to the YIT Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 *
 * @var array $field
 */

!defined( 'ABSPATH' ) && exit; // Exit if accessed directly

wp_enqueue_style( 'wp-color-picker' );

extract( $field );

$class = !empty( $class ) ? $class : 'yith-plugin-fw-colorpicker color-picker';
$default = isset( $default ) ?  $default : '';
if( isset($std) && !empty( $std) && empty($default) ){
	$default = $std;
}
?>

<input type="text" name="<?php echo $name ?>"
       id="<?php echo $id ?>" value="<?php echo esc_attr( $value ) ?>"
       <?php if ( isset( $default ) ) : ?> data-default-color="<?php echo $default ?>"<?php endif ?>
       class="<?php echo $class ?>" data-alpha="true"
    <?php echo $custom_attributes ?>
    <?php if ( isset( $data ) ) echo yith_plugin_fw_html_data_to_string( $data ); ?>/>

