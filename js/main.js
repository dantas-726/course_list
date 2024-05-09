var datastr = $(".block_listallcourses .card-title").html();

$('#status').on('change', function() {
    var selected_status = this.value;
    $.ajax({
         url: 'http://localhost/moodle/blocks/listallcourses/ajax.php',
         data: {selected_status: selected_status},
         type: 'POST',
         success: function(output) {
            $(".resultset").html(output);
        }
    });
});