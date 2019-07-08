<!DOCTYPE html>  
<html>
<head>  
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />  
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title>Hello, World</title>  
<style type="text/css">  
html{height:100%}  
body{height:100%;margin:0px;padding:0px}  
#container{height:100%}  
.input{
	position: absolute;
	border: 1px solid #fff;
	/*background: red;*/
	/*height: 300px;*/
	/*width: 400px;*/
	z-index: 999999;
	top: 0;
	left: 5%;
	margin-top: 100px;
	
}
.input input{
	padding: 5px 5px;
	font-size: 1.2rem;
	border: none;
	background: transparent;
	color: #fff;
	outline: none;
}

#btn{
	position: absolute;
	z-index: 9999;
	bottom: 20px;
	right: 20px;
	width: 100px;
	height: 100px;
	line-height: 100px;
	text-align: center;
	
	/*border: 1px solid rgba(255,255,255,0.5);*/
	border-radius: 300px;
	/*background: rgba(255,255,255,0.5);*/
background: #314755;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #26a0da, #314755);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #26a0da, #314755); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */







	color: #fff;
}
#btn:hover{

background: #24C6DC;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #514A9D, #24C6DC);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #514A9D, #24C6DC); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */



}
.anchorBL a img{
	display: none;
}
</style>  
<script type="text/javascript" src="http://api.map.baidu.com/api?v=3.0&ak=WUTzt001ECezCI4PA8zWAGjGPqUamhRs">
//v3.0版本的引用方式：src="http://api.map.baidu.com/api?v=3.0&ak=您的密钥"
</script>
<script type="text/javascript" src="http://api.map.baidu.com/library/TextIconOverlay/1.2/src/TextIconOverlay_min.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/library/MarkerClusterer/1.2/src/MarkerClusterer_min.js"></script>
<script src="http://code.jquery.com/jquery-latest.js"></script>

</head>  
 
<body>  
<div id="container"></div> 
<!--<div class="input"><input type="text" /></div>-->
<script type="text/javascript"> 
	$(function(){
		

		
		var map = new BMap.Map("container");

		// 创建地图实例  
		var point = new BMap.Point(106.33, 29.35);
		// 可缩放
//		map.enableScrollWheelZoom();
		// 创建点坐标  
		map.centerAndZoom(point, 6);
		// 自定义样式
		map.setMapStyleV2({
			styleId:'f8c2138690d65007945fdc5b27b32cc9'
		});
		//禁止双指缩放
		map.disableDoubleClickZoom();
		

		
		var startPoint1 = [];
		var set_start = function(e,ee,marker){
			var label = new BMap.Label("起点",{offset:new BMap.Size(20,-10)});
			marker.setLabel(label);
			var p = marker.getPosition();       //获取marker的位置
//			alert("marker的位置是" + p.lng + "," + p.lat);
			
			var gc = new BMap.Geocoder();
			var pointAdd = new BMap.Point(p.lng, p.lat);
			
            gc.getLocation(pointAdd, function(rs){
                // 百度地图解析城市名
//              $('#pro_num').html(rs.addressComponents.city);
                //或者其他信息
//              startPoint1 = rs.addressComponents.province;
//              console.log(rs.addressComponents.province);
				startPoint1.push(rs.addressComponents.province);
            })

			console.log(2)
			
//			console.log(start_point);
//			return start_point=marker;
			
		}

		// var start_point = 0;
		function addMarker(point){
		  var marker = new BMap.Marker(point);
		  map.addOverlay(marker);
		  
		 //  if(start_point == 0){
		 //  	var label = new BMap.Label("起点",{offset:new BMap.Size(20,-10)});
			// marker.setLabel(label);
			// start_point = 1
		 //  }
		 var markerMenu=new BMap.ContextMenu();
		markerMenu.addItem(new BMap.MenuItem('设置起点',set_start.bind(marker)));
		
		var marker = new BMap.Marker(point);
		map.addOverlay(marker);
		marker.addContextMenu(markerMenu);
		console.log(1);
		}
		// 随机向地图添加25个标注
		
		var city = [];
		var data = {};
		
//		储存旅游的数组
		var allTravleCity = [];
		var oneTravelCity = [];
		var allCity = [];
		var oneLine = [];
		var allLine = [];
		
		$.ajax({
			type:"get",
			url:"city.json",
			async:false,
			success:function(res){
				console.log(res);
				for (var i = 0; i < res.length; i ++) {
//					储存数据
					var data = {};
					data['name'] = res[i].name;
					data['log'] = res[i].log;
					data['lat'] = res[i].lat;
					data['flag'] = 0;
					city.push(data);
					
				}
			}
			
		});
		console.log(city);
	
//		获取点击位置的城市名字
		function showInfo(e){
			console.log(e.point.lng + "," + e.point.lat);
			var p = new BMap.Point(e.point.lng,e.point.lat);
			var geocoder = new BMap.Geocoder();

			
			geocoder.getLocation(p,function(rs){
				
				console.log(rs);
				console.log(rs.addressComponents.province);
//				点击时地图区域变亮
				
//				if(tapFlag == 1){
					
				for(var i=0; i<city.length; i++){
					if(city[i].name == rs.addressComponents.province){
						if(city[i].flag == 0){
							city[i].flag = 1;
							var p = new BMap.Point(city[i].log,city[i].lat);
							addMarker(p);
							lightCity(rs.addressComponents.province,'red',city[i].flag,city[i].log,city[i].lat);

//							console.log(rs.addressComponents.province);
		//						console.log(i);
							var allOverlay = map.getOverlays();
							console.log(allOverlay);
	//							allTravleCity.push(rs.addressComponents.province);
							
							
						}
//						 else {
////							remove
//							city[i].flag = 0;
//							var allOverlay = map.getOverlays();
//							console.log('b',allOverlay)
//							console.log('lng',allOverlay[1].point.lng)
//							console.log('lat',allOverlay[1].point.lat)
//							console.log('log',city[i].log)
//							console.log('lat',city[i].lat)
//							
//							
//							
////							for(var k=1; k<allOverlay.length; k=k+2){
////								if(allOverlay[k].point.lng==city[i].log && allOverlay[k].point.lat==city[i].lat)
////									console.log(1)
////									
////									map.removeOverlay(allOverlay[k-2]);
////									console.log('k1',k)
////									map.removeOverlay(allOverlay[k-1]);
////									console.log('k2',k+1)
////									console.log(allOverlay)
////									break;
////									
////									
////								}
//							
//						}
					}
						
				}
					
//				}

//				graph.vertices.push('rs');
//				var point = new BMap.Point(res[i].log, res[i].lat);		
//				addMarker(point);
		})

		}
		

		map.addEventListener("click",showInfo);
		map.addEventListener("rightclick",function(){console.log(1)});
		

		
		
		
//		获取区域板块，使其点亮
		function lightCity(name,color,tag,log1,lat1){
			var boundary = new BMap.Boundary();
			boundary.get(name,function(rs){

				console.log(rs);
				var path = [];
				var c = 0;
				for(var i=0; i<rs.boundaries.length; i++){

					var a = rs.boundaries[i].split(';');
					console.log(a.length);
					path = path.concat(a);
				}
				
				var b = [];
				var logLat = [];
				for(var i=0; i<path.length; i++){
					logLat = path[i].split(",");
					var log = logLat[0],lat = logLat[1];
					b.push(new BMap.Point(log,lat));
				}
				
				var polygon = new BMap.Polygon(b,{strokeColor:"gray", strokeWeight:1, strokeOpacity:0.8,fillColor:color,fillOpacity:0.5});
				map.addOverlay(polygon);
//				
			})
		
		}
		
		

		
		function Graph(v){
			this.vertices = [];
			var arcs = [];
			this.vexnum = v;
			var arcnum = (v*(v-1))/2;
			
//			this.init_g = function(){
//				for(var i=0;i<this.vexnum;++i)
//					arcs[i] = [];
//			}
			this.init_g = function(){
				for(var i=0;i<this.vexnum;++i){
					arcs[i] = [];
					for(var j=0;j<this.vexnum;++j){
						arcs[i][j]=0;
					}
				}
			}
			
			
			this.locateVex = function(a,v){
				for(var i=0;i<a.length;i++){
					if(a[i]==v){
						return i;
					}
				}
			}
			this.addEdge = function(v,m,Long_d){
				var i = this.locateVex(this.vertices,v);
				var j = this.locateVex(this.vertices,m);
				arcs[i][j] = Long_d;
				arcs[j][i] = arcs[i][j]; 
			}
			this.showgraph = function(){
				var s="";
				for(var i=0;i<this.vexnum;i++){
					s=this.vertices[i]+"->";
					for(var j=0;j<this.vexnum;j++){
						if(arcs[i][j]!=undefined){
							s=s+arcs[i][j]+"  ";
						}
					}
					console.log(s);
				}
			}
			
			

			this.MiniSpanTree = function(a){
				var flag = [a];
				//标志
				var closedge = [];
				var k = this.locateVex(this.vertices,a);
				for(var j=0;j<this.vexnum;j++){
					if(j!=k) {closedge[j] = [a,arcs[k][j]]}
				}
				closedge[k] = [a,0];
				
				for(var i=1;i<this.vexnum;i++){
					var min = Number.MAX_VALUE;
					var j=0;
					var k=0;
					while(j<this.vexnum){
						if(closedge[j][1]!=0 && closedge[j][1]<min){
							min = closedge[j][1];
							k = j;
						}
						j++;
					}
					
//					console.log(k)
//					for(var x=0;x<closedge.length;x++){
//						console.log(closedge[x]);
//					}

					var min_v = closedge[k][0];
					var min_u = this.vertices[k];

					flag.push(this.vertices[k]);

					closedge[k][1] = 0;
					for(var j=0;j<this.vexnum;j++){
						if(flag.indexOf(this.vertices[j])<0)
							closedge[j] = [this.vertices[k],arcs[k][j]];


					}
				}
//				console.log(flag)
				return flag;
			}
			
			
			
			
			this.suan = function(a){
				var i=0;
				var j=0;
				var Long = 0;
			}
		}
		
		var dis1 = [];
		var oneDis = [];
		var allDis = [];
		var cityMatch = [];
		
//		var allI = [];
//		获取当前地图显示的覆盖物百度地图api
		$('#btn').click(function(){
			for(var i=0; i<city.length; i++)
				if(city[i].flag == 1){
					allTravleCity.push(city[i]);
					allCity.push(city[i].name);

					
				}
//			console.log(allTravleCity)
			console.log('allCity',allCity)
			for(var i=0; i<allCity.length; i++){
				
				for(var j=i+1; j<allCity.length; j++){
					var data = {};
					
					data['city1'] = allCity[i];
					data['city2'] = allCity[j];
					data['distance'] = "";
					cityMatch.push(data);
				}
				
			}
			console.log(cityMatch)
			
			
			
			
//			匹配然后把距离加进去
			s = [];
			$.ajax({
				url:'citydistance.json',
				type:'get',
				datatype:'json',
				async:false,
				success:function(res){
					console.log(res);
					$.each(res,function(index,element){
						for(var i=0;i<cityMatch.length;i++)
						{
//							console.log(string1[i])
							if((cityMatch[i].city1 == element.city1 && cityMatch[i].city2 == element.city2) || (cityMatch[i].city2 == element.city1 && cityMatch[i].city1 == element.city2) ){
//								console.log(element.city1+"-"+element.city2+"距离："+element.distance)
								element.distance = element.distance/1000;
								s.push(element.distance);
								cityMatch[i]['distance'] = element.distance;
							}
						}
					})

				}
			})
			console.log(s);
			console.log(cityMatch);
			
			graph = new Graph(allCity.length);
			graph.init_g();
			
			for(var i=0;i<allCity.length;i++){
				graph.vertices.push(allCity[i]);
			}
			
			
			for(var i=0; i<cityMatch.length; i++){
				graph.addEdge(cityMatch[i].city1,cityMatch[i].city2,cityMatch[i].distance);
			}
			
			graph.showgraph();
//			起始点
			var finalResult =  graph.MiniSpanTree(startPoint1[0]);
			console.log('起始点',startPoint1[0])
			console.log('finalResult',finalResult);
			
			var point_search = [];
			
//			连线
//			console.log('allI',allI);
			var allI = [];
			for(var i=0; i<finalResult.length; i++){
				for(var j=0; j<city.length; j++){
					if(finalResult[i] == city[j].name)
						allI.push(j);
				}
			}
			console.log('allI',allI);
			for(var i=0; i<allI.length; i++){
				point_search[i] = new BMap.Point(city[allI[i]].log,city[allI[i]].lat);
			}

			console.log(point_search)
			
			
			var p = [];  //折线点的集合
			
					var driver = new BMap.DrivingRoute(map);
					var flag = 0 //记录函数执行次数
					var add = function(driver){
			
								
			
								driver.search(point_search[flag],point_search[flag+1])
			
			
							driver.setSearchCompleteCallback(function(){
							// 	var pots = driver.getResults().getPlan(0).getRoute(0).getPath();
							// 	console.log(driver.getResults())
							// 	console.log(pots)
							// 	p = p.concat(pots);
							// 	// console.log(p)
			
								p.push(point_search[flag]);
								p.push(point_search[flag+1])
			
							 	flag+=1;//次数+1
			
								var polyline = new BMap.Polyline(p);
								map.addOverlay(polyline)

								if(flag == point_search.length-1){//退出递归
									var marker = new BMap.Marker(point_search[point_search.length-1]);
									console.log(1)
		  							map.addOverlay(marker);
		  							var label = new BMap.Label("终点",{offset:new BMap.Size(20,-10)});
									marker.setLabel(label);
									return 0;
								}
								add(driver)
								});

							
			
					}
						add(driver);//递归开始
			allCity = [];
		});
		
		 var startPlace = "";
		$("#btn").mousedown(function(e){
			if(3 == e.which){
				
				map.clearOverlays();
				console.log(allCity)
//				allCity = [];
				
				for(var i=0; i<city.length; i++){
					if(city[i].flag==1){
						city[i].flag=0;

					}
				}

			}
		})





		function b(allTravleCity){
			for(var i=0; i<allTravleCity.length; i++)
			{
				for(var j=i+1; j<allTravleCity.length; j++){
					var distance = [];
					oneLine[0] = allTravleCity[i].name;
					oneLine[1] = allTravleCity[j].name;

					console.log(oneLine);
//					allLine.push(oneLine);
					
				}

			
			}
			console.log(allLine);
		}
		
//		console.log(1);
		var p1 = new BMap.Point(city[1].log,city[1].lat);
		var p2 = new BMap.Point(city[2].log,city[2].lat);

		
		function getLineLength1(start,end){
//				var distance = 0;
				
				var searchComplete = function (results){
				if (transit.getStatus() != BMAP_STATUS_SUCCESS){
					return ;
				}
				var plan = results.getPlan(0);
		//		output += plan.getDuration(true) + "\n";                //获取时间
				distance.push(parseFloat(plan.getDistance(true)));
//				console.log(distance);

			}
			var transit = new BMap.DrivingRoute(map, {
					onSearchComplete: searchComplete,
				});
				transit.search(start, end);
//			return distance[0];
		}
		

	})

</script>  
	<div id="btn" oncontextmenu="return false">开始</div>
</body>  
</html>