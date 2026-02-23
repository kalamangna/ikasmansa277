<!-- Place the first <script> tag in your HTML's <head> -->
<script src="https://cdn.tiny.cloud/1/yk0hjcjh99vz5lepsktd8p6bb86y5idcm6e2n5cwy3yvo98z/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

<!-- Place the following <script> and <textarea> tags your HTML's <body> -->
<script>
  tinymce.init({
    selector: 'textarea',
    plugins: [
      // Core editing features
      'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
      // Your account includes a free trial of TinyMCE premium features
      // Try the most popular premium features until May 13, 2025:
      'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
    ],
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
  });
</script>

<h2>Edit Page</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('admin/edit_page/'.$page['id']); ?>

<p>
    <label for="title">Title</label><br>
    <input type="text" name="title" value="<?php echo set_value('title', $page['title']); ?>" required>
</p>

<p>
    <label for="content">Content</label><br>
    <textarea name="content"  id="content" rows="10" cols="50" required><?php echo set_value('content', $page['content']); ?></textarea>
</p>

<p>
    <input type="submit" value="Simpan">
    <a href="<?php echo site_url('admin/pages'); ?>">Batal</a>
</p>

<?php echo form_close(); ?>
