<h1>Wgrywanie plików</h1>
<form id="login-form" action="index.php?a=files" method="post" enctype="multipart/form-data" onsubmit="submit(); return false">
    <input type="hidden" name="MAX_FILE_SIZE" value="83886080" />
    <label for="file">Plik:</label><input id="file" name="file" type="file" />
    <input type="submit" value="Wyślij" />
</form>