function getHttpRequest()
{
    if (window.XMLHttpRequest)
        return new XMLHttpRequest();

    if (window.ActiveXObject)
    {
        var names = [
            "Msxml2.XMLHTTP.6.0",
            "Msxml2.XMLHTTP.3.0",
            "Msxml2.XMLHTTP",
            "Microsoft.XMLHTTP"
        ];
        for(var i in names)
        {
            try{ return new ActiveXObject(names[i]); }
            catch(e){}
        }
    }
    window.alert("Votre navigateur ne prend pas en charge l'objet XMLHTTPRequest.");
    return null; // non supporté
}

var s = 50;
var i = 0;
var tabid;
var corp = document.getElementById('galerie');

function init() {
		var xop = getHttpRequest();
		xop.onreadystatechange = function () {
			if (xop.readyState === 4) {
				if (xop.status != 200) {
				}
				else {
					tabid = JSON.parse(xop.responseText);
					while (i < 5 && i < tabid.length)
					{
						img(tabid[i++]);
					}
				}
			}
		}
		xop.open('POST', 'modele/defil.php', true);
		xop.send();
}

function img(id) {
	var div = document.createElement('div');
	div.className = 'img_galerie';
	div.innerHTML =  "<a href='index.php?page=galerie&type=image&id=" + id + "'><img src='vue/montage/galerie/" + id + ".png'></a>";
	corp.appendChild(div);
}

window.onscroll = function() {scroll()};

function scroll() {
	s = (document.documentElement.scrollHeight) - window.innerHeight;
	if (window.pageYOffset > s / 100 * 90) {
		var d = i + 5;
		while (i < d && i < tabid.length)
			img(tabid[i++]);
	}
}

window.onload = init;
