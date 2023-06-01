<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{asset("css/bootstrap.min.css")}}">
    <title>Performance Graphs PDF</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        var visitor = <?php echo $visitor; ?>;
        console.log(visitor);

        google.charts.load('current', {'packages':['corechart']})
            .then(function () {
            var data = google.visualization.arrayToDataTable(visitor);
            var container = document.getElementById('chart_div');
            var chart = new google.visualization.LineChart(container);
            var btnSave = document.getElementById('save-pdf');

            google.visualization.events.addListener(chart, 'ready', function () {
                btnSave.disabled = false;
            });
            btnSave.addEventListener('click', function () {
                var doc = new jsPDF('l', 'pt', "a4");
                doc.addImage(chart.getImageURI(), 0, 0);
                doc.save('chart.pdf');
            }, false);

            chart.draw(data, {
                chartArea: {
                    bottom: 24,
                    left: 36,
                    right: 12,
                    top: 48
                },
                title: 'Employee performance Line Chart',
                vAxis: 
                    {
                        format:'0', 
                        viewWindow: {
                            max:5,
                            min:1
                        }
                    },
            });
        });
    </script>
<body>

<script src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>

<div class="col-md-12">
    <div id="chart_div" style="width: 900px; height: 470px; margin: auto"></div>
    <div class="mt-5" style="width: 900px; margin: auto">
        <button id="save-pdf"  class="btn btn-lg btn-primary" disabled />Download PDF</button>
    </div>
</div>
</body>
</html>