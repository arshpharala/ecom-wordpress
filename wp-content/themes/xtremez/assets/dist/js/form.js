/**
 * Handle AJAX form submissions
 * @param {string} formSelector - CSS selector for the form
 */
function handleFormSubmission(formSelector) {
	const forms = document.querySelectorAll(formSelector);

	forms.forEach((form) => {
		const submitBtn = form.querySelector('[type="submit"]');

		form.addEventListener("submit", function (e) {
			e.preventDefault();

			if (submitBtn.disabled) return;

			// Clear previous errors
			form.querySelectorAll(".is-invalid").forEach((el) => {
				el.classList.remove("is-invalid");
			});
			form.querySelectorAll(".invalid-feedback").forEach((el) => {
				el.remove();
			});

			const originalText = submitBtn.innerHTML;
			submitBtn.disabled = true;
			submitBtn.innerHTML =
				'<span class="spinner-border spinner-border-sm me-1"></span> Please wait...';

			const formData = new FormData(this);

			fetch(form.action, {
				method: form.method || "POST",
				body: formData,
			})
				.then((response) => {
					if (!response.ok && response.status !== 422) {
						throw new Error("Network response was not ok");
					}
					return response.json();
				})
				.then((data) => {
					if (data.errors) {
						// Validation errors
						Swal.fire({
							icon: "error",
							title: "Validation Error",
							text: data.message || "Please fix the form errors below.",
							background: "#181818",
							color: "#fff",
							confirmButtonColor: "#FF6600",
							customClass: {
								confirmButton: "swal2-confirm-custom",
							},
						});

						// Add error classes and messages
						Object.keys(data.errors).forEach((field) => {
							let input = form.querySelector(`[name="${field}"]`);

							if (!input && field.includes(".")) {
								const flatName = field.replace(/\./g, "_").replace(/\[\]/g, "");
								input = form.querySelector(`[name="${flatName}"]`);
							}

							if (input) {
								input.classList.add("is-invalid");

								// Remove existing feedback
								const existingFeedback = input.nextElementSibling;
								if (
									existingFeedback &&
									existingFeedback.classList.contains("invalid-feedback")
								) {
									existingFeedback.remove();
								}

								// Add new feedback
								const feedback = document.createElement("div");
								feedback.className = "invalid-feedback";
								feedback.textContent = data.errors[field][0];
								input.parentNode.insertBefore(feedback, input.nextSibling);

								// Remove error on input
								input.addEventListener("input", function () {
									this.classList.remove("is-invalid");
									const nextEl = this.nextElementSibling;
									if (nextEl && nextEl.classList.contains("invalid-feedback")) {
										nextEl.remove();
									}
								});
							}
						});
					} else {
						// Success
						Swal.fire({
							icon: "success",
							title: "Success!",
							text: data.message || "Form submitted successfully.",
							timer: 3000,
							showConfirmButton: false,
							background: "#181818",
							color: "#fff",
							confirmButtonColor: "#FF6600",
							customClass: {
								confirmButton: "swal2-confirm-custom",
							},
						}).then(() => {
							if (data.redirect) {
								window.location.href = data.redirect;
							}
						});

						form.reset();
					}
				})
				.catch((error) => {
					Swal.fire({
						icon: "error",
						title: "Error",
						text: "Something went wrong. Please try again.",
						background: "#181818",
						color: "#fff",
						confirmButtonColor: "#FF6600",
						customClass: {
							confirmButton: "swal2-confirm-custom",
						},
					});
					console.error("Form submission error:", error);
				})
				.finally(() => {
					submitBtn.disabled = false;
					submitBtn.innerHTML = originalText;
				});
		});
	});
}

/**
 * Handle delete button clicks with confirmation
 */
function handleDeleteButtons() {
	document.addEventListener("click", (e) => {
		const button = e.target.closest(".btn-delete");
		if (!button) return;

		const url = button.dataset.url;

		Swal.fire({
			title: "Are you sure?",
			text: "This action cannot be undone!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes, delete it!",
		}).then((result) => {
			if (result.isConfirmed) {
				const csrfToken = document.querySelector('meta[name="csrf-token"]');
				const token = csrfToken ? csrfToken.getAttribute("content") : "";

				fetch(url, {
					method: "DELETE",
					headers: {
						"X-CSRF-TOKEN": token,
						"Content-Type": "application/json",
					},
					body: JSON.stringify({
						_method: "DELETE",
						_token: token,
					}),
				})
					.then((response) => response.json())
					.then((data) => {
						Swal.fire({
							icon: "success",
							title: "Deleted!",
							text: data.message || "Record deleted successfully.",
							timer: 2000,
							showConfirmButton: false,
						}).then(() => {
							if (data.redirect) {
								window.location.href = data.redirect;
							} else {
								location.reload();
							}
						});
					})
					.catch((error) => {
						Swal.fire(
							"Error",
							"Something went wrong. Please try again.",
							"error"
						);
						console.error("Delete error:", error);
					});
			}
		});
	});
}

// Initialize when DOM is ready
document.addEventListener("DOMContentLoaded", () => {
	handleFormSubmission("form.ajax-form");
	handleDeleteButtons();
});
