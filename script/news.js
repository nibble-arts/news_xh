function news_init(text) {


	// add delete window confirmation
	jQuery("form#news_form").submit(function (e) {

		if (jQuery(this).find("input.news_delete:focus").length) {

			r = confirm(text);

			// abort submit
			if (!r) {
				e.preventDefault();
			}
		}

	});


	// add datepicker
	(function () {

		// create datepicker
		const input = document.getElementById('news_datepicker');
	    const datepicker = new TheDatepicker.Datepicker(input);

	    // set datepicker options
	    datepicker.options.setInputFormat("j.n.Y");
		datepicker.options.setShowResetButton();

		// calc date
		if (input.value) {
			date = new Date(parseInt(input.value) * 1000);
		    datepicker.options.setInitialDate(date);
		}

	    datepicker.render();
	})();
}
