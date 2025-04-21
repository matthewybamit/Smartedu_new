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