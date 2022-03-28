document.querySelector(".message-container").addEventListener("click", () => {
    document.querySelector(".overlay").style.display = "block";
    document.querySelector(".create-post").classList.add("active");
});

document.querySelector(".create-post .close-btn").addEventListener("click", () => {
    document.querySelector(".overlay").style.display = "none";
    document.querySelector(".create-post").classList.remove("active");
});