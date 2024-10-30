<h1><?php echo esc_html(get_admin_page_title()); ?></h1>
<form name="lh_google_analytics-backend_form" method="post" action="">
<?php wp_nonce_field( $this->namespace."-nonce", $this->namespace."-nonce", false ); ?>
<table class="form-table">
<tr valign="top">
<th scope="row">
<label for="<?php echo $this->namespace; ?>-tracking_codes"><?php  _e("Your Tracking code:", $this->namespace );  ?></label></th>
<td><input id="<?php echo $this->namespace; ?>-tracking_codes" name="<?php echo $this->namespace; ?>-tracking_codes" type="text" value="<?php echo implode(",", $this->options[$this->namespace.'-tracking_codes']); ?>" /> - use a comma to seperate multiple tracking codes if required
</tr>
</table>
<?php submit_button( 'Save Changes' ); ?>
</form>