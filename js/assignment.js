// Kunin ang mga button gamit ang kanilang IDs
const optionA = document.getElementById("option-a");
const optionB = document.getElementById("option-b");
const optionC = document.getElementById("option-c");
const optionD = document.getElementById("option-d");

// Mag-add ng event listener para sa bawat button
optionA.addEventListener("click", function() {
    alert("You selected A. Answer!");
    console.log("Option A clicked");
});

optionB.addEventListener("click", function() {
    alert("You selected B. Answer!");
    console.log("Option B clicked");
});

optionC.addEventListener("click", function() {
    alert("You selected C. Answer!");
    console.log("Option C clicked");
});

optionD.addEventListener("click", function() {
    alert("You selected D. Answer!");
    console.log("Option D clicked");
});