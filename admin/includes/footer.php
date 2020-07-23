  </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/yym7hau1bieyaiazukwh8bpb7yht8h0vfho5x2i804qp6j9h/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
      tinymce.init({
        selector: '#mytextarea'
      });
    </script>
    <script>
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Views',   <?php echo $session->count; ?>],
          ['Photos',   <?php echo Photo::count_all(); ?>],
          ['Comments', <?php echo Comment::count_all(); ?>],
          ['Users',    <?php echo User::count_all(); ?>]
        ]);

        var options = {
          legend: 'none',
          pieSliceText: 'label',
          backgroundColor: 'transparent',
          title: 'My Daily Activities'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
    <script src="js/scripts.js"></script>
    <script src="js/dropzone.js"></script>
  </body>

</html>
