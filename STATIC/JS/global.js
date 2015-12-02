var isHidden = true;

function showHide()
{
	var arr;
	if(isHidden)
	{
		arr = document.getElementsByClassName("icon-container");
		for(var i = 0; i < arr.length; i++)
		{
			arr[i].className = arr[i].className.replace( /(?:^|\s)hidden(?!\S)/g , ' visible' );
		}
		console.log(arr.length);
		clear_hands();
	}
	else
	{
		arr = document.getElementsByClassName("icon-container");
		for(var i = 0; i < arr.length; i++)
		{
			var e = arr[i];
			e.className = e.className.replace( /(?:^|\s)visible(?!\S)/g , ' hidden' );
		}
		init_clock("clock-canvas");
	}
	
	isHidden = !isHidden;
}

// WHY DOESN'T THIS WORK? 
// http://stackoverflow.com/questions/17885855/use-dynamic-variable-string-as-regex-pattern-in-javascript
function switchClasses(c1, c2)
{
	arr = document.getElementsByClassName(c1);
	for(var i = 0; i < arr.length; i++)
	{
		// arr[i].className = arr[i].className.replace( /(?:^|\s)c1(?!\S)/g
		var regex = new RegExp("(?:^|\s)" + c1 + "(?!\S)", "g");
		arr[i].className = arr[i].className.replace(regex, " " + c2);
	}
}

document.getElementById("clock-canvas").addEventListener("click", showHide);