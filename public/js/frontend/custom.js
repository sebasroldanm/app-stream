/**
 * Custom JS - Orchestrator and Global Utilities
 */

// Global event listeners for Livewire
window.Livewire.on("initMasonry", function (data) {
    initializeMasonry();
    initFullviewer();
});

window.Livewire.on("initExplorer", function (data) {
    setTimeout(() => {
        reloadExplorer();
    }, 500);
});

// Periodically check for Fullviewer initialization (fallback for dynamic content)
setInterval(() => {
    initFullviewer();
}, 1000);

window.addEventListener("initFullviewer", () => {
    setTimeout(() => {
        initFullviewer();
    }, 500);
});

window.addEventListener("themeApp", (event) => {
    document.documentElement.setAttribute("data-theme", event.detail.theme);
});

window.addEventListener("notice-age-confirmed", (event) => {
    const link = document.getElementById("parental-css");
    if (link) link.remove();
});

// Global UI Helpers
scrollToTop();

function scrollToTop() {
    const scrollToTopButton = document.getElementById("swipeUpContainer");
    if (!scrollToTopButton) return;

    let lastScrollTop = 0;
    let maxScrollReached = 0;

    window.onscroll = function () {
        let currentScroll = window.pageYOffset || document.documentElement.scrollTop;

        if (currentScroll < 200) {
            scrollToTopButton.classList.remove("show");
            maxScrollReached = currentScroll;
        } 
        else if (currentScroll > lastScrollTop) {
            scrollToTopButton.classList.remove("show");
            maxScrollReached = currentScroll;
        } 
        else {
            if (maxScrollReached - currentScroll > 100) {
                scrollToTopButton.classList.add("show");
            }
        }

        lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
    };

    scrollToTopButton.onclick = function () {
        scrollToTopButton.classList.add('clicked');
        window.scrollTo({ top: 0, behavior: "smooth" });
        setTimeout(() => {
            scrollToTopButton.classList.remove('clicked');
        }, 800);
    };
}

// Toggle live container
document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.getElementById("toggle-live-container");
    const liveContainer = document.getElementById("container-live");

    if (toggleBtn && liveContainer && window.innerWidth > 1449) {
        toggleBtn.addEventListener("click", function () {
            if (liveContainer.classList.contains("container")) {
                if (
                    !document
                        .getElementsByClassName("wrapper-menu")[0]
                        .classList.contains("open")
                ) {
                    sessionStorage.setItem("menu-open", "true");
                    document.getElementsByClassName("wrapper-menu")[0].click();
                }
                if (
                    !document
                        .getElementsByClassName("right-sidebar-mini")[0]
                        .classList.contains("right-sidebar")
                ) {
                    sessionStorage.setItem("sidebar-open", "true");
                    document
                        .getElementsByClassName("right-sidebar-toggle")[0]
                        .click();
                }
                liveContainer.classList.remove("container");
                liveContainer.classList.add("container-fluid");
            } else {
                liveContainer.classList.remove("container-fluid");
                liveContainer.classList.add("container");
                if (sessionStorage.getItem("menu-open") === "true") {
                    document.getElementsByClassName("wrapper-menu")[0].click();
                    sessionStorage.removeItem("menu-open");
                }
                if (sessionStorage.getItem("sidebar-open") === "true") {
                    document
                        .getElementsByClassName("right-sidebar-toggle")[0]
                        .click();
                    sessionStorage.removeItem("sidebar-open");
                }
            }
        });
    }
});
