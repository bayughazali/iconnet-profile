document.addEventListener("DOMContentLoaded", () => {
    const wrapper = document.querySelector(".slider-wrapper");
    const slides = document.querySelectorAll(".slide");
    const indicators = document.querySelector(".slider-indicators");

    let index = 0;
    const total = slides.length;
    const intervalTime = 4000;

    // Buat indikator
    slides.forEach((_, i) => {
        const dot = document.createElement("span");
        if (i === 0) dot.classList.add("active");
        dot.addEventListener("click", () => {
            index = i;
            updateSlider();
            resetInterval();
        });
        indicators.appendChild(dot);
    });

    const dots = indicators.querySelectorAll("span");

    function updateSlider() {
        wrapper.style.transform = `translateX(-${index * 100}%)`;
        dots.forEach(dot => dot.classList.remove("active"));
        dots[index].classList.add("active");
    }

    function nextSlide() {
        index = (index + 1) % total;
        updateSlider();
    }

    let sliderInterval = setInterval(nextSlide, intervalTime);

    function resetInterval() {
        clearInterval(sliderInterval);
        sliderInterval = setInterval(nextSlide, intervalTime);
    }
});
