const container = document.getElementById("container");

document.querySelectorAll(".switch-page").forEach(link => {
	link.addEventListener("click", function(e) {
		e.preventDefault();

		if (!container) return;

		const target = this.getAttribute("href");
		const mode = this.dataset.mode;

		if (mode === "sign-up") {
			container.classList.add("right-panel-active");
		} else {
			container.classList.remove("right-panel-active");
		}

		setTimeout(() => {
			window.location.href = target;
		}, 500);
	});
});

document.querySelectorAll(".switch-btn").forEach(btn => {
	btn.addEventListener("click", function () {
		const target = this.dataset.target;
		const mode = this.dataset.mode;

		if (!container) return;

		// animasi dulu
		if (mode === "sign-up") {
			container.classList.add("right-panel-active");
		} else {
			container.classList.remove("right-panel-active");
		}

		// pindah halaman setelah animasi
		setTimeout(() => {
			window.location.href = target;
		}, 500);
	});
});

