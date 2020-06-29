<?php
/**
 * WooCommerce Intuit Payments
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@skyverge.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade WooCommerce Intuit QBMS to newer
 * versions in the future. If you wish to customize WooCommerce Intuit QBMS for your
 * needs please refer to https://docs.woocommerce.com/document/intuit-qbms/
 *
 * @package   WC-Intuit-Payments/API
 * @author    SkyVerge
 * @copyright Copyright (c) 2013-2020, SkyVerge, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

defined( 'ABSPATH' ) or exit;

use SkyVerge\WooCommerce\PluginFramework\v5_7_1 as Framework;

/**
 * The Payments API base payment request class.
 *
 * @since 2.0.0
 */
abstract class WC_Intuit_Payments_API_Payment_Request extends WC_Intuit_Payments_API_Request {


	/** @var string the payment type, either 'charges' or 'echecks' */
	protected $type;

	/** @var string the API param under which to include a tokenized method in the request */
	protected $tokenized_method_key;

	/** @var \WC_Order the order object */
	protected $order;


	/**
	 * Constructs the class.
	 *
	 * @since 2.0.0
	 * @param \WC_Order $order the order object
	 */
	public function __construct( \WC_Order $order ) {

		$this->order = $order;

		$this->path = '/payments/' . $this->get_type();
	}


	/**
	 * Sets the data for a transaction.
	 *
	 * @since 2.0.0
	 */
	protected function set_payment_data() {

		$data = array(
			'amount'      => $this->get_order()->payment_total,
			'description' => Framework\SV_WC_Helper::str_truncate( $this->get_order()->description, 4000 ),
		);

		// either set a stored token ID or one generated by the payment form JS
		if ( ! empty( $this->get_order()->payment->token ) ) {
			$data[ $this->get_tokenized_method_key() ] = $this->get_order()->payment->token;
		} elseif ( ! empty( $this->get_order()->payment->js_token ) ) {
			$data['token'] = $this->get_order()->payment->js_token;
		} else {
			throw new Framework\SV_WC_API_Exception( 'Payment token missing.' );
		}

		$this->data = $data;
	}


	/**
	 * Sets the data to refund a payment.
	 *
	 * @since 2.0.0
	 */
	public function set_refund_data() {

		$this->set_payment_id( $this->get_order()->refund->trans_id );

		$this->path .= '/refunds';

		$this->data = [
			'amount'      => $this->get_order()->refund->amount,
			'description' => $this->get_order()->refund->reason,
		];
	}


	/**
	 * Sets the payment ID for this request.
	 *
	 * @since 2.0.0
	 * @param string $id the payment (transaction) ID
	 */
	protected function set_payment_id( $id ) {

		$this->path .= '/' . $id;
	}


	/**
	 * Sets the API param under which to include a tokenized method in the request.
	 *
	 * @since 2.0.0
	 * @param string $key
	 */
	protected function set_tokenized_method_key( $key ) {

		$this->tokenized_method_key = $key;
	}


	/**
	 * Sets the payment type for this request.
	 *
	 * @since 2.0.0
	 * @param string $type the payment type. Accepts either 'charges' or 'echecks'
	 */
	protected function set_type( $type ) {

		$this->type = $type;
	}


	/**
	 * Gets the API param under which to include a tokenized method in the request.
	 *
	 * @since 2.0.0
	 * @return string
	 */
	protected function get_tokenized_method_key() {

		return $this->tokenized_method_key;
	}


	/**
	 * Gets the payment type.
	 *
	 * @since 2.0.0
	 * @return string
	 */
	protected function get_type() {

		return $this->type;
	}


	/**
	 * Gets the order object associated with this request.
	 *
	 * @since 2.0.0
	 * @return \WC_Order
	 */
	protected function get_order() {

		return $this->order;
	}


}