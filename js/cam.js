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
	
	function init() {

		navigator.mediaDevices.getUserMedia({ audio: false, video: true }).then(function(mediaStream) {
			
			var video = document.getElementById('sourcevid');
			video.srcObject = mediaStream;
			
			video.onloadedmetadata = function(e) {
				video.play();
			};
		  
		}).catch(function(err) { console.log(err.name + ": " + err.message); });
	
	}
	var imgcheck = false;

	function ischeck() {
		var radio = document.getElementsByName('image');
		for(i = 0; i < radio.length; i++) {
			if (radio[i].checked == true)
				return(radio[i].value);
		}
	}
	
function img(id) {
	var tmp = document.getElementById('ma_galerie');
	var content = tmp.innerHTML;
	tmp.innerHTML = content + "<a href='index.php?page=galerie&type=image&id=" + id + "'><img src='vue/montage/galerie/" + id + ".png'></a>";
}

	function clone(event){
		event.preventDefault();
		if (imgcheck) {
			var vivi = document.getElementById('sourcevid');
			var can = document.getElementById('can');
			can.innerHTML = "<canvas id='cvs' width=" + vivi.offsetWidth +" height= " + vivi.offsetHeight +"></canvas>";
			var cnv = document.getElementById('cvs');
			var canvas1 = document.getElementById('cvs').getContext('2d');
			canvas1.drawImage(vivi, 0,0, vivi.offsetWidth, vivi.offsetHeight);
			var base64=document.getElementById('cvs').toDataURL("image/png");	//l'image au format base 64
			var xop = getHttpRequest();
			var radio = ischeck();
			xop.onreadystatechange = function () {
				if (xop.readyState === 4) {
					if (xop.status != 200) {
					}
					else {
						img(JSON.parse(xop.responseText));
					}
				}
			}
			xop.open('POST', 'vue/montage/photo.php', true);
			xop.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xop.send("photo=" + base64 + "&radio=" + radio);
		}
	}

	window.onload = init;

	function bton() {
		var input = document.getElementById('b_creer');
		input.value="creer";
		imgcheck = true;
	}
