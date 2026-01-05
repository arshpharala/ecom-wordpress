/**
 * Eyes Animation - Follows Mouse Movement
 *
 * Interactive eye animation that responds to mouse position
 * Includes scaling and shadow effects based on distance
 */

(function () {
	let mouseX = 0;
	let mouseY = 0;

	// Track mouse movement
	document.addEventListener("mousemove", function (e) {
		mouseX = e.pageX;
		mouseY = e.pageY;
	});

	/**
	 * Update eye positions and effects based on mouse location
	 */
	function updateEyes() {
		const eyes = document.querySelectorAll(".eye");

		eyes.forEach((eye) => {
			const eyeball = eye.querySelector(".eyeball");

			if (!eyeball) return;

			// Get eye position
			const eyeRect = eye.getBoundingClientRect();
			const eyeCenterX = eyeRect.left + window.scrollX + eyeRect.width / 2;
			const eyeCenterY = eyeRect.top + window.scrollY + eyeRect.height / 2;

			// Calculate distance and angle to mouse
			const dx = mouseX - eyeCenterX;
			const dy = mouseY - eyeCenterY;
			const distance = Math.sqrt(dx * dx + dy * dy);

			// Calculate scaling based on distance
			const maxDist = 400;
			const distanceFactor = Math.min(distance, maxDist) / maxDist;
			const scaleY = Math.min(1.4, 1 + (1 - distanceFactor) * 0.4);
			const scaleX = 1 - (scaleY - 1) / 4;

			// Apply eye scaling
			eye.style.transform = `scaleX(${scaleX.toFixed(
				2
			)}) scaleY(${scaleY.toFixed(2)})`;

			// Calculate eyeball movement
			const angle = Math.atan2(dy, dx);
			const moveX = Math.cos(angle) * 30;
			const moveY = Math.sin(angle) * 30;
			const shadowX = -moveX * 0.2;
			const shadowY = -moveY * 0.2;

			// Apply eyeball transform and shadow
			eyeball.style.transform = `translate(${moveX}px, ${moveY}px)`;
			eyeball.style.boxShadow = `${shadowX}px ${shadowY}px 15px rgba(0, 0, 0, 0.5)`;
		});

		requestAnimationFrame(updateEyes);
	}

	// Start animation when DOM is ready
	if (document.readyState === "loading") {
		document.addEventListener("DOMContentLoaded", updateEyes);
	} else {
		updateEyes();
	}
})();
