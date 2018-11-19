// JavaScript Document
//ajax object declaration	
			var xmlhttp;
			if(window.XMLHttpRequest){
				//code for IE7+, Firefox, Chrome, Opera and Safari
				xmlhttp = new XMLHttpRequest();
			}else{
				//code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");	
			}


//code for search box
	function hideText(){
		if(document.getElementById('search').value == 'Search')
			document.getElementById('search').value = '';				
	}
	function showText(){
		if(document.getElementById('search').value == '')
			document.getElementById('search').value = 'Search';				
	}

function updateClock(){
	var currentTime = new Date();
	
	var currentHours = currentTime.getHours();
	var currentMinutes = currentTime.getMinutes();
	var currentSeconds = currentTime.getSeconds();
	
	currentMinutes = (currentMinutes < 10 ? "0" : "") + currentMinutes;
	currentSeconds = (currentSeconds < 10 ? "0" : "") + currentSeconds;
	
	var timeOfDay = (currentHours < 12) ? "AM" : "PM";
	
	currentHours = (currentHours > 12) ? currentHours - 12 : currentHours;
	
	currentHours = (currentHours == 0) ? 12 : currentHours;
	
	var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
	
	document.getElementById('display_time').firstChild.nodeValue = currentTimeString;	
}

function showLibrary(){
	var myurl = 'includes/show_library.inc.php';
			xmlhttp.onreadystatechange = function(){
				if(xmlhttp.readyState == 4){
					if(xmlhttp.status == 200){
						document.getElementById("rightsidemenu").style.display = 'block';
						document.getElementById("innerrightsidemenu").innerHTML = xmlhttp.responseText;
					}
				}else{
					document.getElementById("innerrightsidemenu").innerHTML = 'Loading...';
				}
			} //function onreadystatechange	
			
			xmlhttp.open("GET", myurl, true);
			xmlhttp.send(null);
}

function showBookDetail(book_id){
	var myurl = 'includes/show_book_detail.inc.php';
			xmlhttp.onreadystatechange = function(){
				if(xmlhttp.readyState == 4){
					if(xmlhttp.status == 200){
						document.getElementById("innerrightlib").innerHTML = xmlhttp.responseText;
					}
				}else{
					document.getElementById("innerrightlib").innerHTML = 'Loading...';
				}
			} //function onreadystatechange	
			
			xmlhttp.open("GET", myurl+'?book_id='+book_id, true);
			xmlhttp.send(null);
}


function edit_book(book_id){
	edit_name = document.getElementById('name_of_book').value;
	edit_status = document.getElementById('edit_status').value;
	edit_author = document.getElementById('author').value;
	edit_edition = document.getElementById('edition').value;
	edit_year = document.getElementById('year').value;
	edit_notes = document.getElementById('notes').value;
	
	if(edit_name == ''){
			
	}else{
		params = 'name_of_book='+edit_name+'&edit_status='+edit_status+'&author='+edit_author+'&edition='+
		edit_edition+'&year='+edit_year+'&notes='+edit_notes;
		
		var myurl = 'includes/edit_book.inc.php';
		xmlhttp.open("POST", myurl, true);
		xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		xmlhttp.setRequestHeader("Content-length", params.length);
		xmlhttp.setRequestHeader("Connection", "close");
		xmlhttp.onreadystatechange = function(){
				if(xmlhttp.readyState == 4){
					if(xmlhttp.status == 200){	
						//document.getElementById('').innerHTML = xmlhttp.responseText;
						showLibrary();
						showBookDetail(book_id);
					}	
				}else {
					//document.getElementById('edit_info_details').innerHTML = 'Loading...';
				}	
		}//function
		
		xmlhttp.send(params);
	
	
	}
}

function showQuotes(){
	var myurl = 'includes/show_quotes.inc.php';
			xmlhttp.onreadystatechange = function(){
				if(xmlhttp.readyState == 4){
					if(xmlhttp.status == 200){
						document.getElementById("rightsidemenu").style.display = 'block';
						document.getElementById("innerrightsidemenu").innerHTML = xmlhttp.responseText;
						
					}
				}else{
					document.getElementById("innerrightsidemenu").innerHTML = 'Loading...';
				}
			} //function onreadystatechange	
			
			xmlhttp.open("GET", myurl, true);
			xmlhttp.send(null);
}
function showMovies(){
	var myurl = 'includes/show_movies.inc.php';
			xmlhttp.onreadystatechange = function(){
				if(xmlhttp.readyState == 4){
					if(xmlhttp.status == 200){
						document.getElementById("rightsidemenu").style.display = 'block';
						document.getElementById("innerrightsidemenu").innerHTML = xmlhttp.responseText;
						
					}
				}else{
					document.getElementById("innerrightsidemenu").innerHTML = 'Loading...';
				}
			} //function onreadystatechange	
			
			xmlhttp.open("GET", myurl, true);
			xmlhttp.send(null);
}
function showMovieDetail(movie_id){
	var myurl = 'includes/show_movie_detail.inc.php';
			xmlhttp.onreadystatechange = function(){
				if(xmlhttp.readyState == 4){
					if(xmlhttp.status == 200){
						document.getElementById("innerrightlib").innerHTML = xmlhttp.responseText;
					}
				}else{
					document.getElementById("innerrightlib").innerHTML = 'Loading...';
				}
			} //function onreadystatechange	
			
			xmlhttp.open("GET", myurl+'?movie_id='+movie_id, true);
			xmlhttp.send(null);
}

function showInspi(){
	var myurl = 'includes/show_inspi.inc.php';
			xmlhttp.onreadystatechange = function(){
				if(xmlhttp.readyState == 4){
					if(xmlhttp.status == 200){
						document.getElementById("rightsidemenu").style.display = 'block';
						document.getElementById("innerrightsidemenu").innerHTML = xmlhttp.responseText;
						
					}
				}else{
					document.getElementById("innerrightsidemenu").innerHTML = 'Loading...';
				}
			} //function onreadystatechange	
			
			xmlhttp.open("GET", myurl, true);
			xmlhttp.send(null);
}

function showInspirationDetail(inspi_id){
	var myurl = 'includes/show_inspiration_detail.inc.php';
			xmlhttp.onreadystatechange = function(){
				if(xmlhttp.readyState == 4){
					if(xmlhttp.status == 200){
						document.getElementById("innerrightlib").innerHTML = xmlhttp.responseText;
					}
				}else{
					document.getElementById("innerrightlib").innerHTML = 'Loading...';
				}
			} //function onreadystatechange	
			
			xmlhttp.open("GET", myurl+'?inspi_id='+inspi_id, true);
			xmlhttp.send(null);
}

function showPlaces(){
	var myurl = 'includes/show_places.inc.php';
			xmlhttp.onreadystatechange = function(){
				if(xmlhttp.readyState == 4){
					if(xmlhttp.status == 200){
						document.getElementById("rightsidemenu").style.display = 'block';
						document.getElementById("innerrightsidemenu").innerHTML = xmlhttp.responseText;
						
					}
				}else{
					document.getElementById("innerrightsidemenu").innerHTML = 'Loading...';
				}
			} //function onreadystatechange	
			
			xmlhttp.open("GET", myurl, true);
			xmlhttp.send(null);
}

function showPlaceDetail(place_id){
	var myurl = 'includes/show_place_detail.inc.php';
			xmlhttp.onreadystatechange = function(){
				if(xmlhttp.readyState == 4){
					if(xmlhttp.status == 200){
						document.getElementById("innerrightlib").innerHTML = xmlhttp.responseText;
					}
				}else{
					document.getElementById("innerrightlib").innerHTML = 'Loading...';
				}
			} //function onreadystatechange	
			
			xmlhttp.open("GET", myurl+'?place_id='+place_id, true);
			xmlhttp.send(null);
}

function showActi(){
	var myurl = 'includes/show_acti.inc.php';
			xmlhttp.onreadystatechange = function(){
				if(xmlhttp.readyState == 4){
					if(xmlhttp.status == 200){
						document.getElementById("rightsidemenu").style.display = 'block';
						document.getElementById("innerrightsidemenu").innerHTML = xmlhttp.responseText;
						
					}
				}else{
					document.getElementById("innerrightsidemenu").innerHTML = 'Loading...';
				}
			} //function onreadystatechange	
			
			xmlhttp.open("GET", myurl, true);
			xmlhttp.send(null);
}

function randomizeQuotes(){
	var myurl = 'includes/randomizeQuotes.inc.php';
			xmlhttp.onreadystatechange = function(){
				if(xmlhttp.readyState == 4){
					if(xmlhttp.status == 200){
						document.getElementById("innerquote_div").innerHTML = xmlhttp.responseText;
						setTimeout(randomizeQuotes, 5000);
					}
				}else{
					document.getElementById("innerquote_div").innerHTML = '';
				}
			} //function onreadystatechange	
			
			xmlhttp.open("GET", myurl, true);
			xmlhttp.send(null);
}

function showRecap(){
	var myurl = 'includes/show_recap.inc.php';
			xmlhttp.onreadystatechange = function(){
				if(xmlhttp.readyState == 4){
					if(xmlhttp.status == 200){
						document.getElementById("rightsidemenu").style.display = 'block';
						document.getElementById("innerrightsidemenu").innerHTML = xmlhttp.responseText;
						
					}
				}else{
					document.getElementById("innerrightsidemenu").innerHTML = 'Loading...';
				}
			} //function onreadystatechange	
			
			xmlhttp.open("GET", myurl, true);
			xmlhttp.send(null);
}

function showRecapDetail(recap_id){
	var myurl = 'includes/show_recap_detail.inc.php';
			xmlhttp.onreadystatechange = function(){
				if(xmlhttp.readyState == 4){
					if(xmlhttp.status == 200){
						document.getElementById("innerrightlib").innerHTML = xmlhttp.responseText;
					}
				}else{
					document.getElementById("innerrightlib").innerHTML = 'Loading...';
				}
			} //function onreadystatechange	
			
			xmlhttp.open("GET", myurl+'?recap_id='+recap_id, true);
			xmlhttp.send(null);
}

function showArticles(){
	var myurl = 'includes/show_articles.inc.php';
			xmlhttp.onreadystatechange = function(){
				if(xmlhttp.readyState == 4){
					if(xmlhttp.status == 200){
						document.getElementById("rightsidemenu").style.display = 'block';
						document.getElementById("innerrightsidemenu").innerHTML = xmlhttp.responseText;
						
					}
				}else{
					document.getElementById("innerrightsidemenu").innerHTML = 'Loading...';
				}
			} //function onreadystatechange	
			
			xmlhttp.open("GET", myurl, true);
			xmlhttp.send(null);
}

function showArticlesDetail(articles_id){
	var myurl = 'includes/show_articles_detail.inc.php';
			xmlhttp.onreadystatechange = function(){
				if(xmlhttp.readyState == 4){
					if(xmlhttp.status == 200){
						document.getElementById("innerrightlib").innerHTML = xmlhttp.responseText;
					}
				}else{
					document.getElementById("innerrightlib").innerHTML = 'Loading...';
				}
			} //function onreadystatechange	
			
			xmlhttp.open("GET", myurl+'?articles_id='+articles_id, true);
			xmlhttp.send(null);
}

function addCategory(){
	catt = document.getElementById('catt').value;
	if(catt == ''){
		//document.getElementById('catterr').style.display='inline';
	}else{
		
                            param = 'catt='+catt;
                            myurls = 'includes/add_category.inc.php';
                            xmlhttp.open('POST', myurls, true);
                            xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
                            xmlhttp.setRequestHeader('Content-length', param.length);
                            xmlhttp.setRequestHeader('Connection', 'close');
                            xmlhttp.onreadystatechange = function(){
                                    if(xmlhttp.readyState == 4){
                                        if(xmlhttp.status == 200){	
											document.getElementById('category_div').style.display='none';
										}	
                                        }else {
                                            document.getElementById('catterr').style.display='inline';
                                        }	
                                	}//function
                    
                    		xmlhttp.send(param);
                     }
}

function showCategories(){
	var myurl = 'includes/show_category.inc.php';
			xmlhttp.onreadystatechange = function(){
				if(xmlhttp.readyState == 4){
					if(xmlhttp.status == 200){
						document.getElementById("rightsidemenu").style.display = 'block';
						document.getElementById("innerrightsidemenu").innerHTML = xmlhttp.responseText;
						
					}
				}else{
					document.getElementById("innerrightsidemenu").innerHTML = 'Loading...';
				}
			} //function onreadystatechange	
			
			xmlhttp.open("GET", myurl, true);
			xmlhttp.send(null);
}

function loadeditCat(cat_name){
	document.getElementById('category_edit').style.display = 'block';
	document.getElementById('editcatt').value = cat_name;
}

function editCategory(){
	editcatt = document.getElementById('editcatt').value;
	cat_id = document.getElementById('edit_id').value;
	if(editcatt == ''){
		//document.getElementById('catterr').style.display='inline';
	}else{
		
                            param = 'editcatt='+editcatt;
                            myurls = 'includes/edit_category.inc.php';
                            xmlhttp.open('POST', myurls+'?cat_id='+cat_id, true);
                            xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
                            xmlhttp.setRequestHeader('Content-length', param.length);
                            xmlhttp.setRequestHeader('Connection', 'close');
                            xmlhttp.onreadystatechange = function(){
                                    if(xmlhttp.readyState == 4){
                                        if(xmlhttp.status == 200){	
											document.getElementById('category_edit').style.display='none';
											showCategories();
										}	
                                        }else {
                                            //document.getElementById('catterr').style.display='inline';
                                        }	
                                	}//function
                    
                    		xmlhttp.send(param);
                     }
}

function deleteCategory(){
	cat_id = document.getElementById('edit_id').value;
	var myurl = 'includes/delete_category.inc.php';
			xmlhttp.onreadystatechange = function(){
				if(xmlhttp.readyState == 4){
					if(xmlhttp.status == 200){
						showCategories();
					}
				}else{
					//document.getElementById("innerrightsidemenu").innerHTML = 'Loading...';
				}
			} //function onreadystatechange	
			
			xmlhttp.open("GET", myurl+'?cat_id='+cat_id, true);
			xmlhttp.send(null);
}