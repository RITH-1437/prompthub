-- MySQL dump 10.13  Distrib 8.0.44, for Win64 (x86_64)
--
-- Host: localhost    Database: prompt_hub
-- ------------------------------------------------------
-- Server version	8.4.8

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `achievement_user`
--

DROP TABLE IF EXISTS `achievement_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `achievement_user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `achievement_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `achievement_user_achievement_id_foreign` (`achievement_id`),
  KEY `achievement_user_user_id_foreign` (`user_id`),
  CONSTRAINT `achievement_user_achievement_id_foreign` FOREIGN KEY (`achievement_id`) REFERENCES `achievements` (`id`) ON DELETE CASCADE,
  CONSTRAINT `achievement_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `achievement_user`
--

LOCK TABLES `achievement_user` WRITE;
/*!40000 ALTER TABLE `achievement_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `achievement_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `achievements`
--

DROP TABLE IF EXISTS `achievements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `achievements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `achievements_user_id_foreign` (`user_id`),
  CONSTRAINT `achievements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `achievements`
--

LOCK TABLES `achievements` WRITE;
/*!40000 ALTER TABLE `achievements` DISABLE KEYS */;
INSERT INTO `achievements` VALUES (2,1,'Prompt Master','2026-06-04 20:05:18','2026-06-04 20:05:18'),(4,1,'Popular Creator','2026-06-04 20:05:18','2026-06-04 20:05:18'),(5,1,'Copy King','2026-06-04 20:05:18','2026-06-04 20:05:18'),(6,1,'First Prompt','2026-06-04 13:41:35','2026-06-04 13:41:35'),(7,1,'Collector','2026-06-08 13:06:47','2026-06-08 13:06:47'),(8,4,'First Prompt','2026-06-08 16:12:19','2026-06-08 16:12:19');
/*!40000 ALTER TABLE `achievements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'AI','ai',NULL,'2026-06-03 03:13:38','2026-06-03 03:13:38'),(2,'Code','code',NULL,'2026-06-03 03:13:38','2026-06-03 03:13:38'),(3,'Design','design',NULL,'2026-06-03 03:13:38','2026-06-03 03:13:38'),(4,'Marketing','marketing',NULL,'2026-06-03 03:13:38','2026-06-03 03:13:38'),(5,'Business','business',NULL,'2026-06-03 03:13:38','2026-06-03 03:13:38'),(6,'Productivity','productivity',NULL,'2026-06-03 03:13:38','2026-06-03 03:13:38'),(7,'Video','video',NULL,'2026-06-03 03:13:38','2026-06-03 03:13:38'),(8,'Writing','writing',NULL,'2026-06-03 03:13:38','2026-06-03 03:13:38');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `collection_prompt`
--

DROP TABLE IF EXISTS `collection_prompt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `collection_prompt` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `collection_id` bigint unsigned NOT NULL,
  `prompt_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `collection_prompt_collection_id_foreign` (`collection_id`),
  KEY `collection_prompt_prompt_id_foreign` (`prompt_id`),
  CONSTRAINT `collection_prompt_collection_id_foreign` FOREIGN KEY (`collection_id`) REFERENCES `collections` (`id`) ON DELETE CASCADE,
  CONSTRAINT `collection_prompt_prompt_id_foreign` FOREIGN KEY (`prompt_id`) REFERENCES `prompts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `collection_prompt`
--

LOCK TABLES `collection_prompt` WRITE;
/*!40000 ALTER TABLE `collection_prompt` DISABLE KEYS */;
INSERT INTO `collection_prompt` VALUES (1,2,1,'2026-06-04 02:17:46','2026-06-04 02:17:46'),(7,1,6,'2026-06-04 02:30:20','2026-06-04 02:30:20'),(8,1,7,'2026-06-04 02:30:20','2026-06-04 02:30:20'),(9,2,8,'2026-06-04 02:30:20','2026-06-04 02:30:20'),(10,3,9,'2026-06-04 02:30:20','2026-06-04 02:30:20'),(12,7,3,NULL,NULL),(13,5,2,NULL,NULL),(14,3,2,NULL,NULL),(15,7,4,NULL,NULL),(16,1,2,NULL,NULL);
/*!40000 ALTER TABLE `collection_prompt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `collections`
--

DROP TABLE IF EXISTS `collections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `collections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `collections_user_id_foreign` (`user_id`),
  CONSTRAINT `collections_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `collections`
--

LOCK TABLES `collections` WRITE;
/*!40000 ALTER TABLE `collections` DISABLE KEYS */;
INSERT INTO `collections` VALUES (1,1,'Test Collection','2026-06-03 18:31:35','2026-06-03 18:31:35'),(2,1,'Test Collection','2026-06-03 18:31:40','2026-06-03 18:31:40'),(3,1,'Web Development','2026-06-04 02:28:38','2026-06-04 02:28:38'),(4,1,'AI Prompts','2026-06-04 02:28:38','2026-06-04 02:28:38'),(5,1,'Laravel Projects','2026-06-04 02:28:38','2026-06-04 02:28:38'),(7,1,'Content Creation','2026-06-04 02:28:38','2026-06-04 02:28:38'),(8,1,'hello','2026-06-08 13:06:47','2026-06-08 13:06:47');
/*!40000 ALTER TABLE `collections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `prompt_id` bigint unsigned NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_user_id_foreign` (`user_id`),
  KEY `comments_prompt_id_foreign` (`prompt_id`),
  CONSTRAINT `comments_prompt_id_foreign` FOREIGN KEY (`prompt_id`) REFERENCES `prompts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (5,1,6,'vb','2026-06-04 17:20:13','2026-06-04 17:20:13');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `conversations`
--

DROP TABLE IF EXISTS `conversations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `conversations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conversations`
--

LOCK TABLES `conversations` WRITE;
/*!40000 ALTER TABLE `conversations` DISABLE KEYS */;
/*!40000 ALTER TABLE `conversations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `favorites`
--

DROP TABLE IF EXISTS `favorites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `favorites` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `prompt_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `favorites_user_id_foreign` (`user_id`),
  KEY `favorites_prompt_id_foreign` (`prompt_id`),
  CONSTRAINT `favorites_prompt_id_foreign` FOREIGN KEY (`prompt_id`) REFERENCES `prompts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favorites`
--

LOCK TABLES `favorites` WRITE;
/*!40000 ALTER TABLE `favorites` DISABLE KEYS */;
INSERT INTO `favorites` VALUES (2,1,3,'2026-06-03 03:13:38','2026-06-03 03:13:38'),(4,1,4,'2026-06-03 06:32:08','2026-06-03 06:32:08'),(5,1,2,'2026-06-03 18:07:21','2026-06-03 18:07:21');
/*!40000 ALTER TABLE `favorites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `follows`
--

DROP TABLE IF EXISTS `follows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `follows` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `follower_id` bigint unsigned NOT NULL,
  `following_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `follows_follower_id_foreign` (`follower_id`),
  KEY `follows_following_id_foreign` (`following_id`),
  CONSTRAINT `follows_follower_id_foreign` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `follows_following_id_foreign` FOREIGN KEY (`following_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `follows`
--

LOCK TABLES `follows` WRITE;
/*!40000 ALTER TABLE `follows` DISABLE KEYS */;
INSERT INTO `follows` VALUES (9,4,1,NULL,NULL),(11,1,4,NULL,NULL);
/*!40000 ALTER TABLE `follows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `conversation_id` bigint unsigned NOT NULL,
  `role` enum('user','assistant') COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (38,4,'user','hi','2026-06-07 04:44:54','2026-06-07 04:44:54'),(39,4,'assistant','Hi there! How can I help you today?','2026-06-07 04:44:57','2026-06-07 04:44:57'),(40,5,'user','hi','2026-06-07 04:47:10','2026-06-07 04:47:10'),(41,5,'assistant','Hi there! How can I help you today?','2026-06-07 04:47:11','2026-06-07 04:47:11'),(42,6,'user','hi','2026-06-07 04:49:54','2026-06-07 04:49:54'),(43,6,'assistant','Hi there! How can I help you today?','2026-06-07 04:49:56','2026-06-07 04:49:56'),(44,7,'user','give me prompt with love','2026-06-07 04:50:19','2026-06-07 04:50:19'),(45,7,'assistant','Here are a few prompt ideas with love, with different vibes and focuses. Choose the one that sparks your imagination!\n\n**For a Romantic Story:**\n\n*   \"Write a story about two people who find love in the most unexpected of places – perhaps during a chaotic event, a mundane chore, or a moment of quiet solitude. Explore the small gestures and unspoken understandings that blossom into deep affection.\"\n\n**For a More Emotional/Reflective Piece:**\n\n*   \"Describe the feeling of first love, not just the butterflies, but the overwhelming sense of discovery and the way it changes your perception of the world. Focus on the sensory details and the internal shifts it causes.\"\n\n**For a Bit of Fantasy/Magic:**\n\n*   \"Imagine a world where love has a tangible, magical property. What happens when someone\'s love is too strong? Or too weak? Tell a story about a character who wields or is affected by this \'love magic\'.\"\n\n**For a Prompt about a Different Kind of Love:**\n\n*   \"Explore the enduring love between siblings, or the fierce protective love of a parent for their child. Show how this love manifests over time, through challenges and triumphs.\"\n\n**For a More Abstract/Metaphorical Prompt:**\n\n*   \"Love is a garden. Describe the different kinds of love as flowers, each unique in its beauty, its needs, and its fragrance. What kind of gardener are you?\"\n\n**To make it even more specific, you could add:**\n\n*   **Setting:** \"...set in a bustling city/a secluded cabin/a historical era.\"\n*   **Conflict:** \"...where an obstacle stands between them.\"\n*   **Characters:** \"...featuring a shy artist and a boisterous musician.\"\n*   **Tone:** \"...with a touch of humor/drama/melancholy.\"\n\n**For example, combining elements:**\n\n*   \"Write a story set in a quiet coastal town about two unlikely friends – a cynical lighthouse keeper and an optimistic marine biologist – who slowly discover a deep and unexpected love for each other. Focus on the small moments of shared sunsets and quiet conversations that build from friendship to something more profound.\"\n\nWhich of these resonates with you, or would you like me to generate another one with a different focus?','2026-06-07 04:50:23','2026-06-07 04:50:23'),(46,8,'user','Hello','2026-06-08 00:23:56','2026-06-08 00:23:56'),(47,8,'assistant','Hello! How can I help you today?','2026-06-08 00:23:59','2026-06-08 00:23:59'),(48,8,'user','Can I know who you are ?','2026-06-08 00:24:11','2026-06-08 00:24:11'),(49,8,'assistant','I am a large language model, trained by Google.','2026-06-08 00:24:12','2026-06-08 00:24:12'),(50,8,'user','give me C++ for Hello World','2026-06-08 00:24:28','2026-06-08 00:24:28'),(51,8,'assistant','```cpp\n#include <iostream>\n\nint main() {\n  std::cout << \"Hello, World!\" << std::endl;\n  return 0;\n}\n```\n\n**Explanation:**\n\n*   **`#include <iostream>`:** This line includes the input/output stream library. It provides functionalities for input and output operations, most importantly for printing to the console using `std::cout`.\n*   **`int main() { ... }`:** This is the main function, the entry point of every C++ program. The `int` indicates that the function will return an integer value, and `0` is conventionally returned to signify successful execution.\n*   **`std::cout << \"Hello, World!\" << std::endl;`:**\n    *   `std::cout`: This is the standard output stream object. It\'s used to display output on the console.\n    *   `<<`: This is the insertion operator. It inserts the data on its right into the stream on its left.\n    *   `\"Hello, World!\"`: This is the string literal that will be printed to the console.\n    *   `std::endl`: This is a manipulator that inserts a newline character and flushes the output buffer. This means the cursor will move to the next line after printing \"Hello, World!\".\n*   **`return 0;`:** This statement indicates that the `main` function has successfully completed its execution.\n\n**How to Compile and Run:**\n\nYou\'ll need a C++ compiler (like g++ or Clang) installed on your system.\n\n1.  **Save the code:** Save the code in a file named `hello.cpp` (or any other name with a `.cpp` extension).\n2.  **Open a terminal or command prompt.**\n3.  **Navigate to the directory where you saved the file.**\n4.  **Compile the code:**\n    *   If you\'re using g++, you can compile it with:\n        ```bash\n        g++ hello.cpp -o hello\n        ```\n        This command compiles `hello.cpp` and creates an executable file named `hello` (or `hello.exe` on Windows).\n5.  **Run the executable:**\n    *   On Linux/macOS:\n        ```bash\n        ./hello\n        ```\n    *   On Windows:\n        ```bash\n        hello.exe\n        ```\n\nYou should see the output:\n\n```\nHello, World!\n```','2026-06-08 00:24:31','2026-06-08 00:24:31'),(52,8,'user','can you give me prompt to create a website ?','2026-06-08 00:24:49','2026-06-08 00:24:49'),(53,8,'assistant','Okay, to give you the best prompt for creating a website, I need a little more information about what kind of website you have in mind. Think about these questions:\n\n1.  **What is the *purpose* of the website?**\n    *   Is it a personal blog?\n    *   A portfolio for your work (art, design, writing, etc.)?\n    *   A business website (e.g., for a local shop, a service provider, a startup)?\n    *   An e-commerce store to sell products?\n    *   An informational site for a cause or hobby?\n    *   A community forum or social platform?\n    *   A landing page for an event or product?\n\n2.  **Who is the *target audience*?**\n    *   General public?\n    *   Specific age groups (e.g., teenagers, seniors)?\n    *   Professionals in a certain industry?\n    *   People interested in a particular hobby?\n\n3.  **What is the *main content* or key features you want to include?**\n    *   Text articles/blog posts?\n    *   Images and galleries?\n    *   Videos?\n    *   Product listings and a shopping cart?\n    *   Contact forms?\n    *   User accounts or login system?\n    *   A map integration?\n    *   Integration with social media?\n\n4.  **What is the *desired aesthetic or style*?**\n    *   Modern and minimalist?\n    *   Classic and elegant?\n    *   Playful and vibrant?\n    *   Professional and corporate?\n    *   Rustic or vintage?\n    *   Are there any specific colors, fonts, or imagery you have in mind?\n\n5.  **What is your *technical skill level* or what tools are you comfortable using?**\n    *   Do you want a code-free solution (like Wix, Squarespace, Shopify)?\n    *   Are you comfortable with website builders (like WordPress.com or WordPress.org with themes)?\n    *   Are you looking to code it yourself using HTML, CSS, JavaScript, and potentially a framework?\n    *   Do you have a specific platform or technology in mind (e.g., React, Vue, Angular, Static Site Generator)?\n\n**Once you give me some of these details, I can craft a much more specific and helpful prompt!**\n\n---\n\n**However, if you want a *general starting prompt* that you can then refine, here\'s a good one:**\n\n---\n\n**General Website Creation Prompt:**\n\n\"I want to create a website. Please help me outline the essential steps and considerations. My goal is to build a [**describe the primary purpose of your website, e.g., personal blog to share my photography, online portfolio for my graphic design skills, small business website for my bakery, e-commerce store for handmade jewelry**]. The target audience is [**describe your main visitors, e.g., potential clients, photography enthusiasts, local community members, online shoppers**]. I envision the website having features like [**list 1-3 key features, e.g., a photo gallery, a contact form, product listings with descriptions, a blog section**]. The overall style should be [**describe desired aesthetic, e.g., clean and modern, warm and inviting, professional and minimalist**]. I\'m open to suggestions on platforms and tools, but I\'m [**mention your comfort level, e.g., a beginner with no coding experience, somewhat familiar with WordPress, comfortable with web development technologies**].\"\n\n---\n\n**Why this prompt is good:**\n\n*   It clearly states the goal.\n*   It defines the audience.\n*   It highlights key desired features.\n*   It touches upon the aesthetic.\n*   It provides context about your technical comfort.\n\nLooking forward to hearing more about your website idea!','2026-06-08 00:24:54','2026-06-08 00:24:54'),(54,9,'user','hi','2026-06-08 02:02:17','2026-06-08 02:02:17'),(55,10,'user','hi','2026-06-08 03:14:29','2026-06-08 03:14:29'),(56,10,'assistant','Hi there! How can I help you today?','2026-06-08 03:14:32','2026-06-08 03:14:32'),(57,11,'user','hi','2026-06-08 13:35:41','2026-06-08 13:35:41'),(58,11,'assistant','Hi there! How can I help you today?','2026-06-08 13:35:42','2026-06-08 13:35:42'),(59,12,'user','hi','2026-06-08 16:17:43','2026-06-08 16:17:43'),(60,12,'assistant','Hi there! How can I help you today?','2026-06-08 16:17:45','2026-06-08 16:17:45'),(61,13,'user','hi','2026-06-08 16:21:50','2026-06-08 16:21:50'),(62,13,'assistant','Hi there! How can I help you today? 😊','2026-06-08 16:21:51','2026-06-08 16:21:51'),(63,14,'user','hoo','2026-06-08 16:24:53','2026-06-08 16:24:53'),(64,14,'assistant','That\'s a fun sound! \"Hoo\" can mean a lot of things depending on the context.\n\nAre you trying to:\n\n*   **Imitate an owl?** Hooooo! 🦉\n*   **Express surprise or excitement?** Like \"Hoo-ray!\"\n*   **Say \"who\"?** As in \"Hoo goes there?\"\n*   **Just making a sound?** Sometimes \"hoo\" is just a vocalization.\n\nWhat were you thinking of when you typed \"hoo\"? I\'d love to know!','2026-06-08 16:24:55','2026-06-08 16:24:55'),(65,15,'user','hi','2026-06-10 04:32:37','2026-06-10 04:32:37'),(66,15,'assistant','Hi there! How can I help you today?','2026-06-10 04:32:39','2026-06-10 04:32:39'),(67,15,'user','can i know who you are ?','2026-06-10 04:32:47','2026-06-10 04:32:47'),(68,15,'assistant','I am a large language model, trained by Google.','2026-06-10 04:32:49','2026-06-10 04:32:49'),(69,15,'user','what do you know about this website ?','2026-06-10 04:33:11','2026-06-10 04:33:11'),(70,15,'assistant','I don\'t have access to the internet or any specific knowledge about the current website you are on. My knowledge is based on the massive dataset of text and code I was trained on.\n\nTherefore, I can\'t tell you anything about **this specific website**.\n\nIf you can tell me the **name of the website** or **describe its content**, I might be able to tell you general information about that topic or type of website, based on my training data.\n\nFor example, you could ask me about:\n\n*   \"What is Wikipedia?\"\n*   \"What are e-commerce websites typically like?\"\n*   \"What kind of information can I find on a news website?\"','2026-06-10 04:33:13','2026-06-10 04:33:13'),(71,15,'user','Give me c++ code','2026-06-10 04:33:45','2026-06-10 04:33:45'),(72,15,'assistant','Sure, I can give you C++ code! To give you the most useful code, I need a little more information.\n\nWhat would you like the C++ code to do? For example, are you looking for:\n\n*   **A simple \"Hello, World!\" program?** (This is a classic starting point.)\n*   **Code to perform a specific task?** (e.g., calculate the factorial of a number, sort an array, read from a file, etc.)\n*   **An example of a particular C++ concept?** (e.g., classes, pointers, templates, etc.)\n*   **Code for a small game or application?**\n*   **Something else entirely?**\n\nOnce you tell me what you\'re looking for, I can provide you with relevant C++ code.\n\nIn the meantime, here\'s a very basic \"Hello, World!\" program as a starting point:\n\n```cpp\n#include <iostream> // This line includes the input/output stream library\n\nint main() { // The main function where program execution begins\n    std::cout << \"Hello, World!\" << std::endl; // std::cout is used to print to the console, std::endl adds a newline\n    return 0; // Indicates that the program executed successfully\n}\n```\n\n**How to compile and run this code:**\n\n1.  **Save:** Save the code in a file named `hello.cpp` (or any other name ending with `.cpp`).\n2.  **Compile:** Open a terminal or command prompt and use a C++ compiler (like g++) to compile it:\n    ```bash\n    g++ hello.cpp -o hello\n    ```\n3.  **Run:** Execute the compiled program:\n    ```bash\n    ./hello\n    ```\n\nYou should see the output: `Hello, World!`\n\nLet me know what you\'d like to see next!','2026-06-10 04:33:48','2026-06-10 04:33:48'),(73,15,'user','java for hello world','2026-06-10 04:34:08','2026-06-10 04:34:08'),(74,15,'assistant','Okay, here\'s the \"Hello, World!\" program in Java:\n\n```java\npublic class HelloWorld { // Declares a public class named HelloWorld\n\n    public static void main(String[] args) { // The main method where program execution begins\n        System.out.println(\"Hello, World!\"); // System.out.println prints the string to the console and adds a newline\n    }\n}\n```\n\n**How to compile and run this Java code:**\n\n1.  **Save:** Save the code in a file named `HelloWorld.java`. The filename **must** match the class name exactly (case-sensitive).\n2.  **Compile:** Open a terminal or command prompt and use the Java compiler (`javac`) to compile the code:\n    ```bash\n    javac HelloWorld.java\n    ```\n    This will create a `HelloWorld.class` file if there are no errors.\n3.  **Run:** Execute the compiled Java code using the Java Virtual Machine (`java`):\n    ```bash\n    java HelloWorld\n    ```\n\nYou should see the output: `Hello, World!`\n\n**Explanation of the code:**\n\n*   `public class HelloWorld { ... }`: This defines a class named `HelloWorld`. In Java, all code resides within classes. `public` means this class can be accessed from anywhere.\n*   `public static void main(String[] args) { ... }`: This is the special `main` method. It\'s the entry point of your Java application.\n    *   `public`: Accessible from anywhere.\n    *   `static`: Means the method belongs to the `HelloWorld` class itself, not to any specific object of the class. You can call it without creating an instance of `HelloWorld`.\n    *   `void`: Indicates that this method does not return any value.\n    *   `main`: The name of the method that the Java runtime looks for to start execution.\n    *   `(String[] args)`: This specifies that the `main` method can accept an array of strings as command-line arguments (though we\'re not using them in this simple example).\n*   `System.out.println(\"Hello, World!\");`: This is the statement that does the actual printing.\n    *   `System`: A built-in Java class.\n    *   `out`: A static member of the `System` class, representing the standard output stream (your console).\n    *   `println()`: A method of the `out` object that prints the given string followed by a newline character.\n\nDo you have any other Java code examples you\'d like to see, or perhaps another programming language?','2026-06-10 04:34:11','2026-06-10 04:34:11'),(75,15,'user','write me 10 sentances for sad love','2026-06-10 04:34:50','2026-06-10 04:34:50'),(76,15,'assistant','Here are 10 sentences capturing the essence of sad love:\n\n1.  The silence between us grew louder than any argument we ever had.\n2.  I trace the ghost of your touch on my skin, a constant, aching reminder of what\'s lost.\n3.  Every song on the radio seems to whisper your name, a cruel melody of our fractured past.\n4.  My heart feels like a forgotten room, filled with the echoes of laughter we no longer share.\n5.  I see your face in every crowd, a fleeting glimpse that only deepens the emptiness.\n6.  Love, once a vibrant fire, has dwindled to embers, casting long, lonely shadows.\n7.  The future we dreamed of together is now a landscape I walk alone, tinged with regret.\n8.  I hold onto the memories, a bittersweet comfort that paradoxically fuels my sorrow.\n9.  There\'s a quiet ache in my chest, a space where your presence used to be a warm embrace.\n10. We built a beautiful world, only to watch it crumble, leaving behind only the dust of what might have been.','2026-06-10 04:34:53','2026-06-10 04:34:53');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2026_06_02_180000_create_users_table',1),(2,'2026_06_02_180337_create_categories_table',1),(3,'2026_06_02_180348_create_prompts_table',1),(4,'2026_06_02_180354_create_favorites_table',1),(5,'2026_06_02_180359_create_tags_table',1),(6,'2026_06_02_180404_create_prompt_tag_table',1),(7,'2026_06_03_030827_add_views_count_to_prompts_table',1),(8,'2026_06_04_002410_create_follows_table',2),(9,'2026_06_04_004419_add_is_featured_to_prompts_table',3),(10,'2026_06_04_010955_create_collections_table',4),(11,'2026_06_04_011026_create_collection_prompt_table',4),(12,'2026_06_04_195440_create_achievements_table',5),(13,'2026_06_04_200210_create_achievement_user_table',6),(14,'2026_06_04_200729_drop_icon_from_achievements_table',7),(15,'2026_06_04_205656_create_comments_table',8),(16,'2026_06_04_214959_create_notifications_table',9),(17,'2026_06_04_221853_create_ratings_table',10),(18,'2026_06_05_002402_add_is_admin_to_users_table',11),(19,'2026_06_06_043432_create_conversations_table',12),(20,'2026_06_06_043443_create_messages_table',12);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_user_id_foreign` (`user_id`),
  CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,1,'John followed you',1,'2026-06-04 21:55:47','2026-06-06 21:25:36'),(2,1,'Sarah commented on your prompt',1,'2026-06-04 21:55:47','2026-06-06 21:25:36'),(3,1,'Alex favorited your prompt',1,'2026-06-04 21:55:47','2026-06-06 21:25:36'),(4,1,'John followed you.',1,'2026-06-04 21:57:16','2026-06-06 21:25:36'),(5,1,'Sarah commented on your prompt \"Modern SaaS Landing Page\".',1,'2026-06-04 21:57:16','2026-06-06 21:25:36'),(6,1,'Alex favorited your prompt.',1,'2026-06-04 21:57:16','2026-06-06 21:25:36'),(7,1,'Michael copied your prompt \"Laravel Admin Dashboard\".',1,'2026-06-04 21:57:16','2026-06-06 21:25:36'),(8,1,'Emily added your prompt to a collection.',1,'2026-06-04 21:57:16','2026-06-06 21:25:36'),(9,1,'David followed you.',1,'2026-06-04 21:57:16','2026-06-06 21:25:36'),(10,1,'Anna commented on your prompt \"AI Productivity Assistant\".',1,'2026-06-04 21:57:16','2026-06-06 21:25:36'),(11,1,'Kevin favorited your prompt \"Anime Character Portrait\".',1,'2026-06-04 21:57:16','2026-06-06 21:25:36'),(12,1,'Jessica copied your prompt.',1,'2026-06-04 21:57:16','2026-06-06 21:25:36'),(13,1,'Your prompt \"NextJS SaaS Starter\" is trending this week! ?',1,'2026-06-04 21:57:16','2026-06-06 21:25:36'),(14,1,'James started following you.',1,'2026-06-04 22:06:52','2026-06-06 21:25:36'),(15,1,'Sophia commented: \"Amazing prompt! ?\"',1,'2026-06-04 22:06:52','2026-06-06 21:25:36'),(16,1,' started following you.',1,'2026-06-06 21:36:55','2026-06-06 21:37:09'),(17,1,' just unfollow you.',1,'2026-06-06 21:40:01','2026-06-06 21:40:59'),(18,1,' just following you.',1,'2026-06-06 21:40:04','2026-06-06 21:40:59'),(20,1,'me just unfollow you.',1,'2026-06-06 21:43:52','2026-06-06 21:44:04'),(23,1,'me just following you.',1,'2026-06-08 00:21:08','2026-06-08 00:21:20'),(24,1,'me just following you.',1,'2026-06-08 13:32:07','2026-06-08 13:35:25'),(25,4,'Nairith just following you.',1,'2026-06-10 04:30:37','2026-06-10 04:37:25'),(26,4,'Nairith just unfollow you.',1,'2026-06-10 04:37:03','2026-06-10 04:37:27'),(27,4,'Nairith just following you.',1,'2026-06-10 04:37:04','2026-06-10 04:37:27');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prompt_tag`
--

DROP TABLE IF EXISTS `prompt_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prompt_tag` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `prompt_id` bigint unsigned NOT NULL,
  `tag_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `prompt_tag_prompt_id_foreign` (`prompt_id`),
  KEY `prompt_tag_tag_id_foreign` (`tag_id`),
  CONSTRAINT `prompt_tag_prompt_id_foreign` FOREIGN KEY (`prompt_id`) REFERENCES `prompts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `prompt_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prompt_tag`
--

LOCK TABLES `prompt_tag` WRITE;
/*!40000 ALTER TABLE `prompt_tag` DISABLE KEYS */;
INSERT INTO `prompt_tag` VALUES (1,1,1),(2,1,2),(3,1,3),(4,1,8),(5,1,9),(6,2,7),(7,2,12),(8,3,1),(9,3,4),(10,3,21),(11,4,19),(12,4,20),(13,4,16),(16,7,22),(18,13,22);
/*!40000 ALTER TABLE `prompt_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prompts`
--

DROP TABLE IF EXISTS `prompts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prompts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `prompt_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `visibility` enum('public','private') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'public',
  `copy_count` bigint unsigned NOT NULL DEFAULT '0',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `views_count` bigint unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `prompts_slug_unique` (`slug`),
  KEY `prompts_user_id_foreign` (`user_id`),
  KEY `prompts_category_id_foreign` (`category_id`),
  CONSTRAINT `prompts_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `prompts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prompts`
--

LOCK TABLES `prompts` WRITE;
/*!40000 ALTER TABLE `prompts` DISABLE KEYS */;
INSERT INTO `prompts` VALUES (1,1,2,'Modern SaaS Landing Page','modern-saas-landing-page',NULL,'Create a modern SaaS landing page with glassmorphism cards, dark UI, responsive layout, premium typography, animated CTA buttons, dashboard sections, testimonials, and startup branding inspired by modern AI companies.','public',44,1,'2026-06-03 03:13:38','2026-06-08 15:52:28',257),(2,1,7,'Anime Character Portrait','anime-character-portrait',NULL,'Generate an ultra detailed anime cyberpunk girl portrait in Tokyo night with neon lighting, cinematic atmosphere, dramatic reflections, futuristic outfit, glowing eyes, and realistic textures.','public',88,1,'2026-06-03 03:13:38','2026-06-08 13:07:41',362),(3,1,2,'Laravel Admin Dashboard','laravel-admin-dashboard',NULL,'Build a professional Laravel admin dashboard using Tailwind CSS with analytics cards, charts, dark mode support, authentication system, responsive sidebar navigation, and modern SaaS design.','public',122,0,'2026-06-03 03:13:38','2026-06-04 16:49:01',519),(4,1,1,'AI Productivity Assistant','ai-productivity-assistant',NULL,'Create an AI assistant interface that helps users manage tasks, summarize notes, generate productivity reports, automate workflows, and improve personal efficiency with clean futuristic UI.','public',201,1,'2026-06-03 03:13:38','2026-06-08 03:38:02',664),(6,1,1,'React Admin Dashboard','react-admin-dashboard',NULL,'Create a modern React admin dashboard with charts, analytics cards, dark mode, and responsive layout.','public',88,0,'2026-06-04 02:26:20','2026-06-08 13:15:05',463),(7,1,1,'YouTube Script Generator','youtube-script-generator',NULL,'Generate a 10-minute YouTube video script about AI trends in 2026 with engaging storytelling.','public',67,0,'2026-06-04 02:26:20','2026-06-08 13:07:58',349),(8,1,3,'Fitness Coach Assistant','fitness-coach-assistant',NULL,'Act as a professional fitness coach and create a personalized 12-week workout plan.','public',52,0,'2026-06-04 02:26:20','2026-06-08 12:56:46',282),(9,1,1,'NextJS SaaS Starter','nextjs-saas-starter',NULL,'Build a complete SaaS starter kit using Next.js, Tailwind CSS, authentication, and Stripe integration.','public',124,1,'2026-06-04 02:26:20','2026-06-04 17:07:43',579),(13,4,2,'c c','c-c',NULL,'vcvc','public',0,0,'2026-06-08 16:12:19','2026-06-08 16:12:59',1);
/*!40000 ALTER TABLE `prompts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ratings`
--

DROP TABLE IF EXISTS `ratings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ratings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `prompt_id` bigint unsigned NOT NULL,
  `rating` tinyint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ratings_user_id_prompt_id_unique` (`user_id`,`prompt_id`),
  KEY `ratings_prompt_id_foreign` (`prompt_id`),
  CONSTRAINT `ratings_prompt_id_foreign` FOREIGN KEY (`prompt_id`) REFERENCES `prompts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ratings`
--

LOCK TABLES `ratings` WRITE;
/*!40000 ALTER TABLE `ratings` DISABLE KEYS */;
INSERT INTO `ratings` VALUES (2,1,6,4,'2026-06-04 15:27:00','2026-06-07 03:40:30'),(3,1,9,5,'2026-06-04 15:35:26','2026-06-04 16:12:22'),(4,1,7,5,'2026-06-04 16:00:59','2026-06-04 16:00:59'),(6,1,4,5,'2026-06-04 16:10:19','2026-06-04 16:10:46'),(7,1,3,5,'2026-06-04 16:10:59','2026-06-04 16:10:59'),(8,1,8,5,'2026-06-04 16:11:35','2026-06-08 15:51:37'),(10,1,1,5,'2026-06-04 16:36:34','2026-06-04 16:36:34'),(11,1,2,4,'2026-06-04 16:36:38','2026-06-04 16:40:47'),(13,4,13,3,'2026-06-08 16:12:24','2026-06-08 16:12:24');
/*!40000 ALTER TABLE `ratings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tags` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tags_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES (1,'Laravel','laravel','2026-06-03 03:13:38','2026-06-03 03:13:38'),(2,'React','react','2026-06-03 03:13:38','2026-06-03 03:13:38'),(3,'Tailwind','tailwind','2026-06-03 03:13:38','2026-06-03 03:13:38'),(4,'PHP','php','2026-06-03 03:13:38','2026-06-03 03:13:38'),(5,'JavaScript','javascript','2026-06-03 03:13:38','2026-06-03 03:13:38'),(6,'UIUX','uiux','2026-06-03 03:13:38','2026-06-03 03:13:38'),(7,'Cyberpunk','cyberpunk','2026-06-03 03:13:38','2026-06-03 03:13:38'),(8,'Startup','startup','2026-06-03 03:13:38','2026-06-03 03:13:38'),(9,'Portfolio','portfolio','2026-06-03 03:13:38','2026-06-03 03:13:38'),(10,'Mobile','mobile','2026-06-03 03:13:38','2026-06-03 03:13:38'),(11,'Dark Mode','dark-mode','2026-06-03 03:13:38','2026-06-03 03:13:38'),(12,'Creative','creative','2026-06-03 03:13:38','2026-06-03 03:13:38'),(13,'SEO','seo','2026-06-03 03:13:38','2026-06-03 03:13:38'),(14,'Marketing','marketing','2026-06-03 03:13:38','2026-06-03 03:13:38'),(15,'Business','business','2026-06-03 03:13:38','2026-06-03 03:13:38'),(16,'Automation','automation','2026-06-03 03:13:38','2026-06-03 03:13:38'),(17,'Freelance','freelance','2026-06-03 03:13:38','2026-06-03 03:13:38'),(18,'Ecommerce','ecommerce','2026-06-03 03:13:38','2026-06-03 03:13:38'),(19,'AI','ai','2026-06-03 03:13:38','2026-06-03 03:13:38'),(20,'Productivity','productivity','2026-06-03 03:13:38','2026-06-03 03:13:38'),(21,'Dashboard','dashboard','2026-06-03 03:13:38','2026-06-03 03:13:38'),(22,'image','image','2026-06-08 12:06:44','2026-06-08 12:06:44');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` text COLLATE utf8mb4_unicode_ci,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Nairith','you@gmail.com',NULL,'$2y$12$X3WO7Zr8knI5axMqT9V1QuEO6jyBtJTN.z5cls27HW0UiEvJgbsFy','/storage/avatars/p2Q1YOSOyArm1U8CRtwWKXFwezg8brbnWtswbkvX.jpg','Hello',NULL,'2026-06-03 03:13:38','2026-06-08 11:02:42',1),(4,'me','me@gmail.com',NULL,'$2y$12$PvArRH.OTup0OkpXlINBXO/04g4J8odoN3xbkRS6raHGAe1CIF04a','https://imgs.search.brave.com/7BCZo5Ly3LA2lUhTRjICl9Amwg6jOdA3Q_f3Qliefpk/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9ibG9n/Z2VyLmdvb2dsZXVz/ZXJjb250ZW50LmNv/bS9pbWcvYi9SMjl2/WjJ4bC9BVnZYc0Vn/X0FfQkZtckJNYjVo/RFV1SXg1cmFPc1cz/OUVGUUR1RFVvU0RM/T1BuZ0hIRmd2aGkt/Q251TEhIMkFhNDJt/cHJQbklWNVN2aEFI/bWt0ZGtzckVqNkVS/YnFrZ3NWbHZyR004/TmRWd1dtSF9qakR2/OFF1MTFBVklkQld0/T05ZMkFGMkdrcHpa/N1IteFFVYjJaZDFX/bzlQRy1SWUlCdlcy/OWhNSG05aVAzdzk0/Q2FIaWNCSHVEUmtz/VmphajV3Z0lsL3Mx/NjAwMC1ydy9nb2pv/LXBmcC01OC5qcGc','See me you already dead',NULL,'2026-06-08 13:31:47','2026-06-08 16:11:12',1),(5,'he','he@gmail.com',NULL,'$2y$12$RF1q6kpuLnU42CprRY4B.O1k43el22qqGQGqGdzzGaXq1pBGlAy3.',NULL,NULL,NULL,'2026-06-08 13:32:37','2026-06-08 13:32:37',0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-10 20:15:12
