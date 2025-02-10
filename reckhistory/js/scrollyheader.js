const navbar = document.getElementById("scrollableNavbar");
const leftArrow = document.getElementById("scrollLeft");
const rightArrow = document.getElementById("scrollRight");

// Function to update the visibility of arrows
function updateArrows() {
    const isScrollable = navbar.scrollWidth > navbar.clientWidth;
    leftArrow.classList.toggle("visible", isScrollable && navbar.scrollLeft > 0);
    rightArrow.classList.toggle("visible", isScrollable && navbar.scrollLeft < navbar.scrollWidth - navbar.clientWidth);
}

// Event listener for scrolling
navbar.addEventListener("scroll", updateArrows);

// Event listener for window resizing
window.addEventListener("resize", updateArrows);

// Initial check on page load
updateArrows();
