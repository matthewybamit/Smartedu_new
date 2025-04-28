document.addEventListener('DOMContentLoaded', function() {
    // Get all carousel wrappers on the page
    const carouselWrappers = document.querySelectorAll('.carousel-wrapper');
    
    carouselWrappers.forEach(wrapper => {
        const carousel = wrapper.querySelector('.carousel');
        const prevButton = wrapper.querySelector('.prev');
        const nextButton = wrapper.querySelector('.next');
        const itemWidth = 270; // Adjust based on your item width + margin
        const scrollAmount = itemWidth * 1; // Scroll 3 items at a time
        
        // Add click event for prev button
        prevButton.addEventListener('click', function() {
            carousel.scrollBy({
                left: -scrollAmount,
                behavior: 'smooth'
            });
        });
        
        // Add click event for next button
        nextButton.addEventListener('click', function() {
            carousel.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        });
    });
});