<div id="welcome">
	<h1 class="logo"><?php echo $this->config->item('cloud_name'); ?></h1>
	<p class="intro">Welcome, please enter your login details</p>
	<?php if (isset($error)) : ?>
	<p class="error"><?php echo $error; ?></p>
	<?php endif; ?>
	<form action="" method="post">
		<p><label for="username">Username</label><input type="text" name="username" value="<?php if (isset($user)) echo $user; ?>" placeholder="Username" /></p>
		<p><label for="password">Password</label><input type="password" name="password" value="<?php if (isset($pass)) echo $pass; ?>" placeholder="Password" /></p>
		<p><input type="submit" id="login-submit" value="Login" /></p>
	</form>
</div>