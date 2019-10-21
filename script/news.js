function news_init(text) {

	// add user delete window
	jQuery("form#news_form").submit(function (e) {

		if (jQuery(this).find("input.delete:focus").length) {

			r = confirm(text);

			// abort submit
			if (!r) {
				e.preventDefault();
			}
		}

	});
}