    <div>
        <a href="javascript: choose_catalog(0, 'KATALOG GŁÓWNY')" class="search-item"><img src="gfx/dir.gif" style="height: 16px" /> ~/</a>
    </div>
<?php foreach ($data as $file): ?>
    <div>
        <a href="javascript: choose_catalog('<?php echo $file['ID'] ?>','<?php echo $file['FILE_NAME'] ?>')" class="search-item"><img src="gfx/dir.gif" style="height: 16px" /> <?php echo $file['FILE_NAME']; ?></a>
    </div>
<?php endforeach; ?>
