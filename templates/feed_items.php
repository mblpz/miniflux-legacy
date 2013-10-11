<?php if (empty($items)): ?>

    <p class="alert">
        <?= t('This subscription is empty, <a href="?action=unread">go back to unread items</a>') ?>
    </p>

<?php else: ?>

    <div class="page-header">
        <h2><?= Helper\escape($feed['title']) ?> (<?= $nb_items ?>)</h2>
        <ul>
            <li>
                <a href="?action=feed-items&amp;feed_id=<?= $feed['id'] ?>&amp;order=updated&amp;direction=<?= $direction == 'asc' ? 'desc' : 'asc' ?>"><?= t('sort by date<span class="hide-mobile"> (%s)</span>', $direction == 'desc' ? t('older first') : t('most recent first')) ?></a>
            </li>
            <li>
                <a href="?action=mark-feed-as-read&amp;feed_id=<?= $feed['id'] ?>" data-action="mark-feed-read" data-feed-id="<?= $feed['id'] ?>"><?= t('mark all as read') ?></a>
            </li>
        </ul>
    </div>

    <section class="items" id="listing">
    <?php foreach ($items as $item): ?>
        <article id="item-<?= $item['id'] ?>" data-item-id="<?= $item['id'] ?>" data-item-page="<?= $menu ?>">
            <h2>
                <?= $item['bookmark'] ? '<span id="bookmark-icon-'.$item['id'].'">★ </span>' : '' ?>
                <?= $item['status'] === 'read' ? '<span id="read-icon-'.$item['id'].'">☑ </span>' : '' ?>
                <a
                    href="?action=show&amp;menu=feed-items&amp;id=<?= $item['id'] ?>"
                    data-item-id="<?= $item['id'] ?>"
                    id="open-<?= $item['id'] ?>"
                    <?= $item['status'] === 'read' ? 'class="read"' : '' ?>
                >
                    <?= Helper\escape($item['title']) ?>
                </a>
            </h2>
            <p class="preview">
                <?= Helper\escape(Helper\summary(strip_tags($item['content']), 50, 300)) ?>
            </p>
            <p>
                <?= Helper\get_host_from_url($item['url']) ?> |
                <span class="hide-mobile"><?= dt('%e %B %Y %k:%M', $item['updated']) ?> |</span>

                <span class="hide-mobile">
                <?php if ($item['bookmark']): ?>
                    <a id="bookmark-<?= $item['id'] ?>" href="?action=bookmark&amp;value=0&amp;id=<?= $item['id'] ?>&amp;menu=feed-items&amp;offset=<?= $offset ?>&amp;feed_id=<?= $item['feed_id'] ?>"><?= t('remove bookmark') ?></a> |
                <?php else: ?>
                    <a id="bookmark-<?= $item['id'] ?>" href="?action=bookmark&amp;value=1&amp;id=<?= $item['id'] ?>&amp;menu=feed-items&amp;offset=<?= $offset ?>&amp;feed_id=<?= $item['feed_id'] ?>"><?= t('bookmark') ?></a> |
                <?php endif ?>
                </span>

                <?php if ($item['status'] == 'unread'): ?>
                    <a
                        href="?action=mark-item-read&amp;id=<?= $item['id'] ?>&amp;offset=<?= $offset ?>&amp;redirect=feed-items&amp;feed_id=<?= $item['feed_id'] ?>"
                    >
                        <?= t('mark as read') ?>
                    </a> |
                <?php else: ?>
                    <a
                        href="?action=mark-item-unread&amp;id=<?= $item['id'] ?>&amp;offset=<?= $offset ?>&amp;redirect=feed-items&amp;feed_id=<?= $item['feed_id'] ?>"
                    >
                        <?= t('mark as unread') ?>
                    </a> |
                <?php endif ?>

                <span class="hide-mobile">
                <a href="?action=mark-item-removed&amp;id=<?= $item['id'] ?>&amp;offset=<?= $offset ?>&amp;redirect=feed-items&amp;feed_id=<?= $item['feed_id'] ?>"><?= t('remove') ?></a> |
                </span>

                <a
                    href="<?= $item['url'] ?>"
                    id="original-<?= $item['id'] ?>"
                    rel="noreferrer"
                    target="_blank"
                    data-item-id="<?= $item['id'] ?>"
                >
                    <?= t('original link') ?>
                </a>
            </p>
        </article>
    <?php endforeach ?>

    <div id="bottom-menu">
        <a href="?action=mark-feed-as-read&amp;feed_id=<?= $feed['id'] ?>" data-action="mark-feed-read" data-feed-id="<?= $feed['id'] ?>"><?= t('mark all as read') ?></a>
    </div>

    <div id="items-paging">
    <?php if ($offset > 0): ?>
        <a id="previous-page" href="?action=feed-items&amp;feed_id=<?= $feed['id'] ?>&amp;offset=<?= ($offset - $items_per_page) ?>&amp;order=<?= $order ?>&amp;direction=<?= $direction ?>">« <?= t('Previous page') ?></a>
        &nbsp;-&nbsp;
    <?php endif ?>
    &nbsp;
    <?php if (($nb_items - $offset) > $items_per_page): ?>
        <a id="next-page" href="?action=feed-items&amp;feed_id=<?= $feed['id'] ?>&amp;offset=<?= ($offset + $items_per_page) ?>&amp;order=<?= $order ?>&amp;direction=<?= $direction ?>"><?= t('Next page') ?> »</a>
    <?php endif ?>
    </div>

    </section>

<?php endif ?>