/**
 * Created by James on 2016-11-27.
 */

function initOption(data){
    // 指定图表的配置项和数据
    var option = {
        title : {
            text: '課堂學員學位數目和學員人數',
            subtext: '以課堂日期為准'
        },
        tooltip : {
            trigger: 'axis'
        },
        legend: {
            data:['課堂學員學位數目','學員人數']
        },
        toolbox: {
            show : true,
            feature : {
                dataView : {show: true, readOnly: false},
                magicType : {show: true, type: ['line', 'bar']},
                restore : {show: true},
                saveAsImage : {show: true}
            }
        },
        calculable : true,
        xAxis : [
            {
                type : 'category',
                axisLabel: {
                    interval: 0,
                    rotate: 60
                },
                data : data.xData
            }
        ],
        yAxis : [
            {
                type : 'value'
            }
        ],
        series : [
            {
                name:'課堂學員學位數目',
                type:'bar',
                data:data.formData,
                markLine : {
                    data : [
                        {type : 'average', name: '平均值'}
                    ]
                }
            },
            {
                name:'學員人數',
                type:'bar',
                data:data.surveyorData,
                markLine : {
                    data : [
                        {type : 'average', name : '平均值'}
                    ]
                }
            }
        ]
    };
    return option;
}

$(function(){
    $('#btnView').on('click',function(){
        initChart();
    });
    initChart();
}) ;

function initChart(){
    //基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main'));
    var url = "../api/chart.php?q=surveyorform&";
    var param = $('#searchForm').serialize();
    url = url + param;
    // 异步加载数据
    $.getJSON(url).done(function (data) {
        var option = initOption(data);
        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
    });
}