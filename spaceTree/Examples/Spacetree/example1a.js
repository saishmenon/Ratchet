var labelType, useGradients, nativeTextSupport, animate;

(function() {
  var ua = navigator.userAgent,
      iStuff = ua.match(/iPhone/i) || ua.match(/iPad/i),
      typeOfCanvas = typeof HTMLCanvasElement,
      nativeCanvasSupport = (typeOfCanvas == 'object' || typeOfCanvas == 'function'),
      textSupport = nativeCanvasSupport 
        && (typeof document.createElement('canvas').getContext('2d').fillText == 'function');
  //I'm setting this based on the fact that ExCanvas provides text support for IE
  //and that as of today iPhone/iPad current text support is lame
  labelType = (!nativeCanvasSupport || (textSupport && !iStuff))? 'Native' : 'HTML';
  nativeTextSupport = labelType == 'Native';
  useGradients = nativeCanvasSupport;
  animate = !(iStuff || !nativeCanvasSupport);
})();

var Log = {
  elem: false,
  write: function(text){
    if (!this.elem) 
      this.elem = document.getElementById('log');
    this.elem.innerHTML = text;
    this.elem.style.left = (500 - this.elem.offsetWidth / 2) + 'px';
  }
};


function init(){
    //init data

    //var json = "<?php echo json_encode($return); ?>";

	// var json = {
		// id:"51d10cede4b0a90e18b14594",
		// name:"attack1child",
		// data:{data2child:"foo2"}
		// children:[{foo:"foo"}]
		// };
	//var json = {
	//"id": "1", 
	//"name": "foo", 
 	//"data": { 
 	//	"image": "http://3.bp.blogspot.com/_MHnA5hJubcU/THpoTJ0--nI/AAAAAAAADfY/wngbsN_a58s/s1600/jackie-chan.jpg", 
 	//	"email": "na...@server.com", 
 	//	"telephone": "5555555555", 
 	//	"mobile phone": "(55) 3225-1410"}, 
 	//	"children" : [{
	//		"id":"2",
	//		"name":"foo2",
	//		"data":{}, 
	//		"children" :[]
	//	}] 
	//};


        //  
        //*  json "tree" structure below 
	//   *  in order for this to work the json output from mongodb will have to be put into this
 	//   *  tree structure where all the children are explicitly placed under the parent.  This 
 	//   *  could involve some complicated processing.  Try json graph structure below to avoid this...
	
	
	// var json = 
	// {"_id":"1000","id":"100","name":"TopLevel","data":"testData1",
	// children:[
		 // {"_id":"1001","id":"1","name":"Name1","data":"testData1",
			// children:[
				// {"_id":"1001-1","id":"1-1","name":"C1-1","data":"testData1"},
				// {"_id":"1001-2","id":"1-2","name":"C1-2","data":"testData1"},
				// {"_id":"1001-3","id":"1-3","name":"C1-3","data":"testData1"}]},
		 // {"_id":"1002","id":"2","name":"Name2","data":"testData1"},
  		 // {"_id":"1003","id":"3","name":"Name3","data":"testData1"}]	};
	

	// Let's try a json "graph" structure
	//  Format : 
	//  It looks like this will work.  In this case the json output from the php script will have to 
	//  put the node id number of the child nodes into an array called "adjacencies".  
	// var json = [
		// {"id":"100","name":"Name100","adjacencies":["1","2","3"]},
		// {"id":"1","name":"Name1","adjacencies":["101"]},
		// {"id":"2","name":"Name2","adjacencies":["201"]},
		// {"id":"3","name":"Name3","adjacencies":["301"]},
		// {"id":"101","name":"Name101","adjacencies":["101-1"]},
		// {"id":"201","name":"Name201"},
		// {"id":"301","name":"Name301"},
		// {"id":"101-1","name":"Name101-1"}
		// ];

// var json = [
		// {"id":"100","name":"Name100","data":"testData1","adjacencies":["1","2","3"]},
		// {"id":"1","name":"Name1","data":"testData2","adjacencies":["101"]},
		// {"id":"2","name":"Name2","data":"testData1","adjacencies":["201"]},
		// {"id":"3","name":"Name3","data":"testData1","adjacencies":["301"]},
		// {"id":"101","name":"Name101","data":"testData1","adjacencies":["101-1"]},
		// {"id":"201","name":"Name201","data":"testData1"},
		// {"id":"301","name":"Name301","data":"testData1"},
		// {"id":"101-1","name":"Name101-1","data":"testData1"}
		// ];

		

	// var json =  [
	// {"_id":"1","adjacencies":["2","4","5"],"data":"","id":"1","name":"root 1"},
	// {"_id":"2","adjacencies":["3"],"data":"Attacks on Apache","id":"2","name":"Apache 2"},
	// {"_id":"3","id":"3","name":"XSS 3","data":"Cross Site Scripting","adjacencies":[]},
	// {"_id":"4","id":"4","name":"Email 4","data":"email stuff","adjacencies":[]},
	// {"_id":"5","id":"5","name":"SQL 5","data":"sql stuff","adjacencies":[]}
	// ];

	//var json = [
	//{"_id":"1","adjacencies":["2","3"],"data":"root node","id":"1","name":"root 1"},
	//{"_id":"3","id":"3","name":"SQL 3","data":"SQL attacks","adjacencies":[]},
	//{"_id":"4","id":"4","name":"XSS 4","data":"xss attacks","adjacencies":[]},
	//{"_id":"2","adjacencies":["4"],"data":"apache attacks","id":"2","name":"Apache 2"}
	//];
     	
    //end
    //init Spacetree
    //Create a new ST instance
    var st = new $jit.ST({
        //id of viz container element
        injectInto: 'infovis',
        //set duration for the animation
        duration: 800,
        //set animation transition type
        transition: $jit.Trans.Quart.easeInOut,
        //set distance between node and its children
        levelDistance: 50,
        //enable panning
        Navigation: {
          enable:true,
          panning:true
        },
        //set node and edge styles
        //set overridable=true for styling individual
        //nodes or edges
        Node: {
			//changed these too
            //height: 20,
            //width: 60,
			height: 35,
            width: 80,
            type: 'rectangle',
            color: '#aaa',
            overridable: true
        },
        
        Edge: {
            type: 'bezier',
            overridable: true
        },
        
        onBeforeCompute: function(node){
            Log.write("loading " + node.name);
        },
        
        onAfterCompute: function(){
            Log.write("done");
        },
        
        //This method is called on DOM label creation.
        //Use this method to add event handlers and styles to
        //your node.
        onCreateLabel: function(label, node){
            label.id = node.id;            
            label.innerHTML = node.name;
            label.onclick = function(){
            	if(normal.checked) {
            	  st.onClick(node.id);
            	} else {
                st.setRoot(node.id, 'animate');
            	}
            };
            //set label styles
            var style = label.style;
			//changed these
            //style.width = 60 + 'px';
            //style.height = 17 + 'px';    
			style.width = 80 + 'px';
            style.height = 35 + 'px';   			
            style.cursor = 'pointer';
            style.color = '#333';
            style.fontSize = '0.8em';
            style.textAlign= 'center';
            style.paddingTop = '3px';
        },
        
        //This method is called right before plotting
        //a node. It's useful for changing an individual node
        //style properties before plotting it.
        //The data properties prefixed with a dollar
        //sign will override the global node style properties.
        onBeforePlotNode: function(node){
            //add some color to the nodes in the path between the
            //root node and the selected node.
            if (node.selected) {
                node.data.$color = "#ff7";
            }
            else {
                delete node.data.$color;
                //if the node belongs to the last plotted level
                if(!node.anySubnode("exist")) {
                    //count children number
                    var count = 0;
                    node.eachSubnode(function(n) { count++; });
                    //assign a node color based on
                    //how many children it has
                    node.data.$color = ['#aaa', '#baa', '#caa', '#daa', '#eaa', '#faa'][count];                    
                }
            }
        },
        
        //This method is called right before plotting
        //an edge. It's useful for changing an individual edge
        //style properties before plotting it.
        //Edge data proprties prefixed with a dollar sign will
        //override the Edge global style properties.
        onBeforePlotLine: function(adj){
            if (adj.nodeFrom.selected && adj.nodeTo.selected) {
                adj.data.$color = "#eed";
                adj.data.$lineWidth = 3;
            }
            else {
                delete adj.data.$color;
                delete adj.data.$lineWidth;
            }
        },
	// Let's try adding some event handlers
	Events: {
		enable: true,
		type: 'auto',
		onRightClick: function(node, eventInfo,e) {
			alert("Right Mouse Click on Node "+node+". Node Id = "+node.id+"  Node name = "+node.name);
		},
		onMouseEnter: function(node, eventInfo,e) {
			console.log("In onMouseEnter function");
			$("#nodeDetails").html("Mouse over on "+node+". Node Id = "+node.id+"  Node name = "+node.data);
			//http://stackoverflow.com/questions/9623593/pass-javascript-variable-to-php-code
			var myval = node.id; 
			console.log("node is is "+ node.id+" myval is "+ myval);
			$.ajax({
			  type: 'POST',
			  url: 'getNodeData.php',
			  data: {'variable': myval},

			 success: function() {
			 	console.log("Return from ajax call in onMouseEnter function");
			 },
			 error: function(xhr, status) {
			 	console.log("Error in ajax call in onMouseEnter function");
			 },
			 complete: function(xhr, status) {
				console.log("Ajax call is complete in onMouseEnter function");
			}
			
		});		
		var data;
		console.log("Testing $.getJSON in onMouseEnter function");
		$.getJSON("getNodeData.php", function(resp) {
			$.each( resp, function( key, value) {
				console.log( key + " : " + value );
			});
			console.log("Attempt to launch spacetree example");
			data=resp;
			init();
		});
		$("#nodeDetails").html("Node Data "+data);
			//alert("Mouse over on "+node+". Node Id = "+node.id+"  Node name = "+node.name);
		console.log("End onMouseEnter function");
		}
		
	}
	
    });
    //load json data
    st.loadJSON(json);
    //compute node positions and layout
    st.compute();
    //optional: make a translation of the tree
    st.geom.translate(new $jit.Complex(-200, 0), "current");
    //emulate a click on the root node.
    st.onClick(st.root);
    //end
    //Add event handlers to switch spacetree orientation.
    var top = $jit.id('r-top'), 
        left = $jit.id('r-left'), 
        bottom = $jit.id('r-bottom'), 
        right = $jit.id('r-right'),
        normal = $jit.id('s-normal');
        
    
    function changeHandler() {
        if(this.checked) {
            top.disabled = bottom.disabled = right.disabled = left.disabled = true;
            st.switchPosition(this.value, "animate", {
                onComplete: function(){
                    top.disabled = bottom.disabled = right.disabled = left.disabled = false;
                }
            });
        }
    };
    
    top.onchange = left.onchange = bottom.onchange = right.onchange = changeHandler;
    //end

}
