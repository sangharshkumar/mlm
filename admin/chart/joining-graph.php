 <script>
        $(document).ready(function() {
            Highcharts.chart("joining_graph", {
                chart: {
                    type: "line",
                    marginBottom: 50,
                },

                title: {
                   text: "",
                },
                yAxis: {
                    title: {
                        text: "Members",
                    },
                },

                legend: {
                    layout: "vertical",
                    align: "right",
                    verticalAlign: "right",
                },

                plotOptions: {
                    series: {
                        label: {
                            connectorAllowed: false,
                        },
                    },
                },
                xAxis: {
                    visible: false,
                    title: {
                        text: "Time Range",
                    },
                    categories: [<?php echo $time_range; ?>],
                },tooltip: {
                  shared: true
              },
                colors: [
                    "#64E572",
                    "#2962E1",
                    "#ED561B",
                    "#50B432",
                    "#DDDF00",
                    "#24CBE5",
                    "#FF9655",
                    "#FFF263",
                    "#6AF9C4",
                ],
                series: [{
                        name: "Left Joining",
                        data: [<?php echo $left_count_graph; ?>]
                    },
                    {
                        name: "Right Joining",
                        data: [<?php echo $right_count_graph; ?>]
                    }
                ],
            });
        });
    </script>