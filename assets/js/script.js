document.querySelector(".signup").addEventListener("click", () => {
    document.querySelector(".home-overlay").style.display = "block";
    document.querySelector(".signup-popup").classList.add("active");
});

document.querySelector(".login").addEventListener("click", () => {
    document.querySelector(".home-overlay").style.display = "block";
    document.querySelector(".login-popup").classList.add("active");
});

document.querySelector(".signup-popup .close-btn").addEventListener("click", () => {
    document.querySelector(".home-overlay").style.display = "none";
    document.querySelector(".signup-popup").classList.remove("active");
});

document.querySelector(".login-popup .close-btn").addEventListener("click", () => {
    document.querySelector(".home-overlay").style.display = "none";
    document.querySelector(".login-popup").classList.remove("active");
});

