{extend name="glob/base" /}
{block name='webname'}网站访问统计{/block}
{block name="content"}
<!-- 地图显示容器 -->
<div id="container" style="height:600px;"></div>

<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=iEUoXQf63l9MXipKdXnuKABZdGsyLwI4"></script>
<script type="text/javascript" src="{:url('static/echarts/echarts.min.js')}"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/extension/bmap.min.js"></script>
<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/map/js/china.js"></script>
<script type="text/javascript">
	var dom = document.getElementById("container");
	var myChart = echarts.init(dom);
	var app = {};
	option = null;

	var data = <?php echo $visithit; ?>;


	option = {
	    title : {
	        text: '网站访问统计',
	        subtext: '以每日访问次数为准',
	        left: 'center'
	    },
	    tooltip : {
	        trigger: 'item'
	    },

	    visualMap: {
	        min: 0,
	        max: 2500,
	        left: 'left',
	        top: 'bottom',
	        text:['高','低'],           // 文本，默认为数值文本
	        calculable : true
	    },
	    toolbox: {
	        show: true,
	        orient : 'vertical',
	        left: 'right',
	        top: 'center',
	        feature : {
	            mark : {show: true},
	            dataView : {show: true, readOnly: false},
	            restore : {show: true},
	            saveAsImage : {show: true}
	        }
	    },
	    series: [
	    	{
	        name: '网站访问统计',
	        type: 'map',
	        mapType: 'china',
	        roam: false,
		    label: {
		        normal: {
		            show: true
		        },
		        emphasis: {
		            show: true
		        }
		    },
	        data:  data,
	    	}]
	};;
	if (option && typeof option === "object") {
	    myChart.setOption(option, true);
	}
</script>
{/block}

