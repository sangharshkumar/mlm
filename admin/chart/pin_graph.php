<script>
        $(document).ready(function() {
            Highcharts.chart("pin_graph", {
                chart: {
                    type: "line",
                    marginBottom: 50,
                },

                title: {
                  text: "",
                },
                yAxis: {
                    title: {
                        text: "Number of Pins",
                    },
                },
                legend: {
                    layout: "vertical",
                    align: "right",
                    verticalAlign: "right",
                },

              colors: [
                  "#2962E1",
                  "#64E572",
                  "#ED561B",
                  "#50B432",
                  "#DDDF00",
                  "#24CBE5",
                  "#FF9655",
                  "#FFF263",
                  "#6AF9C4",
              ],
              tooltip: {
                  shared: true
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
                },

                series: [
                    {
                        name: "Pins Sold",
                        data: [<?php echo $sold_pins_count ?>],
                    },{
                        name: "Pins Activated",
                        data: [<?php echo $active_pins_count ?>],
                    },
                ],
            });
        });
    </script>