
  <script>
      $(document).ready(function() {
          Highcharts.setOptions({
              lang: {
                  thousandsSep: ',',
              }
          });
          Highcharts.chart("dashboard_graph", {
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
                      name: "Registration ",
                      data: [<?php echo $registration_count; ?>],
                  }
              ],
          });
      });
  </script>