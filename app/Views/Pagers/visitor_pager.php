<?php

/**
 * Custom pager template for admin pages that preserves query parameters
 */

// Get all GET parameters except 'page'
$queryParams = $_GET;
unset($queryParams['page']);

// Build query string excluding 'page' parameter
$queryString = http_build_query($queryParams);
if (!empty($queryString)) {
    $queryString = '&' . $queryString;
}

$pager->setSurroundCount(2);

// Only show pagination if there is more than one page
if ($pager->getPageCount() > 1) :
?>

    <nav aria-label="<?= lang('Pager.pageNavigation') ?>">
        <ul class="pagination flex gap-1 list-none">
            <?php if ($pager->hasPrevious()) : ?>
                <li>
                    <a href="<?= $pager->getFirst() . $queryString ?>" aria-label="<?= lang('Pager.first') ?>" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-700 transition-colors">
                        <span aria-hidden="true"><?= lang('Pager.first') ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?= $pager->getPrevious() . $queryString ?>" aria-label="<?= lang('Pager.previous') ?>" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-700 transition-colors">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif ?>

            <?php foreach ($pager->links() as $link) : ?>
                <li <?= $link['active'] ? 'class="active"' : '' ?>>
                    <a href="<?= $link['uri'] . $queryString ?>" class="<?= $link['active'] ? 'px-4 py-2 bg-blue-500 text-white rounded-lg' : 'px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-700 transition-colors' ?>">
                        <?= $link['title'] ?>
                    </a>
                </li>
            <?php endforeach ?>

            <?php if ($pager->hasNext()) : ?>
                <li>
                    <a href="<?= $pager->getNext() . $queryString ?>" aria-label="<?= lang('Pager.next') ?>" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-700 transition-colors">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
                <li>
                    <a href="<?= $pager->getLast() . $queryString ?>" aria-label="<?= lang('Pager.last') ?>" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-700 transition-colors">
                        <span aria-hidden="true"><?= lang('Pager.last') ?></span>
                    </a>
                </li>
            <?php endif ?>
        </ul>
    </nav>
<?php endif; ?>