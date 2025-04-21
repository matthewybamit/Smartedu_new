<?php
require_once 'db_connection.php'; // Make sure to adjust the path

// Get POST data from JavaScript
$data = json_decode(file_get_contents('php://input'), true);

$subject = $data['subject'] ?? null;
$level = $data['level'] ?? null;

$lessons = [];

try {
    if ($subject && $level) {
        // Check if lessons table exists
        $checkTable = $pdo->query("SHOW TABLES LIKE 'lessons'");
        $tableExists = $checkTable->rowCount() > 0;
        
        if ($tableExists) {
            // Prepare SQL query using PDO
            $sql = "SELECT * FROM lessons WHERE subject = :subject AND level = :level ORDER BY id ASC";
            
            // Prepare the statement
            $stmt = $pdo->prepare($sql);
            
            // Bind parameters
            $stmt->bindParam(':subject', $subject, PDO::PARAM_STR);
            $stmt->bindParam(':level', $level, PDO::PARAM_STR);
            
            // Execute the statement
            $stmt->execute();
            
            // Fetch all the results
            $lessons = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        // If no lessons found in database, provide demo content
        if (empty($lessons)) {
            // Demo lessons based on subject
            switch(strtolower($subject)) {
                case 'english':
                    $lessons = [
                        [
                            'id' => 1,
                            'subject' => 'English',
                            'level' => $level,
                            'title' => 'Introduction to Grammar',
                            'description' => 'Learn the basics of English grammar including nouns, verbs, and sentence structure. This foundational chapter will help you understand how English sentences are formed and the rules that govern proper communication.'
                        ],
                        [
                            'id' => 2,
                            'subject' => 'English',
                            'level' => $level,
                            'title' => 'Vocabulary Building',
                            'description' => 'Expand your vocabulary with strategies for learning and remembering new words. This chapter covers root words, prefixes, suffixes, and contextual understanding to help you build a rich vocabulary.'
                        ],
                        [
                            'id' => 3,
                            'subject' => 'English',
                            'level' => $level,
                            'title' => 'Reading Comprehension',
                            'description' => 'Develop skills to understand and analyze written text. Learn techniques for active reading, identifying main ideas, understanding context clues, and drawing inferences from different types of texts.'
                        ],
                        [
                            'id' => 4,
                            'subject' => 'English',
                            'level' => $level,
                            'title' => 'Essay Writing',
                            'description' => 'Master the art of essay writing with this comprehensive guide. Learn how to structure arguments, create compelling introductions and conclusions, and develop your ideas with supporting evidence.'
                        ],
                        [
                            'id' => 5,
                            'subject' => 'English',
                            'level' => $level,
                            'title' => 'Literary Analysis',
                            'description' => 'Explore literature through critical analysis. This chapter teaches you how to identify themes, analyze character development, recognize literary devices, and interpret meaningful passages in fiction and poetry.'
                        ]
                    ];
                    break;
                    
                case 'mathematics':
                    $lessons = [
                        [
                            'id' => 1,
                            'subject' => 'Mathematics',
                            'level' => $level,
                            'title' => 'Number Systems',
                            'description' => 'Explore different number systems including natural numbers, integers, rational and irrational numbers. Learn about their properties and how they relate to one another in the number line.'
                        ],
                        [
                            'id' => 2,
                            'subject' => 'Mathematics',
                            'level' => $level,
                            'title' => 'Algebra Fundamentals',
                            'description' => 'Master the basics of algebra including variables, expressions, equations, and inequalities. Learn how to solve linear equations and apply algebraic concepts to word problems.'
                        ],
                        [
                            'id' => 3,
                            'subject' => 'Mathematics',
                            'level' => $level,
                            'title' => 'Geometry Basics',
                            'description' => 'Discover the principles of geometry through points, lines, angles, and shapes. Study the properties of triangles, quadrilaterals, circles, and other geometric figures.'
                        ],
                        [
                            'id' => 4,
                            'subject' => 'Mathematics',
                            'level' => $level,
                            'title' => 'Introduction to Functions',
                            'description' => 'Learn about functions, their representations, and properties. Explore function notation, domain and range, and different types of functions including linear, quadratic, and exponential.'
                        ],
                        [
                            'id' => 5,
                            'subject' => 'Mathematics',
                            'level' => $level,
                            'title' => 'Statistics and Probability',
                            'description' => 'Study the basics of data analysis, statistical measures, and probability concepts. Learn how to collect, organize, and interpret data to make informed decisions.'
                        ]
                    ];
                    break;
                    
                case 'history':
                    $lessons = [
                        [
                            'id' => 1,
                            'subject' => 'History',
                            'level' => $level,
                            'title' => 'Ancient Civilizations',
                            'description' => 'Explore the rise and fall of early human civilizations including Mesopotamia, Egypt, Greece, and Rome. Learn about their cultural, political, and technological contributions to human history.'
                        ],
                        [
                            'id' => 2,
                            'subject' => 'History',
                            'level' => $level,
                            'title' => 'Middle Ages',
                            'description' => 'Study the medieval period from the fall of Rome to the Renaissance. Discover feudalism, the rise of Islam, the Crusades, and the development of European nation-states.'
                        ],
                        [
                            'id' => 3,
                            'subject' => 'History',
                            'level' => $level,
                            'title' => 'Age of Exploration',
                            'description' => 'Learn about the European voyages of discovery and their impact on global history. Study key explorers, navigational advances, and the beginnings of colonization.'
                        ],
                        [
                            'id' => 4,
                            'subject' => 'History',
                            'level' => $level,
                            'title' => 'Industrial Revolution',
                            'description' => 'Examine the technological and social changes that transformed society between the 18th and 19th centuries. Explore inventions, economic theories, and the rise of urban working classes.'
                        ],
                        [
                            'id' => 5,
                            'subject' => 'History',
                            'level' => $level,
                            'title' => 'World Wars and Modern Era',
                            'description' => 'Study the global conflicts of the 20th century and their aftermath. Analyze causes, significant events, and the reshaping of international relations in the modern world.'
                        ]
                    ];
                    break;
                    
                case 'science':
                    $lessons = [
                        [
                            'id' => 1,
                            'subject' => 'Science',
                            'level' => $level,
                            'title' => 'Scientific Method',
                            'description' => 'Learn the fundamental approach to scientific inquiry including observation, hypothesis formation, experimentation, and analysis. Understand how scientists develop and test theories about the natural world.'
                        ],
                        [
                            'id' => 2,
                            'subject' => 'Science',
                            'level' => $level,
                            'title' => 'Cells and Organisms',
                            'description' => 'Explore the basic unit of life - the cell. Study cell structure, function, and how cells organize into tissues, organs, and complete organisms.'
                        ],
                        [
                            'id' => 3,
                            'subject' => 'Science',
                            'level' => $level,
                            'title' => 'Matter and Energy',
                            'description' => 'Discover the properties of matter and various forms of energy. Learn about atoms, elements, compounds, and the laws that govern energy transformation and conservation.'
                        ],
                        [
                            'id' => 4,
                            'subject' => 'Science',
                            'level' => $level,
                            'title' => 'Earth and Space',
                            'description' => 'Study the structure of Earth, its geological processes, and its place in the solar system. Learn about weather, climate, the water cycle, and our planet\'s natural resources.'
                        ],
                        [
                            'id' => 5,
                            'subject' => 'Science',
                            'level' => $level,
                            'title' => 'Ecosystems and Environment',
                            'description' => 'Examine how living things interact with each other and their environment. Study biodiversity, energy flow in ecosystems, and human impact on the natural world.'
                        ]
                    ];
                    break;
                    
                default:
                    // Generic lessons for any other subject
                    $lessons = [
                        [
                            'id' => 1,
                            'subject' => $subject,
                            'level' => $level,
                            'title' => 'Introduction to ' . $subject,
                            'description' => 'An overview of the fundamental concepts and principles in ' . $subject . '. This chapter will provide you with a strong foundation for future learning.'
                        ],
                        [
                            'id' => 2,
                            'subject' => $subject,
                            'level' => $level,
                            'title' => 'Core Concepts',
                            'description' => 'Explore the essential theories and ideas that form the basis of ' . $subject . '. Learn key terminology and build your understanding of important frameworks.'
                        ],
                        [
                            'id' => 3,
                            'subject' => $subject,
                            'level' => $level,
                            'title' => 'Practical Applications',
                            'description' => 'Discover how the principles of ' . $subject . ' are applied in real-world situations. This chapter connects theory with practice through examples and case studies.'
                        ],
                        [
                            'id' => 4,
                            'subject' => $subject,
                            'level' => $level,
                            'title' => 'Advanced Topics',
                            'description' => 'Delve deeper into specialized areas of ' . $subject . '. This chapter builds on previous knowledge to explore more complex and nuanced aspects of the field.'
                        ],
                        [
                            'id' => 5,
                            'subject' => $subject,
                            'level' => $level,
                            'title' => 'Future Directions',
                            'description' => 'Learn about emerging trends and future developments in ' . $subject . '. This chapter examines cutting-edge research and potential innovations in the field.'
                        ]
                    ];
            }
        }
    }
} catch (PDOException $e) {
    // Log error
    error_log("Database error: " . $e->getMessage());
    
    // Return empty array with error message
    $lessons = [
        [
            'id' => 0,
            'title' => 'Database Error',
            'description' => 'Unable to fetch lessons at this time. Please try again later.'
        ]
    ];
}

// Return lessons as JSON
header('Content-Type: application/json');
echo json_encode($lessons);
?>