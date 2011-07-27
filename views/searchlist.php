<?php foreach ($data as $file): ?>
    <div>
        <?php if ($file['FILE_TYPE'] == 'catalog') { ?>
            <div>
                <a href="javascript: showfiles('<?php echo $file['ID'] ?>')" class="search-item"><?php echo $file['FILE_NAME']; ?> <span style="color: gray; font-size: 10px; vertical-align: top">(folder)</span></a>
            </div>
        <?php } else { ?>
            <div>
                <a href="index.php?a=download&fid=<?php echo $file['ID']; ?>" class="search-item"><?php echo $file['FILE_NAME'] . '.' . $file['FILE_EXTENSION']; ?></a>
            </div>
        <?php } ?>
    </div> 
<?php endforeach; ?>