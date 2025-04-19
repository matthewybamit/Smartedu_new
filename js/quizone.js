document.querySelectorAll(".quiz-option").forEach(option => {
    option.addEventListener("click", function() {
        alert("You selected: " + this.textContent);
    });
});