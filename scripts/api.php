<?php

define('OPENAI_API_KEY', 'for Run get this from the .env file');
// define('MODEL', 'gpt-4'); // or 'gpt-3.5-turbo'
define('MODEL', 'gpt-3.5-turbo');

// Call OpenAI chat completion API
function callOpenAI($messages) {
    $postData = [
        'model' => MODEL,
        'messages' => $messages,
        'temperature' => 0.7
    ];

    $ch = curl_init('https://api.openai.com/v1/chat/completions');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . OPENAI_API_KEY
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    $response = curl_exec($ch);
    curl_close($ch);

    var_dump($response);


    $result = json_decode($response, true);
    return $result['choices'][0]['message']['content'] ?? null;
}

// Get 50 hot topics
function getTrendingTopics($count = 50) {
    $prompt = "Act like a content strategist. Based on today’s global trends, news, and internet buzz, give me a numbered list of $count hot and trending article topics. Include topics from tech, finance, health, entertainment, lifestyle, and business. Keep each topic clear and concise.";
    $messages = [
        ['role' => 'system', 'content' => 'You are a professional content generator.'],
        ['role' => 'user', 'content' => $prompt]
    ];
    $response = callOpenAI($messages);
    return array_map('trim', explode("\n", $response));
}

// Generate full article for a topic
function generateArticle($topic) {
    $prompt = "Write a blog article on: \"$topic\".\n\nInclude:\n- A catchy title\n- A short meta description\n- 500-700 word article\n- Suggested tags\n- An image prompt to generate a relevant cover image";

    $messages = [
        ['role' => 'system', 'content' => 'You are a professional content writer.'],
        ['role' => 'user', 'content' => $prompt]
    ];

    $response = callOpenAI($messages);

    // Basic parsing (could be enhanced with regex)
    preg_match('/Title:\s*(.+)/i', $response, $title);
    preg_match('/Meta Description:\s*(.+)/i', $response, $desc);
    preg_match('/Tags:\s*(.+)/i', $response, $tags);
    preg_match('/Image Prompt:\s*(.+)/i', $response, $image);

    // Remove headers
    $content = preg_replace('/Title:.*|Meta Description:.*|Tags:.*|Image Prompt:.*/i', '', $response);

    return [
        'title' => $title[1] ?? $topic,
        'meta' => $desc[1] ?? '',
        'content' => trim($content),
        'tags' => isset($tags[1]) ? array_map('trim', explode(',', $tags[1])) : [],
        'image_prompt' => $image[1] ?? ''
    ];
}

// Placeholder publishing function
function publishToWebsite($article) {
    if (!isset($article['title'])) {
        echo "No title found for article: " . json_encode($article) . "\n";
        return false;
    }

    // Example payload for your custom CMS or WordPress REST API
    $postData = [
        'title' => $article['title'],
        'content' => $article['content'],
        'meta_description' => $article['meta'],
        'tags' => $article['tags'],
        'image_prompt' => $article['image_prompt'],
        'status' => 'future', // schedule it
        'publish_date' => date('c') // ISO format
    ];

    // Save content to posts directory by name of the title
    $filename = uniqid() . '.md';
    $filepath = __DIR__ . '/posts/' . $filename;
    file_put_contents($filepath, json_encode($article));

    // TODO: Replace with actual API request to your CMS
    echo "Publishing article: " . $article['title'] . "\n";
    // Example: send via cURL or save to DB
    // postToCMS($postData);
}

// Main Process
$topics = getTrendingTopics(1);
var_dump($topics);
if (empty($topics)) {
    echo "No topics found\n";
    exit;
}
$interval = 30; // minutes
$baseTime = strtotime(date('Y-m-d H:i:00'));

foreach ($topics as $i => $rawTopic) {
    if ($rawTopic) {
        $topic = preg_replace('/^\d+\.\s*/', '', $rawTopic);
        $article = generateArticle($topic);

        // Add future publish time
        $publishTime = $baseTime + ($i * $interval * 60);
        $article['publish_date'] = date('c', $publishTime);

        publishToWebsite($article);
    }
}
