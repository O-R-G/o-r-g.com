var isHidden = true;

function showHide()
{
	var menu = document.getElementById("menu");
	if(isHidden)
	{
		// show the menu
		menu.className = menu.className.replace( /(?:^|\s)hidden(?!\S)/g , ' visible' );
		// document.getElementById('jules').scrollIntoView();
		close_clock();
		open_menu();
		
	}
	else
	{
		// hide the menu
		menu.className = menu.className.replace( /(?:^|\s)visible(?!\S)/g , ' hidden' );
		close_menu();
		open_clock();
	}
	
	isHidden = !isHidden;
}


function open_menu()
{
	init_wyoscan("wyoscan-svg");
}

function close_menu()
{
	stop_wyoscan();
}

function open_clock()
{
	document.getElementById("clock-canvas").addEventListener("click", showHide);
	init_clock("clock-canvas");
}

function close_clock()
{
	document.getElementById("clock-canvas").removeEventListener("click", showHide);
	clear_hands();
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
document.getElementById("ex-container").addEventListener("click", showHide);