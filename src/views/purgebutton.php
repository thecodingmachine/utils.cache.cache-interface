<form class="navbar-form pull-right" style="margin-right: 5px">
<button id="menupurgecache" class="btn btn-danger" data-loading-text="Purging cache..." data-toggle="button">Purge cache</button>
<button id="menupurgecachedone" class="btn btn-success" disabled="disabled" style="display:none">Cache purged</button>
</form>
<script type="text/javascript">
jQuery(document).ready(function() {
	
	jQuery("#menupurgecache").click(function() {
		jQuery('#menupurgecache').button('loading');

		var url;
		if (MoufInstanceManager.selfEdit) {
			url = MoufInstanceManager.rootUrl+"purgeCaches/doPurge?selfedit=true";
		} else {
			url = MoufInstanceManager.rootUrl+"purgeCaches/doPurge?selfedit=false";
		}
		 
		jQuery.ajax(url)
			.done(function(data) {
				if (data) {
					addMessage("An error occured while purging cache:<br/>"+data, "alert alert-error");
				}
				jQuery("#menupurgecache").hide();
				jQuery("#menupurgecachedone").show();
				setTimeout(function() {
					jQuery("#menupurgecachedone").hide();
					jQuery("#menupurgecache").show();
					jQuery('#menupurgecache').button('reset');
				}, 1000);
			}).fail(function() {
				addMessage("An error occured while purging cache", "alert alert-error");
			});
		
		return false;
	})
});
</script>