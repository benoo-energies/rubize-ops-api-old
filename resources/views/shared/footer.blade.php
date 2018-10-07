    </div>
    
    <!--   Core JS Files   -->
    <script src="/assets/js/jquery-1.10.2.js" type="text/javascript"></script>
    <script src="/assets/js/bootstrap.min.js" type="text/javascript"></script>
    
    <!--  Checkbox, Radio & Switch Plugins -->
    {{--  <script src="/assets/js/bootstrap-checkbox-radio.js"></script>  --}}
    
    <!--  Charts Plugin -->
    <script src="/assets/js/chartist.min.js"></script>
    
    <!--  Notifications Plugin    -->
    <script src="/assets/js/bootstrap-notify.js"></script>
    <script src="/assets/js/paper-dashboard.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>    

    @if(Request::segment(1) == "kpi")
        @if(Request::segment(2) == "prospection")
        <script>
            var url = "{{$url_energy}}";
            var Wish = new Array();
            var Actual = new Array();
            var Jobs = new Array();
            $(document).ready(function(){
                $("#energyChart").width($("#energyChartContainer").width());
                $.get(url, function(response){
                    console.log(response.data);
                    $.each(response.data, function(key,value){
                        Jobs.push(value.job);
                        Wish.push(value.wish);
                        Actual.push(value.actual);
                    });
                    var ctx = document.getElementById("energyChart").getContext('2d');
                        var myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels:Jobs,
                            datasets: [{
                                label: 'Futur (Wh/j)',
                                data: Wish,
                                borderWidth: 1,
                                backgroundColor : 'rgba(0, 0, 0, 0)',
                                borderColor : '#1007ED',
                                pointBackgroundColor : '#1007ED',
                                pointBorderColor : '#1007ED',
                                pointBorderWidth : 2,
                            },
                            {
                                label: 'Actuel (Wh/j)',
                                data: Actual,
                                borderWidth: 1,
                                backgroundColor : 'rgba(0, 0, 0, 0)',
                                borderColor : '#10ADED',
                                pointBackgroundColor : '#10ADED',
                                pointBorderColor : '#10ADED',
                                pointBorderWidth : 2
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero:true
                                    }
                                }],
                                xAxes: [{
                                    ticks: {
                                        autoSkip: false,
                                        /* maxTicksLimit: 20 */
                                    }
                                }]
                            }
                        }
                    });
                });
            });
            </script>
        @endif
    @endif
</body>

</html>
