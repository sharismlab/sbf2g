/*
	   _____ ____  _____________    __       ____  ________  ________    _____   ________
	  / ___// __ \/ ____/  _/   |  / /      / __ \/  _/ __ \/ ____/ /   /  _/ | / / ____/
	  \__ \/ / / / /    / // /| | / /      / /_/ // // /_/ / __/ / /    / //  |/ / __/   
	 ___/ / /_/ / /____/ // ___ |/ /___   / ____// // ____/ /___/ /____/ // /|  / /___   
	/____/\____/\____/___/_/  |_/_____/  /_/   /___/_/   /_____/_____/___/_/ |_/_____/   
	                                                                                     
by @ooof and @clemsos
for Sharism Lab
2012

*/

// data source, should be a graphml file
var url  = 'data/data.xml';
var force;

// get our data
// graphml>json>Object>d3 force>svg
console.log("getting data from : "+url);
$("#viz").html("loading data...");

///////////// TURN XML DATA INTO JSON
$.get(url, function(xml){

	// convert XML to Json
	var json = $.xml2json(xml);	 
	console.log("raw json data");
	console.log(json);

	// extract only what we need to draw the graph 
	
	cleanGraphmlData(json, function(data){

	 	// callback, start d3 
	 	launchForceViz(data);
	 });
});

///////////// DATA FUNCTIONS
function cleanGraphmlData (data, callback) {

	var cleanData = {};
	cleanData.links = [];
	cleanData.links.types = []; //array to store all types of relatiosnhips
	cleanData.nodes = [];


	// get links
	for (var i = 0; i < data.graph.edge.length; i++) {
		var tmp = {};	
		tmp.value=1;
		tmp.source= Number(data.graph.edge[i].source.substr(1));
		tmp.target= Number (data.graph.edge[i].target.substr(1));
		tmp.color = data.graph.edge[i].data[data.graph.edge[i].data.length -1].PolyLineEdge.LineStyle.color;
		tmp.width = data.graph.edge[i].data[data.graph.edge[i].data.length -1].PolyLineEdge.LineStyle.width;
		
		// console.log( data.graph.edge[i].data[0].text);

		if(data.graph.edge[i].data[0].text != undefined) {
			var type = data.graph.edge[i].data[0].text.toLowerCase();
			if(type == "facebook.co" ) type = "facebook";
			else if(type == "电路" ) type = "dianlu ";
			// console.log(type);
			if( cleanData.links.types.indexOf(type) == -1 ) {
				cleanData.links.types.push(type);
			}
			tmp.type = type;
		}

		// console.log(tmp);
		cleanData.links.push(tmp);
		
	};

	//get image data for nodes
	var images = [];
	for (var i = 0; i < data.data.Resources.Resource.length; i++) {
		var tmp= {}
		if(!data.data.Resources.Resource[i].text){
			var imageIndex = data.data.Resources.Resource[i].ScaledIcon.ImageIcon.image;
			var nodeIndex = data.data.Resources.Resource[i].id -1;
			
			tmp.scaleX = data.data.Resources.Resource[i].ScaledIcon.xScale;
			tmp.scaleY = data.data.Resources.Resource[i].ScaledIcon.yScale;
			tmp.data = data.data.Resources.Resource[imageIndex-1].text;
		}
		images.push(tmp)
	};


	//add all data to nodes
	for (var i = 0; i < data.graph.node.length; i++) {
		var tmp = {};
		tmp.children=[]; //empty array to store relationships

		tmp.id = i;
		tmp.name = data.graph.node[i].data[0].text;

		// for console.log(data.graph.node[i].data[1].ShapeNode);

		tmp.image = {};
		if(typeof data.graph.node[i].data[1].ShapeNode != 'undefined') {
			
			tmp.color = data.graph.node[i].data[1].ShapeNode.Fill.color;
			tmp.colorText = data.graph.node[i].data[1].ShapeNode.NodeLabel.textColor;


			tmp.image.scaleX = images[i].scaleX;
			tmp.image.scaleY = images[i].scaleY;
			tmp.image.data = images[i].data;

			tmp.image.width = data.graph.node[i].data[1].ShapeNode.Geometry.width;
			tmp.image.height = data.graph.node[i].data[1].ShapeNode.Geometry.height;
		}
			
		// prepare text to fit within svg textbox
		/*
		function prepareText (svgTextObject,text) {
			var words = content.split(text);
			var tempText = "";
			for (var i=0; i<words.length; i++) {
				svgTextObject.attr("text", tempText + " " + words[i]);
				if (svgTextObject.getBBox().width > maxWidth) {
			    	tempText += "\n" + words[i];
				} else {
			    tempText += " " + words[i];
				}
			svgTextObject.attr("text", tempText.substring(1));
			}
		}
		*/


		cleanData.nodes.push(tmp);
	}
	
	console.log("data.cleaned !");
	console.log(cleanData);


	// get all childrens for each nodes
	for (var i = 0; i < cleanData.links.length; i++) {
		for (var j = 0; j < cleanData.nodes.length; j++) {
			if( cleanData.links[i].source == cleanData.nodes[j].id) {
				cleanData.nodes[j].children.push(cleanData.links[i].target);
			}
		};
	};

	//send data to callback
	callback(cleanData);
}

///////////// START D3 VIZ
function launchForceViz (data) {
	console.log("start viz now !");

	///////////// SETUP INIT

		var json = data;
		// console.log(json);

		var selectingColor = "blue";
		var selectedColor = "green";

		// console.log($(window).height());
		var width = 1060,
		    height = $(window).height(),
		    path,
		    node,
	    	trans=[0,0],
	    	scale=1;;

		var color = d3.scale.category20();

		// use a d3 brush to make things selectable
		/*
		var brush = d3.svg.brush();
			.on("brushstart", brushstart)
			.on("brush", brushing)
			.on("brushend", brushend);
		

		//set brush constraints to full width 
		brushX=d3.scale.linear().range([0, width]), 
		brushY=d3.scale.linear().range([0, height]);
		*/

		var svg = d3.select("#viz")
			.append("svg:svg")
			    .attr("width", width)
			    .attr("height", height)
			.append('svg:g')
		    	.attr('class', 'brush') 
		    	//.call(brush.x(brushX).y(brushY))
		    	.call(d3.behavior.zoom().on("zoom", redraw));

		force = d3.layout.force()
		    .size([width, height])
		    .on("tick",tick);

	/////////////// BRUSH FUNCTIONS

	/*	// colors selected nodes in red
		function color_node(node) {
		    if (node.selected) { return selectedColor; }
		    else { return color(node.color);}
		}

		function brushstart() {
	    	// do whatever you want on brush start
		}

		function brushing() {
		  	var e = brush.extent();
			svg.selectAll("circle").style("fill", function(d) {
				 truth = e[0][0] <= brushX.invert(d.x) && brushX.invert(d.x) <= e[1][0]
				      && e[0][1] <= brushY.invert(d.y) && brushY.invert(d.y) <= e[1][1];
				 value = truth ? "#cc0000" : color_node(d);
				 return value;
			})
			.attr("stroke-opacity"), function(d) {
				thisOpacity = isConnected(d, o) ? 1 : opacity;
			    this.setAttribute('fill-opacity', thisOpacity);
			    return thisOpacity;
			};
		}

		function brushend() {
		  var e = brush.extent();
		  // empty brush deselect all nodes
		  if (brush.empty()) svg.selectAll("circle").attr("class", function(d) {
		      d.selected=false;
		  });

		  svg.selectAll("circle")
		  	.attr("fill", function(d) {
				truth = e[0][0] <= brushX.invert(d.x) && brushX.invert(d.x) <= e[1][0]
				&& e[0][1] <= brushY.invert(d.y) && brushY.invert(d.y) <= e[1][1];
				if (truth) { d.selected = true; }
				value = truth ? "#cc0000" : color_node(d);
				value = truth ? "#cc0000" : color_node(d);
				return value;
			});
		}
	*/
	///////////// DRAWING FUNCTIONS
		function redraw() {
		  trans=d3.event.translate;
		  scale=d3.event.scale;

		  svg.attr("transform",
		      "translate(" + trans + ")"
		    + " scale(" + scale + ")");
		}

		draw();

		function draw() {

			// Restart the force layout.
			force
			    .nodes(json.nodes)
				.links(json.links)
			    .charge(-130)
			    .linkDistance(320)
			    .gravity(.05)
		        // .distance(100)
		        .start();

			// Per-type markers, as they don't inherit styles.
			markers = svg.append("svg:defs").selectAll("marker")
				.data(json.links.types).enter()
				.append("svg:marker")
					.attr("id", String)
				    .attr("viewBox", "0 -5 10 10")
				    .attr("refX", 15)
				    .attr("refY", -1.5)
				    .attr("markerWidth", 6)
				    .attr("markerHeight", 6)
				    .attr("orient", "auto")
				.append("svg:path")
				    .attr("d", "M0,-5L10,0L0,5");

			path = svg.append("svg:g").selectAll("path")
			    .data(force.links())
			  .enter().append("svg:path")
			    .attr("class", function(d) { return "link " + d.type; })
			    .attr("marker-end", function(d) { return "url(#" + d.type + ")"; });

			// Update the nodes
			node = svg.selectAll("g.node")
			    .data(json.nodes);

			// Enter any new nodes.
			node.enter()
		    	.append("svg:g")
		    	.attr("class", "node");

			node.append("svg:circle")
				.attr("r", function(d) { return d.children.length*1.2; })
				.call(force.drag)
				.on("mouseover", fade(.1))
    			.on("mouseout", fade(1))
    			// .on("click", function(d) { click(d) })
    			.style("fill", function(d) { return color(d.color); })
    			.style("stroke", function(d) { return d3.rgb(color(d.color)).darker();});

			node.append("svg:text")
		        .attr("class", "nodetext")
	        	.attr("dx", ".05em")
	        	.attr("dy", "-.35em")
		        .style("font-size", 14)
		        .style("fill" , "#000000")
		        .style("font-family" , "Arial, sans")
		        .text(function(d) { return d.name })
				.call(force.drag);

			var n = json.nodes.length;
			console.log(n);
			force.start();
			for (var i = n; i > 0; --i) force.tick();
			force.stop();
		}
		

		function tick() {

			path.attr("d", function(d) {
			    var dx = d.target.x - d.source.x,
			        dy = d.target.y - d.source.y,
			        dr = Math.sqrt(dx * dx + dy * dy);
			    return "M" + d.source.x + "," + d.source.y + "A" + dr + "," + dr + " 0 0,1 " + d.target.x + "," + d.target.y;
			});
			if(!node.selected) {
				node.attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });
				// node.attr("display", fade(0.1));
			} else {
			}
	
		}


		// get all elements associated to a specific node 
	    var linkedByIndex = {};
	    json.links.forEach(function(d) {
	        linkedByIndex[d.source.index + "," + d.target.index] = 1;
	    });

	    function isConnected(a, b) {
        return linkedByIndex[a.index + "," + b.index] || linkedByIndex[b.index + "," + a.index] || a.index == b.index;
    	}

    	function fade(opacity) {
	        return function(d) {
	            node.style("stroke-opacity", function(o) {
	                thisOpacity = isConnected(d, o) ? 1 : opacity;
	                this.setAttribute('fill-opacity', thisOpacity);
	                return thisOpacity;
	            });

	            path.style("stroke-opacity", opacity).style("stroke-opacity", function(o) {
	                return o.source === d || o.target === d ? 1 : opacity;
	            });

	            markers.style("stroke-opacity", opacity).style("fill-opacity", function(o) {
	                return o.source === d || o.target === d ? 1 : opacity;
	            });
        };

    }

}

////////// CAPTION INTERACTIONS
jQuery(document).ready(function($) {
	

	// start/stop viz
	/*$("a.start").click( function(e) {
		e.preventDefault();
		force.start();
	})

	$("a.stop").click( function(e) {
		e.preventDefault();
		force.stop();
	})*/


	// add interactive legend
	var types = [];
	$('.legend li').each(function() {
    	types.push( $(this).attr("class") );
	});
	
	$("a.allLinks").click( function(e) {
		$( "path.link").show();
	})

	$(".legend li").click( function(e) {
		
		e.preventDefault();
		
		var myType = $(this).attr("class");
		for (var i = 0; i < types.length; i++) {
			$( "path.link." + types[i] ).hide();
		};
		$( "path.link."+ myType).show();
	})
});
	