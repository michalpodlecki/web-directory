<?php
$cname = array_pop($data);
$pid = array_pop($data); // pierwszy, bo byl ostatni
$cid = array_pop($data);
?>
<div id="files-header" style="overflow: hidden; background: white; font: 12px 'Lucida Sans'; color: black; padding: 3px 10px; border: 1px solid black">
    <div style="float: left; width: 33%">nazwa</div><div style="float: right; margin-right: 10px">modified</div>
</div>
<?php foreach ($data as $file): ?>
    <div class="file">
        <?php if ($file['FILE_TYPE'] == 'catalog') { ?>
            <div style="overflow: hidden">
                <div style="float: left">
                    <a href="javascript: showfiles('<?php echo $file['ID'] ?>')" class="catalogname"><img src="gfx/dir.gif" style="height: 16px" /> <?php echo $file['FILE_NAME']; ?></a>
                </div>
                <div style="float: right; margin-right: 10px">
                    <?php echo substr($file['MODIFIED'], 0, -2); ?>
                </div>
            </div>
        <?php } else { ?>
            <div style="overflow: hidden">
                <div style="float: left">
                    <a href="index.php?a=download&fid=<?php echo $file['ID']; ?>" class="filename"><?php echo $file['FILE_NAME'] . '.' . $file['FILE_EXTENSION']; ?></a>
                </div>
                <div style="float: right; margin-right: 10px">
                    <?php echo substr($file['MODIFIED'], 0, -2); ?>
                </div>
            </div>
        <?php } ?>
        <div class="options">
            <a href="javascript: show_name_form('<?php echo $file['ID']; ?>')">zmień nazwę</a>
            <a href="javascript: deletefile('<?php echo $file['FILE_PATH']; ?>', '<?php echo $file['ID']; ?>')">usuń</a>
            <a href="javascript: show_movefile_form('<?php echo $file['ID']; ?>')">przenieś</a>
        </div>
    </div> 
<?php endforeach; ?>
<input id="catalog_id" type="hidden" value="<?php echo $cid; ?>" />
<input id="catalog_name" type="hidden" value="<?php echo $cname; ?>" />
<input id="parent_id" type="hidden" value="<?php echo $pid; ?>" />