document.addEventListener("DOMContentLoaded", function () {
	let currentIndex = 0;
	const testimonialContent = document.querySelector(".testimonial-content");
	const testimonialItems = document.querySelectorAll(".testimonial-item");
	const nextBtns = document.querySelectorAll(".testimonial-nav .nav-btn.next");
	const prevBtns = document.querySelectorAll(".testimonial-nav .nav-btn.prev");

	function showTestimonial(index) {
		if (testimonialItems.length === 0) return;

		// Ensure index is within bounds (infinite loop)
		index = index % testimonialItems.length;
		if (index < 0) index += testimonialItems.length;

		// Hide all items with smooth transition
		testimonialItems.forEach((item) => {
			item.style.opacity = "0";
			item.style.transition = "opacity 0.5s ease-in-out";
			setTimeout(() => {
				item.style.display = "none";
			}, 250);
		});

		// Show current item
		setTimeout(() => {
			testimonialItems[index].style.display = "flex";
			testimonialItems[index].style.opacity = "0";
			// Trigger reflow to restart animation
			testimonialItems[index].offsetHeight;
			testimonialItems[index].style.opacity = "1";
		}, 250);
	}

	function goToNext() {
		if (testimonialItems.length === 0) return;
		currentIndex = (currentIndex + 1) % testimonialItems.length;
		showTestimonial(currentIndex);
	}

	function goToPrev() {
		if (testimonialItems.length === 0) return;
		currentIndex =
			(currentIndex - 1 + testimonialItems.length) % testimonialItems.length;
		showTestimonial(currentIndex);
	}

	// Attach click handlers to ALL navigation buttons
	nextBtns.forEach((btn) => btn.addEventListener("click", goToNext));
	prevBtns.forEach((btn) => btn.addEventListener("click", goToPrev));

	// Keyboard navigation (optional but nice)
	document.addEventListener("keydown", (e) => {
		if (e.key === "ArrowRight") goToNext();
		if (e.key === "ArrowLeft") goToPrev();
	});

	// Show first testimonial on load
	showTestimonial(currentIndex);
});

document.addEventListener("DOMContentLoaded", function () {
	const menuBtn = document.querySelector("#menu-btn");
	const navbar = document.querySelector(".navbar");
	const crossBtn = document.querySelector(".cross-btn");

	menuBtn.addEventListener("click", () => {
		navbar.classList.toggle("active");
	});
	crossBtn.addEventListener("click", () => {
		navbar.classList.toggle("active");
	});

	// Sticky Header

	const header = document.querySelector(".header");
	const toggleClass = "is-sticky";

	window.addEventListener("scroll", () => {
		const currentScroll = window.pageYOffset;
		if (currentScroll > 150) {
			header.classList.add(toggleClass);
		} else {
			header.classList.remove(toggleClass);
		}
	});
});
