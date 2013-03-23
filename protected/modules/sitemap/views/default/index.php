<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php foreach ($items as $item): ?>

    <url>
        <loc>http://<?php echo $_SERVER['SERVER_NAME']; ?><?php echo $item->url; ?></loc>
        <changefreq>daily</changefreq>
        <priority>0.5</priority>
    </url>
    <?php endforeach; ?>

</urlset>