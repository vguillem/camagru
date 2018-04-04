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
	
	var imgcheck = false;

	function clone(event){
		if (!imgcheck) {
			event.preventDefault();
		}
	}

	function bton() {
		var input = document.getElementById('b_creer');
		input.value="creer";
		imgcheck = true;
	}
