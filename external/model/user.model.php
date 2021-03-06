<?php

	/**
	 * User Class
	 *
	 * User
	 *
	 * @version  1.0
	 * @author   Raul Vera <raul.vera@chimp.mx>
	 */
	class User extends CROOD {

		public $id;
		public $login;
		public $slug;
		public $email;
		public $nickname;
		public $password;
		public $status;
		public $created;
		public $modified;

		/**
		 * Initialization callback
		 * @return nothing
		 */
		function init($args = false) {

			$now = date('Y-m-d H:i:s');

			$this->table = 					'core_user';
			$this->table_fields = 			array('id', 'login', 'slug', 'email', 'nickname', 'password', 'status', 'created', 'modified');
			$this->update_fields = 			array('login', 'slug', 'email', 'nickname', 'password', 'status', 'modified');
			$this->singular_class_name = 	'User';
			$this->plural_class_name = 		'Users';

			#metaModel
			$this->meta_id = 				'user_id';
			$this->meta_table = 			'core_user_meta';

			if (! $this->id ) {

				$this->id = 0;
				$this->login = '';
				$this->slug = '';
				$this->email = '';
				$this->nickname = '';
				$this->password = '';
				$this->status = '';
				$this->created = $now;
				$this->modified = $now;
				$this->metas = new stdClass();
			}

			else {

				$args = $this->preInit($args);

				# Enter your logic here
				# ----------------------------------------------------------------------------------



				# ----------------------------------------------------------------------------------

				$args = $this->postInit($args);
			}
		}

		/**
		 * Save the model
		 * @return boolean True if the model was updated, False otherwise
		 */
		function save() {

			# Sanitization
			if ( empty($this->login) ) {
				return false;
			}

			$this->modified = date('Y-m-d H:i:s');
			$this->nickname = $this->nickname ? $this->nickname : $this->email;
			$this->login = $this->login ? $this->login : $this->email;

			if( substr($this->password, 0, 4) != '$2a$' ) {
				$this->password = Users::hashPassword($this->password);
			}

			return parent::save();
		}

		/* HELPERS */
		/* -------------------------------------------------------------------------------------- */

		/**
		 * Save the model
		 * @return string Full name of the current user (first name and last name)
		 */
		function getFullName() {

			$ret = '';

			if(isset($this->metas)) {

				$ret .= isset($this->metas->first_name) ? $this->metas->first_name : '';
				$ret .= ' ';
				$ret .= isset($this->metas->last_name) ? $this->metas->last_name : '';
				$ret = trim($ret);
			}

			return $ret ?: '-';
		}
	}

	# ==============================================================================================

	/**
	 * Users Class
	 *
	 * Users
	 *
	 * @version 1.0
	 * @author  Raul Vera <raul.vera@chimp.mx>
	 */
	class Users extends NORM {

		protected static $user_id;

		/**
		 * Initialization function
		 */
		static function init() {
			global $site;
			# Initialize some defaults
			self::$user_id = 0;
		}

		protected static $table = 					'core_user';
		protected static $table_fields = 			array('id', 'login', 'slug', 'email', 'nickname', 'password', 'status', 'created', 'modified');
		protected static $singular_class_name = 	'User';
		protected static $plural_class_name = 		'Users';

		/**
		 * Retrieve the current user
		 * @return mixed User object on success, Null otherwise
		 */
		static function getCurrentUser() {
			$ret = self::getById( self::$user_id );
			return $ret;
		}

		/**
		 * Retrieve the current user Id
		 * @return integer Current user Id
		 */
		static function getCurrentUserId() {
			return self::$user_id;
		}

		/**
		 * Recover a previous session
		 * @return boolean True if the user was re-logged in, False otherwise
		 */
		static function checkLogin() {
			global $site;
			$ret = false;
			$name = sprintf('ggi_login%s', $site->hashPassword('cookie'));
			$cookie = isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
			if ($cookie) {
				$id = self::getCookieData($cookie);
				$user = self::getById($id);
				# Check user and password
				if ( $user && self::checkCookie($cookie) ) {
					# Save user id
					self::$user_id = $user->id;
					$ret = true;
				}
			}
			return $ret;
		}

		/**
		 * Check if there's a valid user logged in, otherwise send it to the sign-in page
		 * @return boolean True if the current user is set/valid, otherwise it will be redirected
		 */
		static function requireLogin($redirect = '/sign-in') {
			global $site;
			header("Expires: on, 01 Jan 1970 00:00:00 GMT");
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			# Check user
			if ( self::$user_id ) {
				return true;
			} else {
				$path = $site->getRequest()->uri;
				$path = ltrim($path, '/');
				$_SESSION['login_redirect'] = "/{$path}";
			}
			if ($redirect) {
				$site->redirectTo( $site->urlTo($redirect) );
				exit;
			}
			return false;
		}

		/**
		 * Sign a new user in, replaces previous user (if any)
		 * @param  string  $user     User name
		 * @param  string  $password Plain-text password
		 * @param  boolean $remember Whether to set the cookie for 12 hours (normal) or 2 weeks (remember)
		 * @return boolean           True on success, False otherwise
		 */
		static function login($user, $password, $remember = false) {
			global $site;
			$ret = false;
			$user = self::getByLogin($user);

			if ($user) {
				$auth = self::checkPassword($password, $user->password);

				if ($auth) {
					$expires = strtotime($remember ? '+15 day' : '+12 hour');
					$cookie = Users::buildCookie($expires, $user->id);
					$name = sprintf('ggi_login%s', $site->hashPassword('cookie'));
					# Set user id
					self::$user_id = $user->id;
					# And set cookie
					$ret = setcookie($name, $cookie, $expires, '/');
					# Run hooks
					if ($user->id) {
						$site->executeHook('users.login', $user->id);
					}
				}
			}
			return $ret;
		}

		/**
		 * Set the current user
		 * @param integer $user_id  User ID
		 * @param boolean $remember Remember user or not
		 */
		static function setCurrentUser($user_id, $remember = false) {
			global $site;
			$ret = false;
			$user = self::getById($user_id);
			if ($user) {
				$expires = strtotime($remember ? '+15 day' : '+12 hour');
				$cookie = self::buildCookie($expires, $user->id);
				$name = sprintf('ggi_login%s', $site->hashPassword('cookie'));
				# Set user id
				self::$user_id = $user->id;
				# And set cookie
				$ret = setcookie($name, $cookie, $expires, '/');
				# Run hooks
				if ($user->id) {
					$site->executeHook('users.login', $user->id);
				}
			}
			return $ret;
		}

		/**
		 * Change user, saving the current one
		 * @param  integer $user_id User ID
		 * @return boolean          True on success, False otherwise
		 */
		static function switchUser($user_id) {
			global $site;
			$ret = false;
			$user = self::getById($user_id);
			if ($user && $site->user) {
				# Save old user
				$expires = strtotime('+12 hour');
				$cookie = self::buildCookie($expires, $site->user->id);
				$name = sprintf('ggi_old_login%s', $site->hashPassword('cookie'));
				# Set cookie
				$ret = setcookie($name, $cookie, $expires, '/');
				# And now set the new user
				self::setCurrentUser($user_id);
			}
			return $ret;
		}

		/**
		 * Check whether the user was switched or not
		 * @return boolean True if the user has been switched
		 */
		static function isUserSwitched() {
			global $site;
			$name = sprintf('ggi_old_login%s', $site->hashPassword('cookie'));
			$cookie = isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
			return ($cookie != null);
		}

		/**
		 * Check whether the user was switched or not
		 * @return boolean True if the user has been switched
		 */
		static function restoreUser() {
			global $site;
			$ret = false;
			$old_name = sprintf('ggi_old_login%s', $site->hashPassword('cookie'));
			$old_cookie = isset($_COOKIE[$old_name]) ? $_COOKIE[$old_name] : null;
			if ($old_cookie) {
				# Set new user
				$expires = strtotime('+12 hour');
				$name = sprintf('ggi_login%s', $site->hashPassword('cookie'));
				# Delete old cookie
				setcookie($old_name, '', strtotime('-1 hour'), '/');
				# Update cookie
				$ret = setcookie($name, $old_cookie, $expires, '/');
			}
			return $ret;
		}

		/**
		 * Sign the current user out
		 * @return boolean     True on success, False otherwise
		 */
		static function logout() {
			global $site;
			# Run hooks
			if (self::$user_id) {
				$site->executeHook('users.logout', self::$user_id);
			}
			# Sign user out
			self::$user_id = 0;
			$name = sprintf('ggi_login%s', $site->hashPassword('cookie'));
			return setcookie($name, '', strtotime('-1 hour'), '/');
		}

		/**
		 * Hash a plain-text password
		 * @param  string $password Plain-text password to hash
		 * @return string           Hashed password
		 */
		static function hashPassword($password) {
			$hasher = new PasswordHash(8, FALSE);
			$hash = $hasher->HashPassword($password);
			return $hash;
		}

		/**
		 * Check whether the password is valid or not
		 * @param  string $password    Plain-text password
		 * @param  string $stored_hash Hashed password, usually from the database
		 * @return boolean             True if the password is valid, False otherwise
		 */
		static function checkPassword($password, $stored_hash) {
			$hasher = new PasswordHash(8, FALSE);
			return $hasher->CheckPassword($password, $stored_hash);
		}

		/**
		 * Create a hardened cookie
		 * @param  timestamp $expires When the cookie will expire
		 * @param  string    $data    Data to save (application state)
		 * @return string             Hardened cookie data
		 */
		protected static function buildCookie($expires, $data) {
			global $site;
			# Get secret key
			$secret = $site->hashPassword('mega-ggi');
			# Build cookie
			$cookie = sprintf("exp=%s&data=%s", urlencode($expires), urlencode($data));
			# Calculate the MAC (message authentication code)
			$mac = hash_hmac("sha256", $cookie, $secret);
			# Append MAC to the cookie and return it
			return $cookie . '&digest=' . urlencode($mac);
		}

		/**
		 * Get cookie stored data
		 * @param  string $cookie Cookie data
		 * @return mixed          String with cookie data or False on error
		 */
		protected static function getCookieData($cookie) {
			global $site;
			# Get cookie vars
			parse_str($cookie, $vars);
			return isset( $vars['data'] ) ? $vars['data'] : null;
		}

		/**
		 * Check whether the cookie is valid or not
		 * @param  string $cookie Cookie data
		 * @return boolean        True if the cookie is valid, False otherwise
		 */
		protected static function checkCookie($cookie) {
			global $site;
			# Get secret key
			$secret = $site->hashPassword('mega-ggi');
			# Get cookie vars
			parse_str($cookie, $vars);
			if( empty($vars['exp']) || $vars['exp'] < time() ) {
				# Cookie has expired
				return false;
			}
			# Generate a valid cookie, both should match
			$str = self::buildCookie($vars['exp'], $vars['data']);
			if ($str != $cookie) {
				# Cookie has been forged
				return false;
			}
			# Otherwise the cookie is valid
			return true;
		}
	}
?>