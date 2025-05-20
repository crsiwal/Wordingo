<!doctype html>
<html amp lang="en">
<head>
    <meta charset="utf-8">
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <title><?= esc($post['title']) ?></title>
    <link rel="canonical" href="<?= base_url('blog/' . $post['slug']) ?>">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style>
    <noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
    <style amp-custom>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 1rem;
        }
        .header {
            margin-bottom: 2rem;
        }
        .title {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        .meta {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        .content {
            margin-bottom: 2rem;
        }
        .content p {
            margin-bottom: 1rem;
        }
        .content img {
            max-width: 100%;
            height: auto;
            margin: 1rem 0;
        }
        .tags {
            margin-top: 2rem;
        }
        .tag {
            display: inline-block;
            background: #f0f0f0;
            padding: 0.3rem 0.6rem;
            border-radius: 3px;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
            color: #666;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <article>
        <header class="header">
            <h1 class="title"><?= esc($post['title']) ?></h1>
            <div class="meta">
                <span>By <?= esc($post['user']['name']) ?></span>
                <span>•</span>
                <span><?= date('M d, Y', strtotime($post['published_at'])) ?></span>
                <span>•</span>
                <span><?= $post['views'] ?> views</span>
            </div>
        </header>

        <?php if ($post['thumbnail']): ?>
            <amp-img src="<?= base_url('files/' . $post['user_id'] . '/' . $post['id'] . '/' . $post['thumbnail']) ?>"
                     width="800"
                     height="400"
                     layout="responsive"
                     alt="<?= esc($post['title']) ?>">
            </amp-img>
        <?php endif; ?>

        <div class="content">
            <?= $post['content'] ?>
        </div>

        <?php if (!empty($post['tags'])): ?>
            <div class="tags">
                <?php foreach ($post['tags'] as $tag): ?>
                    <a href="<?= base_url('tag/' . $tag['slug']) ?>" class="tag">
                        #<?= esc($tag['name']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </article>
</body>
</html> 