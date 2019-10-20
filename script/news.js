function news_init(text) {

	// add user delete window
	jQuery("form.delete").submit(function (e) {

		if (jQuery(this).find("input.delete[type=submit]:focus").length) {

			e.preventDefault();
	
			r = confirm(text);

			if (r) {
// TODO error in calling submit
				jQuery(this).submit();
			}
		}
	});
}