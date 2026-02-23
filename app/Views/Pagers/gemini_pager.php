<?php

use CodeIgniter\Pager\PagerRenderer;

/**
 * @var PagerRenderer $pager
 */
$pager->setSurroundCount(2); // Show 2 pages on each side of the current page
?>

<nav class="flex justify-center items-center" aria-label="<?= lang('Pager.pageNavigation') ?>">
    <ul class="pagination flex items-center gap-x-2">
        <?php if ($pager->hasPrevious()) : ?>
            <li>
                <a href="<?= $pager->getFirst() ?>" aria-label="<?= lang('Pager.first') ?>" class="h-9 w-9 flex items-center justify-center rounded-xl bg-blue-50 text-blue-900 hover:bg-blue-900 hover:text-white transition-all shadow-sm border border-blue-100 text-sm font-bold">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li>
                <a href="<?= $pager->getPrevious() ?>" aria-label="<?= lang('Pager.previous') ?>" class="h-9 w-9 flex items-center justify-center rounded-xl bg-blue-50 text-blue-900 hover:bg-blue-900 hover:text-white transition-all shadow-sm border border-blue-100 text-sm font-bold">
                    <span aria-hidden="true">&lsaquo;</span>
                </a>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link) : ?>
            <li <?= $link['active'] ? 'class="active"' : '' ?>>
                <a href="<?= $link['uri'] ?>" class="h-9 w-9 flex items-center justify-center rounded-xl text-sm font-bold <?= $link['active'] ? 'bg-blue-900 text-white shadow-md border border-blue-900' : 'bg-white text-blue-900 shadow-sm border border-blue-100 hover:bg-blue-50 hover:text-blue-950 transition-colors' ?>">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNext()) : ?>
            <li>
                <a href="<?= $pager->getNext() ?>" aria-label="<?= lang('Pager.next') ?>" class="h-9 w-9 flex items-center justify-center rounded-xl bg-blue-50 text-blue-900 hover:bg-blue-900 hover:text-white transition-all shadow-sm border border-blue-100 text-sm font-bold">
                    <span aria-hidden="true">&rsaquo;</span>
                </a>
            </li>
            <li>
                <a href="<?= $pager->getLast() ?>" aria-label="<?= lang('Pager.last') ?>" class="h-9 w-9 flex items-center justify-center rounded-xl bg-blue-50 text-blue-900 hover:bg-blue-900 hover:text-white transition-all shadow-sm border border-blue-100 text-sm font-bold">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        <?php endif ?>
    </ul>
</nav>