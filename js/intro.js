//switch from one picture to another in index.html
// Creating a collection of all pictures
const sliderItems = document.querySelectorAll(".slider_item");
// Index of the current slide
let currentSlide = 0;

/**
 * Displays the picture at the specified index by adding the "active" class.
 *
 * @param {number} index - The index of the picture to be displayed.
 *
 * @return {void} - Returns nothing.
 */
function showCurrentPicture(index) {
  sliderItems.forEach((item, i) => {
    item.classList.toggle("active", i === index);
  });
}

/**
 * Displays the next picture in the slider by incrementing the current slide index.
 *
 * @return {void} - Returns nothing.
 */
function showNextPicture() {
  currentSlide = (currentSlide + 1) % sliderItems.length;
  showCurrentPicture(currentSlide);
}

showCurrentPicture(currentSlide);

// Switching slides every 5 seconds.
setInterval(showNextPicture, 5000);
