<?php
/**
 * App static proxy class.
 *
 * Static proxy class for the application instance.
 *
 * @package   NovaCore
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2008 - 2018, Justin Tadlock
 * @link      https://themehybrid.com/hybrid-core
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Nova\Proxies;

/**
 * App static proxy class.
 *
 * @since  5.0.0
 * @access public
 */
class Engine extends Proxy {

	/**
	 * Returns the name of the accessor for object registered in the container.
	 *
	 * @since  5.0.0
	 * @access protected
	 * @return string
	 */
	protected static function accessor() {

		return 'template/engine';
	}
}
