
{literal}
<script type="text/javascript">
$(function() {

	// initialize overlay trigger
	$("button[rel]").overlay({

		// start exposing when overlay starts to load
		onBeforeLoad: function() {

			// this line does the magic. it makes the background image sit on top of the mask
			this.getBackgroundImage().expose({color: '#ffffff'});
		},

		// when overlay is closed take the expose instance and close it as well
		onClose: function() {
			$.expose.close();
		}

	});

	$('#gallery a').lightBox();
});
</script>
{/literal}
{literal}

   	<style type="text/css">
	/* jQuery lightBox plugin - Gallery style */
	#gallery {
		background-color: #ffffff;
	}
	#gallery ul { list-style: none; }
	#gallery ul li { display: inline; }
	#gallery ul img {
		border: 5px solid;
		border-width: 5px 5px 20px;
	}
	#gallery ul a:hover img {
		border: 5px solid;
		border-width: 5px 5px 20px;
		color: #fff;
	}
	#gallery ul a:hover { color: #fff; }
	#gallery ul a {color			: #ffffff; text-decoration: none;}

	</style>
{/literal}