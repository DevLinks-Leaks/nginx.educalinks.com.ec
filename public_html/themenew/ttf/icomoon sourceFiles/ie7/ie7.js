/* To avoid CSS expressions while still supporting IE 7 and IE 6, use this script */
/* The script tag referring to this file must be placed before the ending body tag. */

/* Use conditional comments in order to target IE 7 and older:
	<!--[if lt IE 8]><!-->
	<script src="ie7/ie7.js"></script>
	<!--<![endif]-->
*/

(function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'icomoon\'">' + entity + '</span>' + html;
	}
	var icons = {
		'icon-uniE664': '&#xe664;',
		'icon-home': '&#xe600;',
		'icon-pencil': '&#xe601;',
		'icon-pencil2': '&#xe602;',
		'icon-images': '&#xe603;',
		'icon-camera': '&#xe604;',
		'icon-headphones': '&#xe605;',
		'icon-play': '&#xe659;',
		'icon-book': '&#xe606;',
		'icon-books': '&#xe607;',
		'icon-file': '&#xe608;',
		'icon-profile': '&#xe609;',
		'icon-file-blank': '&#xe60a;',
		'icon-copy': '&#xe60b;',
		'icon-stack': '&#xe60c;',
		'icon-folder': '&#xe60d;',
		'icon-folder-open': '&#xe60e;',
		'icon-cart': '&#xe60f;',
		'icon-phone': '&#xe610;',
		'icon-clock': '&#xe611;',
		'icon-print': '&#xe65a;',
		'icon-download': '&#xe612;',
		'icon-upload': '&#xe613;',
		'icon-disk': '&#xe65b;',
		'icon-bubbles': '&#xe614;',
		'icon-user': '&#xe615;',
		'icon-users': '&#xe616;',
		'icon-parent': '&#xe617;',
		'icon-zoomin': '&#xe618;',
		'icon-zoomout': '&#xe619;',
		'icon-expand': '&#xe61a;',
		'icon-contract': '&#xe61b;',
		'icon-expand2': '&#xe65c;',
		'icon-lock': '&#xe61c;',
		'icon-unlocked': '&#xe61d;',
		'icon-cog': '&#xe61e;',
		'icon-cogs': '&#xe61f;',
		'icon-stats': '&#xe620;',
		'icon-bars': '&#xe621;',
		'icon-bars2': '&#xe622;',
		'icon-remove': '&#xe65d;',
		'icon-briefcase': '&#xe623;',
		'icon-logout': '&#xe624;',
		'icon-signup': '&#xe625;',
		'icon-list': '&#xe626;',
		'icon-menu': '&#xe627;',
		'icon-tree': '&#xe628;',
		'icon-cloud-download': '&#xe629;',
		'icon-globe': '&#xe62a;',
		'icon-earth': '&#xe62b;',
		'icon-link': '&#xe62c;',
		'icon-flag': '&#xe62d;',
		'icon-attachment': '&#xe62e;',
		'icon-eye': '&#xe62f;',
		'icon-eye-blocked': '&#xe630;',
		'icon-star': '&#xe631;',
		'icon-star2': '&#xe632;',
		'icon-thumbs-up': '&#xe633;',
		'icon-thumbs-down': '&#xe634;',
		'icon-close': '&#xe635;',
		'icon-checkmark': '&#xe636;',
		'icon-minus': '&#xe637;',
		'icon-plus': '&#xe638;',
		'icon-volume': '&#xe639;',
		'icon-volume-mute': '&#xe63a;',
		'icon-checkbox-checked': '&#xe63b;',
		'icon-checkbox-unchecked': '&#xe63c;',
		'icon-checkbox-partial': '&#xe63d;',
		'icon-radio-checked': '&#xe63e;',
		'icon-radio-unchecked': '&#xe63f;',
		'icon-libreoffice': '&#xe640;',
		'icon-file-pdf': '&#xe641;',
		'icon-file-word': '&#xe642;',
		'icon-file-excel': '&#xe643;',
		'icon-file-xml': '&#xe644;',
		'icon-file-css': '&#xe645;',
		'icon-search': '&#xe65e;',
		'icon-add': '&#xe65f;',
		'icon-subtract': '&#xe660;',
		'icon-exclamation': '&#xe661;',
		'icon-question': '&#xe662;',
		'icon-close2': '&#xe663;',
		'icon-envelope': '&#xe658;',
		'icon-calendar': '&#xe646;',
		'icon-statistics': '&#xe647;',
		'icon-pie': '&#xe648;',
		'icon-bars3': '&#xe649;',
		'icon-minus2': '&#xe64a;',
		'icon-plus2': '&#xe64b;',
		'icon-arrow-left': '&#xe64c;',
		'icon-arrow-down': '&#xe64d;',
		'icon-arrow-up': '&#xe64e;',
		'icon-arrow-right': '&#xe64f;',
		'icon-arrow-left2': '&#xe650;',
		'icon-arrow-down2': '&#xe651;',
		'icon-arrow-up2': '&#xe652;',
		'icon-arrow-right2': '&#xe653;',
		'icon-arrow-left3': '&#xe654;',
		'icon-arrow-down3': '&#xe655;',
		'icon-arrow-up3': '&#xe656;',
		'icon-uniE657': '&#xe657;',
		'0': 0
		},
		els = document.getElementsByTagName('*'),
		i, c, el;
	for (i = 0; ; i += 1) {
		el = els[i];
		if(!el) {
			break;
		}
		c = el.className;
		c = c.match(/icon-[^\s'"]+/);
		if (c && icons[c[0]]) {
			addIcon(el, icons[c[0]]);
		}
	}
}());
