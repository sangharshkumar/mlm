<script>
    $(document).ready(function() {
        $('#income_table').DataTable();
        Highcharts.setOptions({
            lang: {
                thousandsSep: ',',
            }
        });
        Highcharts.chart("income_graph", {
            chart: {
                type: "line",
                marginBottom: 50,
            },

            title: {
                text: "",
            },

            yAxis: {
                title: {
                    text: "Dollars",
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
            },
            colors: [
                "#2962E1",
                "#ED561B",
                "#50B432",
                "#DDDF00",
                "#24CBE5",
                "#64E572",
                "#FF9655",
                "#FFF263",
                "#6AF9C4",
            ],
            tooltip: {
                shared: true
            },
            series: [{
                    name: "Pins Earning ($) ",
                    data: [<?php echo $pin_graph; ?>],
                },
                {
                    name: "Paid ($) ",
                    data: [<?php echo $payout_graph; ?>],
                },
                {
                    name: "Income ($) ",
                    data: [<?php echo $profit_graph; ?>],
                },
                {
                    name: "Member Wallet($) ",
                    data: [<?php echo $wallet_graph; ?>],
                }
            ],
        });
    });
</script>