this.onload = function () {
    d.getElementById('file_name').onfocus = function () {
        d.getElementById('file_name').value='';
    };
        
    d.getElementById('file_name').onblur = function () {
        setTimeout(function () {
            if (d.getElementById('file_name').value.length === 0) {
                d.getElementById('file_name').value='Szukaj plików';
                var el = d.getElementById('search-list');
                while (el.hasChildNodes()) {
                    el.removeChild(el.firstChild);
                }
            }
        }, 400);
    };

    d.getElementById('addcatalog-submit').onclick = function () {
        addcatalog();
        setTimeout(function () {
            show_catalog_form(false);
        }, 50);
        d.getElementById('addcatalog-name').value = '';
    };
    
    d.getElementById('changename-submit').onclick = function () {
        var fid = changeName.fid;
        changeName(fid);
        setTimeout(function () {
            show_name_form(false);
        }, 50);
        d.getElementById('newName').value = '';
    }

    show_catalog_name();
    
    d.getElementById('movefile-catalog-name').onkeyup = function () {
        filter_catalogs();
    };
    
    d.getElementById('movefile-catalog-name').onfocus = function () {
        d.getElementById('movefile-catalog-name').value='';
    };
        
    d.getElementById('file_name').onkeyup = function () {
        filterfiles();
    };
    
}