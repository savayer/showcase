var visibleNews = [];
var visibleTeasers = [];

$().ready(function () {

	checkBlocksVisible();
	$(window).scroll(function () {
		checkBlocksVisible();
	});
	if ($('#article').length) {// it is full text page
		var id = $('#article').data('id');
		var category = $('#article').data('category');
		$('a:not(.no-changer)').click(function () {
			$.ajax({
				url: '/api/changer?id=' + id + '&category=' + category,
				success: function (response) {
					if (response && response.url) {
						location.href = response.url;
					}
				}
			});
		});
	}
	if (typeof(chrome) !== 'undefined' && chrome.webstore && getCookie('ext') !== '0') {
		$('#show_popup').show();
	}
	$('.popup_no').click(function () {
		var date = new Date(new Date().getTime() + 24 * 60 * 60 * 1000);
		document.cookie = "ext=0; expires=" + date.toUTCString();
		$('#show_popup').hide();
	});
	$('.popup_yes').click(function () {
		chrome.webstore.install($('link[rel="chrome-webstore-item"]').attr('href'), installCallback, installFailCallback);
	});
	function installCallback () {
		var date = new Date(new Date().getTime() + 120 * 24 * 60 * 60 * 1000);
		document.cookie = "ext=0; expires=" + date.toUTCString();
		$('#show_popup').hide();
	}
	function installFailCallback () {
	}
	$('.popup_close').click(function () {
		$('#show_popup').hide();
	});

	if ($('body').hasClass('custom-page')) {
		function autoHeight() {
		$('#main').css('min-height', 0);
		$('#main').css('min-height', (
			$(document).height()
			- $('header').height()
			- $('footer').height()
			- 38
		));
		}

		// onDocumentReady function bind
		$(document).ready(function() {
			autoHeight();
		});

		// onResize bind of the function
		$(window).resize(function() {
			autoHeight();
		});
	}
	$('.main-news').click(function () {
		window.location.replace('/teasers');
	});
});

function checkBlocksVisible () {
	var currentVisibleNews = [];
	var currentVisibleTeasers = [];
	$('.data-block').each(function () {
		if (isScrolledIntoView(this)) {
			var el = $(this);
			if (el.data('type') === 'news' || el.data('type') === 'categoryNews') {
				currentVisibleNews.push(el.data('id'));
			} else {
				currentVisibleTeasers.push(el.data('id'));
			}
		}
	});
	currentVisibleNews = _.uniq(currentVisibleNews);
	currentVisibleTeasers = _.uniq(currentVisibleTeasers);
	var newVisibleNews = _.difference(currentVisibleNews, visibleNews);
	var newVisibleTeasers = _.difference(currentVisibleTeasers, visibleTeasers);
	visibleNews = _.union(newVisibleNews, visibleNews);
	visibleTeasers = _.union(newVisibleTeasers, visibleTeasers);
	if (newVisibleTeasers.length || newVisibleNews.length) {
		sendVisible(newVisibleNews, newVisibleTeasers);
	}
}

function isScrolledIntoView(el) {
		var elemTop = el.getBoundingClientRect().top;
		var elemBottom = el.getBoundingClientRect().bottom;

		var isVisible = elemTop < window.innerHeight - 50 && elemBottom >= 0;//at leasts 50px of block is visible
		return isVisible;
}

var waitingForSend = {};
var isSending = false;
function sendVisible (news, teasers) {
	waitingForSend = _.mergeWith(waitingForSend, {news: news, teasers: teasers}, mergeCustomizer);
	if (!isSending) {
		isSending = true;
		$.ajax({
				type: 'POST',
				url: '/api/visible',
				data: waitingForSend
		}).always(function () {
			setTimeout(function () {
				isSending = false;
				if (
					(waitingForSend.news && waitingForSend.news.length) ||
					(waitingForSend.teasers && waitingForSend.teasers.length)
				) {
					sendVisible([], []);
				}
			}, 500);
		});
		waitingForSend = {};
	}
}

function mergeCustomizer(objValue, srcValue) {
	if (_.isArray(objValue)) {
		return objValue.concat(srcValue);
	}
}
function getCookie(name) {
	var matches = document.cookie.match(new RegExp(
		"(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
	));
	return matches ? decodeURIComponent(matches[1]) : undefined;
}
