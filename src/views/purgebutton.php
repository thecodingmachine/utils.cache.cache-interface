<form class="navbar-form pull-right" style="margin-right: 5px">
<button id="menupurgecache" class="btn btn-danger" data-loading-text="Purging cache..." data-toggle="button">Purge cache</button>
</form>
<script type="text/javascript">
jQuery(document).ready(function() {
	
	jQuery("#menupurgecache").click(function() {
		jQuery('#menupurgecache').button('loading');

		jQuery.ajax(MoufInstanceManager.rootUrl+"vendor/mouf/utils.cache.cache-interface/src/direct/purge_all.php?selfedit="+MoufInstanceManager.rootUrl);
		
		return false;
	})
});
</script>