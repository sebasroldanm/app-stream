document.addEventListener("DOMContentLoaded", function () {
    const birthdayAlert = document.getElementById("birthday-alert");
    if (!birthdayAlert) return;

    const colores = [
        "#ff0a54",
        "#ff477e",
        "#ff85a1",
        "#fbb1bd",
        "#f9bec7",
        "#00bbf9",
        "#00f5d4",
        "#fee440",
        "#9b5de5",
    ];

    const DURACION_LLUVIA = 15000;

    function lluviaConfetti() {
        const intervalo = setInterval(() => {
            confetti({
                particleCount: 3,
                angle: 90,
                spread: 60,
                startVelocity: 15,
                gravity: 0.6,
                drift: Math.random() - 0.5,
                origin: {
                    x: Math.random(),
                    y: 0,
                },
                colors: colores,
                scalar: Math.random() * 0.8 + 0.6,
            });
        }, 120);

        setTimeout(() => clearInterval(intervalo), DURACION_LLUVIA);
    }

    function disparoLados() {
        confetti({
            particleCount: 80,
            angle: 60,
            spread: 70,
            origin: { x: 0 },
            colors: colores,
        });

        confetti({
            particleCount: 80,
            angle: 120,
            spread: 70,
            origin: { x: 1 },
            colors: colores,
        });
    }

    function explosionCentro() {
        confetti({
            particleCount: 120,
            spread: 100,
            startVelocity: 30,
            origin: { x: 0.5, y: 0.5 },
            colors: colores,
        });
    }

    function lanzarMegaFiesta() {
        disparoLados();

        setTimeout(() => explosionCentro(), 400);
        setTimeout(() => disparoLados(), 800);
    }

    lluviaConfetti();

    setTimeout(() => {
        lanzarMegaFiesta();
    }, 800);
});
