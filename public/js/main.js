document.addEventListener("DOMContentLoaded", function(event) {
	var lazyImages =[].slice.call(
		document.querySelectorAll(".lazy > source")
	)
	if ("IntersectionObserver" in window && 'IntersectionObserverEntry' in window) {
		let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
			entries.forEach(function(entry) {
				if (entry.isIntersecting) {      
					let lazyImage = entry.target;
					lazyImage.srcset = lazyImage.dataset.srcset;
					lazyImage.nextElementSibling.srcset = lazyImage.dataset.srcset;
					lazyImage.parentElement.classList.remove("lazy");
					lazyImageObserver.unobserve(lazyImage);
				}
			});
		});

		lazyImages.forEach(function(lazyImage) {
			lazyImageObserver.observe(lazyImage);
		});
	} else {


		let active = false;

		const lazyLoad = function() {
			if (active === false) {
				active = true;
				setTimeout(function() {
					lazyImages.forEach(function(lazyImage) {
						if ((lazyImage.getBoundingClientRect().top <= window.innerHeight && lazyImage.getBoundingClientRect().bottom >= 0) && getComputedStyle(lazyImage).display !== "none") {
							lazyImage.srcset = lazyImage.dataset.srcset;
							lazyImage.nextElementSibling.src = lazyImage.dataset.srcset;
							lazyImage.parentElement.classList.remove("lazy");

							lazyImages = lazyImages.filter(function(image) {
								return image !== lazyImage;
							});

							if (lazyImages.length === 0) {
								document.removeEventListener("scroll", lazyLoad);
								window.removeEventListener("resize", lazyLoad);
								window.removeEventListener("orientationchange", lazyLoad);
							}
						}
					});

					active = false;
				}, 200);
			}
		};

		document.addEventListener("scroll", lazyLoad);
		window.addEventListener("resize", lazyLoad);
		window.addEventListener("orientationchange", lazyLoad);
	}

});

document.addEventListener("DOMContentLoaded", function() {
	var lazyBackgrounds = [].slice.call(document.querySelectorAll(".display"));

	if ("IntersectionObserver" in window) {
		let lazyBackgroundObserver = new IntersectionObserver(function(entries, observer) {
			entries.forEach(function(entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add("visible");
					lazyBackgroundObserver.unobserve(entry.target);
				}
			});
		});

		lazyBackgrounds.forEach(function(lazyBackground) {
			lazyBackgroundObserver.observe(lazyBackground);
		});
	}
});


Modernizr.on('webp', function(result) {
	const devices = document.querySelectorAll(".display");
		devices.forEach(function(device) {
			if (result) {
				device.classList.add("webp");
			} else {
				device.classList.add("no-webp");
			}

	});
});
