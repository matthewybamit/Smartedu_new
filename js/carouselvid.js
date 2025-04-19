document.addEventListener("DOMContentLoaded", () => {
    const carousel = document.querySelector(".carousel");
    const prevBtn = document.querySelector(".prev");
    const nextBtn = document.querySelector(".next");

    let scrollAmount = 0;
    const step = 260; 

    nextBtn.addEventListener("click", () => {
        carousel.scrollTo({
            left: (scrollAmount += step),
            behavior: "smooth"
        });
    });

    prevBtn.addEventListener("click", () => {
        carousel.scrollTo({
            left: (scrollAmount -= step),
            behavior: "smooth"
        });
    });
});
