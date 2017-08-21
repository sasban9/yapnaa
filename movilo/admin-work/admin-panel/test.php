<!DOCTYPE html>
<html>
    <head>
        <title>Autocomplete Textbox Demo | PHP | jQuery</title>
        <!-- load jquery ui css-->
		
 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script type="text/javascript"
src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript"
src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>

        <script type="text/javascript">
        $(function() {
            var availableTags = <?php include('get_user_list.php'); ?>;
            $("#department_name").autocomplete({
                source: availableTags,
                autoFocus:true
            });
        });
        </script>
    </head>
    <body>
        <label>Department Name</label></br>
        <input id="department_name" type="text" size="50" />
    </body>
</html>