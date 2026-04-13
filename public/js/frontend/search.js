searchGlobe();

function searchGlobe() {
    let debounceTimer;

    document
        .getElementById("searchGlobe")
        .addEventListener("input", function (e) {
            const value = e.target.value.trim();

            clearTimeout(debounceTimer);

            debounceTimer = setTimeout(() => {
                // Si está vacío, limpiar resultados y no consultar
                if (!value) {
                    document.getElementById("resultSearch").innerHTML = "";
                    return;
                }

                fetch("/search?q=" + encodeURIComponent(value))
                    .then((r) => r.json())
                    .then((data) => {
                        console.log("API Response:", data);
                        renderResults(data.models || []);
                    })
                    .catch((err) => console.error(err));
            }, 500);
        });
}

function renderResults(models) {
    const container = document.getElementById("resultSearch");

    // Si no hay resultados
    if (!models || models.length === 0) {
        container.innerHTML = "<p>No hay resultados</p>";
        return;
    }

    // Construcción del HTML
    let html = `
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">Owners</h4>
            </div>
        </div>
        <div class="card-body">
            <ul class="media-story list-inline m-0 p-0">
    `;

    models.forEach((model) => {
        html += `
            <li class="d-flex mb-1 align-items-center">
                <img src="${model.avatarUrl}" 
                    alt="Pic Profile ${model.username}" 
                    class="rounded-circle img-fluid">
                <div class="stories-data ms-3">
                    <h5>
                        <a href="/owner/${model.username}" >${model.username}</a>
                    </h5>
                </div>
            </li>
        `;
    });

    html += `
            </ul>
        </div>
    `;

    container.innerHTML = html;
}
