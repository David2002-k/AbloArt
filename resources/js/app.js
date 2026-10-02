

import Alpine from 'alpinejs';
import Carousel from 'bootstrap/js/dist/carousel';

window.Alpine = Alpine;

Alpine.start();

const homePortraitCarousel = document.querySelector('#homePortraitCarousel');

if (homePortraitCarousel) {
	new Carousel(homePortraitCarousel, {
		interval: 3000,
		pause: false,
		ride: 'carousel',
	}).cycle();
}
