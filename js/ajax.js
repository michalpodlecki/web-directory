var d = this.document;

var ajax = {
	XHR: null,
	init: function () {
		if (this.XHR === null) {
			try {
				/* dla przeglądarki Firefox */
				this.XHR = new XMLHttpRequest();
			} catch (e) {
				try {
					/* dla niektórych wersji przeglądarki IE */
					this.XHR = new ActiveXObject("Msxml2.XMLHTTP");
				} catch (e1) {
					try {
						/* dla pozostałych wersji przeglądarki IE */
						this.XHR = new ActiveXObject("Microsoft.XMLHTTP");
					} catch (e2) {
						this.XHR = null;
					}
				}
			}
		}
	},
	ajax: function (method, url, fn, data) {
        if (this.XHR === null) {this.init();}
        data = data || null;
		this.XHR.open(method, url, true);
		this.XHR.onreadystatechange = fn;

        if (data) {
            this.XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        }
        this.XHR.send(data);
	},
    loading: function (id) {
        var box = document.getElementById('id');
        var el = document.createElement('div');
        el.className = 'message-background';
        box.appendChild(el);
    }
};

var load = function (url) {
    d.getElementById('message-background').style.display = 'block';
    var mw = d.getElementById('message-window');
    mw.style.display = 'block';
    mw.style.marginLeft = -(mw.offsetWidth/2) + 'px';
    
    ajax.ajax('GET', url, function () {
        if (ajax.XHR.readyState === 4 && ajax.XHR.status === 200) {
            var el = d.getElementById('content');
            while (el.hasChildNodes()) {
                el.removeChild(el.firstChild);
            }
            el.innerHTML = ajax.XHR.responseText;
            d.getElementById('message-background').style.display = 'none';
            mw.style.display = 'none';
        }  
    });
};

var filterfiles = function () {
    var val = d.getElementById('file_name').value;
    var url = 'index.php?a=filter&q=' + val;
    ajax.ajax('GET', url, function () {
        if (ajax.XHR.readyState === 4 && ajax.XHR.status === 200) {
            var el = d.getElementById('search-list');
            while (el.hasChildNodes()) {
                el.removeChild(el.firstChild);
            }
            el.innerHTML = ajax.XHR.responseText;
        }  
    });
};

var showfiles = function (cid) {
//    var pid = d.getElementById('catalog_id').value;
    var url = 'index.php?a=ajax&cid=' + cid; //+ '&pid=' + pid;
    ajax.ajax('GET', url, function () {
        if (ajax.XHR.readyState === 4 && ajax.XHR.status === 200) {
            var el = d.getElementById('file-list');
            while (el.hasChildNodes()) {
                el.removeChild(el.firstChild);
            }
            el.innerHTML = ajax.XHR.responseText;
            setTimeout(function () {
                show_catalog_name();
            }, 100);
        }  
    });
//    setTimeout(function () {
//        show_catalog_name();
//    }, 100);
};

var deletefile = function (file, fid) {
    var url = '?a=delete&file=' + file + '&fid=' + fid;
    ajax.ajax('GET', url, function () {
        if (ajax.XHR.readyState == 4 && ajax.XHR.status == 200) {
                setTimeout(function () {
                    var actual = d.getElementById('catalog_id').value;
                    showfiles(actual);
                }, 200);
            }
    });
};

var changeName = function (fid) {
    //var newName = prompt('Podaj nową nazwę pliku:', '');
    var newName = d.getElementById('newName').value;
    if (newName.length > 0) {
        ajax.ajax('GET', '?a=changeFileName&fid=' + fid + '&newname=' + newName, function () {
            if (ajax.XHR.readyState == 4 && ajax.XHR.status == 200) {
                setTimeout(function () {
                    var actual = d.getElementById('catalog_id').value;
                    showfiles(actual);
                }, 100);
            }
        });
        
    }
};

var addcatalog = function () {
    //    var el = d.createElement('div');
    //    el.className = 'window';
    //    el.style['display'] = 'block';
    //    el.innerHTML = 'dzień dobry';
    var name = d.getElementById('addcatalog-name').value;
    name = (name === '') ? 'nowy_katalog' : name;
    
    var cid = d.getElementById('catalog_id').value;
    //document.getElementsByTagName('body')[0].appendChild(el);
    
    ajax.ajax('GET', '?a=addcatalog&name=' + name + '&cid=' + cid, function () {
        if (ajax.XHR.readyState == 4 && ajax.XHR.status == 200) {
            setTimeout(function () {
                var actual = d.getElementById('catalog_id').value;
                showfiles(actual);
            }, 100);
        }
    });
//el.style.display = 'none';
//return false;
};

var show_catalog_form = function() {
    var el = d.getElementById('window');
    var bg = d.getElementById('window-background');
    
    if (arguments.length > 0 && arguments[0] === false) {
        el.style.display = 'none';
        bg.style.display = 'none';
        d.getElementById('addcatalog-name').value = '';
        return;
    }
    
    el.style.display = 'block';
    el.style.marginLeft = -(el.offsetWidth/2) + 'px';
    el.style.marginTop = -(el.offsetHeight/2 + 50) + 'px';
    
    bg.style.display = 'block';
    bg.style.width = (el.offsetWidth + 20) + 'px';
    bg.style.height = (el.offsetHeight + 20) + 'px';
    bg.style.marginLeft = - (bg.offsetWidth/2) + 'px';
    bg.style.marginTop = - (bg.offsetHeight/2 + 50) + 'px';
    
    d.getElementById('addcatalog-name').focus();
};

var catalog_back = function () {
    var cid = d.getElementById('parent_id').value;
    var url = 'index.php?a=ajax&cid=' + cid; //+ '&pid=' + pid;
    ajax.ajax('GET', url, function () {
        if (ajax.XHR.readyState === 4 && ajax.XHR.status === 200) {
            var el = d.getElementById('file-list');
            while (el.hasChildNodes()) {
                el.removeChild(el.firstChild);
            }
            el.innerHTML = ajax.XHR.responseText;
            setTimeout(function () {
                show_catalog_name();
            }, 100);
        }  
    });
};

var show_catalog_name = function () {
    var txt;
    var catalogName = d.getElementById('catalog_name').value;
    var parentId = d.getElementById('parent_id').value;
    var prefix = d.createTextNode('Aktualny katalog: ');
    if (catalogName === '0') {
        txt = d.createTextNode('~/');
    } else {
        if (parentId === '0') {
        txt = d.createTextNode('~/' + catalogName);
        }
        else {
            txt = d.createTextNode('~/../' + catalogName);
        }
    }
    var el = d.getElementById('actual-catalog');
    if (el.hasChildNodes()) {
        while (el.hasChildNodes()) {
            el.removeChild(el.firstChild); 
        }
    }
    el.appendChild(prefix);
    el.appendChild(txt);
//    el.innerHTML = '~/.../' + val;
};

var show_name_form = function(fid) {
    var el = d.getElementById('window-changename');
    var bg = d.getElementById('window-background');
    
    if (arguments.length > 0 && arguments[0] === false) {
        el.style.display = 'none';
        bg.style.display = 'none';
        d.getElementById('newName').value = '';
        return;
    }
    
    el.style.display = 'block';
    el.style.marginLeft = -(el.offsetWidth/2) + 'px';
    el.style.marginTop = -(el.offsetHeight/2 + 50) + 'px';
    
    bg.style.display = 'block';
    bg.style.width = (el.offsetWidth + 20) + 'px';
    bg.style.height = (el.offsetHeight + 20) + 'px';
    bg.style.marginLeft = - (bg.offsetWidth/2) + 'px';
    bg.style.marginTop = - (bg.offsetHeight/2 + 50) + 'px';
    
//    console.log(el.style.marginLeft);
//    console.log(el.style.marginTop);
//    console.log(el.offsetParent);
    changeName.fid = fid;
    d.getElementById('newName').focus();
};

var show_movefile_form = function (fid) {
    var el = d.getElementById('window-movefile');
    var bg = d.getElementById('window-background');
    
    if (arguments.length > 0 && arguments[0] === false) {
        el.style.display = 'none';
        bg.style.display = 'none';
        return;
    }
    
    el.style.display = 'block';
    el.style.marginLeft = -(el.offsetWidth/2) + 'px';
    el.style.marginTop = -(el.offsetHeight/2 + 50) + 'px';
    
    bg.style.display = 'block';
    bg.style.width = (el.offsetWidth + 20) + 'px';
    bg.style.height = (el.offsetHeight + 20) + 'px';
    bg.style.marginLeft = - (bg.offsetWidth/2) + 'px';
    bg.style.marginTop = - (bg.offsetHeight/2 + 50) + 'px';
    
//    console.log(el.style.marginLeft);
//    console.log(el.style.marginTop);
//    console.log(el.offsetParent);
    movefile.fid = fid;
    filter_catalogs();
    d.getElementById('movefile-catalog-name').focus();
};

var filter_catalogs = function () {
    var val = d.getElementById('movefile-catalog-name').value;
    var url = 'index.php?a=filterCatalogs&q=' + val;
    ajax.ajax('GET', url, function () {
        if (ajax.XHR.readyState === 4 && ajax.XHR.status === 200) {
            var el = d.getElementById('catalog-list');
            while (el.hasChildNodes()) {
                el.removeChild(el.firstChild);
            }
            el.innerHTML = ajax.XHR.responseText;
//            setTimeout(function () {
                /* border update */
                var el = d.getElementById('window-movefile');
                var bg = d.getElementById('window-background');

//                bg.style.width = (el.offsetWidth + 20) + 'px';
                bg.style.height = (el.offsetHeight + 20) + 'px';
//                bg.style.marginLeft = - (bg.offsetWidth/2) + 'px';
//                bg.style.marginTop = - (bg.offsetHeight/2 + 50) + 'px';
                /* border update */
//            }, 50);
        }  
    });
};

var choose_catalog = function (cid, name) {
    movefile.cid = cid;
    d.getElementById('movefile-submit').value = 'Przenieś do ' + name;
}

var movefile = function (fid) {
    var cid = movefile.cid;
    var fid = movefile.fid;
        ajax.ajax('GET', '?a=moveFile&fid=' + fid + '&cid=' + cid, function () {
            if (ajax.XHR.readyState == 4 && ajax.XHR.status == 200) {
                setTimeout(function () {
                    var actual = d.getElementById('catalog_id').value;
                    showfiles(actual);
                    show_movefile_form(false);
                }, 100);
            }
        });      
};