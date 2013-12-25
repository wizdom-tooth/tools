<script type='text/javascript'>
// draw table and chart
function drawChart(){
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'id');
    data.addColumn('string', 'store_name');
    <?php foreach ($addup as $data):?>
    data.addRows([
        ["<?php echo $data['id'];?>", "<?php echo $data['store_name'];?>"],
    ]);
    <?php endforeach;?>
    var table = new google.visualization.Table(document.getElementById('table'));
    table.draw(data, {showRowNumber: true});
}
</script>
</head>
<body>
<div id='table'></div>
</body>
</html>
