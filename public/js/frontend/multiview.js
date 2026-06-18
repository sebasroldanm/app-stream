document.addEventListener("DOMContentLoaded", function () {
    const videoGrid = document.getElementById("video-grid");

    document.querySelectorAll(".owner-btn").forEach((button) => {
        button.addEventListener("click", function () {
            const ownerId = this.dataset.ownerId;
            const username = this.dataset.username;
            const status = this.dataset.status;
            const streamUrl = this.dataset.streamUrl;

            const existingCard = document.getElementById(
                "video-card-" + ownerId,
            );

            /*
            |--------------------------------------------------------------------------
            | SI YA EXISTE -> ELIMINAR
            |--------------------------------------------------------------------------
            */
            if (existingCard) {
                existingCard.remove();

                this.classList.remove("btn-outline-danger");
                this.classList.add("btn-outline-light");

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | SI NO EXISTE -> CREAR
            |--------------------------------------------------------------------------
            */

            this.classList.remove("btn-outline-light");
            this.classList.add("btn-outline-danger");

            // Crear columna
            const col = document.createElement("div");

            col.className = "col";
            col.id = "video-card-" + ownerId;

            col.innerHTML = `
                <div class="card h-100 shadow-sm border-primary">

                    <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white p-1">
                        <h6 class="mb-0 text-white">${username} - (${status})</h6>

                        <button
                            type="button"
                            class="btn-close btn-close-white remove-video"
                            data-owner-id="${ownerId}">
                        </button>
                    </div>

                    <div class="card-body p-0 bg-dark" style="min-height: 250px;">

                        <video
                            class="w-100 h-100"
                            autoplay
                            muted
                            playsinline
                            controls
                        >
                            <source
                                src="${streamUrl}"
                                type="application/x-mpegURL"
                            >
                        </video>

                    </div>

                </div>
            `;

            videoGrid.appendChild(col);

            /*
            |--------------------------------------------------------------------------
            | BOTON CERRAR VIDEO
            |--------------------------------------------------------------------------
            */
            col.querySelector(".remove-video").addEventListener(
                "click",
                function () {
                    const ownerId = this.dataset.ownerId;

                    const card = document.getElementById(
                        "video-card-" + ownerId,
                    );

                    if (card) {
                        card.remove();
                    }

                    // Restaurar botón original
                    const ownerButton = document.querySelector(
                        '.owner-btn[data-owner-id="' + ownerId + '"]',
                    );

                    if (ownerButton) {
                        ownerButton.classList.remove("btn-outline-danger");
                        ownerButton.classList.add("btn-outline-light");
                    }
                },
            );
        });
    });
});
