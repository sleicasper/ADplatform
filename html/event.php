<?php require("header.php"); ?>

		<div class=cnt>
			<center>
			<script type="text/javascript">
			var socket;
			var arr = new Array();
			function init() {
				var host = "ws://139.162.126.185:2017";
				try {
					socket = new WebSocket(host);
					console.log('WebSocket - status '+socket.readyState);
					socket.onopen    = function(msg) {
						console.log("Welcome - status "+this.readyState);
					};

					socket.onmessage = function(msg) {
						arr.push(msg);
						if( arr.length > 15){
							arr.reverse();
							arr.pop();
							arr.reverse();
						}
						var output = "";
						for(var i=0; i<arr.length; i++){
							var m = arr[arr.length-1-i];
							var attacker = JSON.parse(m.data)['attacker'];
							var defender = JSON.parse(m.data)['defender'];
							var chall = JSON.parse(m.data)['chall'];
							output += ("<b>" + attacker + "</b> pwned <b>" + defender + "</b>'s <i style='color:#8ac122'>" + chall + "</i><hr>");
						}
						$("pannel").innerHTML = output;
					};
					socket.onclose   = function(msg) {
						console.log("Disconnected - status "+this.readyState);
					};
				}
				catch(ex){
					console.log(ex);
				}
			}
			window.onload = function() {
				init();
			};

			function $(id){ return document.getElementById(id); }
			</script>
			<div id="pannel" style="height:90%;width:700px;border:1px;background-color:#caf9de"> 
			</div>


			</center>



		</div>
<?php require("footer.php"); ?>
