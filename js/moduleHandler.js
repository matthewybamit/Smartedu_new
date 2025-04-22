document.addEventListener('DOMContentLoaded', function() {
    // Get all quiz content elements
    const quizContents = document.querySelectorAll('.quiz-content');
    
    // Add click event listeners to each quiz content
    quizContents.forEach(content => {
        content.addEventListener('click', function() {
            // Get the subject from the h1 element
            const subject = this.querySelector('h1').textContent;
            
            // Redirect to personalize.php with the selected subject
            window.location.href = `personalize.php?subject=${encodeURIComponent(subject)}`;
        });
    });

    // Get the quiz and assignments buttons
    const quizButton = document.querySelector('.quiz');
    const assignmentsButton = document.querySelector('.assignments');
    
    // Add click event listener to assignments button (for future implementation)
    assignmentsButton.addEventListener('click', function() {
        alert('Assignments feature coming soon!');
    });
});
