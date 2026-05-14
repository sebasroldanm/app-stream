document.addEventListener('alpine:init', () => {
    Alpine.data('progressComponent', (initialPercent) => ({
        percent: initialPercent,
        init() {
            setProgress(0);
            setTimeout(() => setProgress(this.percent), 100);
            this.$watch('percent', value => setProgress(value));
        }
    }))
})

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

