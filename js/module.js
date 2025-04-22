fetch('php_functions/get_subjects.php')
    .then(response => response.json())
    .then(subjects => {
        const container = document.querySelector('.grid-content');
        container.innerHTML = ''; // clear any static content

        subjects.forEach(subject => {
            const div = document.createElement('div');
            div.className = 'quiz-content';

                //SUBJECT IMAGES JUST IN CASE

                // const subjectImages = {
                //     "English": "https://m.media-amazon.com/images/I/618JU+EmlBL._AC_UF1000,1000_QL80_.jpg",
                //     "Mathematics": "math.jpg",
                //     "Science": "science.jpg",
                //     // Add more as needed
                // };

                // ...

                // div.innerHTML = `
                //     ${subjectImages[subject] ? `<img src="${subjectImages[subject]}" alt="${subject} Cover" class="quiz-cover" style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0;">` : ""}
                //     <h1>${subject}</h1>
                // `;
            
                div.innerHTML = `
                <a href="personalize.php?subject=${encodeURIComponent(subject)}">
                    <h1>${subject}</h1>
                </a>
            `;

            container.appendChild(div);
        });

        // Save selected subject to localStorage
        document.querySelectorAll('.subject-link').forEach(link => {
            link.addEventListener('click', function (e) {
                const selectedSubject = this.dataset.subject;
                localStorage.setItem('preferredSubject', selectedSubject);
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Set background colors for quiz content elements
        const quizContents = document.querySelectorAll('.quiz-content');
        const colors = [
            '#ff8800', // Orange
            '#4285F4', // Blue
            '#34A853', // Green
            '#EA4335', // Red
            '#FBBC05', // Yellow
            '#8E44AD'  // Purple
        ];
        
        // Apply different background colors to each quiz content
        quizContents.forEach((content, index) => {
            const colorIndex = index % colors.length;
            content.style.backgroundColor = colors[colorIndex];
            
            // Add hover effect
            content.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.05)';
                this.style.boxShadow = '0 10px 30px rgba(0, 0, 0, 0.2)';
            });
            
            content.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
                this.style.boxShadow = 'none';
            });
        });
    });
    