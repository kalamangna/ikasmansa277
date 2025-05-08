
<h2>Daftar Pages</h2>
<p><a href="<?php echo site_url('admin/add_page'); ?>">Tambah Page Baru</a></p>

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Slug</th>
        <th>Aksi</th>
    </tr>
    <?php 
    if (!empty($pages)):
        $i=1; 
        ?>
        <?php foreach($pages as $page): ?>
        <tr>
            <td><?=$i?></td>
            <td><a href="<?php echo site_url('pages/index/'.$page['slug']); ?>"><?php echo $page['title']; ?></a></td>
            <td><?php echo $page['slug']; ?></td>
            <td>
                <a href="<?php echo site_url('admin/edit_page/'.$page['id']); ?>">Edit</a> | 
                <a href="<?php echo site_url('admin/delete_page/'.$page['id']); ?>" onclick="return confirm('Yakin ingin menghapus page ini?')">Hapus</a>
            </td>
        </tr>
        <?php
            $i++; 
            endforeach; 
        ?>
    <?php else: ?>
        <tr><td colspan="4">Belum ada data page.</td></tr>
    <?php endif; ?>
</table>
