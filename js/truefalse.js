// Halimbawa ng pag-check kung tama ang sagot
trueButton.addEventListener("click", function() {
    const correctAnswer = true; // I-assume na ang tamang sagot ay TRUE
    if (correctAnswer) {
        alert("Correct! The answer is TRUE.");
    } else {
        alert("Incorrect! The answer is FALSE.");
    }
});

falseButton.addEventListener("click", function() {
    const correctAnswer = true; // I-assume na ang tamang sagot ay TRUE
    if (!correctAnswer) {
        alert("Correct! The answer is FALSE.");
    } else {
        alert("Incorrect! The answer is TRUE.");
    }
});