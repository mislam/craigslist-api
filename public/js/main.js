/* global $ */

(function (window) {

	'use strict';

	$(document).ready(function () {
		$.getJSON('/api/newyork/web/1', function (data) {
			var date = data[0].date,
				results = data[0].results;
			$('h1').text(date);
			for (var i = 0, l = results.length; i < l; i++) {
				var result = results[i], 
					title = result.title,
					location = result.location,
					url = result.url,
					template = $('li.template').clone().removeClass('template');

				template.find('.num').text(i+1);
				template.find('.title').text(title);
				template.find('.location').text(location);
				template.find('a').attr('href', url);

				$('.main ul').append(template);
			}
		});
	});

}(this));