<!DOCTYPE html> 
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css/latihan.css"> <!--pemanggilan file css-->

</head>
<script src="js/AjaxCreateObject.js" language="javascript"></script>
<script type="text/javascript">

function suggestSearch(str){
	//document.getElementById("search_suggestion").innerHTML = str;
	if(str.length == 0){
		document.getElementById("search_suggestion").innerHTML="";
		return;
	}
	
	http.onreadystatechange=function(){
		if(http.readyState == 4 && http.status == 200){
			document.getElementById("search_suggestion").innerHTML = http.responseText;
		}
	}
	
	http.open("GET","proses_suggest_search.php?q="+str,true);
	http.send();
}

function copySuggest(){
	var x = document.getElementsByName("key");
	x[0].value = document.getElementById("search_suggestion").innerHTML;
}


function checkSubmit(){
			
			
	var username = document.getElementById("username").value;
	var password = document.getElementById("password").value;
	var confirm_password = document.getElementById("confirm_password").value;
	var nama_lengkap = document.getElementById("nama_lengkap").value;
	var email = document.getElementById("email").value;
	
	

	//document.getElementById("pesan").innerHTML = "sadf";
	
	http.onreadystatechange=function(){
		if(http.readystate=4 && http.status == 200){
			
			var decodeJSON = JSON.parse(http.responseText);
			var boolUser = decodeJSON.boolUser;
			var boolPass = decodeJSON.boolPass;
			var bool = decodeJSON.bool;
			var boolNama = decodeJSON.boolNama;
			var boolUsedUser=decodeJSON.boolUsedUser;
			var boolUsedEmail=decodeJSON.boolUsedEmail;
			 
			var echo = http.responseText;
			var response = echo.substr(0,4);
			document.getElementById("nama_label").innerHTML = echo;
			//document.getElementById("pesan").innerHTML = echo;
			//response = "true";
			
			//document.getElementById("pesan").innerHTML = response;
			
			if(boolUser && boolPass && bool && boolNama){
				document.getElementById("user_error").innerHTML = "";
				document.getElementById("pass_label").innerHTML = "";
				document.getElementById("conf_pass_label").innerHTML = "";
				document.getElementById("nama_label").innerHTML = "";
				document.getElementById("email_label").innerHTML = "";
				document.getElementById("submit").disabled = false;
				//document.getElementById("pesan").innerHTML = "sadf"
			}else{
				document.getElementById("submit").disabled = true;
				var errorMessage = "";
				if(!boolNama){
					document.getElementById("user_error").innerHTML = "ERROR PADA USERNAME";
				}else{
					document.getElementById("user_error").innerHTML = "";
				}
				if(!boolPass){
					document.getElementById("conf_pass_label").innerHTML = "PASSWORD TIDAK SAMA";
				}else{
					document.getElementById("conf_pass_label").innerHTML = "";
				}
				if(!boolUser){
					document.getElementById("nama_label").innerHTML = "ERROR PADA NAMA";
				}else{
					document.getElementById("nama_label").innerHTML = "";
				}
				if(!bool){
					document.getElementById("email_label").innerHTML = "Kesalahan Pada Email";
				}else{
					document.getElementById("email_label").innerHTML = "";
				}
 				if(!boolUsedUser)
				{
					document.getElementById("user_error").innerHTML = "USERNAME SUDAH DIPAKAI";
				}
				if(!boolUsedEmail)
				{
					document.getElementById("email_label").innerHTML = "EMAIL SUDAH DIPAKAI";
				}  
			}
		}
	}
	http.open("GET","Registrasi/validasi.php?username=" + username + "&password=" + password
		+"&confirm_password=" + confirm_password + "&nama_lengkap=" + nama_lengkap
		+ "&email=" + email,true);
	http.send();
}

function popClik()
{
	
	var lightbox = document.getElementById("lightbox");
       var dimmer = document.createElement("div");
    
    dimmer.style.width =  document.documentElement.scrollWidth + 'px';
    dimmer.style.height = document.documentElement.scrollHeight + 'px';
    dimmer.className = 'dimmer';
    dimmer.id='dim';
    test.onclick=function(){
        document.body.removeChild(this);   
        lightbox.style.visibility = 'hidden';
    }
    
    dimmer.onclick = function(){
        document.body.removeChild(this);   
		document.getElementById('user').value="";
		document.getElementById('pass').value="";
        lightbox.style.visibility = 'hidden';
    }
        
    document.body.appendChild(dimmer);
    
    lightbox.style.visibility = 'visible';
    lightbox.style.top = window.innerHeight/2 - 200 + 'px';
    lightbox.style.left = window.innerWidth/2 - 100 + 'px';
	document.getElementById("user").focus();
}
function login()
{
	
	//mengambil semua variable dalam form login
	var username = encodeURI(document.getElementById('user').value);	
	var password = encodeURI(document.getElementById('pass').value);
	
	//request ke file php
	http.open('get', 'proses_login.php?user='+username+'&pass='+password,true);
	//cek hasil request 4 jika berhasil
	http.onreadystatechange = function()
	  {
		
		if (http.readyState==4 && http.status==200)
		{
			try
			{
			var decodeJSON = JSON.parse(http.responseText);
			
			document.getElementById("welcome").innerHTML="WELCOME,"+decodeJSON.nama;
			var lightbox = document.getElementById("lightbox");
			var dimmer = document.getElementById("dim");
			var signup = document.getElementById("signup");
			
			var loginButton = document.getElementById("loginButton");
			lightbox.style.visibility = 'hidden';
			signup.style.visibility = 'hidden';
			loginButton.src="images/logout.png";
			loginButton.onclick=function()
			{
				window.location="logout.php";
			}
			document.body.removeChild(dimmer); 
			remove("signup"); 
			
			}
			catch(e)
			{
			document.getElementById("Error").innerHTML="Welcome,"+http.responseText;
			var user=document.getElementById("user");
			
			
			}
		}
	  }
	http.send(); 
	
}
function logout()
{
window.location="logout.php";
}
function cancel()
{
	var lightbox = document.getElementById("lightbox");
	var dimmer = document.getElementById("dim");
	lightbox.style.visibility = 'hidden';
	document.getElementById('user').value="";
	document.getElementById('pass').value="";
	document.body.removeChild(dimmer); 
}
function remove(id)
{
    return (elem=document.getElementById(id)).parentNode.removeChild(elem);
}

function startRead(evt) {  
  var file = document.getElementById('file').files[0];
  if(file){
    if(file.type.match("image.*"))
    {
    getAsImage(file);
    /* alert("Name: "+file.name +"\n"+"Last Modified Date :"+file.lastModifiedDate); */
    }
    else
    {
    getAsText(file);
    alert("Name: "+file.name +"\n"+"Last Modified Date :"+file.lastModifiedDate);
    }
    }
    evt.stopPropagation();
    evt.preventDefault();
}

function startReadFromDrag(evt) {
    var file = evt.dataTransfer.files[0];
    if (file) {
        if (file.type.match("image.*")) {
            getAsImage(file);
            alert("Name: " + file.name + "\n" + "Last Modified Date :" + file.lastModifiedDate);
        }
        else {
            getAsText(file);
            alert("Name: " + file.name + "\n" + "Last Modified Date :" + file.lastModifiedDate);
        }
    }
    evt.stopPropagation();
    evt.preventDefault();
}


function getAsText(readFile) {
        
  var reader = new FileReader();
  
  // Read file into memory as UTF-16      
  reader.readAsText(readFile, "UTF-8");
  
  // Handle progress, success, and errors
  reader.onprogress = updateProgress;
  reader.onload = loaded;
  reader.onerror = errorHandler;
}

function getAsImage(readFile) {
        
  var reader = new FileReader();
  
  // Read file into memory as UTF-16      
  reader.readAsDataURL(readFile);
  
  // Handle progress, success, and errors
  reader.onload = addImg;
}

function updateProgress(evt) {
  if (evt.lengthComputable) {
    // evt.loaded and evt.total are ProgressEvent properties
    var loaded = (evt.loaded / evt.total);
    
    if (loaded < 1) {
      // Increase the prog bar length
      // style.width = (loaded * 200) + "px";
    }
  }
}


function errorHandler(evt) {
  if(evt.target.error.name == "NotReadableError") {
    // The file could not be read
  }
}

function addImg(imgsrc){
 var img = document.createElement('img');
  img.setAttribute("src",imgsrc.target.result);
  img.setAttribute("height","300");
  img.setAttribute("width","300");
  document.getElementById("output").insertBefore(img);
}

  var dropingDiv = document.getElementById('draghere');
  dropingDiv.addEventListener('dragover', domagic, false);
  dropingDiv.addEventListener('drop', startReadFromDrag, false);

</script>

<meta charset=utf-8 />
<body>
<div id="lightbox">	
		<div class="loginpoptop"><!--pop up-->
		<h4 id="loginHeader">LOGIN</h4>
		</div>
		<form id="test">
			<div class="forms">
			Username : <input type="text" id="user" required placeholder = "Username" /></br>
			</div>
			<div class="forms">
			Password : <input type="password" id="pass" required placeholder = "Password"></br>
			</div>
			<div class="forms">
			<input type="button" value="LogIn" onclick="login()"></input>
			<input type="button" value="Cancel" onclick="cancel()"></input>
			</div>
			<div class="error">
			<p id="Error"></p>
			</div>
			</form>

		</div>
<div class = "main">
		<div class = "header">
		
		<div class = "logohead">
			<div >
				<a href="index.php"><img src = "images/logo.png" class = "logo"></a>
				</img>
				</div>
			<div class = "loginplace">
				<div>
				<?php
				if(!isset($_COOKIE['user1']))
				{
				?>
					<img src = "images/login.png" class = "login" onclick="popClik()" id="loginButton"></img>
				<?php
				}
				else
				{
				?>
					<img src = "images/logout.png" class = "login" onclick="logout()" id="loginButton"></img>
				<?php
				}
				?>
				</div>
				
				<div >
					<img src = "images/cart.png" class = "cart" onclick="window.location='shoppingbag.php'"></img>
				</div>
				
				<div>
					<p class = "welcomeadmin" > WELCOME , ADMIN </p>
				</div>
				
			</div>
			<div class = "signupplace">
				
				<div>
				<?php
				if(!isset($_COOKIE['user1']))
				{
				?>
				<img src = "images/signup.png" class = "signup" id="signup" onclick="window.location='registrasi.php'"></img>
				<?php
				}
				?>
					
				</div> 
				
			<a href="see_profile.php"><p class="welctext" id="welcome"><?php if(isset($_COOKIE['user1'])) echo "WELCOME,".$_COOKIE['user1'].""; ?></p></a>
			</div>
		</div>
		<div class = "menu">
				<div>
					<a href="kategori.php?key=Jaket"><img src = "images/jacket.png" class = "jacket"></img></a>
				</div>
				<div>
					<a href="kategori.php?key=Sweater"><img src = "images/sweaters.png" class = "tshirt"></img>
				</div>
				<div >
					<a href="kategori.php?key=TShirt"><img src = "images/tshirt.png" class = "wristband"></img></a>
				</div>
				<div>
					<a href="kategori.php?key=Misc"><img src = "images/misc.png"  class = "emblem"></img></a>
				</div>
				<div>
					<a href="kategori.php?key=Pokemon"><img src = "images/pokemon.png"  class = "pokemon"></img></a>
				</div>
		</div>
		<div class = "main">
		</div>
	
</div>

<div class = "bodymain">
	<div class = "sidebar">
		
			<p class = "searchtitle"> Search it! </p>
		<form action="hasilsearch.php" method="get">
		<div class = "kategori">
			<select name="kategori">
				<option value="all">All</option>
				<option value="Jaket">Jacket</option>
				<option value="TShirt">T-shirt</option>
				<option value="Sweater">Sweater</option>
				<option value="Misc">Misc.</option>
				<option value="Pokemon">Pokemon</option>
			</select>
			<input type="text" id="user" name="key" required placeholder = "e.g. Mylo Xyloto" onkeyup="suggestSearch(this.value)" /></br>
	</div>
	
	<div class = "kategori">
	<label> Price Range: </label>
	<select name="range">
				<option value=1>< Rp50.000 </option>
				<option value=2>Rp50.000 - Rp100.000</option>
				<option value=3>Rp100.001 - Rp150.000</option>
				<option value=4>> Rp150.000</option>
				
			</select>
	</div>
	<div class = "kategori">
		<input type="submit" value="Search!"></input>
	</div>
	
	<label>Suggestion : <br><span id="search_suggestion" onclick="copySuggest()"></span></label>
	
	</form>
			
		<div class = "space"> 
				
		</div>
				
		<p class = "textadmin"> FITUR KHUSUS ADMIN </p>		
		
		<div class = "placetambahbarang" >
			<form action="upload.php">
				<input type="submit" class = "buttontambahbarang" value="Tambah Barang">
			</form>
		</div>
	
	</div>
	<div class = "boddy">
		<div class = "topfivetitle">
		<h1 id = "loginHeader"> EDIT BARANG</h1></br></br>
		</div>
		
			<div class = "registerspace">
                          
			<form method="post" ACTION="update.php" name="uploadForm"> 
				
				<label>Nama Barang </label> 
				<input type="text"  name ="nama_barang" id="nama_barang" onkeyup="checkSubmit()" value="<?php echo $_GET['nama']; ?>>" required placeholder = "e.g. Pintu Kemana Saja" />
						
				</br></br>
				<label>Kategori Barang</label> 
				<select name="kategori_barang">
					<option value="Jaket">Jacket</option>
					<option value="TShirt">T-shirt</option>
					<option value="Sweater">Sweater</option>
					<option value="Misc">Misc.</option>
					<option value="Pokemon">Pokemon</option>
				</select>
				<input type="text" name="idBarang" hidden value="<?php echo $_GET['id'];?>" />		
				</br></br>
				<label>Jumlah Barang</label> 
				<input type="text" id="jumlah_barang" name="jumlah_barang" onkeyup="checkSubmit()" required placeholder = "1000" />

				</br></br>
				<label>Harga Barang</label> 
				<input type="text" id="harga_barang" name="harga_barang" onkeyup="checkSubmit()" value="<?php echo $_GET['harga'];?>" required placeholder = "100000" />	
						
				</br></br>
				<label>Deskripsi Barang</label> 
				<textarea name="deskripsi_barang" rows = 3 cols = 35> Deskripsi Barang </textarea><br><br>
								
				<input type="submit" name="Submit" value="Submit"> 
				<input type="reset" name="Reset" value="Reset"> 
				<br><br>
			
			</form>
			
			<fieldset>      

					<legend>Upload Gambar Barang</legend>       

					<div id = "output" >
						
					</div>						
					<br>	
						
					<form method="post" ACTION="edit_foto_barang.jsp" name="uploadForm" ENCTYPE='multipart/form-data'> 

						<input type="file" name="uploadFile" id='file' onchange="startRead()"/> 
						<input type="submit" name="Submit" value="Submit"> 
						<input type="reset" name="Reset" value="Reset"> 

					</form>

			</fieldset>
			
			</div>
		
			 
			  
	</div>
			
</div>
			
			
			
	
	<div class = "footer">
		<div class = "info">

		</div>
		
				
		
	</div>
</div>
</body>
</html>