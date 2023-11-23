    <!-- Essential javascripts for application to work-->
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>
	<script src="../js/plugins/pace.min.js"></script>

    <!-- The javascript plugin to display page loading on top-->
    <script src="../js/plugins/pace.min.js"></script>
    <script type="text/javascript" src="../js/plugins/sweetalert.min.js"></script>
    <script type="text/javascript" src="../js/plugins/chart.js"></script>


        <!-- Data table plugin-->
    <script type="text/javascript" src="../js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../js/plugins/dataTables.bootstrap.min.js"></script>
    <!--<script type="text/javascript" src="js/funtions_users_sigeitp.js"></script>
    <script type="text/javascript" src="js/funtions_users_evadoc.js"></script>-->
    <script type="text/javascript" src="js/funtions_cuestions.js"></script>
<!--	<script type="text/javascript" src="js/FuntionsManageQuestions.js"></script>
	<script type="text/javascript" src="js/FuntionsConfigQuestionnaire.js"></script>
	<script type="text/javascript" src="js/FuntionsBankQuestion.js"></script>
	<script type="text/javascript" src="js/FuntionsConfigGuysQues.js"></script>
	<script type="text/javascript" src="js/FuntionsConfigRoles.js"></script>
	<script type="text/javascript" src="js/FuntionsConfigCategoriOfQuestions.js"></script>
	<script type="text/javascript" src="js/FuntionsConfigAssignGroupCatQues.js"></script>
	<script type="text/javascript" src="js/FuntionsConfigGroupCatQues.js"></script>
	<script type="text/javascript" src="js/FuntionsConfigQuestionForCategori.js"></script>
	<script type="text/javascript" src="js/FuntionsConfigAssignQuestions.js"></script>-->



	
    <script type="text/javascript">
      var data = {
      	labels: ["January", "February", "March", "April", "May"],
      	datasets: [
      		{
      			label: "My First dataset",
      			fillColor: "rgba(220,220,220,0.2)",
      			strokeColor: "rgba(220,220,220,1)",
      			pointColor: "rgba(220,220,220,1)",
      			pointStrokeColor: "#fff",
      			pointHighlightFill: "#fff",
      			pointHighlightStroke: "rgba(220,220,220,1)",
      			data: [65, 59, 80, 81, 56]
      		},
      		{
      			label: "My Second dataset",
      			fillColor: "rgba(151,187,205,0.2)",
      			strokeColor: "rgba(151,187,205,1)",
      			pointColor: "rgba(151,187,205,1)",
      			pointStrokeColor: "#fff",
      			pointHighlightFill: "#fff",
      			pointHighlightStroke: "rgba(151,187,205,1)",
      			data: [28, 48, 40, 19, 86]
      		}
      	]
      };
      var pdata = [
      	{
      		value: 300,
      		color: "#46BFBD",
      		highlight: "#5AD3D1",
      		label: "Complete"
      	},
      	{
      		value: 50,
      		color:"#F7464A",
      		highlight: "#FF5A5E",
      		label: "In-Progress"
      	}
      ]
      
      var ctxl = $("#lineChartDemo").get(0).getContext("2d");
      var lineChart = new Chart(ctxl).Line(data);
      
      var ctxp = $("#pieChartDemo").get(0).getContext("2d");
      var pieChart = new Chart(ctxp).Pie(pdata);
    </script>
    <!-- <script type="text/javascript">$('#tableusers').DataTable();</script>-->

    <!-- Page specific javascripts-->
    <!-- Google analytics script
    <script type="text/javascript">
      if(document.location.hostname == 'pratikborsadiya.in') {
      	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      	ga('create', 'UA-72504830-1', 'auto');
      	ga('send', 'pageview');
      }
    </script>-->
  </body>
</html>