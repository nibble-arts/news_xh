function news_init(text) {

	// add user delete window
	jQuery("form").submit(function (e) {

		if (jQuery(this).find("input.delete[name='news_button_del_cat']:focus").length) {

			e.preventDefault();

			r = confirm(text);

			if (r) {
				// window.location = e.currentTarget.href;
			}
		}

	});
}