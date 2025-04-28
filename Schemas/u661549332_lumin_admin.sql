-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 28, 2025 at 08:20 AM
-- Server version: 10.11.10-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u661549332_lumin_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `level` varchar(100) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `cover_photo` varchar(255) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `view_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `title`, `description`, `level`, `subject`, `cover_photo`, `date_created`, `created_at`, `view_count`) VALUES
(21, 'The Solar System', 'Introduction\r\nOur Solar System consists of the Sun and the celestial bodies that orbit it, including eight planets, their moons, dwarf planets, comets, and asteroids. These planets are categorized based on their physical characteristics and compositions into three main types:​\r\n\r\nTerrestrial Planets: Mercury, Venus, Earth, and Mars. These are characterized by their solid, rocky surfaces.​\r\nGas Giants: Jupiter and Saturn. These massive planets are composed mainly of hydrogen and helium and lack a definite solid surface.​\r\nIce Giants: Uranus and Neptune. These planets contain heavier elements and compounds like water, methane, and ammonia, giving them a different composition compared to gas giants.\r\n\r\nIndividual Planets:\r\nMercury: The closest planet to the sun, known for its extreme temperature fluctuations and having no moons.\r\nVenus: Similar in size to Earth but with a toxic atmosphere and surface temperatures high enough to melt lead.\r\nEarth: The only known planet to support life, characterized by abundant liquid water and a protective atmosphere.\r\nMars: Known as the Red Planet due to its iron oxide-rich soil; it has the largest volcano and canyon in the solar system.\r\nJupiter: The largest planet, famous for its Great Red Spot—a gigantic storm—and having at least 79 moons.\r\nSaturn: Renowned for its prominent ring system composed of ice and rock particles.\r\nUranus: Unique for rotating on its side, it has a faint ring system and a blue-green color due to methane in its atmosphere.\r\nNeptune: Known for its strong winds and deep blue color, it was the first planet located through mathematical predictions.', 'Beginner', 'Science', 'admin/uploads/covers/680c554bd0db2_Solar system.png', '2025-04-23 16:27:57', '2025-04-23 16:27:57', 18),
(22, 'Pre-colonial Philippines', 'Before the arrival of the Spanish colonizers, the Philippine archipelago was home to thriving communities with distinct cultures, traditions, and governance. These early societies were organized into small, independent settlements called barangays, each led by a datu, or chieftain. The word barangay comes from balangay, a type of boat used by early Austronesian settlers. These communities were often situated along coastlines and rivers, where trade and fishing were central to daily life.\r\nSocial classes existed within these barangays. The ruling class, known as the maharlika or maginoo, included the datu and his family, as well as warriors and nobles. Beneath them were the timawa, or free citizens, who worked as farmers, fishermen, and traders. The lowest class, the alipin, consisted of individuals who served the higher classes. Unlike slaves in European societies, alipin could earn their freedom through labor or marriage.\r\nAgriculture was the backbone of pre-colonial life. Early Filipinos cultivated rice, taro, sugarcane, and coconuts, among other crops. Farming techniques such as kaingin, or slash-and-burn agriculture, were widely practiced in mountainous areas. In addition to farming, they engaged in fishing, hunting, and raising livestock. Tools were made from wood, stone, and metal, and communities developed specialized crafts like weaving, pottery, and boat-making.\r\nTrade played a crucial role in the economy. Filipinos had extensive trade networks with neighboring regions, including China, India, and the Middle East. Artifacts such as porcelain, silk, and glass beads found in archaeological sites suggest that early Filipinos exchanged local products like gold, pearls, beeswax, and spices for foreign goods. The presence of foreign merchants also influenced aspects of Filipino culture, including language, fashion, and religious beliefs.\r\nThe religious beliefs of pre-colonial Filipinos were animistic, meaning they believed that spirits resided in natural objects such as trees, mountains, and rivers. They worshiped deities, known as anitos, and performed rituals led by spiritual leaders called babaylan or katalonan. These rituals included offerings, chants, and dances to seek blessings for good harvests, safe journeys, or healing. Some communities also believed in a supreme being, though interpretations varied across regions.\r\nMarriage and family were important aspects of society. Courtship involved elaborate rituals, including the practice of harana, or serenading, and paninilbihan, where a suitor would perform tasks to prove his worth to a woman\'s family. Dowries, known as bigay-kaya, were given as a form of respect. Families were tightly knit, and children were raised to respect their elders, a value that continues in Filipino culture today.\r\nJustice in pre-colonial barangays was based on customary laws, which were often passed down orally. Conflicts were settled by the datu, who acted as both leader and judge. Punishments varied depending on the offense, ranging from fines and labor to exile or death for severe crimes. Some disputes were resolved through trial by ordeal, where the accused had to undergo physical tests, such as retrieving a stone from boiling water, to prove innocence.\r\nThe arts and literature of pre-colonial Filipinos were rich and expressive. Oral traditions, including epic poems, proverbs, and folktales, played a key role in preserving history and values. These stories were passed down through generations, teaching lessons about bravery, love, and morality. Traditional music and dance were integral to celebrations and rituals, often accompanied by indigenous instruments like the kulintang, gong, and kubing.\r\nDespite the absence of a unified government, pre-colonial Filipinos lived in organized societies with structured leadership, economies, and cultural traditions. Their way of life reflected their deep connection with nature, their adaptability, and their ability to sustain thriving communities long before colonial influence.', 'Beginner', 'History', 'admin/uploads/covers/680c54d8a1bb9_Pre-colonial Philippines.png', '2025-04-23 16:34:06', '2025-04-23 16:34:06', 22),
(23, 'States of Matter', 'Introduction\r\nMatter exists in various forms, commonly categorized into three primary states: solids, liquids, and gases. Each state is defined by distinct physical properties and particle arrangements:\r\n\r\nSolids - have a definite shape and volume due to closely packed particles.\r\nLiquids - have a definite volume but take the shape of their container, as their particles are less tightly packed than in solids.\r\nGases - lack a definite shape or volume, filling any container they\'re in because their particles are widely spaced and move freely.\r\nPlasma: The fourth state of matter, consisting of ionized gas with freely moving charged particles. Common examples include lightning, neon signs, and stars like the sun.\r\nMelting: The process where a solid absorbs heat and transitions into a liquid. For example, ice melting into water.\r\nFreezing: The reverse of melting; a liquid loses heat and becomes a solid, such as water freezing into ice.\r\nSublimation: A phase transition in which a substance changes directly from a solid to a gas without passing through the liquid phase. A common example of sublimation is dry ice (solid carbon dioxide) turning into carbon dioxide gas at room temperature. ​\r\nEvaporation: When a liquid gains sufficient energy, its particles can escape into the gas phase, like water evaporating into water vapor.\r\nDeposition: The phase transition in which a gas transforms directly into a solid without becoming a liquid. An example is the formation of frost, where water vapor turns into ice on a cold surface.\r\nCondensation: The process where gas particles lose energy and transition into a liquid state, evident when water vapor condenses into dew.', 'Beginner', 'Science', 'admin/uploads/covers/680c553dd5e1f_State of matter.png', '2025-04-23 16:42:38', '2025-04-23 16:42:38', 4),
(24, 'The Philippines during the Marcos Dictatorship', 'The period of Ferdinand Marcos\' dictatorship in the Philippines lasted from 1965 to 1986, with the most significant years occurring during the declaration of Martial Law (1972-1981). Marcos first became president in 1965 and was re-elected in 1969, becoming the first Philippine president to win a second term. However, during his rule, corruption and political instability increased, leading to his controversial declaration of Martial Law in 1972. This period was marked by government control over media, suppression of dissent, human rights abuses, and economic decline.\r\nThe Rise of Marcos and Martial Law (1965-1972)\r\nFerdinand Marcos became the 10th president of the Philippines after defeating Diosdado Macapagal in 1965. His administration initially focused on infrastructure projects, agriculture, and tourism, but his second term was marked by economic problems and rising protests from students and activists. To maintain control, Marcos declared Martial Law on September 21, 1972, citing the threat of communist insurgency and social unrest. Under Martial Law, the military arrested opposition leaders, controlled the press, and suppressed protests. Marcos ruled by decree, extending his presidency beyond the constitutional limit.\r\nHuman Rights Violations and Political Repression (1972-1981)\r\nDuring Martial Law, many Filipinos experienced political oppression and human rights violations. The military arrested activists, journalists, and political opponents, including Senator Benigno \"Ninoy\" Aquino Jr., who was jailed for opposing Marcos. Many people were tortured, disappeared, or killed. The media was also controlled by the government, with newspapers, radio stations, and television networks either shut down or taken over by Marcos\' allies. Despite the harsh conditions, resistance movements, including student groups and underground organizations, continued to fight against the dictatorship.\r\nEconomic Policies and the Debt Crisis\r\nAt first, Marcos promoted economic development by borrowing large amounts of money from foreign institutions. His administration built roads, bridges, hospitals, and the controversial Bataan Nuclear Power Plant, which never operated due to safety concerns. However, corruption and mismanagement led to an economic crisis. By the early 1980s, the Philippines had accumulated a massive foreign debt, causing inflation, job losses, and poverty. While some benefited from the economic policies, many Filipinos suffered due to unemployment and rising prices of goods.\r\nThe Assassination of Benigno Aquino Jr. and the Fall of Marcos (1983-1986)\r\nIn 1983, opposition leader Benigno Aquino Jr. was assassinated at the Manila International Airport upon returning from exile in the United States. His assassination sparked nationwide protests and exposed the corruption and brutality of the Marcos regime. The economy worsened, and Marcos lost the trust of many Filipinos.\r\nIn 1986, Marcos called for a snap election against Corazon Aquino, the widow of Ninoy Aquino. The election was marred by cheating and fraud, leading to the People Power Revolution on February 22-25, 1986. Millions of Filipinos gathered along EDSA (Epifanio de los Santos Avenue), demanding Marcos to step down. With pressure from both local and international forces, Marcos fled to Hawaii on February 25, 1986, marking the end of his dictatorship. Corazon Aquino then became the new president of the Philippines.\r\nThe Marcos dictatorship was one of the most controversial periods in Philippine history. While it brought infrastructure development, it was also marked by corruption, economic struggles, and human rights violations. The People Power Revolution remains a significant event, symbolizing the Filipino people\'s fight for democracy.', 'Beginner', 'History', 'admin/uploads/covers/680c54c2722fd_Philippines under Marcos dictatorship.png', '2025-04-23 16:43:39', '2025-04-23 16:43:39', 6),
(25, 'Basic Addition', 'Addition is the process of combining two or more numbers to get a total. You can think of it as \"putting things together.\"\r\n\r\nImagine you have a certain number of objects, and then you get more objects. To find out how many you have in total, you add them together.\r\n\r\nThe Parts of an Addition Problem:\r\n1. Addends: The numbers that you are adding together.\r\n2. Sum: The result or answer of the addition.\r\n\r\nHow to Add:\r\nLet’s say you have two numbers: 3 and 5.\r\n• You start with 3 (this is your first addend).\r\n• Then you add 5 (this is your second addend).\r\n• To get the total, you count forward from 3, five steps: \r\n3, 4, 5, 6, 7, 8.\r\nSo, 3 + 5 = 8.\r\nVisualizing Addition with Objects:\r\nIf you have 3 apples and then get 5 more apples:\r\n• Start with the 3 apples.\r\n• Add 5 more.\r\n• Count all the apples to find the total (3 + 5 = 8 apples).', 'Beginner', 'Mathematics', 'admin/uploads/covers/680c552da5de4_Basic Math.png', '2025-04-23 16:45:22', '2025-04-23 16:45:22', 12),
(26, 'Genetic Engineering', 'Introduction\r\nGenetic engineering is the direct manipulation of an organism\'s DNA to alter its characteristics in a specific way. This technology allows scientists to add, remove, or modify genetic material within an organism\'s genome, leading to applications in medicine, agriculture, and industry.\r\nDNA (Deoxyribonucleic Acid): The molecule that carries genetic instructions in living organisms.​ \r\nGene: A segment of DNA that contains the instructions for building a specific protein.​\r\nGenome: The complete set of genes or genetic material present in a cell or organism. \r\nRecombinant DNA (rDNA): DNA molecules formed by laboratory methods to bring together genetic material from multiple sources.​\r\nGenetically Modified Organism (GMO): An organism whose genetic material has been altered using genetic engineering techniques.​\r\nCRISPR-Cas9: A modern gene-editing tool that allows for precise, efficient modifications to DNA.\r\nKey Factors in Genetic Engineering\r\n1. Medical Applications\r\nGene Therapy: Treating genetic disorders by inserting healthy genes into a patient\'s cells.​\r\nPharmaceutical Production: Producing insulin, growth hormones, and vaccines using genetically engineered bacteria.​\r\n2. Agricultural Enhancements\r\nCrop Improvement: Developing crops resistant to pests, diseases, or environmental conditions.​\r\nNutritional Enhancement: Biofortification of crops, such as Golden Rice enriched with vitamin A.​\r\n3. Industrial Biotechnology\r\nEnzyme Production: Creating enzymes for use in detergents, food processing, and biofuels.​\r\nBioremediation: Using genetically engineered organisms to clean up environmental pollutants.​\r\nPioneers in Genetic Engineering\r\nPaul Berg: Created the first recombinant DNA molecules in 1972, combining DNA from different organisms.​ \r\nHerbert Boyer and Stanley Cohen: Developed techniques to insert recombinant DNA into bacteria, leading to the creation of GMOs in 1973.​ \r\nRudolf Jaenisch: Produced the first genetically modified animal, a mouse, in 1974.​ \r\nJennifer Doudna and Emmanuelle Charpentier: Developed the CRISPR-Cas9 gene-editing technology, revolutionizing genetic engineering.​\r\nBrief History of Genetic Engineering\r\n1972: Paul Berg constructs the first recombinant DNA molecules.​ \r\n1973: Boyer and Cohen successfully introduce recombinant DNA into bacteria.​ \r\n1974: Jaenisch creates the first genetically modified animal.​ \r\n1978: Genentech produces synthetic human insulin using genetically engineered bacteria.​ \r\n1994: The Flavr Savr tomato becomes the first genetically modified food approved for sale.​ \r\n2012: CRISPR-Cas9 is introduced as a groundbreaking gene-editing tool.', 'Intermediate', 'Science', 'admin/uploads/covers/680c551e510ce_Molecular Biology of Gene Expression.png', '2025-04-23 16:50:44', '2025-04-23 16:50:44', 4),
(27, 'The Philippines during the Marcos Dictatorship', 'The Marcos dictatorship, spanning from 1965 to 1986, was a period of political repression, economic mismanagement, and human rights abuses. While Ferdinand Marcos initially presented himself as a visionary leader dedicated to economic progress and national stability, his later years in power were characterized by authoritarian rule, corruption, and resistance from the Filipino people.\r\nThe Establishment of Martial Law (1972-1981)\r\nBy the late 1960s, Marcos’ government was struggling with economic instability and growing public dissatisfaction. The 1969 elections, which secured Marcos\' second term, were marred by allegations of vote-buying and election fraud. As protests escalated, Marcos responded by declaring Martial Law on September 21, 1972, through Proclamation No. 1081.\r\nUnder Martial Law:\r\nThe writ of habeas corpus was suspended, allowing the government to arrest individuals without due process.\r\nThe press was censored, with major news outlets either shut down or controlled by the state.\r\nPolitical opponents were arrested, including Benigno “Ninoy” Aquino Jr.\r\nThe military gained increased authority, enforcing strict curfews and suppressing demonstrations.\r\nThe 1973 Constitution was ratified through a questionable referendum, enabling Marcos to extend his rule beyond constitutional limits.\r\nDespite government claims of peace and order, this period saw widespread human rights violations. Reports from Amnesty International and other organizations detailed cases of torture, extrajudicial killings, and disappearances.\r\nEconomic Policies and the Rise of Crony Capitalism\r\nMarcos initially focused on infrastructure development, funding large-scale projects such as the San Juanico Bridge, Heart Center, and Cultural Center of the Philippines. These projects were financed by massive foreign loans, which led to a ballooning national debt.\r\nA key aspect of the Marcos economy was crony capitalism—a system in which economic power was concentrated in the hands of his close allies. These individuals, known as Marcos cronies, were granted monopolies in key industries, including:\r\nRoberto Benedicto – controlled the sugar industry\r\nDanding Cojuangco – had influence over coconut production\r\nJuan Ponce Enrile – dominated the logging industry\r\nWhile Marcos and his allies amassed great wealth, the economy suffered from high inflation, rising unemployment, and deteriorating public services. By the early 1980s, the country was burdened by over $26 billion in foreign debt, pushing the economy into crisis.\r\nThe Assassination of Benigno Aquino Jr. and the Growing Opposition\r\nOn August 21, 1983, opposition leader Benigno “Ninoy” Aquino Jr. was assassinated at the Manila International Airport (now Ninoy Aquino International Airport). Aquino, a vocal critic of Marcos, had spent years in exile in the United States before returning to the Philippines. His assassination became a turning point in Philippine history, fueling widespread protests and intensifying opposition to the dictatorship.\r\nThe assassination led to:\r\nA wave of mass protests under the Yellow Movement, led by Corazon Aquino.\r\nIncreased international pressure from the U.S. and other nations, questioning the legitimacy of Marcos\' rule.\r\nEconomic instability, as foreign investors pulled out, further weakening the Philippine economy.\r\nThe Snap Elections and the People Power Revolution\r\nFacing increasing opposition, Marcos called for a snap election on February 7, 1986, to prove his legitimacy. His opponent was Corazon Aquino, the widow of Ninoy Aquino. The elections, however, were marred by massive fraud, vote tampering, and intimidation. Despite official results declaring Marcos the winner, independent election observers and the Church-supported National Citizens’ Movement for Free Elections (NAMFREL) reported widespread electoral fraud.\r\nOn February 22-25, 1986, the People Power Revolution unfolded. Millions of Filipinos gathered on EDSA (Epifanio de los Santos Avenue) in a peaceful protest, calling for Marcos’ resignation. The military, led by Defense Minister Juan Ponce Enrile and AFP Vice Chief of Staff Fidel Ramos, defected from Marcos and joined the revolution.\r\nOn February 25, 1986, with mounting pressure, Marcos and his family fled to Hawaii, ending over two decades of dictatorship. Corazon Aquino was sworn in as the 11th President of the Philippines, marking the restoration of democracy.\r\nThe Marcos dictatorship was a defining period in Philippine history. While it began with promises of progress, it ended in economic collapse, human rights violations, and mass resistance. The People Power Revolution of 1986 remains a powerful symbol of the Filipino people’s resilience and commitment to democracy.', 'Intermediate', 'History', 'admin/uploads/covers/680c54adb9f75_Philippines under Marcos dictatorship.png', '2025-04-23 16:51:15', '2025-04-23 16:51:15', 2),
(28, 'The Japanese Empire Occupation to the Philippines', 'The Japanese occupation of the Philippines from 1941 to 1945 was one of the most challenging periods in the country’s history. The invasion began on December 8, 1941, just hours after the attack on Pearl Harbor. The Japanese military quickly overwhelmed American and Filipino forces, forcing them to retreat to the Bataan Peninsula and Corregidor. The fall of Bataan on April 9, 1942, led to the infamous Bataan Death March, where approximately 76,000 American and Filipino prisoners of war were forced to walk over 100 kilometers under brutal conditions, leading to thousands of deaths due to exhaustion, starvation, and execution.\r\nWith the fall of Corregidor on May 6, 1942, the Japanese solidified their control over the Philippines. They established a puppet government led by President José P. Laurel, who was forced to collaborate under Japanese rule. The Japanese sought to instill their ideology by suppressing American influence, banning English-language media, and promoting Japanese culture and language through education and propaganda. However, the Philippine resistance movement, composed of guerrilla fighters, fiercely opposed the occupation. These resistance fighters engaged in sabotage, intelligence gathering, and ambushes against the Japanese forces.\r\nEconomically, the occupation devastated the Philippines. The Japanese military seized resources, leading to widespread food shortages and inflation. The people were forced to use Japanese-issued currency, known as \"Mickey Mouse money,\" which quickly lost its value. Many Filipinos suffered from extreme hunger, and essential goods became scarce. Despite these hardships, underground movements provided aid and support to those in need.\r\nThe liberation of the Philippines began with the return of General Douglas MacArthur in October 1944. The Battle of Leyte Gulf, one of the largest naval battles in history, marked the beginning of the end for Japanese control. The fight for Manila in early 1945 resulted in massive destruction, with tens of thousands of civilians killed as the Japanese military refused to surrender. The city was left in ruins, and the Philippines faced immense post-war challenges.\r\nThe Japanese occupation officially ended on September 2, 1945, after Japan’s surrender following the atomic bombings of Hiroshima and Nagasaki. The Philippines, now freed, faced the difficult task of rebuilding and seeking justice for war crimes committed during the occupation. The war left deep scars on the nation, but it also strengthened Filipino nationalism and the determination to protect their independence.', 'Intermediate', 'History', 'admin/uploads/covers/680c5493be5f5_Philippines under Japanese Empire.png', '2025-04-23 16:56:04', '2025-04-23 16:56:04', 0),
(29, 'Basic Subtraction', 'Subtraction is the process of taking away a certain number from another number. It\'s like removing or \"taking away\" objects from a group. So, when you subtract, you’re trying to find out how many are left after something is taken away.\r\n\r\nThe Parts of a Subtraction Problem:\r\n1. Minuend: The number you\'re starting with (the total or the amount you have at first).\r\n2. Subtrahend: The number you\'re taking away (the amount to remove).\r\n3. Difference: The result or answer of the subtraction.\r\n\r\nHow to Subtract:\r\nLet’s say you have 8 apples and you give away 3 apples. To find out how many apples you have left, you subtract 3 from 8.\r\nYou can write it like this:\r\n8 - 3 = ?\r\n\r\nTo solve this:\r\n• Start with 8 apples.\r\n• Take away 3 apples.\r\n• Count how many are left: 8, 7, 6, 5.\r\n\r\nSo, 8 - 3 = 5.\r\nVisualizing Subtraction with Objects:\r\nIf you have 8 apples and give away 3, you’ll count how many apples are left:\r\n• Start with the 8 apples.\r\n• Remove 3 apples.\r\n• You’ll have 5 apples left.', 'Beginner', 'Mathematics', 'admin/uploads/covers/680c550651baf_Basic Math.png', '2025-04-23 16:59:53', '2025-04-23 16:59:53', 14),
(30, 'The Austronesians and the Polynesians', 'The Austronesians were among the most influential seafaring peoples in human history, navigating and settling vast oceanic distances. Their expansion, which began from Taiwan around 3000 BCE, resulted in the largest language family in the world, covering Southeast Asia, the Pacific Islands, and even parts of Africa, such as Madagascar. This expansion was not merely an act of migration but involved complex socio-political interactions, technological advancements, and environmental adaptations.\r\nOne of the most debated aspects of Austronesian migration is whether their movements were a result of population pressure, environmental shifts, or economic factors. Scholars propose that agricultural innovations, such as the domestication of taro, yams, and bananas, played a crucial role in sustaining large populations, which eventually led to expansion. Additionally, the use of outrigger canoes and double-hulled sailing vessels allowed them to navigate open waters with remarkable precision. The study of Lapita pottery, an archaeological marker of early Austronesian presence in the Pacific, suggests a highly organized trading network that facilitated cultural and technological exchanges across vast distances.\r\nWhen the Austronesians reached the Pacific, their societies diversified into distinct Polynesian, Micronesian, and Melanesian cultures. Polynesians, in particular, achieved an extraordinary feat of long-distance voyaging. Using knowledge of celestial navigation, ocean currents, and bird migration, Polynesians settled islands as far apart as Hawaii, New Zealand, and Easter Island, forming what is known as the Polynesian Triangle. Each society developed unique adaptations to its environment, as seen in the extensive taro irrigation systems in Hawaii, the massive stone statues (moai) of Easter Island, and the fortified hill settlements of New Zealand’s Māori.\r\nPolynesian social hierarchies were often structured around hereditary leadership, where chiefs (ariki) held divine status. Religious beliefs centered on animism and ancestor worship, with many societies maintaining strict taboo systems (kapu) that regulated behavior, resource use, and social interactions. The marae, sacred temple complexes found across Polynesia, functioned as religious, political, and social centers. Polynesian spirituality and governance were deeply intertwined, as chiefs derived legitimacy from their connection to the gods.\r\nDespite their advanced navigation skills, the eventual decline of Polynesian societies in some regions was caused by ecological overexploitation and resource depletion. Easter Island, for example, experienced deforestation and societal collapse due to unsustainable practices. These challenges demonstrate the fragile balance between human adaptation and environmental sustainability.\r\nModern Polynesian identity remains strong, with cultural revival movements emphasizing traditional navigation, language preservation, and indigenous governance structures. The reconstruction of Polynesian voyaging canoes, such as Hōkūleʻa, has reignited interest in the techniques that enabled the Austronesians to shape the history of the Pacific.', 'Advanced', 'History', 'admin/uploads/covers/680c547bc9d5d_Austronesian and Polynesian.png', '2025-04-23 17:01:38', '2025-04-23 17:01:38', 0),
(31, 'Nervous System', 'Introduction\r\nThe nervous system is the body\'s control center, coordinating actions and transmitting signals between different parts of the body. It enables organisms to respond to stimuli, maintain homeostasis, and perform complex functions.​\r\n\r\n1. Structural Divisions of the Nervous System\r\nThe nervous system is divided into two main parts:​NICHD\r\nCentral Nervous System (CNS): Comprises the brain and spinal cord. It processes information and coordinates activity throughout the body.​\r\nPeripheral Nervous System (PNS): Consists of all the nerves outside the CNS. It connects the CNS to limbs and organs.​\r\n2. Functional Divisions of the Peripheral Nervous System\r\nThe PNS is further divided based on function:​\r\nSomatic Nervous System: Controls voluntary movements via skeletal muscles.​\r\nAutonomic Nervous System: Regulates involuntary body functions like heartbeat and digestion.​\r\nSympathetic Nervous System: Prepares the body for \'fight or flight\' responses. \r\nParasympathetic Nervous System: Conserves energy and restores the body to a resting state.​\r\n3. Neurons and Their Components\r\nNeurons are the basic units of the nervous system, responsible for transmitting nerve impulses. Key components include:​\r\nDendrites: Branch-like structures that receive messages from other neurons.​\r\nAxon: The long projection that transmits electrical impulses away from the neuron\'s cell body.​\r\nSynapse: The junction between two neurons where nerve impulses are transmitted.​\r\nNeurotransmitters: Chemical substances that transmit signals across a synapse from one neuron to another.​\r\n4. Major Parts of the Brain\r\nThe brain is a complex organ with specialized regions:​\r\nCerebrum: Responsible for voluntary activities, intelligence, memory, and sensory processing.​\r\nCerebellum: Controls posture, balance, and coordination.​\r\nBrainstem: Connects the brain to the spinal cord and controls automatic functions such as breathing, digestion, heart rate, and blood pressure.​\r\n5. Spinal Cord\r\nThe spinal cord is a long, thin, tubular structure made up of nervous tissue, extending from the brainstem. It transmits neural signals between the brain and the rest of the body.​\r\n6. Physiological Concepts\r\nHomeostasis: The body\'s ability to maintain a stable internal environment despite changes in external conditions.​\r\nStimulus: A change in the environment that elicits a response from the body.​\r\nResponse: The body\'s reaction to a stimulus.​\r\nReflex: An automatic, involuntary response to a stimulus.', 'Advanced', 'Science', 'admin/uploads/covers/680c54636cbdc_Nervous system.png', '2025-04-23 17:01:56', '2025-04-23 17:01:56', 0),
(32, 'Algebra', 'Algebra is a branch of mathematics that deals with symbols and the rules for manipulating those symbols. The goal is to solve for unknown values (usually represented by letters like x, y, etc.). These unknowns are called variables.\r\nAlgebra helps you solve equations by finding the values that make the equation true. For example, an equation like x + 3 = 5 asks you to find the value of x that makes the equation true.\r\nBasic Concepts in Algebra:\r\nVariables: Letters like x, y, or z that represent unknown values.\r\nExample: In x + 2 = 5, x is the variable.\r\nExpressions: A combination of numbers, variables, and mathematical operations (addition, subtraction, multiplication, etc.) without an equal sign.\r\nExample: 3x + 2 is an expression, where x is the variable.\r\nEquations: A mathematical statement where two expressions are equal, usually involving variables.\r\nExample: x + 2 = 5 is an equation because it has an equal sign.\r\nSolving Equations: The process of finding the value of the variable that makes the equation true.\r\nExample: x + 2 = 5. To solve for x, subtract 2 from both sides to get x = 3.\r\nSteps to Solve Simple Algebraic Equations:\r\nIsolate the variable: Get the variable by itself on one side of the equation.\r\nPerform operations (addition, subtraction, multiplication, division) on both sides of the equation to maintain balance.\r\nCheck your solution: Plug the value of the variable back into the original equation to see if it makes the equation true.\r\nExample:\r\nSolve for x in the equation: 2x + 3 = 11\r\nStep 1: Subtract 3 from both sides.\r\n2x = 8\r\nStep 2: Divide both sides by 2.\r\nx = 4\r\nSo, the solution is x = 4.', 'Intermediate', 'Mathematics', 'admin/uploads/covers/680c54304bf83_Algebra.png', '2025-04-23 17:11:07', '2025-04-23 17:11:07', 14),
(33, 'Calculus', 'Calculus is a branch of mathematics that studies how things change. It is divided into two main areas:\r\n\r\nDifferential Calculus: Deals with rates of change and the slopes of curves. It focuses on how a function changes at a particular point.\r\nIntegral Calculus: Deals with the accumulation of quantities, such as finding areas under curves or total accumulated change.\r\n\r\nCalculus is extremely useful for understanding the world around us, from physics to economics to engineering.\r\n\r\nKey Concepts in Calculus\r\n1. Limits\r\nThe limit is the foundation of calculus. It describes the behavior of a function as it approaches a certain point.\r\n\r\nDefinition: The limit of a function f(x) as x approaches a value a is the value that f(x) gets closer to as x gets closer to a.\r\nExample:\r\nlim (x → 2) of (x² - 4) / (x - 2)\r\nAs x approaches 2, the value of the expression gets closer to 4. This is important because we use limits to define derivatives and integrals.\r\n\r\n2. Derivatives (Differential Calculus)\r\nA derivative represents the rate of change of a function. In simpler terms, it gives us the slope of the tangent line to a function at any given point.\r\nDefinition: The derivative of a function f(x) at a point x is the limit of the average rate of change of the function as the change in x approaches zero. This is written as:\r\nf\'(x) = lim (h → 0) [f(x + h) - f(x)] / h\r\nInterpretation: If you have a position-time graph, the derivative gives you the velocity at any given point in time.\r\nExample:\r\nIf f(x) = x², then the derivative f\'(x) = 2x. This tells us the slope of the function at any point x.\r\n\r\n3. Integrals (Integral Calculus)\r\nAn integral is essentially the opposite of a derivative. It is used to find areas, volumes, and other quantities that are accumulated over time or space.\r\nDefinite Integral: The integral of a function f(x) from a to b gives the area under the curve between those two points:\r\n∫[a, b] f(x) dx\r\nThis can be thought of as summing up tiny slices under the curve from x = a to x = b.\r\nIndefinite Integral: The indefinite integral, or antiderivative, gives us a general function whose derivative is the original function:\r\n∫ f(x) dx = F(x) + C\r\nWhere C is the constant of integration.\r\n\r\nKey Rules in Calculus:\r\n1. Power Rule for Derivatives:\r\nIf f(x) = x^n, then f\'(x) = n * x^(n-1).\r\n2. Sum Rule for Derivatives:\r\nIf f(x) = g(x) + h(x), then f\'(x) = g\'(x) + h\'(x).\r\n3. Product Rule for Derivatives:\r\nIf f(x) = g(x) * h(x), then f\'(x) = g\'(x) * h(x) + g(x) * h\'(x).\r\n4. Quotient Rule for Derivatives:\r\nIf f(x) = g(x) / h(x), then f\'(x) = (g\'(x) * h(x) - g(x) * h\'(x)) / h(x)^2.\r\n5. Basic Rules for Integrals:\r\nThe integral of x^n is x^(n+1)/(n+1).\r\nThe integral of e^x is e^x.\r\nThe integral of sin(x) is -cos(x).', 'Advanced', 'Mathematics', 'admin/uploads/covers/680c5451159b2_Calculus.png', '2025-04-23 17:23:11', '2025-04-23 17:23:11', 14),
(34, 'Parts of Speech', 'In English, words are classified into different categories known as parts of speech. Each part of speech serves a different function in a sentence, helping to form clear and grammatically correct statements. Understanding parts of speech is essential for building the foundation of any language, as it improves both written and spoken communication.\r\n\r\nThere are eight main parts of speech in English: noun, pronoun, verb, adjective, adverb, preposition, conjunction, and interjection. Each part of speech plays a specific role, which makes it easier to understand how sentences are constructed and how meaning is conveyed. This module will introduce each part of speech in simple terms, providing clear definitions and examples to ensure that even beginners can grasp the concepts. By the end of the lesson, you will be able to identify the different parts of speech in a sentence and apply this knowledge to your own writing and speaking.\r\n\r\n1. Noun\r\nA noun is a word that represents a person, place, thing, or idea. It is often the subject of a sentence and can be singular or plural. Common nouns include words like teacher, school, dog, and happiness. For example, in the sentence “The dog is sleeping,” the word dog is the noun, as it names a thing. Nouns can also be used as the object of a verb or preposition, such as in “I read a book,” where book is the object of the verb read.\r\n\r\n2. Pronoun\r\nA pronoun is used in place of a noun to avoid repetition. Instead of repeating a noun over and over in a sentence, we use pronouns to make the sentence flow more naturally. For instance, instead of saying “Maria is my friend. Maria is also smart,” we can say “Maria is my friend. She is also smart.” In this case, she is a pronoun that takes the place of the noun Maria. Other examples of pronouns include he, it, they, this, and who.\r\n\r\n3. Verb\r\nA verb expresses an action or a state of being. It is an essential part of any sentence because it tells what the subject is doing or what is happening. For example, in the sentence “She reads every day,” the word reads is a verb because it describes the action the subject (she) is performing. Verbs can also indicate a state of being, such as is, are, and was. For example, in the sentence “She is tired,” the word “is” is a verb that links the subject to its condition.\r\n\r\n4. Adjective\r\nAn adjective is a word that describes or modifies a noun or pronoun. It provides more detail about the thing or person being discussed. Adjectives help us give more information and make our language richer and more descriptive. For example, in the sentence “The green apple is on the table,” the word green is an adjective because it describes the noun apple. Other examples of adjectives include happy, cold, beautiful, and tall.\r\n\r\n5. Adverb\r\nAn adverb is a word that modifies or describes a verb, adjective, or even another adverb. It gives more information about how, when, where, or to what extent something happens. For example, in the sentence “She sings beautifully,” the word beautifully is an adverb because it tells us how she sings. Other examples of adverbs include quickly, very, often, and well. In the sentence “He runs very fast,” very modifies the adverb fast to show the degree of speed.\r\n\r\n6. Preposition\r\nA preposition is a word that shows the relationship between a noun (or pronoun) and another word in the sentence. It often indicates location, direction, time, or movement. For example, in the sentence “The cat is under the table,” the word under is a preposition that shows where the cat is in relation to the table. Common prepositions include in, on, at, under, beside, between, and during. Prepositions help clarify where or when something happens.\r\n\r\n7. Conjunction\r\nA conjunction is a word used to connect words, phrases, or clauses. It helps link ideas together, making sentences more coherent and easier to understand. Common conjunctions include and, but, or, so, and because. For example, in the sentence “I want to go swimming, but it’s raining,” the word \"but\" is a conjunction that connects two contrasting ideas. Conjunctions are essential for forming complex and compound sentences.\r\n\r\n8. Interjection\r\nAn interjection is a word or phrase that expresses a strong feeling or emotion. It is often followed by an exclamation mark and is typically used at the beginning of a sentence. Interjections are used to express surprise, excitement, joy, pain, or any other strong emotion. For example, in the sentence “Wow! That was an amazing performance,” the word Wow! is an interjection that conveys excitement. Other examples of interjections include ouch, hey, oh, and yikes.', 'Beginner', 'English', 'admin/uploads/covers/680c544368691_Parts of Speech.jpg', '2025-04-24 12:02:55', '2025-04-24 12:02:55', 32);

-- --------------------------------------------------------

--
-- Table structure for table `lesson_materials`
--

CREATE TABLE `lesson_materials` (
  `id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `material_type` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `option_text` text NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `question_id`, `option_text`, `is_correct`) VALUES
(62, 33, 'Venus', 0),
(63, 33, 'Mars', 1),
(64, 33, 'Jupiter', 0),
(65, 33, 'Mercury', 0),
(66, 34, 'Jupiter', 0),
(67, 34, 'Saturn', 1),
(68, 34, 'Uranus', 0),
(69, 34, 'Neptune', 0),
(70, 35, 'Mercury', 1),
(71, 35, 'Venus', 0),
(72, 35, 'Earth', 0),
(73, 35, 'Mars', 0),
(74, 36, 'Saturn', 0),
(75, 36, 'Jupiter', 1),
(76, 36, 'Neptune', 0),
(77, 36, 'Uranus', 0),
(78, 37, 'Neptune', 0),
(79, 37, 'Saturn', 0),
(80, 37, 'Uranus', 1),
(81, 37, 'Jupiter', 0),
(82, 38, 'Venus', 1),
(83, 38, 'Mars', 0),
(84, 38, 'Mercury', 0),
(85, 38, 'Neptune', 0),
(86, 39, 'Earth', 0),
(87, 39, 'Venus', 0),
(88, 39, 'Mars', 1),
(89, 39, 'Mercury', 0),
(90, 40, 'Jupiter', 0),
(91, 40, 'Saturn', 0),
(92, 40, 'Neptune', 1),
(93, 40, 'Mars', 0),
(94, 41, 'Uranus', 0),
(95, 41, 'Neptune', 1),
(96, 41, 'Saturn', 0),
(97, 41, 'Jupiter', 0),
(98, 42, 'Mercury', 1),
(99, 42, 'Venus', 0),
(100, 42, 'Mars', 0),
(101, 42, 'Neptune', 0),
(102, 43, 'Sultanates', 0),
(103, 43, 'Barangays', 1),
(104, 43, 'Pueblos', 0),
(105, 43, 'Colonies', 0),
(106, 44, 'Babaylan', 0),
(107, 44, 'Rajah', 0),
(108, 44, 'Datu', 1),
(109, 44, 'Gobernadorcillo', 0),
(110, 45, 'Maharlika', 0),
(111, 45, 'Timawa', 1),
(112, 45, 'Alipin', 0),
(113, 45, 'Maginoo', 0),
(114, 46, 'Irrigation', 0),
(115, 46, 'Crop rotation', 0),
(116, 46, 'Kaingin', 1),
(117, 46, 'Terrace farming', 0),
(118, 47, 'Manufacturing', 1),
(119, 47, 'Trading', 0),
(120, 47, 'Mining', 0),
(121, 47, 'Banking', 0),
(122, 48, 'Electronics and textiles', 0),
(123, 48, 'Spices, gold, and pearls', 1),
(124, 48, 'Weapons and livestock', 0),
(125, 48, 'Steel and machinery', 0),
(126, 49, 'Datu', 0),
(127, 49, 'Babaylan', 1),
(128, 49, 'Timawa', 0),
(129, 49, 'Alipin', 0),
(130, 50, 'Polytheism', 0),
(131, 50, 'Animism', 1),
(132, 50, 'Monotheism', 0),
(133, 50, 'Shamanism', 0),
(134, 51, 'Harana', 0),
(135, 51, 'Bigay-kaya', 1),
(136, 51, 'Paninilbihan', 0),
(137, 51, 'Pasalubong', 0),
(138, 52, 'Spanish law', 0),
(139, 52, 'Trial by ordeal', 1),
(140, 52, 'Roman law', 0),
(141, 52, 'Military rule', 0),
(142, 53, 'Teacher', 0),
(143, 53, 'Judge', 1),
(144, 53, 'Warrior', 0),
(145, 53, 'Priest', 0),
(146, 54, 'Liquid', 0),
(147, 54, 'Gas', 0),
(148, 54, 'Solid', 1),
(149, 54, 'Plasma', 0),
(150, 55, 'Solid', 0),
(151, 55, 'Liquid', 0),
(152, 55, 'Gas', 1),
(153, 55, 'Bose-Einstein Condensate', 0),
(154, 56, 'Condensation', 0),
(155, 56, 'Freezing', 0),
(156, 56, 'Sublimation', 1),
(157, 56, 'Deposition', 0),
(158, 57, 'Melting', 0),
(159, 57, 'Evaporation', 0),
(160, 57, 'Freezing', 1),
(161, 57, 'Condensation', 0),
(162, 58, 'They move slower and pack more closely.', 0),
(163, 58, 'They gain energy and move more freely.', 1),
(164, 58, 'They lose energy and become stationary.', 0),
(165, 58, 'They break apart into atoms.', 0),
(166, 59, 'Solid', 0),
(167, 59, 'Liquid', 1),
(168, 59, 'Gas', 0),
(169, 59, 'Plasma', 0),
(170, 60, 'Evaporation', 0),
(171, 60, 'Freezing', 0),
(172, 60, 'Condensation', 1),
(173, 60, 'Melting', 0),
(174, 61, 'Boiling', 0),
(175, 61, 'Evaporation', 1),
(176, 61, 'Condensation', 0),
(177, 61, 'Freezing', 0),
(178, 62, 'Solid', 0),
(179, 62, 'Liquid', 1),
(180, 62, 'Gas', 0),
(181, 62, 'Plasma', 0),
(182, 63, 'Melting', 0),
(183, 63, 'Freezing', 0),
(184, 63, 'Condensation', 0),
(185, 63, 'Deposition', 1),
(186, 64, 'Diosdado Macapagal', 0),
(187, 64, 'Ferdinand Marcos', 1),
(188, 64, 'Corazon Aquino', 0),
(189, 64, 'Ramon Magsaysay', 0),
(190, 65, '1965', 0),
(191, 65, '1969', 0),
(192, 65, '1972', 1),
(193, 65, '1986', 0),
(194, 66, 'To improve the economy', 0),
(195, 66, 'To stop the communist and rebel threats', 1),
(196, 66, 'To expand foreign relations', 0),
(197, 66, 'To promote tourism', 0),
(198, 67, 'Diosdado Macapagal', 0),
(199, 67, 'Corazon Aquino', 0),
(200, 67, 'Benigno &quot;Ninoy&quot; Aquino Jr.', 1),
(201, 67, 'Fidel Ramos', 0),
(202, 68, 'Katipunan Revolt', 0),
(203, 68, 'Cry of Pugad Lawin', 0),
(204, 68, 'People Power Revolution', 1),
(205, 68, 'Philippine-American War', 0),
(206, 69, '1972', 0),
(207, 69, '1981', 0),
(208, 69, '1983', 0),
(209, 69, '1986', 1),
(210, 70, 'Japan', 0),
(211, 70, 'United States', 0),
(212, 70, 'Hawaii', 1),
(213, 70, 'Singapore', 0),
(214, 71, 'Fidel Ramos', 0),
(215, 71, 'Corazon Aquino', 1),
(216, 71, 'Diosdado Macapagal', 0),
(217, 71, 'Benigno Aquino Jr.', 0),
(218, 72, 'Freedom of speech', 1),
(219, 72, 'Strict military rule and political repression', 0),
(220, 72, 'Increased democracy', 0),
(221, 72, 'More opportunities for activists', 0),
(222, 73, 'They supported Marcos', 0),
(223, 73, 'They wanted a stronger military rule', 0),
(224, 73, 'They valued democracy and unity', 1),
(225, 73, 'They were afraid to protest', 0),
(226, 74, 'Presidential Decree 1081', 1),
(227, 74, 'The 1935 Constitution', 0),
(228, 74, 'The Treaty of Paris', 0),
(229, 74, 'The Commonwealth Act', 0),
(230, 75, '14', 0),
(231, 75, '15', 0),
(232, 75, '16', 1),
(233, 75, '17', 0),
(234, 76, '8', 0),
(235, 76, '9', 1),
(236, 76, '10', 0),
(237, 76, '11', 0),
(238, 77, '14', 0),
(239, 77, '15', 1),
(240, 77, '16', 0),
(241, 77, '17', 0),
(242, 78, '18', 1),
(243, 78, '19', 0),
(244, 78, '20', 0),
(245, 78, '21', 0),
(246, 79, '10', 0),
(247, 79, '11', 1),
(248, 79, '12', 0),
(249, 79, '13', 0),
(250, 80, '14', 0),
(251, 80, '15', 0),
(252, 80, '16', 1),
(253, 80, '17', 0),
(254, 81, '8', 0),
(255, 81, '9', 1),
(256, 81, '10', 0),
(257, 81, '11', 0),
(258, 82, '14', 0),
(259, 82, '15', 1),
(260, 82, '16', 0),
(261, 82, '17', 0),
(262, 83, '18', 0),
(263, 83, '19', 0),
(264, 83, '20', 1),
(265, 83, '21', 0),
(266, 84, '10', 0),
(267, 84, '11', 1),
(268, 84, '12', 0),
(269, 84, '13', 0),
(270, 85, 'To observe natural selection in organisms', 0),
(271, 85, 'To directly modify an organism&#039;s DNA to alter its traits', 1),
(272, 85, 'To study the behavior of organisms in their natural habitats', 0),
(273, 85, 'To breed organisms selectively over generations', 0),
(274, 86, 'Deoxyribose Nucleic Acid', 1),
(275, 86, 'Deoxyribonucleic Acid', 0),
(276, 86, 'Dioxyribonucleic Acid', 0),
(277, 86, 'Deoxyribonuclear Acid', 0),
(278, 87, 'Genome', 0),
(279, 87, 'Gene', 1),
(280, 87, 'Chromosome', 0),
(281, 87, 'Nucleotide', 0),
(282, 88, 'An organism bred through traditional methods', 1),
(283, 88, 'An organism with naturally occurring mutations', 0),
(284, 88, 'An organism whose genetic material has been altered using genetic engineering techniques', 0),
(285, 88, 'An organism cloned from another', 0),
(286, 89, 'PCR', 0),
(287, 89, 'Gel electrophoresis', 0),
(288, 89, 'CRISPR-Cas9', 1),
(289, 89, 'DNA ligase', 0),
(290, 90, 'To clone human cells', 0),
(291, 90, 'To treat genetic disorders by inserting healthy genes into a patient&#039;s cells', 1),
(292, 90, 'To replace damaged tissues', 0),
(293, 90, 'To study gene expression patterns', 0),
(294, 91, 'Pest resistance', 0),
(295, 91, 'Nutritional enhancement', 1),
(296, 91, 'Drought tolerance', 0),
(297, 91, 'Increased yield', 0),
(298, 92, 'Herbert Boyer', 0),
(299, 92, 'Paul Berg', 1),
(300, 92, 'Stanley Cohen', 0),
(301, 92, 'Rudolf Jaenisch', 0),
(302, 93, '1984', 1),
(303, 93, '1988', 0),
(304, 93, '1994', 0),
(305, 93, '2000', 0),
(306, 94, 'The use of plants to improve soil fertility', 0),
(307, 94, 'The use of genetically engineered organisms to clean up environmental pollutants', 1),
(308, 94, 'The breeding of animals for specific traits', 0),
(309, 94, 'The process of cloning endangered species', 0),
(310, 95, 'Presidential Decree No. 27', 0),
(311, 95, 'Proclamation No. 1081', 1),
(312, 95, 'The 1973 Constitution', 0),
(313, 95, 'The Philippine Autonomy Act', 0),
(314, 96, 'The 1935 Constitution', 0),
(315, 96, 'The 1973 Constitution', 1),
(316, 96, 'The Treaty of Tordesillas', 0),
(317, 96, 'The Federalist Papers', 0),
(318, 97, 'Sugar', 1),
(319, 97, 'Oil', 0),
(320, 97, 'Automobiles', 0),
(321, 97, 'Space research', 0),
(322, 98, 'Diosdado Macapagal', 0),
(323, 98, 'Fidel Ramos', 0),
(324, 98, 'Benigno “Ninoy” Aquino Jr.', 1),
(325, 98, 'Imelda Marcos', 0),
(326, 99, 'COMELEC', 0),
(327, 99, 'NAMFREL', 1),
(328, 99, 'ASEAN', 0),
(329, 99, 'OPEC', 0),
(330, 100, 'Plaza Miranda', 0),
(331, 100, 'Luneta Park', 0),
(332, 100, 'EDSA', 1),
(333, 100, 'Intramuros', 0),
(334, 101, 'December 7, 1941', 0),
(335, 101, 'December 8, 1941', 1),
(336, 101, 'January 2, 1942', 0),
(337, 101, 'February 5, 1942', 0),
(338, 102, 'The Bataan Trail', 0),
(339, 102, 'The Death March of Luzon', 0),
(340, 102, 'The Bataan Death March', 1),
(341, 102, 'The March of the Fallen', 0),
(342, 103, 'Mindoro', 0),
(343, 103, 'Corregidor', 1),
(344, 103, 'Leyte', 0),
(345, 103, 'Palawan', 0),
(346, 104, 'The Katipunan', 0),
(347, 104, 'The Makapili', 1),
(348, 104, 'The Hukbalahap', 0),
(349, 104, 'The Guerrilla Fighters', 0),
(350, 105, 'He remained president', 0),
(351, 105, 'He was executed', 0),
(352, 105, 'He was imprisoned but later granted amnesty', 1),
(353, 105, 'He fled to Japan', 0),
(354, 106, 'The Philippines became a territory of Japan', 0),
(355, 106, 'Filipinos became more supportive of colonial rule', 0),
(356, 106, 'It strengthened Filipino nationalism and the push for independence', 1),
(357, 106, 'The Philippines adopted Japanese as its official language', 0),
(358, 107, '7', 0),
(359, 107, '8', 0),
(360, 107, '9', 1),
(361, 107, '10', 0),
(362, 108, '14', 0),
(363, 108, '15', 0),
(364, 108, '16', 1),
(365, 108, '17', 0),
(366, 109, '7', 0),
(367, 109, '8', 1),
(368, 109, '9', 0),
(369, 109, '10', 0),
(370, 110, '10', 0),
(371, 110, '11', 1),
(372, 110, '12', 0),
(373, 110, '13', 0),
(374, 111, '7', 0),
(375, 111, '8', 1),
(376, 111, '9', 0),
(377, 111, '10', 0),
(378, 112, '7', 0),
(379, 112, '8', 0),
(380, 112, '9', 1),
(381, 112, '10', 0),
(382, 113, '14', 0),
(383, 113, '15', 0),
(384, 113, '16', 1),
(385, 113, '17', 0),
(386, 114, '7', 0),
(387, 114, '8', 1),
(388, 114, '9', 0),
(389, 114, '10', 0),
(390, 115, '10', 0),
(391, 115, '11', 1),
(392, 115, '12', 0),
(393, 115, '13', 0),
(394, 116, '7', 0),
(395, 116, '8', 1),
(396, 116, '9', 0),
(397, 116, '10', 0),
(398, 117, 'Shell tools', 0),
(399, 117, 'Lapita pottery', 1),
(400, 117, 'Stone statues', 0),
(401, 117, 'Bamboo scripts', 0),
(402, 118, 'Waʻa', 0),
(403, 118, 'Outrigger', 0),
(404, 118, 'Koru', 0),
(405, 118, 'Vaka', 1),
(406, 119, 'Hawaiians', 0),
(407, 119, 'Māori', 0),
(408, 119, 'Rapa Nui (Easter Island)', 1),
(409, 119, 'Chamorro', 0),
(410, 120, 'Marae', 1),
(411, 120, 'Totem', 0),
(412, 120, 'Ziggurat', 0),
(413, 120, 'Pagoda', 0),
(414, 121, 'Hawaii', 0),
(415, 121, 'New Zealand', 1),
(416, 121, 'Fiji', 0),
(417, 121, 'Tonga', 0),
(418, 122, 'Marble', 0),
(419, 122, 'Basalt', 0),
(420, 122, 'Volcanic tuff', 1),
(421, 122, 'Limestone', 0),
(422, 123, 'Glial cell', 0),
(423, 123, 'Meninges', 0),
(424, 123, 'Neuron', 1),
(425, 123, 'Cerebrospinal fluid', 0),
(426, 124, 'Peripheral Nervous System', 0),
(427, 124, 'Central Nervous System', 1),
(428, 124, 'Autonomic Nervous System', 0),
(429, 124, 'Somatic Nervous System', 0),
(430, 125, 'Autonomic Nervous System', 0),
(431, 125, 'Somatic Nervous System', 1),
(432, 125, 'Sympathetic Nervous System', 0),
(433, 125, 'Parasympathetic Nervous System', 0),
(434, 126, 'Axon', 0),
(435, 126, 'Dendrite', 1),
(436, 126, 'Synapse', 0),
(437, 126, 'Neurotransmitter', 0),
(438, 127, 'Axon', 0),
(439, 127, 'Dendrite', 0),
(440, 127, 'Synapse', 1),
(441, 127, 'Node of Ranvier', 0),
(442, 128, 'Cerebellum', 0),
(443, 128, 'Brainstem', 0),
(444, 128, 'Cerebrum', 1),
(445, 128, 'Spinal Cord', 0),
(446, 129, 'Somatic Nervous System', 0),
(447, 129, 'Sympathetic Nervous System', 1),
(448, 129, 'Parasympathetic Nervous System', 0),
(449, 129, 'Central Nervous System', 0),
(450, 130, 'Reflex', 0),
(451, 130, 'Stimulus', 0),
(452, 130, 'Response', 0),
(453, 130, 'Homeostasis', 1),
(454, 131, 'Voluntary action', 0),
(455, 131, 'Conscious response', 0),
(456, 131, 'Reflex', 1),
(457, 131, 'Deliberate movement', 0),
(458, 132, 'Dendrite', 0),
(459, 132, 'Axon', 1),
(460, 132, 'Synapse', 0),
(461, 132, 'Nucleus', 0),
(462, 133, '6', 0),
(463, 133, '7', 0),
(464, 133, '8', 1),
(465, 133, '9', 0),
(466, 134, '7', 1),
(467, 134, '6', 0),
(468, 134, '8', 0),
(469, 134, '5', 0),
(470, 135, '11', 0),
(471, 135, '12', 0),
(472, 135, '14', 1),
(473, 135, '15', 0),
(474, 136, '4', 0),
(475, 136, '5', 0),
(476, 136, '6', 1),
(477, 136, '7', 0),
(478, 137, '10', 0),
(479, 137, '12', 1),
(480, 137, '15', 0),
(481, 137, '7', 0),
(482, 138, '3', 1),
(483, 138, '4', 0),
(484, 138, '5', 0),
(485, 138, '6', 0),
(486, 139, '4', 1),
(487, 139, '5', 0),
(488, 139, '6', 0),
(489, 139, '7', 0),
(490, 140, '4', 0),
(491, 140, '5', 1),
(492, 140, '6', 0),
(493, 140, '7', 0),
(494, 141, '18', 0),
(495, 141, '27', 1),
(496, 141, '30', 0),
(497, 141, '24', 0),
(498, 142, '5', 0),
(499, 142, '4', 1),
(500, 142, '6', 0),
(501, 142, '7', 0),
(502, 143, '3x²', 1),
(503, 143, 'x²', 0),
(504, 143, '3x', 0),
(505, 143, '2x³', 0),
(506, 144, '5x³/3', 1),
(507, 144, '5x³', 0),
(508, 144, '10x²', 0),
(509, 144, '5x', 0),
(510, 145, 'cos(x)', 1),
(511, 145, '-cos(x)', 0),
(512, 145, '-sin(x)', 0),
(513, 145, 'sin(x)', 0),
(514, 146, 'x³', 0),
(515, 146, 'x³ + C', 1),
(516, 146, '3x³/3', 0),
(517, 146, 'x³/3 + C', 0),
(518, 147, '16x³ + 4x', 1),
(519, 147, '16x³ + 2x', 0),
(520, 147, '12x³ + 2x²', 0),
(521, 147, '12x³ + 4x²', 0),
(522, 148, '7x²/2', 1),
(523, 148, '7x²', 0),
(524, 148, '7x² + C', 0),
(525, 148, '7x + C', 0),
(526, 149, 'e^x', 1),
(527, 149, 'x', 0),
(528, 149, 'e', 0),
(529, 149, '1/x', 0),
(530, 150, 'sin(x)', 1),
(531, 150, '-sin(x)', 0),
(532, 150, 'cos(x)', 0),
(533, 150, '-cos(x)', 0),
(534, 151, '4x³ + 6x', 1),
(535, 151, '4x³ + 6x²', 0),
(536, 151, '3x³ + 6x', 0),
(537, 151, '4x³ + 3x²', 0),
(538, 152, '3x² + C', 1),
(539, 152, '6x²', 0),
(540, 152, '3x²', 0),
(541, 152, '6x² + C', 0),
(542, 153, 'Noun', 0),
(543, 153, 'Pronoun', 0),
(544, 153, 'Verb', 1),
(545, 153, 'Adjective', 0),
(546, 154, 'Noun', 1),
(547, 154, 'Adverb', 0),
(548, 154, 'Pronoun', 0),
(549, 154, 'Preposition', 0),
(550, 155, 'Verb', 0),
(551, 155, 'Adjective', 1),
(552, 155, 'Preposition', 0),
(553, 155, 'Interjection', 0),
(554, 156, 'Verb', 0),
(555, 156, 'Interjection', 1),
(556, 156, 'Conjunction', 0),
(557, 156, 'Adjective', 0),
(558, 157, 'Preposition', 0),
(559, 157, 'Adverb', 1),
(560, 157, 'Noun', 0),
(561, 157, 'Conjunction', 0),
(562, 158, 'Adjective', 0),
(563, 158, 'Verb', 0),
(564, 158, 'Preposition', 1),
(565, 158, 'Pronoun', 0),
(566, 159, 'Pronoun', 1),
(567, 159, 'Noun', 0),
(568, 159, 'Verb', 0),
(569, 159, 'Adjective', 0),
(570, 160, 'Conjunction', 1),
(571, 160, 'Pronoun', 0),
(572, 160, 'Verb', 0),
(573, 160, 'Adverb', 0),
(574, 161, 'Verb', 1),
(575, 161, 'Noun', 0),
(576, 161, 'Adjective', 0),
(577, 161, 'Preposition', 0),
(578, 162, 'Verb', 0),
(579, 162, 'Interjection', 1),
(580, 162, 'Noun', 0),
(581, 162, 'Pronoun', 0);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `question_type` varchar(50) NOT NULL,
  `points` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `quiz_id`, `question_text`, `question_type`, `points`, `created_at`) VALUES
(33, 15, 'Which planet is known as the Red Planet?​', 'multiple-choice', 1, '2025-04-23 16:27:57'),
(34, 15, 'Which planet has the most prominent ring system?​', 'multiple-choice', 1, '2025-04-23 16:27:57'),
(35, 15, 'Which planet is closest to the Sun?​', 'multiple-choice', 1, '2025-04-23 16:27:57'),
(36, 15, 'Which planet is known for its Great Red Spot?​', 'multiple-choice', 1, '2025-04-23 16:27:57'),
(37, 15, 'Which planet is tilted on its side, leading to extreme seasonal variations?​', 'multiple-choice', 1, '2025-04-23 16:27:57'),
(38, 15, 'Which planet is similar in size to Earth but has a toxic atmosphere and extremely high surface temperatures?​', 'multiple-choice', 1, '2025-04-23 16:27:57'),
(39, 15, 'Which planet has the largest volcano and canyon in the solar system?​', 'multiple-choice', 1, '2025-04-23 16:27:57'),
(40, 15, 'Which planet is primarily composed of heavier elements and compounds like water, methane, and ammonia?​', 'multiple-choice', 1, '2025-04-23 16:27:57'),
(41, 15, 'Which planet is known for its strong winds and deep blue color?​', 'multiple-choice', 1, '2025-04-23 16:27:57'),
(42, 15, 'Which planet has no moons?​', 'multiple-choice', 1, '2025-04-23 16:27:57'),
(43, 16, 'What were early Filipino communities called?', 'multiple-choice', 1, '2025-04-23 16:34:06'),
(44, 16, 'Who led a barangay in pre-colonial Philippines?', 'multiple-choice', 1, '2025-04-23 16:34:06'),
(45, 16, 'What was the lowest social class in pre-colonial society?', 'multiple-choice', 1, '2025-04-23 16:34:06'),
(46, 16, 'Which farming method involved clearing land by burning vegetation?', 'multiple-choice', 1, '2025-04-23 16:34:06'),
(47, 16, 'What was the main livelihood of early Filipinos aside from farming?', 'multiple-choice', 1, '2025-04-23 16:34:06'),
(48, 16, 'What did early Filipinos trade with foreign merchants?', 'multiple-choice', 1, '2025-04-23 16:34:06'),
(49, 16, 'Who were the spiritual leaders who performed rituals and healing practices?', 'multiple-choice', 1, '2025-04-23 16:34:06'),
(50, 16, 'What is the belief that spirits reside in natural objects?', 'multiple-choice', 1, '2025-04-23 16:34:06'),
(51, 16, 'What was the term for the dowry given in marriage?', 'multiple-choice', 1, '2025-04-23 16:34:06'),
(52, 16, 'What type of justice system did pre-colonial Filipinos follow?', 'multiple-choice', 1, '2025-04-23 16:34:06'),
(53, 16, 'What was the role of the datu aside from being a leader?', 'multiple-choice', 1, '2025-04-23 16:34:06'),
(54, 17, 'Which state of matter has a definite shape and volume?​', 'multiple-choice', 1, '2025-04-23 16:42:38'),
(55, 17, 'In which state do particles move freely and fill the entire volume of their container?​', 'multiple-choice', 1, '2025-04-23 16:42:38'),
(56, 17, 'What is the process called when a solid turns directly into a gas?​', 'multiple-choice', 1, '2025-04-23 16:42:38'),
(57, 17, 'Which phase change involves a liquid becoming a solid?​', 'multiple-choice', 1, '2025-04-23 16:42:38'),
(58, 17, 'What happens to the particles in a substance during melting?​', 'multiple-choice', 1, '2025-04-23 16:42:38'),
(59, 17, 'Which state of matter is characterized by particles that are close together but can move past one another?​', 'multiple-choice', 1, '2025-04-23 16:42:38'),
(60, 17, 'What is the term for the phase change from gas to liquid?​', 'multiple-choice', 1, '2025-04-23 16:42:38'),
(61, 17, 'During which process does a liquid change into a gas at its surface?​', 'multiple-choice', 1, '2025-04-23 16:42:38'),
(62, 17, 'Which state of matter has an indefinite shape but a definite volume?​', 'multiple-choice', 1, '2025-04-23 16:42:38'),
(63, 17, 'What is the reverse process of sublimation, where a gas turns directly into a solid?​', 'multiple-choice', 1, '2025-04-23 16:42:38'),
(64, 18, 'Who was the president of the Philippines during the dictatorship period?', 'multiple-choice', 1, '2025-04-23 16:43:39'),
(65, 18, 'In what year did Marcos declare Martial Law?', 'multiple-choice', 1, '2025-04-23 16:43:39'),
(66, 18, 'What was the main reason Marcos gave for declaring Martial Law?', 'multiple-choice', 1, '2025-04-23 16:43:39'),
(67, 18, 'Who was the opposition leader assassinated in 1983?', 'multiple-choice', 1, '2025-04-23 16:43:39'),
(68, 18, 'What was the name of the peaceful protest movement that removed Marcos from power?', 'multiple-choice', 1, '2025-04-23 16:43:39'),
(69, 18, 'In what year did Marcos flee the Philippines?', 'multiple-choice', 1, '2025-04-23 16:43:39'),
(70, 18, 'Where did Marcos go after leaving the Philippines?', 'multiple-choice', 1, '2025-04-23 16:43:39'),
(71, 18, 'Who became president after Marcos was removed?', 'multiple-choice', 1, '2025-04-23 16:43:39'),
(72, 18, 'What was a key characteristic of Martial Law?', 'multiple-choice', 1, '2025-04-23 16:43:39'),
(73, 18, 'What did the People Power Revolution show about Filipinos?', 'multiple-choice', 1, '2025-04-23 16:43:39'),
(74, 18, 'What law allowed Marcos to rule by decree during Martial Law?', 'multiple-choice', 1, '2025-04-23 16:43:39'),
(75, 19, '9 + 7 = ?', 'multiple-choice', 1, '2025-04-23 16:45:22'),
(76, 19, '3 + 6 = ?', 'multiple-choice', 1, '2025-04-23 16:45:22'),
(77, 19, '5 + 10 = ?', 'multiple-choice', 1, '2025-04-23 16:45:22'),
(78, 19, '8 + 12 = ?', 'multiple-choice', 1, '2025-04-23 16:45:22'),
(79, 19, '6 + 5 = ?', 'multiple-choice', 1, '2025-04-23 16:45:22'),
(80, 19, '9 + 7 = ?', 'multiple-choice', 1, '2025-04-23 16:45:22'),
(81, 19, '3 + 6 = ?', 'multiple-choice', 1, '2025-04-23 16:45:22'),
(82, 19, '5 + 10 = ?', 'multiple-choice', 1, '2025-04-23 16:45:22'),
(83, 19, '8 + 12 = ?', 'multiple-choice', 1, '2025-04-23 16:45:22'),
(84, 19, '6 + 5 = ?', 'multiple-choice', 1, '2025-04-23 16:45:22'),
(85, 20, 'What is the primary goal of genetic engineering?', 'multiple-choice', 1, '2025-04-23 16:50:44'),
(86, 20, 'What does DNA stand for?', 'multiple-choice', 1, '2025-04-23 16:50:44'),
(87, 20, 'Which term describes a segment of DNA that codes for a specific protein?', 'multiple-choice', 1, '2025-04-23 16:50:44'),
(88, 20, 'What is a Genetically Modified Organism (GMO)?', 'multiple-choice', 1, '2025-04-23 16:50:44'),
(89, 20, 'Which tool allows scientists to make precise edits to DNA sequences?', 'multiple-choice', 1, '2025-04-23 16:50:44'),
(90, 20, 'What is the purpose of gene therapy in medicine?', 'multiple-choice', 1, '2025-04-23 16:50:44'),
(91, 20, 'Golden Rice is an example of which application of genetic engineering?', 'multiple-choice', 1, '2025-04-23 16:50:44'),
(92, 20, 'Who created the first recombinant DNA molecules in 1972?', 'multiple-choice', 1, '2025-04-23 16:50:44'),
(93, 20, 'In which year was the Flavr Savr tomato, the first genetically modified food approved for sale, introduced?', 'multiple-choice', 1, '2025-04-23 16:50:44'),
(94, 20, 'What is bioremediation?', 'multiple-choice', 1, '2025-04-23 16:50:44'),
(95, 21, 'What law allowed Marcos to declare Martial Law in 1972?', 'multiple-choice', 1, '2025-04-23 16:51:15'),
(96, 21, 'What constitutional change allowed Marcos to remain in power beyond the two-term limit?', 'multiple-choice', 1, '2025-04-23 16:51:15'),
(97, 21, 'Which of the following industries was controlled by Marcos&#039; cronies?', 'multiple-choice', 1, '2025-04-23 16:51:15'),
(98, 21, 'Who was assassinated in 1983, leading to widespread protests?', 'multiple-choice', 1, '2025-04-23 16:51:15'),
(99, 21, 'Which organization monitored the 1986 snap elections and reported fraud?', 'multiple-choice', 1, '2025-04-23 16:51:15'),
(100, 21, 'Where did the People Power Revolution take place?', 'multiple-choice', 1, '2025-04-23 16:51:15'),
(101, 22, 'When did the Japanese invasion of the Philippines begin?', 'multiple-choice', 1, '2025-04-23 16:56:04'),
(102, 22, 'What was the name of the forced march of American and Filipino prisoners of war after the fall of Bataan?', 'multiple-choice', 1, '2025-04-23 16:56:04'),
(103, 22, 'Which island stronghold fell to the Japanese on May 6, 1942, marking their full control of the Philippines?', 'multiple-choice', 1, '2025-04-23 16:56:04'),
(104, 22, 'What was the name of the Filipino collaborators who supported the Japanese?', 'multiple-choice', 1, '2025-04-23 16:56:04'),
(105, 22, 'What happened to José P. Laurel after the war?', 'multiple-choice', 1, '2025-04-23 16:56:04'),
(106, 22, 'What was one lasting effect of the Japanese occupation on the Philippines?', 'multiple-choice', 1, '2025-04-23 16:56:04'),
(107, 23, '18 - 9 = ?', 'multiple-choice', 1, '2025-04-23 16:59:53'),
(108, 23, '20 - 4 = ?', 'multiple-choice', 1, '2025-04-23 16:59:53'),
(109, 23, '11 - 3 = ?', 'multiple-choice', 1, '2025-04-23 16:59:53'),
(110, 23, '17 - 6 = ?', 'multiple-choice', 1, '2025-04-23 16:59:53'),
(111, 23, '13 - 5 = ?', 'multiple-choice', 1, '2025-04-23 16:59:53'),
(112, 23, '18 - 9 = ?', 'multiple-choice', 1, '2025-04-23 16:59:53'),
(113, 23, '20 - 4 = ?', 'multiple-choice', 1, '2025-04-23 16:59:53'),
(114, 23, '11 - 3 = ?', 'multiple-choice', 1, '2025-04-23 16:59:53'),
(115, 23, '17 - 6 = ?', 'multiple-choice', 1, '2025-04-23 16:59:53'),
(116, 23, '13 - 5 = ?', 'multiple-choice', 1, '2025-04-23 16:59:53'),
(117, 24, 'What archaeological evidence is considered a key marker of early Austronesian expansion into the Pacific?', 'multiple-choice', 1, '2025-04-23 17:01:38'),
(118, 24, 'What is the Polynesian term for the traditional double-hulled canoe used in oceanic voyages?', 'multiple-choice', 1, '2025-04-23 17:01:38'),
(119, 24, 'Which Polynesian society is known for constructing massive stone statues called moai?', 'multiple-choice', 1, '2025-04-23 17:01:38'),
(120, 24, 'What is the name of the sacred Polynesian temple structures used for religious ceremonies?', 'multiple-choice', 1, '2025-04-23 17:01:38'),
(121, 24, 'Which island was the last major Polynesian settlement before European contact?', 'multiple-choice', 1, '2025-04-23 17:01:38'),
(122, 24, 'What type of stone was used to carve the moai statues on Easter Island?', 'multiple-choice', 1, '2025-04-23 17:01:38'),
(123, 25, 'What is the basic unit of the nervous system?', 'multiple-choice', 1, '2025-04-23 17:01:56'),
(124, 25, 'Which part of the nervous system comprises the brain and spinal cord?', 'multiple-choice', 1, '2025-04-23 17:01:56'),
(125, 25, 'Which division of the Peripheral Nervous System controls voluntary movements?', 'multiple-choice', 1, '2025-04-23 17:01:56'),
(126, 25, 'Which structure of a neuron receives messages from other neurons?', 'multiple-choice', 1, '2025-04-23 17:01:56'),
(127, 25, 'What is the junction between two neurons where nerve impulses are transmitted?', 'multiple-choice', 1, '2025-04-23 17:01:56'),
(128, 25, 'Which part of the brain is responsible for voluntary activities, intelligence, memory, and sensory processing?', 'multiple-choice', 1, '2025-04-23 17:01:56'),
(129, 25, 'Which subdivision of the Autonomic Nervous System prepares the body for &#039;fight or flight&#039; responses?', 'multiple-choice', 1, '2025-04-23 17:01:56'),
(130, 25, 'What term describes the body&#039;s ability to maintain a stable internal environment?', 'multiple-choice', 1, '2025-04-23 17:01:56'),
(131, 25, 'What is an automatic, involuntary response to a stimulus called?', 'multiple-choice', 1, '2025-04-23 17:01:56'),
(132, 25, 'Which part of the neuron transmits electrical impulses away from the cell body?', 'multiple-choice', 1, '2025-04-23 17:01:56'),
(133, 26, 'Solve for x:\r\nx + 7 = 15', 'multiple-choice', 1, '2025-04-23 17:11:07'),
(134, 26, 'Solve for x:\r\n2x - 5 = 9', 'multiple-choice', 1, '2025-04-23 17:11:07'),
(135, 26, 'Solve for y:\r\ny - 4 = 10', 'multiple-choice', 1, '2025-04-23 17:11:07'),
(136, 26, 'Solve for x:\r\n3x = 18', 'multiple-choice', 1, '2025-04-23 17:11:07'),
(137, 26, 'Solve for x:\r\nx/4 = 3', 'multiple-choice', 1, '2025-04-23 17:11:07'),
(138, 26, 'Solve for x:\r\n5x + 2 = 17', 'multiple-choice', 1, '2025-04-23 17:11:07'),
(139, 26, 'Solve for x:\r\n4x - 6 = 10', 'multiple-choice', 1, '2025-04-23 17:11:07'),
(140, 26, 'Solve for y:\r\n3y + 5 = 20', 'multiple-choice', 1, '2025-04-23 17:11:07'),
(141, 26, 'Solve for x:\r\nx/3 = 9', 'multiple-choice', 1, '2025-04-23 17:11:07'),
(142, 26, 'Solve for x:\r\n2(x + 3) = 14', 'multiple-choice', 1, '2025-04-23 17:11:07'),
(143, 27, 'What is the derivative of f(x) = x³?', 'multiple-choice', 1, '2025-04-23 17:23:11'),
(144, 27, 'Find the integral of f(x) = 5x².', 'multiple-choice', 1, '2025-04-23 17:23:11'),
(145, 27, 'What is the derivative of f(x) = sin(x)?', 'multiple-choice', 1, '2025-04-23 17:23:11'),
(146, 27, 'What is the integral of f(x) = 3x²?', 'multiple-choice', 1, '2025-04-23 17:23:11'),
(147, 27, 'Find the derivative of f(x) = 4x⁴ + 2x².', 'multiple-choice', 1, '2025-04-23 17:23:11'),
(148, 27, 'What is the integral of f(x) = 7x?', 'multiple-choice', 1, '2025-04-23 17:23:11'),
(149, 27, 'Find the derivative of f(x) = e^x.', 'multiple-choice', 1, '2025-04-23 17:23:11'),
(150, 27, 'What is the integral of f(x) = cos(x)?', 'multiple-choice', 1, '2025-04-23 17:23:11'),
(151, 27, 'What is the derivative of f(x) = x⁴ + 3x²?', 'multiple-choice', 1, '2025-04-23 17:23:11'),
(152, 27, 'Find the integral of f(x) = 6x.', 'multiple-choice', 1, '2025-04-23 17:23:11'),
(153, 28, 'She runs every morning.', 'multiple-choice', 1, '2025-04-24 12:02:55'),
(154, 28, 'I saw a cat on the roof.', 'multiple-choice', 1, '2025-04-24 12:02:55'),
(155, 28, 'He is a funny person.', 'multiple-choice', 1, '2025-04-24 12:02:55'),
(156, 28, 'Wow! You did great!', 'multiple-choice', 1, '2025-04-24 12:02:55'),
(157, 28, 'The kids played outside.', 'multiple-choice', 1, '2025-04-24 12:02:55'),
(158, 28, 'The book is on the table.', 'multiple-choice', 1, '2025-04-24 12:02:55'),
(159, 28, 'He went to the store.', 'multiple-choice', 1, '2025-04-24 12:02:55'),
(160, 28, 'I like both pizza and pasta.', 'multiple-choice', 1, '2025-04-24 12:02:55'),
(161, 28, 'The big house is on the hill.', 'multiple-choice', 1, '2025-04-24 12:02:55'),
(162, 28, 'Ouch! That hurts.', 'multiple-choice', 1, '2025-04-24 12:02:55');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `total_points` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `lesson_id`, `title`, `description`, `total_points`, `created_at`) VALUES
(15, 21, 'The Solar System', 'This is the quiz for Beginner\'s \"The Solar System\"', 10, '2025-04-23 16:27:57'),
(16, 22, 'Pre-colonial Philippines', 'Pre-colonial Philippines Quiz for beginners', 11, '2025-04-23 16:34:06'),
(17, 23, 'States of Matter', 'Beginner quiz for States of Matter', 10, '2025-04-23 16:42:38'),
(18, 24, 'The Philippines during the Marcos Dictatorship', 'Quiz for beginners', 11, '2025-04-23 16:43:39'),
(19, 25, 'Basic Addition Quiz#1', 'This quiz is designed to help students practice and strengthen their basic addition skills. Learners will solve simple addition problems using numbers typically under 20. The quiz includes real-life scenarios and visual examples to make learning engaging and easy to understand. Great for early learners, beginners, or anyone wanting to refresh their addition knowledge!', 10, '2025-04-23 16:45:22'),
(20, 26, 'Genetic Engineering', 'Intermediate Quiz for Genetic Engineering', 10, '2025-04-23 16:50:44'),
(21, 27, 'The Philippines during the Marcos Dictatorship', 'Intermediate Quiz', 6, '2025-04-23 16:51:15'),
(22, 28, 'The Japanese Empire Occupation to the Philippines', 'Quiz for Intermediate', 6, '2025-04-23 16:56:04'),
(23, 29, 'Basic Subtraction Quiz#1', 'This short 10-question quiz is designed to help students practice basic subtraction in a fun and simple way. It includes easy-to-understand problems that focus on taking away numbers and finding how many are left. A great tool for young learners or beginners to build confidence with subtraction!', 10, '2025-04-23 16:59:53'),
(24, 30, 'The Austronesians and the Polynesians', 'Quiz for Advanced Learners', 6, '2025-04-23 17:01:38'),
(25, 31, 'Nervous System', 'Advanced Quiz for Nervous system', 10, '2025-04-23 17:01:56'),
(26, 32, 'Algebra #1', 'This quiz is designed to test your understanding of fundamental algebraic concepts. You will encounter questions covering variables, expressions, equations, and the steps to solve simple algebraic problems. It includes a mix of multiple-choice and short-answer questions to help you practice isolating variables and solving equations accurately.\r\n\r\nBy completing this quiz, you\'ll reinforce your knowledge of:\r\n\r\nIdentifying variables in equations\r\n\r\nRecognizing algebraic expressions\r\n\r\nUnderstanding the structure of equations\r\n\r\nApplying step-by-step methods to solve for unknown values\r\n\r\nTarget Audience:\r\nStudents beginning their journey into algebra or anyone needing a refresher on basic algebraic techniques.\r\n\r\nRecommended Prerequisites:\r\nBasic arithmetic (addition, subtraction, multiplication, and division).', 10, '2025-04-23 17:11:07'),
(27, 33, 'Calculus #1', 'This quiz will test your understanding of the core principles of Calculus, including limits, derivatives, and integrals. Designed for beginners or students reviewing the basics, this quiz includes conceptual and practical questions covering both Differential and Integral Calculus. You\'ll practice applying rules like the Power Rule, Product Rule, and evaluate simple limits and integrals.\r\n\r\nBy taking this quiz, you\'ll strengthen your knowledge of:\r\n\r\nThe concept and application of limits\r\n\r\nFinding the derivative of algebraic functions\r\n\r\nApplying integration techniques to compute areas and antiderivatives\r\n\r\nKey calculus rules and their use in solving real-world problems\r\n\r\nTarget Audience:\r\nStudents new to Calculus, those preparing for exams, or anyone who wants to review foundational calculus concepts.\r\n\r\nRecommended Prerequisites:\r\nA good grasp of algebra and functions.', 10, '2025-04-23 17:23:11'),
(28, 34, 'Parts of Speech', 'Beginner Quiz for Parts of Speech', 10, '2025-04-24 12:02:55'),
(29, 34, 'a', 'a', 0, '2025-04-28 03:40:13');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_attempts`
--

CREATE TABLE `quiz_attempts` (
  `id` int(11) NOT NULL,
  `user_email` varchar(120) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `total_questions` int(11) NOT NULL,
  `source` varchar(20) NOT NULL,
  `subject` varchar(64) NOT NULL,
  `content_id` int(11) DEFAULT NULL,
  `date_completed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quiz_attempts`
--

INSERT INTO `quiz_attempts` (`id`, `user_email`, `quiz_id`, `score`, `total_questions`, `source`, `subject`, `content_id`, `date_completed`) VALUES
(60, 'kjgquilatis00@gmail.com', 15, 0, 10, 'read', 'Science', 1, '2025-04-24 11:42:46'),
(61, 'mangilog.lloyd.bigot1@gmail.com', 53, 1, 5, 'video', 'History', 63, '2025-04-24 12:24:33'),
(62, 'mangilog.lloyd.bigot1@gmail.com', 18, 0, 11, 'read', 'History', 1, '2025-04-24 12:26:40'),
(63, 'zephyr.fika@gmail.com', 54, 2, 4, 'video', 'Science', 64, '2025-04-24 13:21:24'),
(64, 'defrostref@gmail.com', 19, 9, 10, 'read', 'Mathematics', 1, '2025-04-24 17:45:24'),
(65, 'sison.axcel.sagun@gmail.com', 57, 1, 5, 'video', 'Science', 67, '2025-04-24 19:03:01'),
(66, 'angelotebrero01@gmail.com', 60, 2, 4, 'video', 'English', 70, '2025-04-25 01:58:08'),
(67, 'kquilatis05@gmail.com', 53, 2, 5, 'video', 'History', 63, '2025-04-25 02:40:33'),
(68, 'josexyrus@gmail.com', 16, 4, 11, 'read', 'History', 1, '2025-04-25 04:03:48'),
(69, 'josexyrus@gmail.com', 27, 0, 10, 'read', 'Mathematics', 1, '2025-04-25 04:05:15'),
(70, 'josexyrus@gmail.com', 27, 0, 10, 'read', 'Mathematics', 1, '2025-04-25 04:05:15'),
(71, 'ernestdenila@gmail.com', 60, 0, 4, 'video', 'English', 70, '2025-04-25 16:05:42'),
(72, 'ernestdenila@gmail.com', 60, 1, 4, 'video', 'English', 70, '2025-04-25 16:09:27'),
(73, 'ernestdenila@gmail.com', 19, 9, 10, 'read', 'Mathematics', 1, '2025-04-25 16:19:30'),
(74, 'jpasspc090@gmail.com', 60, 0, 4, 'video', 'English', 70, '2025-04-26 01:11:27'),
(75, 'jpasspc090@gmail.com', 60, 3, 4, 'video', 'English', 70, '2025-04-26 01:12:23'),
(76, 'jpasspc090@gmail.com', 59, 5, 6, 'video', 'Mathematics', 69, '2025-04-26 01:14:27'),
(77, 'imlanderbose@gmail.com', 19, 7, 10, 'read', 'Mathematics', 25, '2025-04-26 03:40:51'),
(78, 'imlanderbose@gmail.com', 23, 9, 10, 'read', 'Mathematics', 29, '2025-04-26 03:43:31'),
(79, 'imlanderbose@gmail.com', 26, 9, 10, 'read', 'Mathematics', 32, '2025-04-26 03:45:34'),
(80, 'renzmatthewy@gmail.com', 23, 10, 10, 'read', 'Mathematics', 29, '2025-04-26 03:46:30'),
(81, 'renzmatthewy@gmail.com', 28, 3, 10, 'read', 'English', 34, '2025-04-26 03:48:39'),
(82, 'renzmatthewy@gmail.com', 17, 0, 10, 'read', 'Science', 23, '2025-04-26 03:49:41'),
(83, 'rosswellacabo2004@gmail.com', 59, 5, 6, 'video', 'Mathematics', 69, '2025-04-26 04:04:38'),
(84, 'roden.belgera17@gmail.com', 23, 10, 10, 'read', 'Mathematics', 29, '2025-04-26 04:10:45'),
(85, 'afilomino@gmail.com', 60, 1, 4, 'video', 'English', 70, '2025-04-26 04:44:47'),
(86, 'emilbose.eb@gmail.com', 15, 4, 10, 'read', 'Science', 21, '2025-04-26 04:49:00'),
(87, 'afilomino@gmail.com', 60, 1, 4, 'video', 'English', 70, '2025-04-26 04:59:46'),
(88, 'kjgquilatis00@gmail.com', 16, 7, 11, 'read', 'History', 22, '2025-04-26 10:38:17'),
(89, 'kjgquilatis00@gmail.com', 19, 9, 10, 'read', 'Mathematics', 25, '2025-04-26 10:42:31'),
(90, 'pogikotalaga@gmail.com', 59, 5, 6, 'video', 'Mathematics', 69, '2025-04-26 10:45:02'),
(91, 'pogikotalaga@gmail.com', 59, 5, 6, 'video', 'Mathematics', 69, '2025-04-26 10:45:38'),
(92, 'kjgquilatis00@gmail.com', 27, 4, 10, 'read', 'Mathematics', 33, '2025-04-26 10:46:30'),
(93, 'guzmanaceace@gmail.com', 60, 0, 4, 'video', 'English', 70, '2025-04-26 11:07:53'),
(94, 'flores.clarencekyle.manrique@gmail.com', 15, 2, 10, 'read', 'Science', 21, '2025-04-26 15:20:12'),
(95, 'jojifork69@gmail.com', 60, 0, 4, 'video', 'English', 70, '2025-04-27 05:34:20'),
(96, 'intertasmico@gmail.com', 58, 1, 4, 'video', 'Science', 68, '2025-04-27 06:00:42'),
(97, 'jojifork69@gmail.com', 60, 0, 4, 'video', 'English', 70, '2025-04-27 06:02:01'),
(98, 'jojifork69@gmail.com', 63, 8, 8, 'video', 'Mathematics', 73, '2025-04-27 06:03:47'),
(99, 'jojifork69@gmail.com', 59, 5, 6, 'video', 'Mathematics', 69, '2025-04-27 06:07:46'),
(100, 'jojifork69@gmail.com', 26, 4, 10, 'read', 'Mathematics', 32, '2025-04-27 06:10:59'),
(101, 'gilojohnlloydgierza@gmail.com', 59, 5, 6, 'video', 'Mathematics', 69, '2025-04-27 07:33:52'),
(102, 'gilojohnlloydgierza@gmail.com', 26, 3, 10, 'read', 'Mathematics', 32, '2025-04-27 07:35:46'),
(103, 'flores.clarencekyle.manrique@gmail.com', 15, 5, 10, 'read', 'Science', 21, '2025-04-28 02:09:35'),
(104, 'renzmatthewy@gmail.com', 60, 2, 4, 'video', 'English', 70, '2025-04-28 02:31:34'),
(105, 'flores.clarencekyle.manrique@gmail.com', 27, 3, 10, 'read', 'Mathematics', 33, '2025-04-28 03:24:40');

-- --------------------------------------------------------

--
-- Table structure for table `recommendations`
--

CREATE TABLE `recommendations` (
  `id` int(11) NOT NULL,
  `user_email` varchar(150) NOT NULL,
  `content_type` varchar(20) NOT NULL,
  `content_id` int(11) NOT NULL,
  `priority` int(11) DEFAULT 3,
  `is_viewed` tinyint(1) DEFAULT 0,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(120) NOT NULL,
  `first_name` varchar(64) NOT NULL,
  `last_name` varchar(64) NOT NULL,
  `password_hash` varchar(256) DEFAULT NULL,
  `profile_image` varchar(256) DEFAULT NULL,
  `date_registered` datetime DEFAULT current_timestamp(),
  `last_login` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `username` varchar(250) NOT NULL,
  `age` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `first_name`, `last_name`, `password_hash`, `profile_image`, `date_registered`, `last_login`, `is_active`, `username`, `age`) VALUES
(11, 'clarencekylemanriqueflores@gmail.com', 'Clarence', 'Flores', '$2y$10$rgK1gNDSKPne4qKFgeS5neyjflZUCtJdzy4yK9YbbXKUN.CANH0/i', 'https://lh3.googleusercontent.com/a/ACg8ocJ5oqYITmzLbqs7nqITZQl5hUTnhoWOcprU98ixq0KQG7NfWZE=s96-c', '2025-04-23 16:04:27', NULL, 1, 'Clarence', 22),
(12, 'renzmatthew.ybamit@gmail.com', 'Renz', 'Matthew', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocJt4TxgotofiNBXpG-cSSAjik-s0-m8UFjgt08oC9Igp2GOQA=s96-c', '2025-04-23 16:07:59', NULL, 1, '', 0),
(13, 'renzmatthewy@gmail.com', 'Ybamit,', 'Renz', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocJd7o_68L0FhczQm8yIiQ0mY-9OSd5-XYuSXLAzUOa_tg5KUMXF=s96-c', '2025-04-23 17:02:01', NULL, 1, '', 0),
(14, 'pogikotalaga@gmail.com', 'PogiKo', 'Talaga', '$2y$10$rwEoLF8SSUo.BhRtvYMi/ek26qswXKWBZLt8R3hfcEq5tMMe10nDS', NULL, '2025-04-23 17:29:20', NULL, 1, 'Yolo', 25),
(15, 'imlanderbose@gmail.com', 'Lan', 'Durr', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocIUrZs5uKSxESWINQdvJo0EjKL2XqxqB_WQVkNXJ1al2yv7f2c=s96-c', '2025-04-23 17:31:45', NULL, 1, '', 0),
(16, 'bose.johnlander.guingab@gmail.com', 'Bose,', 'John', '$2y$10$Sbw7g79n2NS6wsQySXg9iedh3EBtYruDNp55Qt/vlCusRGmZCygv.', 'https://lh3.googleusercontent.com/a/ACg8ocJ1oqdtL57AhShMMQRIvUPb4m0CAaz9aZr2hM4OjijX6QRA-Npk=s96-c', '2025-04-23 23:03:48', NULL, 1, 'Der', 60),
(17, 'felomino.amelyn.basence@gmail.com', 'Felomino,', 'Amelyn,', '$2y$10$BgEdN8awKjPtuLRBqGewae19C9J4/9e5CuH/lrs9xRWnC0mgnuR0G', 'https://lh3.googleusercontent.com/a/ACg8ocKvR3hu3S9Jz7FoTzU6fqRFkA3OTALOWNTXdYAiBRGL7ogtQwGz=s96-c', '2025-04-24 11:33:16', NULL, 1, 'Ame', 21),
(18, 'kjgquilatis00@gmail.com', 'KJ', 'Q', '$2y$10$jyaLT/yQTKSec6FTJBWbE.R10dYSwb5jsgM2UCwCywbfkaxWxpHRK', NULL, '2025-04-24 11:33:40', NULL, 1, 'KJ', 21),
(19, 'flores.clarencekyle.manrique@gmail.com', 'Flores,', 'Clarence', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocJSWoINvgM1XcwkQt1HEyt9MDHGhlFvowlTcPnj-eFTBCuxb7CV=s96-c', '2025-04-24 11:53:44', NULL, 1, '', 0),
(20, 'junielcardenas9@gmail.com', 'Juniel', 'Cardenas', '$2y$10$qMeYcxnjI455kDqi9MlRjObzJWr2f9MDXx95WSG0OVihImXPDruZu', NULL, '2025-04-24 11:58:16', NULL, 1, 'Juniii', 22),
(21, 'Aoiii.yukii@gmail.com', 'Yuks', 'Aoi', '$2y$10$PA3KD6THAd3BNONhU7hKIepUskJe/H65qdeh38TQIzu5xBhvYobay', NULL, '2025-04-24 12:02:55', NULL, 1, 'Aoi', 20),
(22, 'richmondhomo18@gmail.com', 'Richmond', 'Homo', '$2y$10$nbLgMa/0sUnvIoa6cd7IDOCtLbT0rKEZ.TaoB6/443hRWvgIFFGN.', NULL, '2025-04-24 12:10:51', NULL, 1, 'tsuki_1', 21),
(23, 'mangilog.lloyd.bigot1@gmail.com', 'Mangilog,', 'Lloyd', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocInh3mM5bzDtml8jXvxC1RIjF1ZKSmSjgwM1N8enuyU06Z0T3IV=s96-c', '2025-04-24 12:22:04', NULL, 1, '', 0),
(24, 'belugasolano@gmail.com', 'Lloyd', 'Mangilog', '$2y$10$CQ/L5hEzJmlPrJzV81TQUu.g31azaHBDEEWkryeq3TXSWqtn76KEq', NULL, '2025-04-24 12:32:35', NULL, 1, 'mitchbading', 22),
(25, 'hipolitoangelaquino@gmail.com', 'Hipolito,', 'Angel', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocLjXrU6FMXoiw7scTD206J1uIITy2RybXpLCkuBy_WMTPBIzxU=s96-c', '2025-04-24 13:07:43', NULL, 1, '', 0),
(26, 'zephyr.fika@gmail.com', 'Zephyr', '', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocLpvPR0TQO-7V60Q9o9s9Q0yUj7Vl9JLVYylPNBT-NkUMyvaOw=s96-c', '2025-04-24 13:20:16', NULL, 1, '', 0),
(27, 'cortezandreim014@gmail.com', 'Andrei', 'Cortez', '$2y$10$xQaImfea/wN2P1oV9K7gYO0yFDHx7dCwmjeefQ64jhwXpIPtH0Dg.', NULL, '2025-04-24 13:23:10', NULL, 1, 'andreic', 21),
(28, 'tanginamojepoydizon@gmail.com', 'Tanginamo', 'Jepoy Dizon', '$2y$10$9INpVEhHqjFbtKrBuL1Ex.Tc9xmxFVRfDzMqqTwZh9CenxyEnbTgG', NULL, '2025-04-24 15:10:41', NULL, 1, 'tanginamo', 2147483647),
(29, 'emaas.jhonmar.granada@gmail.com', 'Emaas,', 'Jhonmar', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocKD8uaQpi6Cru73-UcQqlLtYVwzP-vbR0AEA17JL5a0k3o59CU=s96-c', '2025-04-24 15:47:16', NULL, 1, '', 0),
(30, 'defrostref@gmail.com', 'def', 'frost', '$2y$10$.bCw2gI5SgR.Ztcfge4pp.NtHgA1AOBtYfjn9kA0r4KYCuuXz2ASe', NULL, '2025-04-24 16:32:08', NULL, 1, 'ref', 21),
(31, 'hocit23266@raymatc.com', 'Papap', 'Dol', '$2y$10$FC6odAmQgPwSitjn9r74luScq0jUhLu.1pHYopj6P3UGrRbw6g23C', NULL, '2025-04-24 18:14:21', NULL, 1, 'Papapdol', 23),
(32, 'sison.axcel.sagun@gmail.com', 'Sison,', 'Axcel', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocKhAv1vUwkY4XFYTYBjWb84Px2Z3pTVE4jr188qvyA5AlmmmLA=s96-c', '2025-04-24 19:01:31', NULL, 1, '', 0),
(33, 'ryan.casipe78@gmail.com', 'ryan', 'casipe', '$2y$10$w6Z.LM2j5jh/w3CM4RmXPuvk5PLEd9slUk2yAyrjs6eE.3LR/ws8G', NULL, '2025-04-24 22:17:09', NULL, 1, 'nyar', 21),
(34, 'liezel.gecelengineering0114@gmail.com', 'Liezel', 'Peralta', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocKDBzpXzqK4_7JYj5jykuJOtdKisqtHOIWfCZ7VRozS8S1_nLK9=s96-c', '2025-04-25 01:19:58', NULL, 1, '', 0),
(35, 'angelotebrero01@gmail.com', 'Angelo', 'Tebrero', '$2y$10$F0kBlKoZQjr2T5IUKWpC4u8F3ESiRzOwSnKGfMKCpNJa.b3c.N7Cq', NULL, '2025-04-25 01:56:32', NULL, 1, 'angelotebrero01@gmail.com', 22),
(36, 'aces05816@gmail.com', 'Ace', 'Yanae', '$2y$10$5R86XwqmHrqHaXl0U7vilebsszAxuTQK5916oM5D50w6EEkMjzEJq', NULL, '2025-04-25 02:11:09', NULL, 1, 'Ace', 20),
(37, 'kquilatis05@gmail.com', 'Quilatis,', 'Katherine', NULL, 'https://lh3.googleusercontent.com/a-/ALV-UjWTrfNaNvGifrwPl1pZneq7BfZak1IQ65cw7C2Gr3LhNegLwkTgjMWAXBYb9SUdiju81oB2Kh_iCrYkAZWaXp0QCEqZi4VBMldjzThDvObMRZK9O7n7iAnJVuvt-dYG1eRNPs__06awt5sIcqdTPDQYJi0ywktMkxoz1g_hz-8MxllRd9anv5lovrAH0-CZQ0J2gH2nC4WwyXCck54GmWE', '2025-04-25 02:37:51', NULL, 1, '', 0),
(38, 'albiso.chaddaeniel.luib@gmail.com', 'Chad', 'Daeniel', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocJ6ZEnJpRqzK46fvweFPRUKGMHTqL0vkqJz3oHovKjJyqe-gqed=s96-c', '2025-04-25 02:50:02', NULL, 1, '', 0),
(39, 'josexyrus@gmail.com', 'Xyrus', 'Waje', '$2y$10$Dl1aKL2MIxvWeUnjqKJkFuwfxYe6DbiUN7.7nLaYIupsL7e8aTbca', NULL, '2025-04-25 04:01:36', NULL, 1, 'Xyciee', 24),
(40, 'tan.heannamenoella.rebolledo@gmail.com', 'Heanna', 'Tan', '$2y$10$rmQ2felBfaVEz1I7F3/gOeT66oyH2fuM971g1puIUHAxEW5U/SdNa', NULL, '2025-04-25 04:59:19', NULL, 1, 'tan.heannamenoella.rebolledo', 20),
(41, 'nathlegaspi9@gmail.com', 'Nath', 'Lee', '$2y$10$LJuPP8DY618MQ9TFB2W52egJFFm7wu3KJ0rukNcZ1SzzMbDKsUzKC', NULL, '2025-04-25 05:03:04', NULL, 1, 'Nath', 20),
(42, 'longaquitgabrielle@gmail.com', 'Gabrielle', 'Longaquit', '$2y$10$sMCloRTBUKo9Q57/taOiYO00Y.wBqSllTeTg9cIyFfIKud/N8cdAS', NULL, '2025-04-25 05:24:41', NULL, 1, 'Gabrielle', 15),
(43, 'marknelzonjamolin@gmail.com', 'Mark', 'Jamolin', '$2y$10$VGw15PCkFA0xdhEoUMu5He7Sk/oTR3DYfBgH8mJ6zOUv4qb06484W', NULL, '2025-04-25 06:04:01', NULL, 1, 'ampoginigulpe', 22),
(44, 'villamora.ivanren.manguiat@gmail.com', 'Ivan Ren', 'Villamora', '$2y$10$Sxg81KpC4j4seW/Ec7BhY.cgmfwFMSaZAH/0d2gUx5kBTw3PMj4Tq', NULL, '2025-04-25 06:30:23', NULL, 1, 'ivanren13', 21),
(45, 'zhanekim17@gmail.com', 'Zhane', 'Kim', '$2y$10$HHMZP3LMiyT6N/P.sfa7NOCJS.o2Hu7MeaIwfXy0Bw9kftEU8kozy', NULL, '2025-04-25 06:41:00', NULL, 1, 'Zhane', 22),
(46, 'javier.lancekenneth.barberan@gmail.com', 'Lance Kenneth', 'Javier', '$2y$10$5MyeQiJ1RdxwqAMzNUGZDOG30m/.U31Mqfc98ArgytIu/XklE6TiO', NULL, '2025-04-25 06:43:44', NULL, 1, 'Aztec', 20),
(47, 'ernestdenila@gmail.com', 'Ernest', 'Denila', '$2y$10$1Jfs80.nHikqz./70uRinuRCYwJvcI2CTkky6LB7y7sxZ5xdsdgLa', NULL, '2025-04-25 15:55:53', NULL, 1, 'Denden', 20),
(48, 'keithikalina@gmail.com', 'Ket', 'Russ', '$2y$10$VxUqhGP2ildxmwWTA8evJe5cXtpmNmW6ncp1ge8pBBpe.VWB/sZP.', NULL, '2025-04-25 20:31:43', NULL, 1, 'AEROSMITH', 21),
(49, 'kuroakari666@gmail.com', 'Sam', 'Sam', '$2y$10$h3Besu7NoIY5g7IW.tUQxuZkGPT7k4KBfgexPG6gWzLZpKUFf5NbG', NULL, '2025-04-26 00:59:49', NULL, 1, 'pos602', 23),
(50, 'jpasspc090@gmail.com', 'Kim', 'Delilah', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocIRzDd0wJzsRxnapmH7taztCkcvL1ADbkYJFLdKoL1yi-BHPw=s96-c', '2025-04-26 01:06:36', NULL, 1, '', 0),
(51, 'laquinto202@gmail.com', 'Lara', 'Quinto', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocL-3X_9pZOyvgOiB5L3qV7ZBr9wuoPeXFHWOswAAA-Wqiup8A=s96-c', '2025-04-26 01:10:16', NULL, 1, '', 0),
(52, 'judgedread14@gmail.com', 'Reginald', 'Flores', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocKz3NGNcHMb5BlZ4U6swOjm490QdSjM4QeO-tVJVhc3dfX75vmT=s96-c', '2025-04-26 01:17:49', NULL, 1, '', 0),
(53, 'jepoydizon@gmail.com', 'PUTANGINAMO', 'JEPOY DIZON', '$2y$10$spCT3ghZTIY5rOOF14YY4eNeTx6VssU9C0xX4Co6ngVE4WbL3LaP2', NULL, '2025-04-26 02:28:34', NULL, 1, 'Tanginamo', 199),
(54, 'rosswellacabo2004@gmail.com', 'Rosswell', 'Acabo', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocKy4I400Zt9saX9qPARrF2QvLy8qqMRSKhW861xu_pJevYaFOw-=s96-c', '2025-04-26 04:03:22', NULL, 1, '', 0),
(55, 'roden.belgera17@gmail.com', 'Den', 'Don', '$2y$10$Qvvpk5rz8lF1455bBStg5e/3Ah3aCO9hUr9dhJm7/XvjfFHjwOyaO', NULL, '2025-04-26 04:09:09', NULL, 1, 'Admin214', 0),
(56, 'tumaliuan.kelvin.alegrid@gmail.com', 'Tumaliuan,', 'Kelvin', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocJ58wK8RvDWoxSOlWsJ3ulJkiE6RGJw0viQJwv7f6OLwWXzs8aF=s96-c', '2025-04-26 04:11:02', NULL, 1, '', 0),
(57, 'kupal.king@gmail.com', 'kupal', 'kupalking', '$2y$10$C1aTBgG3TA2R6QY7bb5O/O2DmwoCL7T.mREA.at0z6pR/YXmqi2CO', NULL, '2025-04-26 04:11:06', NULL, 1, 'kupalking', 0),
(58, 'afilomino@gmail.com', 'Amelia', 'Perualila', '$2y$10$2iCETnMgihgnmR1cW4QJIOlY7/eZ.9UXsSqDf6ecn0nVsJGhMnGB.', NULL, '2025-04-26 04:38:20', NULL, 1, 'Amelia', 0),
(59, 'emilbose.eb@gmail.com', 'Emil', 'Bose', '$2y$10$uY1re1iPlCSKjplexKFZ3unfRfiae2Tf6RQbf.9K0UG7jiB/kBMrq', NULL, '2025-04-26 04:46:01', NULL, 1, 'ebose', 0),
(60, 'grevusoipellu-7568@yopmail.com', 'ziegfrid', 'gualberto', '$2y$10$/ksgAO0zD0FrThUoflmmYesM5SI8eg3ShZ.EoLqG2fq/k0iTEFEPq', NULL, '2025-04-26 05:28:19', NULL, 1, 'zngualberto', 0),
(61, 'rosales4682.jr@gmail.com', 'John', 'Rey', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocJN1KN36n3QwzTth3c5Icvrn8ZRRinzBYPry2UGaA6zpyxbHtE=s96-c', '2025-04-26 08:00:08', NULL, 1, '', 0),
(62, 'hahaha@gmail.com', 'kupal', 'mema', '$2y$10$43cO.KespGON/JJIjN.jvOj9W8ocoAUvDf5hHplk11TXQV6WxMrpW', NULL, '2025-04-26 08:32:01', NULL, 1, 'hahaha', 0),
(63, 'inobio.johnaebrix.nanquil1@gmail.com', 'jai', 'inobio', '$2y$10$yq/C846/NfAV0knSsiPSde2ORhicgHly.Eh2E.p9vKf8ZYOiGCCB.', NULL, '2025-04-26 10:16:12', NULL, 1, 'jayiii', 0),
(64, 'guzmanaceace@gmail.com', 'Angelo', 'Ace', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocJPuvzVf0w0l9c618KNw13zMvvWl_BxdgXjeodhAD7bQIbL0AdT=s96-c', '2025-04-26 11:06:04', NULL, 1, '', 0),
(65, 'jahaddaisu@gmail.com', 'Jahad', 'Daisu', '$2y$10$1.zEs9.kwWy/yJT4.IH2EebwrHfFbWyhihNYI92.3Am0QNaTpVIAi', NULL, '2025-04-26 14:05:12', NULL, 1, 'jahad_45', 0),
(66, 'gracedeocaris@gmail.com', 'Deocaris,', 'Grace', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocKryXtwZEhJqjuVVJtP-4XyZvWw3m8OeRrMxTKa_CRE3JAqebs6=s96-c', '2025-04-26 14:43:07', NULL, 1, '', 0),
(67, 'jaysantos@gmail.com', 'jay', 'Santos', '$2y$10$fDh2gM0ItywoxysXo3ku0eB2.apgrH..SBGao7OPOmykB934iI1fu', NULL, '2025-04-27 01:43:54', NULL, 1, 'Jayjay', 0),
(68, 'avila.igiboy17@gmail.com', 'Avila,', 'John', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocIA1gJicDF5uuSXikA5S4r1hLcDFabuAtxD-H8_1iczKWe0SjVF=s96-c', '2025-04-27 02:14:24', NULL, 1, '', 0),
(69, 'fletcherp8154@gmail.com', 'Hernandez,', 'Fletcher', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocIAJ3BVcKAlRR9tkJ8ppVGuuWaccrghkPWbJgRJMPfGyseOMF8=s96-c', '2025-04-27 04:58:23', NULL, 1, '', 0),
(70, 'jojifork69@gmail.com', 'Jojoji', '!', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocJkiwQQt3kWucb5KLLeVpr13JIRRPJxxHR85PIIttUEPOPMIA=s96-c', '2025-04-27 05:30:23', NULL, 1, '', 0),
(71, 'intertasmico@gmail.com', 'Mico', 'Intertas', '$2y$10$5m32.LNr6XXfkvzY5/sfPu5Rqu/Cyj8fKkuKrAXeuL1LkUIta.vPa', NULL, '2025-04-27 05:58:26', NULL, 1, 'Oshinobi', 0),
(72, 'gilojohnlloydgierza@gmail.com', 'Gilo,', 'John', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocJPCUpW_4VT4LDaMyclsLBs7qpOI6ykT0tTWaM7r7ZFRjpAKi0=s96-c', '2025-04-27 07:30:43', NULL, 1, '', 0),
(73, 'bandibadmhelroco@gmail.com', 'Bandibad,', 'Mhel', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocLy0z67rnlQRHYM0YSZHNH7bm2ce99G-WPi51Eh2EkSP2U4k_73=s96-c', '2025-04-27 12:53:20', NULL, 1, '', 0),
(74, 'peralta.daniela.sunico@gmail.com', 'Daniela', 'Peralta', '$2y$10$haKD1TuqnuRczMt7lSDfWukcUWa8VwfSkhAz0nHfw8igQbEAXBet2', NULL, '2025-04-28 05:59:06', NULL, 1, 'Daniela', 0),
(75, 'guzman.angelo.tabulao@gmail.com', 'Guzman', 'Angelo', NULL, 'https://lh3.googleusercontent.com/a-/ALV-UjV74P18juSEgRIoGYCGGphNBAe47jLzh1tmoDGJrbAR7JvYXGxO-2Mn1KXoT2OdXGI9vJ3exju37yXw484vNszlsa-KHAwJFkyuv4Sw66dOizICDo-M-FlJWEauvB-zZM85zgvb4wfbRY61A7jhtK_Zc31rmXPBQ_NSGemxQFXbGMkwrSxjdvLp7aSpJBNZA3g_iKxBtISyfxhfShmZTjI', '2025-04-28 05:59:52', NULL, 1, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_clusters`
--

CREATE TABLE `user_clusters` (
  `id` int(11) NOT NULL,
  `user_email` varchar(150) NOT NULL,
  `cluster_id` int(11) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_clusters`
--

INSERT INTO `user_clusters` (`id`, `user_email`, `cluster_id`, `last_updated`) VALUES
(2799, 'afilomino@gmail.com', 1, '2025-04-28 08:15:14'),
(2800, 'angelotebrero01@gmail.com', 1, '2025-04-28 08:15:14'),
(2801, 'defrostref@gmail.com', 2, '2025-04-28 08:15:14'),
(2802, 'emilbose.eb@gmail.com', 2, '2025-04-28 08:15:14'),
(2803, 'ernestdenila@gmail.com', 0, '2025-04-28 08:15:14'),
(2804, 'flores.clarencekyle.manrique@gmail.com', 2, '2025-04-28 08:15:14'),
(2805, 'gilojohnlloydgierza@gmail.com', 2, '2025-04-28 08:15:14'),
(2806, 'guzmanaceace@gmail.com', 1, '2025-04-28 08:15:14'),
(2807, 'imlanderbose@gmail.com', 2, '2025-04-28 08:15:14'),
(2808, 'intertasmico@gmail.com', 1, '2025-04-28 08:15:14'),
(2809, 'jojifork69@gmail.com', 0, '2025-04-28 08:15:14'),
(2810, 'josexyrus@gmail.com', 2, '2025-04-28 08:15:14'),
(2811, 'jpasspc090@gmail.com', 0, '2025-04-28 08:15:14'),
(2812, 'kjgquilatis00@gmail.com', 2, '2025-04-28 08:15:14'),
(2813, 'kquilatis05@gmail.com', 1, '2025-04-28 08:15:14'),
(2814, 'mangilog.lloyd.bigot1@gmail.com', 2, '2025-04-28 08:15:14'),
(2815, 'pogikotalaga@gmail.com', 0, '2025-04-28 08:15:14'),
(2816, 'renzmatthewy@gmail.com', 2, '2025-04-28 08:15:14'),
(2817, 'roden.belgera17@gmail.com', 2, '2025-04-28 08:15:14'),
(2818, 'rosswellacabo2004@gmail.com', 0, '2025-04-28 08:15:14'),
(2819, 'sison.axcel.sagun@gmail.com', 1, '2025-04-28 08:15:14'),
(2820, 'zephyr.fika@gmail.com', 3, '2025-04-28 08:15:14');

-- --------------------------------------------------------

--
-- Table structure for table `user_performance`
--

CREATE TABLE `user_performance` (
  `id` int(11) NOT NULL,
  `user_email` varchar(150) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `avg_score` float DEFAULT 0,
  `quizzes_taken` int(11) DEFAULT 0,
  `learning_style` varchar(50) DEFAULT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_performance`
--

INSERT INTO `user_performance` (`id`, `user_email`, `subject`, `avg_score`, `quizzes_taken`, `learning_style`, `last_updated`) VALUES
(12, 'kjgquilatis00@gmail.com', 'Science', 0, 1, 'read', '2025-04-24 11:42:46'),
(13, 'mangilog.lloyd.bigot1@gmail.com', 'History', 10, 2, 'read', '2025-04-24 12:26:40'),
(14, 'zephyr.fika@gmail.com', 'Science', 50, 1, 'video', '2025-04-24 13:21:24'),
(15, 'defrostref@gmail.com', 'Mathematics', 90, 1, 'read', '2025-04-24 17:45:24'),
(16, 'sison.axcel.sagun@gmail.com', 'Science', 20, 1, 'video', '2025-04-24 19:03:01'),
(17, 'angelotebrero01@gmail.com', 'English', 50, 1, 'video', '2025-04-25 01:58:08'),
(18, 'kquilatis05@gmail.com', 'History', 40, 1, 'video', '2025-04-25 02:40:33'),
(19, 'josexyrus@gmail.com', 'History', 36.3636, 1, 'read', '2025-04-25 04:03:48'),
(20, 'josexyrus@gmail.com', 'Mathematics', 0, 2, 'read', '2025-04-25 04:05:15'),
(21, 'ernestdenila@gmail.com', 'English', 12.5, 2, 'video', '2025-04-25 16:09:27'),
(22, 'ernestdenila@gmail.com', 'Mathematics', 90, 1, 'read', '2025-04-25 16:19:30'),
(23, 'jpasspc090@gmail.com', 'English', 37.5, 2, 'video', '2025-04-26 01:12:23'),
(24, 'jpasspc090@gmail.com', 'Mathematics', 83.3333, 1, 'video', '2025-04-26 01:14:27'),
(25, 'imlanderbose@gmail.com', 'Mathematics', 83.3333, 3, 'read', '2025-04-26 03:45:34'),
(26, 'renzmatthewy@gmail.com', 'Mathematics', 100, 1, 'read', '2025-04-26 03:46:30'),
(27, 'renzmatthewy@gmail.com', 'English', 40, 2, 'video', '2025-04-28 02:31:34'),
(28, 'renzmatthewy@gmail.com', 'Science', 0, 1, 'read', '2025-04-26 03:49:41'),
(29, 'rosswellacabo2004@gmail.com', 'Mathematics', 83.3333, 1, 'video', '2025-04-26 04:04:38'),
(30, 'roden.belgera17@gmail.com', 'Mathematics', 100, 1, 'read', '2025-04-26 04:10:45'),
(31, 'afilomino@gmail.com', 'English', 25, 2, 'video', '2025-04-26 04:59:46'),
(32, 'emilbose.eb@gmail.com', 'Science', 40, 1, 'read', '2025-04-26 04:49:00'),
(33, 'kjgquilatis00@gmail.com', 'History', 63.6364, 1, 'read', '2025-04-26 10:38:17'),
(34, 'kjgquilatis00@gmail.com', 'Mathematics', 65, 2, 'read', '2025-04-26 10:46:30'),
(35, 'pogikotalaga@gmail.com', 'Mathematics', 83.3333, 2, 'video', '2025-04-26 10:45:38'),
(36, 'guzmanaceace@gmail.com', 'English', 0, 1, 'video', '2025-04-26 11:07:53'),
(37, 'flores.clarencekyle.manrique@gmail.com', 'Science', 35, 2, 'read', '2025-04-28 02:09:35'),
(38, 'jojifork69@gmail.com', 'English', 0, 2, 'video', '2025-04-27 06:02:01'),
(39, 'intertasmico@gmail.com', 'Science', 25, 1, 'video', '2025-04-27 06:00:42'),
(40, 'jojifork69@gmail.com', 'Mathematics', 74.4444, 3, 'read', '2025-04-27 06:10:59'),
(41, 'gilojohnlloydgierza@gmail.com', 'Mathematics', 56.6667, 2, 'read', '2025-04-27 07:35:46'),
(42, 'flores.clarencekyle.manrique@gmail.com', 'Mathematics', 30, 1, 'read', '2025-04-28 03:24:40');

-- --------------------------------------------------------

--
-- Table structure for table `user_recommendations`
--

CREATE TABLE `user_recommendations` (
  `id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `video_id` int(11) DEFAULT NULL,
  `recommendation_type` enum('lesson','video') NOT NULL,
  `priority` tinyint(4) NOT NULL,
  `is_viewed` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL,
  `date_viewed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_recommendations`
--

INSERT INTO `user_recommendations` (`id`, `user_email`, `lesson_id`, `video_id`, `recommendation_type`, `priority`, `is_viewed`, `date_created`, `date_viewed`) VALUES
(1, 'imlanderbose@gmail.com', NULL, 72, 'video', 2, 0, '2025-04-28 08:08:58', NULL),
(2, 'imlanderbose@gmail.com', NULL, 70, 'video', 2, 0, '2025-04-28 08:08:58', NULL),
(3, 'imlanderbose@gmail.com', NULL, 64, 'video', 3, 0, '2025-04-28 08:08:58', NULL),
(4, 'imlanderbose@gmail.com', NULL, 73, 'video', 3, 0, '2025-04-28 08:08:58', NULL),
(5, 'imlanderbose@gmail.com', 23, NULL, 'lesson', 3, 0, '2025-04-28 08:08:58', NULL),
(6, 'imlanderbose@gmail.com', 32, NULL, 'lesson', 3, 0, '2025-04-28 08:08:58', NULL),
(7, 'felomino.amelyn.basence@gmail.com', NULL, 70, 'video', 3, 0, '2025-04-28 08:13:50', NULL),
(8, 'felomino.amelyn.basence@gmail.com', 25, NULL, 'lesson', 3, 0, '2025-04-28 08:13:50', NULL),
(9, 'felomino.amelyn.basence@gmail.com', NULL, 69, 'video', 3, 0, '2025-04-28 08:13:50', NULL),
(10, 'felomino.amelyn.basence@gmail.com', NULL, 67, 'video', 3, 0, '2025-04-28 08:13:50', NULL),
(11, 'felomino.amelyn.basence@gmail.com', 34, NULL, 'lesson', 3, 0, '2025-04-28 08:13:50', NULL),
(12, 'felomino.amelyn.basence@gmail.com', 26, NULL, 'lesson', 3, 0, '2025-04-28 08:13:50', NULL),
(13, 'pogikotalaga@gmail.com', NULL, 71, 'video', 2, 0, '2025-04-28 08:18:17', NULL),
(14, 'pogikotalaga@gmail.com', NULL, 70, 'video', 2, 0, '2025-04-28 08:18:17', NULL),
(15, 'pogikotalaga@gmail.com', 23, NULL, 'lesson', 3, 0, '2025-04-28 08:18:17', NULL),
(16, 'pogikotalaga@gmail.com', 25, NULL, 'lesson', 3, 0, '2025-04-28 08:18:17', NULL),
(17, 'pogikotalaga@gmail.com', 34, NULL, 'lesson', 3, 0, '2025-04-28 08:18:17', NULL),
(18, 'pogikotalaga@gmail.com', NULL, 67, 'video', 3, 0, '2025-04-28 08:18:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `video_lessons`
--

CREATE TABLE `video_lessons` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `youtube_url` varchar(255) NOT NULL,
  `level` varchar(50) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `thumbnail_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `view_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `video_lessons`
--

INSERT INTO `video_lessons` (`id`, `title`, `description`, `youtube_url`, `level`, `subject`, `thumbnail_url`, `created_at`, `date_created`, `view_count`) VALUES
(63, 'The History of Asia', 'Southeast Asia\'s history is a rich tapestry woven from diverse cultures, kingdoms, and empires that have flourished over millennia. The region\'s strategic position made it a crossroads for trade, leading to the rise of influential maritime states. For instance, the Srivijaya Empire, based on the island of Sumatra, dominated trade routes between the 7th and 13th centuries, serving as a vital center for the spread of Buddhism. Similarly, the Majapahit Empire, originating in Java during the 13th century, unified much of present-day Indonesia and parts of the Malay Peninsula, showcasing the region\'s capacity for complex governance and cultural development.\r\nColonialism profoundly reshaped Southeast Asia in the 16th century, as European powers sought control over its lucrative trade networks. The Portuguese, Dutch, British, and French established colonies, introducing new administrative systems and economic structures. Despite foreign domination, indigenous cultures demonstrated resilience, blending external influences with traditional practices. The 20th century witnessed a wave of independence movements, leading to the formation of modern nation-states. Today, Southeast Asia stands as a testament to the enduring strength and adaptability of its peoples, reflecting a history marked by both external influences and internal dynamism.', 'https://www.youtube.com/watch?v=EAZHaIsNiLI', 'Beginner', 'History', NULL, '2025-04-23 17:06:09', '2025-04-23 17:06:09', 1),
(64, 'Electricity and Magnetism', 'This engaging educational video introduces the fundamental concepts of electricity, magnetism, and electromagnetism. It explains how electric charges produce electric fields and how moving charges generate magnetic fields. The video also explores the relationship between electricity and magnetism, demonstrating how they combine to form electromagnetism. Through clear explanations and visual demonstrations, viewers gain a foundational understanding of these essential physical phenomena.', 'https://www.youtube.com/watch?v=rk5e2Ce3KCo', 'Advanced', 'Science', NULL, '2025-04-23 17:12:56', '2025-04-23 17:12:56', 4),
(65, 'Philippines During the Spanish Era', 'The Spanish colonization of the Philippines, spanning over three centuries from 1565 to 1898, profoundly influenced the archipelago&#039;s cultural, social, and political landscapes. The initial European contact occurred in 1521 when Portuguese explorer Ferdinand Magellan, sailing under the Spanish flag, arrived in the Philippines. However, it wasn&#039;t until 1565 that a permanent Spanish presence was established under the leadership of Miguel López de Legazpi.\r\nOne of the most significant impacts of Spanish rule was the widespread conversion to Christianity. Missionaries, particularly from the Augustinian, Franciscan, Dominican, and Jesuit orders, played a crucial role in this religious transformation, leading to the Philippines becoming Asia&#039;s largest Catholic nation. The Spanish also introduced a centralized colonial government, restructuring the indigenous barangay system into a more hierarchical framework under Spanish authority. Economically, the galleon trade connected the Philippines to global commerce, particularly linking Asia and the Americas. However, this era also saw the exploitation of native populations and the suppression of indigenous cultures, leading to numerous uprisings and resistance movements.\r\nThe 19th century brought significant changes as the Philippines opened up to international trade. The decline of the galleon trade led to the privatization of communal lands to meet global demand for agricultural products, transforming the local economy. This period also witnessed the rise of a Filipino educated class, the Ilustrados, who became instrumental in advocating for reforms and eventual independence.\r\nThe culmination of these internal and external pressures led to the Philippine Revolution of 1896. Although initially suppressed, the revolution gained momentum, and combined with the outcome of the Spanish-American War, it resulted in the end of Spanish rule in 1898. The Treaty of Paris subsequently ceded the Philippines to the United States, marking the beginning of a new colonial chapter in the nation&#039;s history.', 'http://youtube.com/watch?v=R23NNcU4RIQ', 'Intermediate', 'History', NULL, '2025-04-23 17:13:38', '2025-04-23 17:13:38', 1),
(66, 'The Philippines during the Marcos Dictatorship', 'Ferdinand Marcos&#039;s presidency in the Philippines, spanning from 1965 to 1986, is notably marked by the declaration of martial law in 1972. This period was characterized by significant political repression, human rights violations, and widespread corruption. Marcos justified martial law as a necessary measure against rising disorder, citing violent student demonstrations and threats from communist insurgencies. However, this move effectively extended his presidency beyond constitutional limits, consolidating power and suppressing opposition.\r\nUnder martial law, the regime committed numerous human rights abuses, including extrajudicial killings, torture, and arbitrary detentions. Estimates suggest that approximately 3,257 individuals were murdered, 35,000 tortured, and 70,000 illegally detained during this time. The period also witnessed significant emigration, with around 300,000 Filipinos leaving the country between 1965 and 1986. Corruption was rampant, with the Marcos family reportedly amassing illicit wealth estimated at US$10 billion, facilitated through government monopolies, crony capitalism, and direct raiding of the public treasury.\r\nCulturally, the regime&#039;s censorship extended to popular media. For instance, in 1979, the Japanese anime &quot;Voltes V&quot; was banned, ostensibly due to its violent content. However, many believe the ban was politically motivated, as the show&#039;s themes of resistance and anti-authoritarianism resonated with the Filipino populace, potentially inspiring dissent against the dictatorship.\r\nThe Marcos dictatorship&#039;s legacy is a complex tapestry of authoritarian rule, economic plunder, and societal upheaval, leaving an indelible mark on the Philippines&#039; political and cultural landscape.', 'https://www.youtube.com/watch?v=EjdTZbeKo2c', 'Advanced', 'History', NULL, '2025-04-23 17:19:03', '2025-04-23 17:19:03', 0),
(67, 'Photosynthesis', 'This Crash Course video delves into the process of photosynthesis, explaining how plants convert light energy into chemical energy. It covers the light-dependent and light-independent reactions, providing a clear and engaging explanation suitable for learners at all levels.', 'https://www.youtube.com/watch?v=sQK3Yr4Sc_k', 'Intermediate', 'Science', NULL, '2025-04-23 17:22:03', '2025-04-23 17:22:03', 2),
(68, 'Plant Life Cycles', 'The video \"Learn the Plant Life Cycle Steps | Earth Science for Kids\" provides an overview of the stages in a plant\'s life cycle.  It begins with a seed, which germinates under suitable conditions, leading to the growth of a seedling. As the plant matures, it develops roots, stems, and leaves, enabling photosynthesis. Upon reaching maturity, the plant produces flowers, which, after pollination and fertilization, form fruits containing seeds. These seeds can then disperse and germinate, perpetuating the cycle.', 'https://www.youtube.com/watch?v=zPqnYYI2Uq8', 'Beginner', 'Science', NULL, '2025-04-23 17:27:12', '2025-04-23 17:27:12', 4),
(69, 'Math - Addition | Basic Introduction', 'Basic addition is one of the first math skills we learn and is all about putting numbers together to find out how many there are in total. It’s like combining groups of objects—if you have 2 apples and get 3 more, you now have 5 apples. Addition helps us count, compare amounts, and solve simple problems in everyday life, making it a key building block for all other math skills.', 'https://www.youtube.com/watch?v=BZ4FjSXjzgg&t=189s', 'Beginner', 'Mathematics', NULL, '2025-04-23 17:40:58', '2025-04-23 17:40:58', 18),
(70, 'Parts of Speech', 'Words are the building blocks of language, but did you know that every word has a role to play? We use these words everyday but we do not know what they are called. In this video, we will break down the eight parts of speech—nouns, pronouns, adjectives, verbs, adverbs, prepositions, conjunctions, and interjections—and explain how they work together to form sentences.', 'https://www.youtube.com/watch?v=ZqLeGm4k6CU', 'Beginner', 'English', NULL, '2025-04-24 12:06:55', '2025-04-24 12:06:55', 22),
(71, 'Subtraction - Math | Basic Introduction', 'This video offers a basic introduction to subtraction, beginning with explanations using a number line and then advancing to subtracting two-digit, three-digit, and four-digit numbers, including demonstrations of the borrowing technique in subtraction.', 'https://www.youtube.com/watch?v=r3qKojj4g4g', 'Beginner', 'Mathematics', NULL, '2025-04-26 12:29:19', '2025-04-26 12:29:19', 3),
(72, 'Math - Long Multiplication', 'Basic multiplication is a core arithmetic operation that involves adding a number to itself a certain number of times. It is represented by the multiplication symbol (× or *). For example, 3 × 4 means adding 3 four times, which equals 12. Multiplication helps in understanding patterns, scaling numbers, and solving problems involving groups of equal size. It is widely used in daily life, such as calculating prices, areas, and quantities.', 'https://youtu.be/GKetIwxaenA', 'Beginner', 'Mathematics', NULL, '2025-04-26 12:44:14', '2025-04-26 12:44:14', 0),
(73, 'Basic Division Explained!', 'Basic division is a fundamental arithmetic operation used to split a number into equal parts or groups. It is represented by the division symbol (÷ or /). For example, 12 ÷ 3 means dividing 12 into 3 equal parts, which gives 4. Division helps us understand how to share or distribute things evenly and is often used in everyday activities like splitting bills, dividing items, or measuring portions.', 'https://youtu.be/yAJxHO7CLh4', 'Beginner', 'Mathematics', NULL, '2025-04-26 12:54:54', '2025-04-26 12:54:54', 1);

-- --------------------------------------------------------

--
-- Table structure for table `video_questions`
--

CREATE TABLE `video_questions` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `question_type` varchar(50) NOT NULL,
  `points` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `video_questions`
--

INSERT INTO `video_questions` (`id`, `quiz_id`, `question_text`, `question_type`, `points`, `created_at`) VALUES
(74, 53, 'Which empire, based on Sumatra, dominated Southeast Asian trade between the 7th and 13th centuries?', 'multiple-choice', 1, '2025-04-23 17:06:09'),
(75, 53, 'Which empire unified much of present-day Indonesia and the Malay Peninsula in the 13th century?', 'multiple-choice', 1, '2025-04-23 17:06:09'),
(76, 53, 'What was a significant factor in the rise of Southeast Asian empires?', 'multiple-choice', 1, '2025-04-23 17:06:09'),
(77, 53, 'Which European power was the first to establish a colonial presence in Southeast Asia in the 16th century?', 'multiple-choice', 1, '2025-04-23 17:06:09'),
(78, 53, 'Which Southeast Asian country was NOT colonized by a European power?', 'multiple-choice', 1, '2025-04-23 17:06:09'),
(79, 54, 'What is the basic unit of electric charge?', 'multiple-choice', 1, '2025-04-23 17:12:56'),
(80, 54, 'Which particle carries a negative electric charge?', 'multiple-choice', 1, '2025-04-23 17:12:56'),
(81, 54, 'What happens when like magnetic poles are brought close together?', 'multiple-choice', 1, '2025-04-23 17:12:56'),
(82, 54, 'What is created around a wire when an electric current flows through it?', 'multiple-choice', 1, '2025-04-23 17:12:56'),
(83, 55, 'Who was the Portuguese explorer who arrived in the Philippines in 1521 under the Spanish flag?', 'multiple-choice', 1, '2025-04-23 17:13:38'),
(84, 55, 'In what year did Spain establish a permanent presence in the Philippines?', 'multiple-choice', 1, '2025-04-23 17:13:38'),
(85, 55, 'What was the primary religion introduced by the Spanish to the Filipino people?', 'multiple-choice', 1, '2025-04-23 17:13:38'),
(86, 55, 'What event officially ended Spanish rule in the Philippines?', 'multiple-choice', 1, '2025-04-23 17:13:38'),
(87, 56, 'In what year did Ferdinand Marcos declare martial law in the Philippines?', 'multiple-choice', 1, '2025-04-23 17:19:03'),
(88, 56, 'What was one of the main reasons Marcos cited for declaring martial law?', 'multiple-choice', 1, '2025-04-23 17:19:03'),
(89, 56, 'What was the estimated number of people who were illegally detained during martial law?', 'multiple-choice', 1, '2025-04-23 17:19:03'),
(90, 56, 'Which Japanese anime was banned during Marcos’s rule due to its perceived themes of resistance?', 'multiple-choice', 1, '2025-04-23 17:19:03'),
(91, 56, 'Approximately how many Filipinos emigrated from the country between 1965 and 1986?', 'multiple-choice', 1, '2025-04-23 17:19:03'),
(92, 57, 'What is the primary purpose of photosynthesis in plants?', 'multiple-choice', 1, '2025-04-23 17:22:03'),
(93, 57, 'Where in the plant cell does photosynthesis primarily occur?', 'multiple-choice', 1, '2025-04-23 17:22:03'),
(94, 57, 'Which pigment is responsible for capturing light energy in plants?', 'multiple-choice', 1, '2025-04-23 17:22:03'),
(95, 57, 'What are the two main stages of photosynthesis?', 'multiple-choice', 1, '2025-04-23 17:22:03'),
(96, 57, 'During the light-dependent reactions, what molecule is produced as a byproduct?', 'multiple-choice', 1, '2025-04-23 17:22:03'),
(97, 58, 'What is the first stage of a plant&#039;s life cycle?', 'multiple-choice', 1, '2025-04-23 17:27:12'),
(98, 58, 'What does a seed need to start growing?', 'multiple-choice', 1, '2025-04-23 17:27:12'),
(99, 58, 'What is the process called when a seed begins to grow?', 'multiple-choice', 1, '2025-04-23 17:27:12'),
(100, 58, 'What part of the plant grows downward into the soil?', 'multiple-choice', 1, '2025-04-23 17:27:12'),
(101, 58, 'What part of the plant grows upward and supports leaves and flowers?', 'multiple-choice', 1, '2025-04-23 17:27:12'),
(102, 59, '9 + 7 = ?', 'multiple-choice', 1, '2025-04-23 17:40:58'),
(103, 59, '3 + 6 = ?', 'multiple-choice', 1, '2025-04-23 17:40:58'),
(104, 59, '5 + 10 = ?', 'multiple-choice', 1, '2025-04-23 17:40:58'),
(105, 59, '8 + 12 = ?', 'multiple-choice', 1, '2025-04-23 17:40:58'),
(106, 59, '6 + 5 = ?', 'multiple-choice', 1, '2025-04-23 17:40:58'),
(107, 59, '9 + 7 = ?', 'multiple-choice', 1, '2025-04-23 17:40:58'),
(108, 59, '3 + 6 = ?', 'multiple-choice', 1, '2025-04-23 17:40:58'),
(109, 59, '5 + 10 = ?', 'multiple-choice', 1, '2025-04-23 17:40:58'),
(110, 59, '8 + 12 = ?', 'multiple-choice', 1, '2025-04-23 17:40:58'),
(111, 59, '6 + 5 = ?', 'multiple-choice', 1, '2025-04-23 17:40:58'),
(112, 60, 'Which of the following is a noun?', 'multiple-choice', 1, '2025-04-24 12:06:55'),
(113, 60, 'Identify the verb in the sentence:\r\n&quot;She sings beautifully.&quot;', 'multiple-choice', 1, '2025-04-24 12:06:55'),
(114, 60, 'Which word is a pronoun?', 'multiple-choice', 1, '2025-04-24 12:06:55'),
(115, 60, 'What part of speech is the word &quot;quickly&quot; in this sentence?\r\n&quot;He ran quickly to the store.&quot;', 'multiple-choice', 1, '2025-04-24 12:06:55'),
(116, 61, '18 - 9 = ?', 'multiple-choice', 1, '2025-04-26 12:29:19'),
(117, 61, '20 - 4 = ?', 'multiple-choice', 1, '2025-04-26 12:29:19'),
(118, 61, '11 - 3 = ?', 'multiple-choice', 1, '2025-04-26 12:29:19'),
(119, 61, '17 - 6 = ?', 'multiple-choice', 1, '2025-04-26 12:29:19'),
(120, 61, '13 - 5 = ?', 'multiple-choice', 1, '2025-04-26 12:29:19'),
(121, 61, '30 - 12 = ?', 'multiple-choice', 1, '2025-04-26 12:29:19'),
(122, 61, '22 - 8 = ?', 'multiple-choice', 1, '2025-04-26 12:29:19'),
(123, 61, '17 - 9 = ?', 'multiple-choice', 1, '2025-04-26 12:29:19'),
(124, 61, '19 - 4 = ?', 'multiple-choice', 1, '2025-04-26 12:29:19'),
(125, 61, '24 - 7 = ?', 'multiple-choice', 1, '2025-04-26 12:29:19'),
(126, 62, '7 × 5 = ?', 'multiple-choice', 1, '2025-04-26 12:44:14'),
(127, 62, '6 × 8 = ?', 'multiple-choice', 1, '2025-04-26 12:44:14'),
(128, 62, '9 × 4 = ?', 'multiple-choice', 1, '2025-04-26 12:44:14'),
(129, 62, '3 × 11 = ?', 'multiple-choice', 1, '2025-04-26 12:44:14'),
(130, 62, '12 × 3 = ?', 'multiple-choice', 1, '2025-04-26 12:44:14'),
(131, 62, '5 × 9 = ?', 'multiple-choice', 1, '2025-04-26 12:44:14'),
(132, 62, '8 × 7 = ?', 'multiple-choice', 1, '2025-04-26 12:44:14'),
(133, 62, '10 × 6 = ?', 'multiple-choice', 1, '2025-04-26 12:44:14'),
(134, 62, '4 × 4 = ?', 'multiple-choice', 1, '2025-04-26 12:44:14'),
(135, 62, '13 × 2 = ?', 'multiple-choice', 1, '2025-04-26 12:44:14'),
(136, 63, '20 ÷ 4?', 'multiple-choice', 1, '2025-04-26 12:54:54'),
(137, 63, '15 ÷ 3?', 'multiple-choice', 1, '2025-04-26 12:54:54'),
(138, 63, '18 ÷ 6?', 'multiple-choice', 1, '2025-04-26 12:54:54'),
(139, 63, '24 ÷ 8?', 'multiple-choice', 1, '2025-04-26 12:54:54'),
(140, 63, '30 ÷ 5?', 'multiple-choice', 1, '2025-04-26 12:54:54'),
(141, 63, '12 ÷ 4?', 'multiple-choice', 1, '2025-04-26 12:54:54'),
(142, 63, '9 ÷ 3?', 'multiple-choice', 1, '2025-04-26 12:54:54'),
(143, 63, '14 ÷ 2?', 'multiple-choice', 1, '2025-04-26 12:54:54'),
(144, 63, '21 ÷ 7?', 'multiple-choice', 1, '2025-04-26 12:54:54'),
(145, 63, '16 ÷ 2?', 'multiple-choice', 1, '2025-04-26 12:54:54');

-- --------------------------------------------------------

--
-- Table structure for table `video_question_options`
--

CREATE TABLE `video_question_options` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `option_text` text NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `video_question_options`
--

INSERT INTO `video_question_options` (`id`, `question_id`, `option_text`, `is_correct`) VALUES
(135, 74, 'Khmer Empire', 0),
(136, 74, 'Srivijaya Empire', 1),
(137, 75, 'Majapahit Empire', 0),
(138, 75, 'Ayutthaya Kingdom', 1),
(139, 75, 'Srivijaya Empire', 0),
(140, 75, 'Majapahit Empire', 0),
(141, 76, 'Champa Kingdom', 0),
(142, 76, 'Khmer Empire', 1),
(143, 76, 'Isolation from foreign traders', 0),
(144, 76, 'Control of maritime trade routes', 0),
(145, 77, 'Reliance on European technology', 1),
(146, 77, 'The spread of Christianity', 0),
(147, 77, 'Portuguese', 0),
(148, 77, 'Dutch', 0),
(149, 78, 'British', 1),
(150, 78, 'French', 0),
(151, 78, 'Indonesia', 0),
(152, 78, 'Vietnam', 0),
(153, 79, 'Volt', 1),
(154, 79, 'Watt', 0),
(155, 80, 'Coulomb', 0),
(156, 80, 'Ampere', 1),
(157, 80, 'Proton', 0),
(158, 80, 'Electron', 0),
(159, 81, 'Neutron', 0),
(160, 81, 'Photon', 1),
(161, 81, 'They attract', 0),
(162, 81, 'They repel', 0),
(163, 82, 'They neutralize', 0),
(164, 82, 'No interaction', 1),
(165, 82, 'Electric field', 0),
(166, 82, 'Magnetic field', 0),
(167, 83, 'Miguel López de Legazpi', 0),
(168, 83, 'Ferdinand Magellan', 1),
(169, 84, 'Juan de Salcedo', 0),
(170, 84, 'Francisco Dagohoy', 1),
(171, 84, '1521', 0),
(172, 84, '1565', 0),
(173, 85, '1600', 1),
(174, 85, '1645', 0),
(175, 85, 'Islam', 0),
(176, 85, 'Buddhism', 0),
(177, 86, 'Christianity', 0),
(178, 86, 'Hinduism', 0),
(179, 88, '1965', 0),
(180, 88, '1972', 1),
(181, 88, '1981', 0),
(182, 88, '1986', 0),
(183, 88, 'Economic downturn', 0),
(184, 88, 'Rising disorder and communist insurgencies', 0),
(185, 89, 'International pressure', 1),
(186, 89, 'To extend his presidency', 0),
(187, 89, '10,000', 0),
(188, 89, '25,000', 0),
(189, 90, '70,000', 0),
(190, 90, '100,000', 0),
(191, 90, 'Astro Boy', 1),
(192, 90, 'Gundam', 0),
(193, 91, 'Voltes V', 0),
(194, 91, 'Dragon Ball', 0),
(195, 91, '50,000', 1),
(196, 91, '150,000', 0),
(197, 92, 'To produce oxygen for animals', 0),
(198, 92, 'To convert light energy into chemical energy stored as glucose', 1),
(199, 93, 'To absorb carbon dioxide from the atmosphere', 0),
(200, 93, 'To create chlorophyll​', 1),
(201, 93, 'Mitochondria', 0),
(202, 93, 'Nucleus', 0),
(203, 94, 'Chloroplasts', 0),
(204, 94, 'Ribosomes​', 1),
(205, 94, 'Carotenoids', 0),
(206, 94, 'Chlorophyll', 0),
(207, 95, 'Xanthophyll', 0),
(208, 95, 'Anthocyanin​', 1),
(209, 95, 'Glycolysis and Krebs Cycle', 0),
(210, 95, 'Light-dependent reactions and Calvin Cycle', 0),
(211, 96, 'Electron Transport Chain and Fermentation', 0),
(212, 96, 'Carbon dioxide', 1),
(213, 96, 'Oxygen', 0),
(214, 97, 'Growth', 0),
(215, 97, 'Seed', 1),
(216, 98, 'Flower', 0),
(217, 98, 'Pollination', 0),
(218, 100, 'Darkness', 0),
(219, 100, 'Water, warmth, and soil', 1),
(220, 101, 'Wind', 0),
(221, 101, 'Fertilizer', 1),
(222, 101, 'Pollination', 0),
(223, 101, 'Germination', 0),
(224, 103, '8', 0),
(225, 103, '9', 1),
(226, 104, '10', 0),
(227, 104, '11', 1),
(228, 104, '14', 0),
(229, 104, '15', 0),
(230, 106, '10', 0),
(231, 106, '11', 1),
(232, 108, '8', 0),
(233, 108, '9', 1),
(234, 109, '14', 0),
(235, 109, '15', 1),
(236, 111, '10', 0),
(237, 111, '11', 1),
(238, 112, 'Run', 1),
(239, 112, 'Happy', 0),
(240, 113, 'Dog', 0),
(241, 113, 'Quickly', 1),
(242, 113, 'She', 0),
(243, 113, 'Sings', 0),
(244, 114, 'Beautifully', 0),
(245, 114, 'The', 1),
(246, 114, 'Table', 0),
(247, 114, 'He', 0),
(248, 115, 'Apple', 1),
(249, 115, 'Yellow', 0),
(250, 115, 'Noun', 0),
(251, 115, 'Verb', 0),
(252, 117, '14', 0),
(253, 117, '15', 0),
(254, 118, '7', 0),
(255, 118, '8', 1),
(256, 119, '10', 0),
(257, 119, '11', 1),
(258, 120, '7', 0),
(259, 120, '8', 1),
(260, 122, '13', 0),
(261, 122, '14', 1),
(262, 123, '7', 0),
(263, 123, '8', 1),
(264, 124, '14', 0),
(265, 124, '15', 1),
(266, 125, '16', 0),
(267, 125, '17', 1),
(268, 126, '30', 0),
(269, 126, '35', 1),
(270, 127, '48', 1),
(271, 127, '46', 0),
(272, 130, '35', 0),
(273, 130, '36', 1),
(274, 131, '45', 1),
(275, 131, '40', 0),
(276, 135, '24', 0),
(277, 135, '26', 1),
(278, 137, '5', 1),
(279, 137, '6', 0),
(280, 138, '2', 0),
(281, 138, '3', 1),
(282, 139, '2', 0),
(283, 139, '3', 1),
(284, 140, '2', 0),
(285, 140, '3', 1),
(286, 141, '2', 0),
(287, 141, '3', 1),
(288, 143, '6', 0),
(289, 143, '7', 1),
(290, 144, '2', 0),
(291, 144, '3', 1),
(292, 145, '7', 0),
(293, 145, '8', 1);

-- --------------------------------------------------------

--
-- Table structure for table `video_quizzes`
--

CREATE TABLE `video_quizzes` (
  `id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `total_points` int(11) DEFAULT 0,
  `time_stamp` int(11) DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `video_quizzes`
--

INSERT INTO `video_quizzes` (`id`, `video_id`, `title`, `description`, `total_points`, `time_stamp`, `created_at`) VALUES
(53, 63, 'The History of Asia', 'Quiz for Beginners', 0, 0, '2025-04-23 17:06:09'),
(54, 64, 'Electricity and Magnetism', 'Advanced quiz for Electricity and Magnetism', 0, 0, '2025-04-23 17:12:56'),
(55, 65, 'Philippines During the Spanish Era', 'Intermediate Quiz', 0, 0, '2025-04-23 17:13:38'),
(56, 66, 'The Philippines during the Marcos Dictatorship', 'Quiz for Advanced Learners', 0, 0, '2025-04-23 17:19:03'),
(57, 67, 'Photosynthesis', 'Intermediate Quiz for Photosynthesis', 0, 0, '2025-04-23 17:22:03'),
(58, 68, 'Plant Life Cycles', 'Beginner Quiz for Plant Life Cycles', 0, 0, '2025-04-23 17:27:12'),
(59, 69, 'Basic Addition #1', 'This quiz is designed to help learners practice and reinforce their basic addition skills. From adding small numbers to solving simple word problems, this quiz introduces the foundational math concepts that are essential for everyday problem-solving and future math success.\r\n\r\nBy taking this quiz, you\'ll get better at:\r\n\r\nAdding single-digit and double-digit numbers\r\n\r\nUnderstanding how addition works through real-life examples\r\n\r\nStrengthening number sense and mental math skills\r\n\r\nTarget Audience:\r\nYoung learners starting out with math, or anyone looking to review and sharpen their basic addition skills.\r\n\r\nRecommended Prerequisites:\r\nNone! Just bring your curiosity and counting fingers.', 0, 0, '2025-04-23 17:40:58'),
(60, 70, 'Parts of Speech', 'Beginner Quiz for Parts of Speech', 0, 0, '2025-04-24 12:06:55'),
(61, 71, 'Basic Subtraction', 'This quiz helps students learn and practice the basics of subtraction. Through simple, real-life examples and visual concepts, learners will understand how to \"take away\" and find what\'s left. Perfect for young learners or anyone needing a refresher on subtraction!', 0, 0, '2025-04-26 12:29:19'),
(62, 72, 'Basic multiplication', 'Test your understanding of basic multiplication facts. This quiz covers multiplication problems involving single-digit and small double-digit numbers. It\'s perfect for learners who are beginning to explore multiplication or looking to reinforce their skills.​', 0, 0, '2025-04-26 12:44:14'),
(63, 73, 'Basic Division #1', 'Sharpen your division skills with this beginner-friendly quiz! Practice solving simple division problems involving single-digit and small double-digit numbers. This quiz is perfect for students learning how to divide and for those wanting to strengthen their quick math skills!', 0, 0, '2025-04-26 12:54:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lesson_materials`
--
ALTER TABLE `lesson_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_email` (`user_email`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `subject` (`subject`),
  ADD KEY `source` (`source`);

--
-- Indexes for table `recommendations`
--
ALTER TABLE `recommendations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `email_2` (`email`);

--
-- Indexes for table `user_clusters`
--
ALTER TABLE `user_clusters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_performance`
--
ALTER TABLE `user_performance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_email` (`user_email`,`subject`);

--
-- Indexes for table `user_recommendations`
--
ALTER TABLE `user_recommendations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_email` (`user_email`);

--
-- Indexes for table `video_lessons`
--
ALTER TABLE `video_lessons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_questions`
--
ALTER TABLE `video_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `video_question_options`
--
ALTER TABLE `video_question_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `video_quizzes`
--
ALTER TABLE `video_quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `video_id` (`video_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `lesson_materials`
--
ALTER TABLE `lesson_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=582;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `recommendations`
--
ALTER TABLE `recommendations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `user_clusters`
--
ALTER TABLE `user_clusters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2821;

--
-- AUTO_INCREMENT for table `user_performance`
--
ALTER TABLE `user_performance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `user_recommendations`
--
ALTER TABLE `user_recommendations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `video_lessons`
--
ALTER TABLE `video_lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `video_questions`
--
ALTER TABLE `video_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `video_question_options`
--
ALTER TABLE `video_question_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=294;

--
-- AUTO_INCREMENT for table `video_quizzes`
--
ALTER TABLE `video_quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lesson_materials`
--
ALTER TABLE `lesson_materials`
  ADD CONSTRAINT `lesson_materials_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `options`
--
ALTER TABLE `options`
  ADD CONSTRAINT `options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `video_questions`
--
ALTER TABLE `video_questions`
  ADD CONSTRAINT `video_questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `video_quizzes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `video_question_options`
--
ALTER TABLE `video_question_options`
  ADD CONSTRAINT `video_question_options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `video_questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `video_quizzes`
--
ALTER TABLE `video_quizzes`
  ADD CONSTRAINT `video_quizzes_ibfk_1` FOREIGN KEY (`video_id`) REFERENCES `video_lessons` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
