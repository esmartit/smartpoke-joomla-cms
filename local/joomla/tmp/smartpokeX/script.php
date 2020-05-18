
<form name="upload" method="post" enctype="multipart/form-data">
    <input type="file" name="file_upload" />
    <input type="submit" />
</form>

<?php
/*
* File upload example
*/
// Retrieve file details from uploaded file, sent from upload form
$file = JFactory::getApplication()->input->files->get('file_upload');

// Import filesystem libraries. Perhaps not necessary, but does not hurt.
jimport('joomla.filesystem.file');

// Clean up filename to get rid of strange characters like spaces etc.
$filename = JFile::makeSafe($file['name']);

// Set up the source and destination of the file
$src = $file['tmp_name'];
$dest = JPATH_COMPONENT . DS . "uploads" . DS . $filename;

// First verify that the file has the right extension. We need jpg only.
if (strtolower(JFile::getExt($filename)) == 'jpg')
{
    // TODO: Add security checks.

    if (JFile::upload($src, $dest))
    {
        // Redirect to a page of your choice.
    }
    else
    {
        // Redirect and throw an error message.
    }
}
else
{
    // Redirect and notify user file does not have right extension.
}
?>
