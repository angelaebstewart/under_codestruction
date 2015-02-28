

<div class="component">
        <div class="class-list-edit">
        <div class="panel panel-default">
  <input class="form-control" type="text" id="clsname"/>
  <button class="btn btn-group-xs" id="addclassbtn">Test Ajax</button>
        </div></div>
</div>

<div class="the-return">
  [HTML is replaced when successful.]
</div>

<script>
/*
 * 
 * This is just a test of ajax using jQuery
 * 
 */

$(document).ready(function(){
var $classNameInput = $('#clsname');
var $returnBox = $(".the-return");
    
    $("#addclassbtn").on('click', function(){
        var data = {
        clsname: $classNameInput.val()
        };


        $.ajax({
        type: "POST",
        url: "<?php echo Config::get('URL', 'gen'); ?>class/reassure",
        data: data,
        success: function (result) {
            
            $returnBox.html(result);

        },
        error: function () {alert("error");}
        });

    });

});
</script>