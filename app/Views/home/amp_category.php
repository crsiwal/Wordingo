<!doctype html>
<html amp lang="en">
<head>
    <meta charset="utf-8">
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <title><?= esc($category['name']) ?> - Wordiqo</title>
    <link rel="canonical" href="<?= base_url('category/' . $category['slug']) ?>">
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
        .description {
            color: #666;
            margin-bottom: 2rem;
        }
        .post {
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid #eee;
        }
        .post:last-child {
            border-bottom: none;
        }
        .post-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        .post-title a {
            color: #333;
            text-decoration: none;
        }
        .post-meta {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        .post-excerpt {
            color: #666;
            margin-bottom: 1rem;
        }
        .pagination {
            margin-top: 2rem;
            text-align: center;
        }
        .pagination a {
            display: inline-block;
            padding: 0.5rem 1rem;
            margin: 0 0.25rem;
            border: 1px solid #ddd;
            border-radius: 3px;
            color: #666;
            text-decoration: none;
        }
        .pagination a.active {
            background: #f0f0f0;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title"><?= esc($category['name']) ?></h1>
        <?php if (!empty($category['description'])): ?>
            <p class="description"><?= esc($category['description']) ?></p>
        <?php endif; ?>
    </div>

    <?php if (empty($posts)): ?>
        <p>No posts found in this category.</p>
    <?php else: ?>
        <?php foreach ($posts as $post): ?>
            <article class="post">
                <h2 class="post-title">
                    <a href="<?= base_url('blog/' . $post['slug']) ?>">
                        <?= esc($post['title']) ?>
                    </a>
                </h2>
                
                <div class="post-meta">
                    <span>By <?= esc($post['user']['name']) ?></span>
                    <span>•</span>
                    <span><?= date('M d, Y', strtotime($post['published_at'])) ?></span>
                </div>

                <?php if ($post['thumbnail']): ?>
                    <amp-img src="<?= base_url('files/' . $post['user_id'] . '/' . $post['id'] . '/' . $post['thumbnail']) ?>"
                             width="800"
                             height="400"
                             layout="responsive"
                             alt="<?= esc($post['title']) ?>">
                    </amp-img>
                <?php endif; ?>

                <div class="post-excerpt">
                    <?= character_limiter(strip_tags($post['content']), 200) ?>
                </div>

                <a href="<?= base_url('blog/' . $post['slug']) ?>" class="read-more">
                    Read More
                </a>
            </article>
        <?php endforeach; ?>

        <?php if ($pager->getPageCount() > 1): ?>
            <div class="pagination">
                <?php if ($pager->hasPrevious()): ?>
                    <a href="<?= base_url('category/' . $category['slug'] . '?page=' . ($pager->getCurrentPage() - 1)) ?>">
                        Previous
                    </a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $pager->getPageCount(); $i++): ?>
                    <a href="<?= base_url('category/' . $category['slug'] . '?page=' . $i) ?>"
                       class="<?= $i === $pager->getCurrentPage() ? 'active' : '' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>

                <?php if ($pager->hasNext()): ?>
                    <a href="<?= base_url('category/' . $category['slug'] . '?page=' . ($pager->getCurrentPage() + 1)) ?>">
                        Next
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html> 