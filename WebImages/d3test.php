<?php
include 'DBfile.php';
$walk_id = $_REQUEST['walkid'];
$sql="SELECT beacon_id,time_spent,timestamp FROM beacons where walk_id='".$walk_id."'";
$beacon =array();
$beacon_tts=array();
$result=mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
		//echo "selection successful";
		//echo $row["beacon_id"];
		$beacon_id=$row["beacon_id"];
		$tts=$row["time_spent"];
		array_push($beacon,$beacon_id);
		array_push($beacon_tts,$tts);
	}
}
else{
	echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

print_r("<p> </p> ");
?>
<!DOCTYPE html>
<html>
<head>
<script src="https://d3js.org/d3.v4.min.js"></script>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
<script type="text/javascript">
var BeaconArray = <?php 

$beconArr = "[";

for ($i = 0; $i < (count($beacon)-1); $i++) {
	$beconArr .= $beacon[$i].",";
}
$beconArr.= $beacon[count($beacon)-1]."]";

echo $beconArr;

?>;

var BeaconTTS= <?php 
$beaconTTSarr = "[";

for ($i = 0; $i < (count($beacon_tts)-1); $i++) {
	$beaconTTSarr .= $beacon_tts[$i].",";
}
$beaconTTSarr.= $beacon_tts[count($beacon_tts)-1]."]";

echo $beaconTTSarr;

?>;


var temp_Array=[];
debugger;
var svgContainer = d3.select("body")
.append("svg").style("background","url('http://qav2.cs.odu.edu/karan/BeaconsD3/BeaconRooms.JPG') no-repeat")
.attr("width", 700)
.attr("height", 700);

d3.selectAll('svgContainer')
.append('image')
//.attr('d',path)
.attr('xlink:href','view.jpg')
.attr('class', 'pico')
.attr('height', '100')
.attr('width', '100')

  .attr('x', '59')
  .attr('y', '50')
  .attr('background', 'red')

for(var i=0;i<BeaconArray.length;i++)
{
	var result=checkArray(BeaconArray[i]);
	
	 
		 plotCircle(BeaconArray[i],i,BeaconArray.length-1);	 
	 

	  if(i>=1){
		 //plotLine(BeaconArray[i-1],BeaconArray[i]);
		 } 
		
	
}



//Add SVG Text Element Attributes




/*                         
 for(i=0;i<BeaconArray.length;i++)
{
	var result=checkArray(BeaconArray[i],temp_Array);
	if(result =="False"){
		
		
			}
	
} */
 



 function checkArray(value){
	var result="False";

	for (var i=0;i<temp_Array.length;i++)
	{
		if(value==temp_Array[i]){
			result="True";
			return result;
		}
		
	}
	return result;
} 
var b1=[100,200];
var firstvalue;
  function plotCircle(x,i,max) {

	  
	
      
	  if(x==1){ cx=30; cy=30;}
	  else if(x==2){ cx=400; cy=50;} 
	  else if(x==4){cx=250;cy=450}
		//Draw the Circle
	if(i==0){
		firstvalue=x;
		circle = svgContainer.append("circle")
		.attr("cx", cx)
		.attr("cy", cy)
		.attr("r", 05)
		.style("fill","orange");
	}
	else if(i==max){
		if(firstvalue==x){
			circle = svgContainer.append("circle")
			.attr("cx", cx)
			.attr("cy", cy)
			.attr("r", 05)
			.style("fill","blue");
		}
		else{
			if(firstvalue!=x)
			{
			circle = svgContainer.append("circle")
			.attr("cx", cx)
			.attr("cy", cy)
			.attr("r", 05)
			.style("fill","black");
			}
		}
		
		}
	else{
		if(x!=firstvalue){
					
		 circle = svgContainer.append("circle")
		.attr("cx", cx)
		.attr("cy", cy)
		.attr("r", 05)
		.style("fill","green");
		}
	}

	temp_Array.push(x);
}

  function Beacon_time(){
	  alert(BeaconTTS);
	var out="<h2>Time spent near each beacon</h2> <table class='table'><thead> <tr><th>Beacon</th><th>Time Spent</th></tr></thead><tbody>";
	for(i=0;i<BeaconTTS.length;i++){
		out+="<tr><td>"+BeaconArray[i]+"</td><td>"+BeaconTTS[i]+"</td></tr>";
		}
	out+=" </tbody></table>";
	$("#displayTable").html(out);
	  }
  
/*   function plotLine(x,y){	   
	   if(x==2&&y==4)       {x1=855; y1=300; x2=855; y2=170;}
	   if(x==2&&y==1)       {x1=855; y1=300; x2=680; y2=170;}
	   else if(x==4&&y==2)  {x1=855; y1=170; x2=855; y2=300;}
	   else if(x==4&&y==1)  {x1=855; y1=170; x2=680; y2=170;}
	   else if(x==1&&y==2)  {x1=680; y1=170; x2=855; y2=300;}
	   else if(x==1&&y==4)  {x1=680; y1=170; x2=855; y2=170;}
	   var line = svgContainer.append("line")
	                            .attr("x1", x1)
	                            .attr("y1", y1)
	                            .attr("x2", x2)
	                            .attr("y2", y2)
	                            .attr("stroke-width", 2)
	                            .attr("stroke", "green");
		
	  }  */
 
/* var circle = svgContainer.append("circle")
						.attr("cx", 230)
						.attr("cy", 30)
						.attr("r", 5);

var line = svgContainer.append("line")   
                         .attr("x1", 30)
                         .attr("y1", 30)
                         .attr("x2", 230)
                         .attr("y2", 30)
                         .attr("stroke-width", 2)
                         .attr("stroke", "black"); */
/*  var beacons =[
		{"x_axis":100, "y_axis":100, "radius":5,  "color": "green"},
		{"x_axis":100, "y_axis":400, "radius":5,  "color": "green"},
		{"x_axis":400, "y_axis":100, "radius":5, "color": "green"}];
var single={"x_axis":200, "y_axis":200, "radius":5,  "color": "red"}; 

 //var spaceCircles = [30, 70, 110];

var svgContainer = d3.select("body").append("svg")
                                    .attr("width", 500)
                                    .attr("height", 500);

var circles = svgContainer.selectAll("circle")
                          .data(beacons)
						  .enter()
                         .append("circle");

 var circles = svgContainer.selectAll("circle")
                          .data(single)
						  .enter()
                         .append("circle"); 
var circleAttributes = circles
                       .attr("cx", function (d) { return d.x_axis; })
                       .attr("cy", function (d) { return d.y_axis; })
                       .attr("r", function (d) { return d.radius;  })
                       .style("fill", function(d) { return d.color;});      
                          */
                      
 
</script>
</head>
<body onload="Beacon_time()">
<div id="displayTable"style="width:400px; float:left">
 
</div>

</body>

</html>
