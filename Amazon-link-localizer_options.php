<?php
// LAYOUT FOR THE SETTINGS/OPTIONS PAGE
?>

<style>
button {
 background: #8dc63f;
   background: -moz-linear-gradient(top,  #8dc63f 0%, #8dc63f 50%, #7fb239 51%, #7fb239 100%);
   background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#8dc63f), color-stop(50%,#8dc63f), color-stop(51%,#7fb239), color-stop(100%,#7fb239));
   background: -webkit-linear-gradient(top,  #8dc63f 0%,#8dc63f 50%,#7fb239 51%,#7fb239 100%);
   background: -o-linear-gradient(top,  #8dc63f 0%,#8dc63f 50%,#7fb239 51%,#7fb239 100%);
   background: -ms-linear-gradient(top,  #8dc63f 0%,#8dc63f 50%,#7fb239 51%,#7fb239 100%);
   background: linear-gradient(top,  #8dc63f 0%,#8dc63f 50%,#7fb239 51%,#7fb239 100%);
   margin: auto;
   cursor:pointer;
   color: #fff;
   text-shadow: 1px 0px 0 rgba(0,0,0,.4);
   border-radius: 5px;
   border: none;
   font-family: cabin,sans-serif;
   display: block;
   font-weight: bold;
   padding: 5px 15px;
}
.inf{
	font-weight:bold;
	font-size:15px;
}
.form-field{
	width:70%;
}
.divider{
    border-top: 1px solid #ddd;
    width: 90%;
    margin: 10px 0px;
}
</style>

<div class="wrap">
    <?php screen_icon(); ?>
    <form action="options.php" method="post" id=<?php echo $this->plugin_id; ?>"_options_form" name=<?php echo $this->plugin_id; ?>"_options_form">
    <?php settings_fields($this->plugin_id.'_options'); ?>
    <h2>Amazon Link Localizer &raquo; Settings</h2>
   <p> All done! </p>

	<p>Once installed, the plugin will by default start localizing your international traffic (a UK visitor to amazon.co.uk and a US visitor to amazon.com).
	</p>
	<p>
	Add your international affiliate IDs to <a href="https://www.prourls.com" target="_blank">Prourls</a> account for earning commission from various Amazon stores. (It’s free and won't take more than 2 minutes to signup). 
	</p>
	<p>Happy Localizing!</p>
    <div class="divider"></div>
	<p class="inf"> Please Enter Your Prourls API Keys
		</p>
   <!-- <table width="550" border="0" cellpadding="5" cellspacing="5" style="margin-top:100px;margin-left:50px;"> 
	<tr>
        <td width="200" height="16" align="right" style="vertical-align: top;padding-top:9px;"><label style="font-weight:600;font-size:15px;" for="<?php echo $this->plugin_id; ?>[storeid]">Your API Key:</label> </td>
        <td width="200" height="16" align="right" style="vertical-align: top;padding-top:9px;"><label style="font-weight:600;font-size:15px;" for="<?php echo $this->plugin_id; ?>[storeid]">Your API Secret Key:</label> </td>
        <td id="key-holder" width="366" style="padding:5px;margin:0px;width:100%;"><input placeholder="Please Enter Store ID" id="storeid" name="<?php echo $this->plugin_id; ?>[storeid]" type="text" value="<?php echo $options['storeid']; ?>"  /></td>
		 <td > <input type="submit" name="submit" value="Save" class="button-primary"/></td>
    </tr>
    </table> -->
    <table width="550" border="0" cellpadding="5" cellspacing="5">
    	<tr>
    		<td>
    			<label for="api-key">API Key : </label> 
    		</td>
    	</tr>
    	<tr>
    		<td>
    			<input type="text" placeholder="API Key" id="prourls_api_key" class="form-field" name="<?php echo $this->plugin_id; ?>[api_key]" value="<?php echo $options['api_key']; ?>">
    		</td>
    	</tr>
    	<tr>
    		<td>
    			<label for="api-key">API Secret : </label> 
    		</td>
    	</tr>
    	<tr>
    		<td>
    			<input type="text" placeholder="API Secret"id="prourls_api_secret" class="form-field" name="<?php echo $this->plugin_id; ?>[api_secret]" value="<?php echo $options['api_secret']; ?>">
    		</td>
    	</tr>
    	<tr>
    		<td>
    			<label for="api-key">Domains: </label> 
    		</td>
    	</tr>
    	<tr>
    		<td>
    			<select name="<?php echo $this->plugin_id; ?>[domain]" class="form-field" id="prourls_domain">
    				<option value="https://www.prourls.com/">https://www.prourls.com/</option>
    			</select>
    		</td>
    	</tr>
    	<tr>
    		<td>
    			 <input type="submit" class="button-primary" value="Save">
    		</td>
    	</tr>
    </table>
    </form>
</div>
<script type="text/javascript">
jQuery(document).ready( function(e){
	var domain = "<?= $options['domain'] ?>";
	jQuery.ajax({
		type : "GET",
		url : "https://www.prourls.com/api/get_domains",
		data : { api_key : jQuery('#prourls_api_key').val(), api_secret : jQuery('#prourls_api_secret').val()},
		success : function(response){
			var domains = response.domains;
			for(var i=0; i<domains.length;i++){
				jQuery('#prourls_domain').append(jQuery("<option></option>")
                    .attr("value",domains[i])
                    .text(domains[i])); 
			}
			jQuery('#prourls_domain').val(domain);
		}
	});
});
</script>
