function loadPage(page) {
    fetch(page)
        .then(res => res.text())
        .then(data => {
            const conten = document.getElementById("conten");
            conten.innerHTML = data;

            // Jalankan semua script yang ada di dalam konten
            conten.querySelectorAll("script").forEach(oldScript => {
                const newScript = document.createElement("script");
                newScript.textContent = oldScript.textContent;
                document.body.appendChild(newScript);
                document.body.removeChild(newScript);
            });
        })
        .catch(err => console.log(err));
}