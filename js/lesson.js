document.addEventListener("DOMContentLoaded", function () {
    // Fetch lessons
    fetch('php_functions/get_lessons.php')
        .then(response => response.json())
        .then(data => {
            const container = document.querySelector(".books-grid");
            container.innerHTML = ""; // Clear static books

            data.forEach(lesson => {
                const bookItem = document.createElement("div");
                bookItem.className = "book-item";
                bookItem.innerHTML = `
                    <img src="admin/${lesson.cover_photo}" alt="${lesson.subject} Book Cover" class="book-cover" style="width: 150px; height: 200px;">
                    <p>${lesson.subject} - ${lesson.title}</p>
                `;
                container.appendChild(bookItem);
            });
        })
        .catch(error => {
            console.error("Error fetching lessons:", error);
        });

    // Fetch video lessons
    fetch('php_functions/get_video.php')
        .then(res => res.json())
        .then(data => {
            const container = document.querySelector('.carousel');
            container.innerHTML = ''; // Clear existing content

            data.forEach(video => {
                const videoId = video.video_id; // Use video_id directly from server response
                const thumbUrl = `https://img.youtube.com/vi/${videoId}/0.jpg`;

                const div = document.createElement('div');
                div.className = 'video-item';
                div.innerHTML = `
                    <a href="https://www.youtube.com/watch?v=${videoId}" target="_blank">
                        <img src="${thumbUrl}" width="300" height="200" />
                        <p>${video.title}</p>
                    </a>
                `;
                container.appendChild(div);
            });
        })
        .catch(error => {
            console.error("Error fetching video lessons:", error);
        });
    
});
