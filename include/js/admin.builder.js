admin.builder = {
	user_modal: function( href ){
		$('body').modalmanager('loading');
		$.ajax({
			url: href
		}).done(function( html ){
			$("#meta_modal").html( html );
			$(".modal_user").modal();
		}).fail(function(){});
	}
}