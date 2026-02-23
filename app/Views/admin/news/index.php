<h2>Daftar News</h2>
<p><a href="<?php echo site_url('admin/add_news'); ?>">Tambah News Baru</a></p>

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Slug</th>
        <th>Aksi</th>
    </tr>
    <?php if (!empty($news)): ?>
        <?php foreach($news as $item): ?>
        <tr>
            <td><?php echo $item['id']; ?></td>
            <td><?php echo $item['title']; ?></td>
            <td><?php echo $item['slug']; ?></td>
            <td>
                <a href="<?php echo site_url('admin/edit_news/'.$item['id']); ?>">Edit</a> | 
                <a href="<?php echo site_url('admin/delete_news/'.$item['id']); ?>" onclick="return confirm('Yakin ingin menghapus news ini?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="4">Belum ada data news.</td></tr>
    <?php endif; ?>
</table>
