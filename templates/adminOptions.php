<div class="wrap">
    <div>
        <img src="<?php echo EmiSlider::$pluginUrl . '/resources/images/logo-main.png';?>" width="400">
    </div>
	<div style="width: 450px;float: left;">
		<form method="post" action="options.php">

			<?php settings_fields( 'emiSlider_option_group' );?>
			<?php echo '<h3>', __( 'General options', 'emiPrivateMessages' ), ':</h3>';?>
			<table class="form-table">
				<tr>
					<th><?php _e( 'Activity time range in minutes', 'emiSlider' ); ?>
					</th>
					<td><input type="text" name="emiSlider[activityTimeRange]"
						value="<?php echo $fnControl->options['activityTimeRange']; ?>" />
					</td>
				</tr>
				<tr>
					<th><?php _e( 'cookieLifeTime in days', 'emiSlider' ); ?>
					</th>
					<td><input type="text" name="emiSlider[cookieLifeTime]"
						value="<?php echo $fnControl->options['cookieLifeTime']; ?>" />
					</td>
				</tr>
				<tr>
					<th><?php _e( 'Max posts to show in list', 'emiSlider' ); ?>
					</th>
					<td><input type="text" name="emiSlider[maxPostInList]"
						value="<?php echo $fnControl->options['maxPostInList']; ?>" />
					</td>
				</tr>
				<tr>
					<th><?php _e( 'Sort by?', 'emiSlider' ); ?>
					</th>
					<td> 
						<select name="emiSlider[sortBy]" style="width:150px;">
							<option value="post_date"<?=($fnControl->options['sortBy']=='post_date'?' SELECTED':''); ?>><?php _e( 'Post Date', 'emiSlider' ); ?></option>
							<option value="post_modified"<?=($fnControl->options['sortBy']=='post_modified'?' SELECTED':''); ?>><?php _e( 'Post Modified Date', 'emiSlider' ); ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<th><?php _e( 'Sort direction?', 'emiSlider' ); ?>
					</th>
					<td> 
						<select name="emiSlider[sortDirection]" style="width:150px;">
							<option value="ASC"<?=($fnControl->options['sortDirection']=='ASC'?' SELECTED':''); ?>><?php _e( 'Ascending', 'emiSlider' ); ?></option>
							<option value="DESC"<?=($fnControl->options['sortDirection']=='DESC'?' SELECTED':''); ?>><?php _e( 'Descending', 'emiSlider' ); ?></option>
						</select>
					</td>
				</tr>
			</table>
	<?php echo '<h3>', __( 'Box options', 'emiPrivateMessages' ), ':</h3>';?>
	<table class="form-table">
				<tr>
					<th><?php _e('Box title', 'emiSlider' ); ?>
					</th>
					<td><input type="text"
						name="emiSlider[boxTitle]"
						value="<?php echo $fnControl->options['boxTitle']; ?>" />
					</td>
				</tr>
                <tr>
                    <th><?php _e('No posts to show text', 'emiSlider'); ?></th>
                    <td>
                        <input type="text"
                               name="emiSlider[boxNoPostText]"
                               value="<?php echo $fnControl->options['boxNoPostText']; ?>" />
                    </td>
                </tr>
				<tr>
					<th><?php _e('Box width', 'emiSlider' ); ?>
					</th>
					<td><input type="text"
						name="emiSlider[boxWidth]"
						value="<?php echo $fnControl->options['boxWidth']; ?>" />
					</td>
				</tr>
				<tr>
					<th><?php _e('Box height', 'emiSlider' ); ?>
					</th>
					<td><input type="text"
						name="emiSlider[boxHeight]"
						value="<?php echo $fnControl->options['boxHeight']; ?>" />
					</td>
				</tr>
				<tr>
					<th><?php _e('Max title length', 'emiSlider' ); ?>
					</th>
					<td><input type="text"
						name="emiSlider[maxTitleLength]"
						value="<?php echo $fnControl->options['maxTitleLength']; ?>" />
					</td>
				</tr>
				<tr>
					<th><?php _e( 'Show in homepage?', 'emiSlider' ); ?>
					</th>
					<td> 
						<select name="emiSlider[showInHomepage]" style="width:150px;">
							<option value="1"<?=($fnControl->options['showInHomepage']=='1'?' SELECTED':''); ?>><?php _e( 'Yes', 'emiSlider' ); ?></option>
							<option value="0"<?=($fnControl->options['showInHomepage']=='0'?' SELECTED':''); ?>><?php _e( 'No', 'emiSlider' ); ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<th><?php _e( 'Splash animation?', 'emiSlider' ); ?>
					</th>
					<td> 
						<select name="emiSlider[splashAnimation]" style="width:150px;">
							<option value="1"<?=($fnControl->options['splashAnimation']=='1'?' SELECTED':''); ?>><?php _e( 'Yes', 'emiSlider' ); ?></option>
							<option value="2"<?=($fnControl->options['splashAnimation']=='2'?' SELECTED':''); ?>><?php _e( 'Just in first visit', 'emiSlider' ); ?></option>
							<option value="0"<?=($fnControl->options['splashAnimation']=='0'?' SELECTED':''); ?>><?php _e( 'Off', 'emiSlider' ); ?></option>
						</select>
					</td>
				</tr>
			</table>
		


			<p class="submit">
				<input type="submit" name="submit" class="button-primary"
					value="<?php _e('Save Changes', 'emiSlider' ) ?>" />
			</p>

		</form>

	</div>
    <div id="emi_share_button" style="margin-top: 10px;">
        <span style="font-size: 14px;font-weight: bold;">Share This Plugin</span><br>
        <div class="fb-share-button" data-href="http://revisitxperience.com/" data-type="button_count"></div>
        <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://revisitxperience.com/" data-text="Revisit Xperience Plugin" data-size="medium">Tweet</a>
    </div>
    <div style="width:380px; height:470px; display: inline-block;box-shadow: 1px 2px 1px rgba(0, 0, 0, 0.3);border: 1px solid #e0e0e0; background-color: #f5f5f5;padding: 10px;text-align: center;margin-top: 30px;border-radius: 3px;-webkit-border-radius: 3px;-moz-border-radius: 3px;">
        <p>If you see the benefits of using Revisit Xperience LITE, you should upgrade to PRO:</p>
        <img src="<?php echo EmiSlider::$pluginUrl . '/resources/images/box.png'; ?>">
        <a href="http://revisitxperience.com/"><img src="<?php echo EmiSlider::$pluginUrl . '/resources/images/upgrade.png'; ?>" style="width: 280px;"></a>
    </div>
    <div style="clear: both; margin-bottom: 10px;"></div>
	<div style="border: 1px solid #ccc; padding: 2px; color: grey;">
		<b>Having problems?</b> Contact us at nino@revisitxperience.com.
	</div>
</div>
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=243247959214586&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    window.twttr = (function (d, s, id) {
        var t, js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return; js = d.createElement(s); js.id = id;
        js.src = "http://platform.twitter.com/widgets.js"; fjs.parentNode.insertBefore(js, fjs);
        return window.twttr || (t = { _e: [], ready: function (f) { t._e.push(f) } });
    }(document, "script", "twitter-wjs"));
</script>
<style>
    #emi_share_button iframe.twitter-share-button {
        margin-left: 5px;
        position: relative;
        top: 3px;
    }
</style>