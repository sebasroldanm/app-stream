function setProgress(percent) {
    console.log("percent", percent);
    const bar = document.getElementById("progressBar");
    const text = document.getElementById("progressText");

    const value = Math.max(0, Math.min(percent, 100));

    bar.style.width = value + "%";
    text.textContent = value + "%";

    if (value === 100) {
        bar.classList.add("complete");
    } else {
        bar.classList.remove("complete");
    }
}

var percentActual = 0;

window.Livewire.on("updateBarInfo", function (data) {
    console.log(data[0]);
    if (percentActual != data[0].percent) {
        console.log("Actualización porcentaje");
        percentActual = data[0].percent;
        setProgress(data[0].percent);
    }
});
