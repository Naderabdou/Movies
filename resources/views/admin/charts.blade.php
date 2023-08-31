<div id="movies-chart"></div>

<script>
    $(document).ready(function (){
        var options = {
            series: [{
                name: "@lang('movies.total_movies')",
                data: @json($movies->pluck('total_movies')->toArray())

            }], //end of series



            chart: {
                type: 'bar',
                height: 380,

            },//end of chart



            plotOptions: {
                bar: {
                    columnWidth: '40%',
                    borderRadius: 15,
                }//end of bar

            },//end of plotOptions

            colors: ['#009644'],//end of colors


            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },//end of stroke

            fill: {
                colors: ['#009644']
            },//end of fill


            dataLabels: {
                enabled: false
            },//end of dataLabels






            xaxis: {
                categories: @json($movies->pluck('month')->toArray()),

            }//end of xaxis

        }//end of options;

        var chart = new ApexCharts(document.querySelector("#movies-chart"), options);
        chart.render();
    })
</script>
