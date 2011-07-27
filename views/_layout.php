<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Web Directory</title>
        <?php echo $html->css('style'); ?>
        <script type="text/javascript" src="js/ajax.js"></script>
    </head>
    <body>
        <div id="message-background"></div>
        <div id="message-window">
            <img src="gfx/ajax-loader(2).gif" border="0" alt="loading" />
            <div style="font: 10px Arial; color: black; text-align: center">ładowanie - proszę czekać...</div>
        </div>
        <div id="container">
            <?php if (isset($_SESSION['user'])): ?>
            <div id="top-bar">zalogowany: <b><?php echo $_SESSION['user']['EMAIL']; ?></b></div>
            <div id="nav">
                <a href="javascript: load('index.php?a=edit')">Profil</a>
                <a href="index.php?a=showfiles">Pliki</a>  <!-- style="background-color: #4E1F31; color: white; text-decoration: none"-->
                <a href="javascript: load('index.php?a=files')">Upload</a>
                <a href="index.php" style="display: none">Config</a>
                <a href="index.php?a=logout" style="float: right">Logout</a>
            </div>
            <?php endif; ?>
            <div id="content">
                <?php echo $content_for_layout; ?>
                <div id="message-background"></div>
            </div>
        </div>
        
        <div id="window-background" style="display: none"></div>
        <div id="window" class="window">
            <input id="addcatalog-name" type="text" /><label for="addcatalog-name">Nazwa katalogu:</label>
            <input id="addcatalog-submit" type="button" value="Dodaj katalog" />
            <div id="close-window" onclick="show_catalog_form(false);">&times;</div>
        </div>
        <div id="window-changename" class="window">
            <input id="newName" type="text" /><label for="newName">Nowa nazwa:</label>
            <input id="changename-submit" type="button" value="Zapisz zmianę" />
            <div id="close-window" onclick="show_name_form(false);">&times;</div>
        </div>
        <div id="window-movefile" class="window">
            <input id="movefile-catalog-name" name="catalog_name" type="text" /><label for="movefile-catalog-name">Nazwa katalogu:</label>
            <input type="submit" value="Szukaj" style="display: none" />
            <div id="close-window" onclick="show_movefile_form(false);">&times;</div>
            <div id="catalog-list" style="clear: both"></div>
            <input id="movefile-submit" type="button" value="Przenieś plik" onclick="movefile()" style="width: auto; padding: 4px 10px" />
        </div>

    </body>
</html>