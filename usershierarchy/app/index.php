 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


<script>
   function getSubordinates(){

        var id= $('#userid').val();
        var name=$("#userid option:selected").text();
        if(id=='')
        {
            alert('Select user');
            return false;
        }

        $.ajax({
            url: "process.php",
            type: "POST",
            data: {id : id, name:name},
            success:function(response)
            {
                $('#subordinates').html(response);
            },
            fail:function()
            {
                alert("Error");
            }
        });


    }
    $(document).ready(function(){
        getSubordinates();
    });

</script>


 <form method="post" name="form">
     <select name="userid" id="userid">
         <option value="1">Adam Admin</option>
         <option value="2">Emily Employee</option>
         <option value="3">Sam Supervisor</option>
         <option value="4">Mary Manager</option>
         <option value="5">Steve Trainer</option>
     </select>
     <button id="btnsubmit" type="button" onclick="getSubordinates();return false;">Get Subordinates</button>
    <div style="margin-top: 10px">
     <span id="subordinates"></span>
    </div>
 </form>
