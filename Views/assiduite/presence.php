<div class="container" id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script>
window.onload = function() {

    var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        theme: "light1", // "light1", "light2", "dark1", "dark2"
        title: {
            text: "Assiduité des étudiants en <?php echo strtoupper($classe) . ' la semaine de ' . $semaineDe ?>"
        },
        axisY: {
            title: "Pourcentage des étudiants présents",
            suffix: "%"
        },
        data: [{
            type: "column",
            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
        }]
    });
    chart.render();

}
</script>