const navbar = document.getElementById("scrollableNavbar");
const leftArrow = document.getElementById("scrollLeft");
const rightArrow = document.getElementById("scrollRight");

// Function to update arrow visibility
function updateArrows() {
    const isScrollable = navbar.scrollWidth > navbar.clientWidth;
    leftArrow.classList.toggle("visible", isScrollable && navbar.scrollLeft > 0);
    rightArrow.classList.toggle("visible", isScrollable && navbar.scrollLeft < navbar.scrollWidth - navbar.clientWidth);
}

// Scroll on arrow click
leftArrow.addEventListener("click", () => {
    navbar.scrollBy({ left: -150, behavior: "smooth" });
});
rightArrow.addEventListener("click", () => {
    navbar.scrollBy({ left: 150, behavior: "smooth" });
});

// Listen for scroll and resize events
navbar.addEventListener("scroll", updateArrows);
window.addEventListener("resize", updateArrows);

// Initial update on page load
updateArrows();
