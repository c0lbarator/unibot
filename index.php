<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width" />
		<title>Unibot</title>
		
		<link rel="stylesheet" href="css/content.css" />
		<link rel="stylesheet" href="css/rangeslider.css">
		<script src="js/jquery/1.12.3/jquery-1.12.3.min.js"></script>
		
		<script src="js/rangeslider.js"></script>
	</head>
	<body>
		<!-- TITLE -->
		<div id="title">
			<div class="logo">
				<img class="padding10" src="images/logo.png"/>
			</div>
		</div>
		<!-- LEFT MENU -->
		<div class="left_menu_container" style="border-right-style: solid;border-right-width: 1px;margin-left: 10px;margin-top: 10px;border-left-width: 1px;border-left-style: solid;border-top-width: 1px;border-top-style: solid;border-bottom-width: 1px;border-bottom-style: solid;">
			<!-- START SERVER BUTTON -->
			<div class="menu_row">
				<button id="start_server">
				<img src="images/btn_start_server.png" style="width: 280px;height: 60px;margin-left: 170px;">
				</button>
			</div>
			<!-- STOP SERVER -->
			<div class="menu_row">
				<button class="grey_wide_button" id="stop_server">Остановить Сервер</button>
			</div>
			<!-- CLEAR CONSOLE -->
			<div class="menu_row">
				<button class="grey_wide_button" style="margin-left: 350px;margin-top: -70px;" id="clear_console">Очистить консоль</button>
			</div>
			<!-- FEED PAPER ROW -->
			<div class="menu_row">
				<div class="grey_box" style="margin-top: -60px;" align=center>Мотор листа</div>
				<button class="red_box_btn" style="margin-top: -60px;margin-left: 70px;" id="feed_paper_in">
				<img src="images/btn_up.png"/>
				</button>
				<button class="red_box_btn" style="margin-top: -60px;margin-left: 130px;" id="feed_paper_out">
				<img src="images/btn_down.png"/>
				</button>
				<button class="red_box_btn" style="margin-top: -60px;margin-left: 190px;" id="stop_feed_paper">
				<img src="images/btn_stop.png"/>
				</button>
			</div>
			<!-- SET PEN ROW -->
			<div class="menu_row">
				<div class="grey_box" align=center style="margin-top: -130px;margin-left: 350px;">Ручка</div>
				<button class="red_box_btn" style="margin-top: -130px;margin-left: 420px;" id="move_pen_up">
				<img src="images/btn_up.png"/>
				</button>
				<button class="red_box_btn" style="margin-top: -130px;margin-left: 480px;" id="move_pen_down">
				<img src="images/btn_down.png"/>
				</button>
				<button class="red_box_btn" style="margin-top: -130px;margin-left: 540px;" id="set_pen_position">
				<img src="images/btn_confirm.png"/>
				</button>
			</div>
			<!-- CALIBRATE -->
			<div class="menu_row">
				<button class="grey_wide_button" style="margin-left: 170px;margin-top: -100px;" id="calibrate">Откалибровать</button>
			</div>
			<!-- FORCE STOP -->
			<div class="menu_row">
				<button class="grey_wide_button" style="margin-left: 170px;margin-top: -100px;" id="force_stop">Остановить</button>
			</div>
			<!-- DRAW MAZE -->
			<div class="menu_row" style="height:230px;margin-top: -100px;margin-left: 10px;">
				<div>
					<div class="slider_label">WIDTH:<span id="width_label">12<span></div>
					<input id="width_slider" type="range" min="3" max="20" data-rangeslider>
				</div>
				<div>
					<div class="slider_label">HEIGHT:<span id="height_label">12</span></div>
					<input id="height_slider" type="range" min="3" max="20" data-rangeslider>
				</div>
				<div>
					<div class="slider_label">SIZE:<span id="size_label" >100</span></div>
					<input id="size_slider" type="range" min="50" max="150" step="10" data-rangeslider>
				</div>
				<button  id="draw_maze" style="margin-top:10px;">
				<img src="images/btn_draw_maze.png"/>
				</button>
			</div>
			<!-- DRAW SVG -->
			<div class="menu_row" style="height:160px;margin-left: 350px;margin-top: -230px;" style="height:160px;">
				
				<input id="uploadFile" placeholder="Choose File" disabled="disabled" style="margin-bottom:10px;width: 280px;" />
					<div class="fileUpload btn btn-primary">
					    <div class="grey_wide_button" align="center" style="width:250px;height:60px;padding-top:20px">Выбрать файл для рисования</div>
					    <input id="uploadBtn" type="file" class="upload" style="height: 60px;width: 250px;" />
					</div>
					<button class="grey_wide_button" id="upload_svg" style="width:250px;margin-left:0px;">Загрузить файл для рисования</button>
				
				<button id="draw_svg" style="margin-top:10px;">
				<img src="images/btn_draw_svg.png"/>
				</button>
			</div>
		</div>
		<div class="console_container" id="console_container">
		</div>
	</body>
</html>
<script>
$(document).ready(function() {
var $document = $(document);
var selector = '[data-rangeslider]';
var $element = $(selector);

document.getElementById("uploadBtn").onchange = function () {
    document.getElementById("uploadFile").value = this.value;
};

var slideElements = [];
slideElements["width_slider"] = $('#width_label');
slideElements["height_slider"] = $('#height_label');
slideElements["size_slider"] = $('#size_label');
// Basic rangeslider initialization
$element.rangeslider({
// Deactivate the feature detection
polyfill: false,
// Callback function
onInit: function() {

},
// Callback function
onSlide: function(position, value) {
var id = this.$element[0].id;
slideElements[id].text(value);
},
// Callback function
onSlideEnd: function(position, value) {
var id = this.$element[0].id;
slideElements[id].text(value);
}
});


$( "body" ).keydown(function(e) {
	console.log("keydown "+e.keyCode);
	  if(e.keyCode == 38 || e.which == 38){ // UP
	  	$.post( "python_socket_server.php", { action: "send", data:"feed_paper_out_inc" })
	  }else if(e.keyCode == 40 || e.which == 40){ // DOWN
	  	$.post( "python_socket_server.php", { action: "send", data:"feed_paper_in_inc" })
	  }else if(e.keyCode == 39){ // RIGHT
	  	$.post( "python_socket_server.php", { action: "send", data:"move_right" })
	  }else if(e.keyCode == 37){ // LEFT
		$.post( "python_socket_server.php", { action: "send", data:"move_left" })
	  }else if(e.keyCode == 32){ // SPACE
	  	$.post( "python_socket_server.php", { action: "send", data:"switch_pen_pos" })
	  }else if(e.keyCode == 90){ // z
	  	$.post( "python_socket_server.php", { action: "send", data:"switch_pen_state" })
	  }
});

$( "body" ).keyup(function(e) {
	  if(e.keyCode == 38 || e.which == 38){ // UP
	  	$.post( "python_socket_server.php", { action: "send", data:"feed_paper_stop_inc" })
	  }else if(e.keyCode == 40|| e.which == 40){ // DOWN
	  	$.post( "python_socket_server.php", { action: "send", data:"feed_paper_stop_inc" })
	  }else if(e.keyCode == 39){ // RIGHT
	  	$.post( "python_socket_server.php", { action: "send", data:"move_stop" })
	  }else if(e.keyCode == 37){ // LEFT
	  	$.post( "python_socket_server.php", { action: "send", data:"move_stop" })
	  }else if(e.keyCode == 32){ // SPACE

	  }
});


// START SERVER BUTTON
		$('#start_server').click(function(){
		$.post( "python_socket_server.php", { action: "start_server" })
		.done(function( data ) {
		logMessage(data);
		});
		})

// STOP SERVER BUTTON
		$('#stop_server').click(function(){
		$.post( "python_socket_server.php", { action: "stop_server" })
		.done(function( data ) {
		logMessage(data);
		});
		})



// PAPER FEED
		$('#feed_paper_in').click(function(){
		$.post( "python_socket_server.php", { action: "send",data:"feed_paper_in" })
		})
		$('#clear_console').click(function(){
			var el = document.getElementById("console_container");
			el.innerHTML= "";
		})
		$('#feed_paper_out').click(function(){
		$.post( "python_socket_server.php", { action: "send",data:"feed_paper_out" })
		})
		$('#stop_feed_paper').click(function(){
		$.post( "python_socket_server.php", { action: "send",data:"stop_feed" })
		})
		// PEN POSITION
		$('#move_pen_up').click(function(){
		$.post( "python_socket_server.php", { action: "send",data:"move_pen_up" })
		})

		$('#move_pen_down').click(function(){
		$.post( "python_socket_server.php", { action: "send",data:"move_pen_down" })
		})

		$('#set_pen_position').click(function(){
		$.post( "python_socket_server.php", { action: "send",data:"set_pen_position" })
		})
		// CALIBRATE
		$('#calibrate').click(function(){
		$.post( "python_socket_server.php", { action: "send",data:"calibrate" })
		})
		// DISPLAY INFO
		$('#get_info').click(function(){
		$.post( "python_socket_server.php", { action: "send",data:"get_info" })
		})
		// FORCE STOP
		$('#force_stop').click(function(){
		$.post( "python_socket_server.php", { action: "send",data:"force_stop" })
		})

		// DRAW MAZE
		$('#draw_maze').click(function(){
			var d = "draw_maze |"+$('#width_label').text()+"|"+$('#height_label').text()+"|"+$('#size_label').text();
		$.post( "python_socket_server.php", { action: "send",data:d})
		})

		// UPLOAD SVG
		$('#upload_svg').click(function(){
			
			var fileInput = document.querySelector("#uploadBtn");

		    var xhr = new XMLHttpRequest();
		    xhr.open('POST', 'upload.php');

		    xhr.upload.onprogress = function(e) 
		    {
		        /* 
		        * values that indicate the progression
		        * e.loaded
		        * e.total
		        */
		        console.log(e.loaded+":"+e.total);
		    };

		    xhr.onload = function()
		    {
		        alert('upload complete');
		    };

		    // upload success
		    if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
		    {
		        // if your server sends a message on upload sucess, 
		        // get it with xhr.responseText
		        alert(xhr.responseText);
		    }

		    var form = new FormData();
		    form.append('upload_file', fileInput.files[0]);

		    xhr.send(form);

		})

		// DRAW SVG
		$('#draw_svg').click(function(){
			window.open("svg_draw.php","_blank");
		})

		if (!!window.EventSource) {
	      var source = new EventSource("python_console.php");

	      source.addEventListener("message", function(e) {
	        logMessage(e.lastEventId+"--> "+e.data);
	      }, false);
	      
	      source.addEventListener("open", function(e) {
	        logMessage("СОКЕТ-СЕРВЕР открыт:");
	      }, false);

	      source.addEventListener("error", function(e) {
	        logMessage("Ошибка:");
	        if (e.readyState == EventSource.CLOSED) {
	          logMessage("СОКЕТ-СЕРВЕР закрыт");
	        }
	      }, false);
	    } else {
      		document.getElementById("notSupported").style.display = "block";
	    }

	    logMessage("Добро пожаловать в панель управления ЮниБота");
	    logMessage("Ожидание СОКЕТ-СЕРВЕРА");

		
		function logMessage(obj) {
			var el = document.getElementById("console_container");
			var entry = '<div class="console_entry"> > '+obj+' </div>';
			el.innerHTML= entry+el.innerHTML;
		}
});
</script>





		
