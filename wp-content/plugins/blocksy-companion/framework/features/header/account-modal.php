<?php

$users_can_register = get_option('users_can_register');
// $users_can_register = true;

?>

<div id="account-modal" class="ct-panel" data-behaviour="modal">
	<div class="ct-panel-actions">
		<div class="close-button">
			<span class="ct-trigger closed">
				<span></span>
			</span>
		</div>
	</div>

	<div class="ct-panel-content">
		<div class="ct-account-form">
			<?php if ($users_can_register) { ?>
				<ul>
					<li class="active ct-login">
						<?php echo __('Login', 'blc') ?>
					</li>

					<li class="ct-register">
						<?php echo __('Sign Up', 'blc') ?>
					</li>
				</ul>
			<?php } ?>

			<section class="ct-login-form active">
				<?php //wp_login_form([]); ?>

				<form name="loginform" id="loginform" action="<?php echo wp_login_url() ?>" method="post">
					<?php do_action('woocommerce_login_form_start'); ?>
					<?php do_action('blocksy:account:modal:login:start'); ?>

					<p class="login-username">
						<label for="user_login"><?php echo __('Email Address', 'blc') ?></label>
						<input type="text" name="log" id="user_login" class="input" value="" size="20">
					</p>

					<p class="login-password">
						<label for="user_pass"><?php echo __('Password', 'blc') ?></label>
						<input type="password" name="pwd" id="user_pass" class="input" value="" size="20">
					</p>

					<p class="login-remember col-2">
						<label>
							<input name="rememberme" type="checkbox" id="rememberme" value="forever">
							<?php echo __('Remember Me', 'blc') ?>
						</label>

						<a href="<?php echo wp_lostpassword_url() ?>" class="ct-forgot-password">
							<?php echo __('Forgot Password?', 'blc') ?>
						</a>
					</p>

					<?php do_action('login_form') ?>

					<p class="login-submit">
						<button name="wp-submit" class="ct-button">
							<?php echo __('Log In', 'blc') ?>
						</button>

						<input type="hidden" name="redirect_to" value="<?php echo blocksy_current_url() ?>">
					</p>

					<?php do_action('blocksy:account:modal:login:end'); ?>
					<?php do_action('woocommerce_login_form_end'); ?>
				</form>
			</section>

			<?php if ($users_can_register) { ?>
				<section class="ct-register-form">

					<form name="registerform" id="registerform" action="<?php echo wp_registration_url() ?>" method="post" novalidate="novalidate">
						<?php do_action('woocommerce_register_form_start') ?>
						<?php do_action('blocksy:account:modal:register:start'); ?>

						<p>
							<label for="user_login_register"><?php echo __('Username', 'blc') ?></label>
							<input type="text" name="user_login" id="user_login_register" class="input" value="" size="20" autocapitalize="off">
						</p>

						<p>
							<label for="user_email"><?php echo __('Email', 'blc') ?></label>
							<input type="email" name="user_email" id="user_email" class="input" value="" size="25">
						</p>

						<?php do_action('register_form') ?>

						<p id="reg_passmail">
							<?php echo __('Registration confirmation will be emailed to you', 'blc') ?>
						</p>

						<p>
							<button name="wp-submit" class="ct-button">
								<?php echo __('Register', 'blc') ?>
							</button>

							<!-- <input type="hidden" name="redirect_to" value="<?php echo blocksy_current_url() ?>"> -->
						</p>

						<?php do_action('blocksy:account:modal:register:end'); ?>
						<?php do_action('woocommerce_register_form_end') ?>
					</form>

				</section>
			<?php } ?>

			<section class="ct-forgot-password-form">
				<form name="lostpasswordform" id="lostpasswordform" action="<?php echo wp_lostpassword_url() ?>" method="post">
					<?php do_action('blocksy:account:modal:lostpassword:start'); ?>

					<p>
						<label for="user_login_forgot"><?php echo __('Username or Email Address', 'blc')?></label>
						<input type="text" name="user_login" id="user_login_forgot" class="input" value="" size="20" autocapitalize="off" required>
					</p>

					<p>
						<button name="wp-submit" class="ct-button">
							<?php echo __('Get New Password', 'blc') ?>
						</button>

						<!-- <input type="hidden" name="redirect_to" value="<?php echo blocksy_current_url() ?>"> -->
					</p>

					<?php do_action('blocksy:account:modal:lostpassword:end'); ?>
				</form>

				<a href="<?php echo wp_login_url() ?>" class="ct-back-to-login ct-login">
					← <?php echo __('Back to login', 'blc') ?>
				</a>
			</section>
		</div>
	</div>
</div>

