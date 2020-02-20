
<script type="text/javascript">
    $(document).ready(function(){
        $('.btnClose').click(function(){
            $('#insert-form')[0].reset();            
        })

        /* attach a submit handler to the form */
        $("#insert-form").submit(function(event) {
            /* stop form from submitting normally */
            event.preventDefault();            
            
            console.log( $( this ).serialize() );
            $.ajax({
                url: "pMA_PC_Data_insert.php",
                method: "post",
                data: $('#insert-form').serialize(),
                beforeSend:function(){
                    $('#insert').val('Insert...')
                },
                success: function(data){
                    if (data == '') {
                        $('#insert-form')[0].reset();
                        $('#insert_modal').modal('hide');
                        location.reload();
                    }
                    else
                    {
                        alert(data);
                        location.reload();
                    }
                }
            });   
        });

        $("#edit-form").submit(function(event) {
            /* stop form from submitting normally */
            event.preventDefault();            
            
            console.log( $( this ).serialize() );
            $.ajax({
                url: "pMA_PC_Data_edit.php",
                method: "post",
                data: $('#edit-form').serialize(),
                beforeSend:function(){
                    $('#edit').val('Edit...')
                },
                success: function(data){
                    if (data == '') {
                        $('#edit-form')[0].reset();
                        $('#edit_modal').modal('hide');
                        location.reload();
                    }
                    else
                    {
                        alert(data);
                        location.reload();
                    }
                }
            });   
        });

        $('.edit_data').click(function(){
            //alert('Edit Mode ...!');

            var short_text = $(this).attr("short_text");
            var supplier_name = $(this).attr("supplier_name");

            $.ajax({
                url: "pMA_PC_Data_fetch.php",
                method: "post",
                data: {short_text: short_text, supplier_name: supplier_name},
                dataType: "json",
                success: function(data)
                {   
                    $('#editShortText').val(data['Short Text']);
                    $('#editSupplierName').val(data['Supplier_Name']);                                
                    var cDay = new Date(data['Enter Date']).getDate();
                    var cMonth = new Date(data['Enter Date']).getMonth()+1;
                    var cYear = new Date(data['Enter Date']).getFullYear();
                    var cDate = cDay.toString() + " / " + cMonth.toString() + " / " + cYear.toString();
                    //alert(typeof cDay);                    
                    $('#editEntDate').val(cDate);

                    $('#editQty').val(data['Order Quantity']);
                    $('#editUprice').val(data['Order Price']);
                    $('#editAmt').val(data['Order Amount']);

                    $('#edit_modal').modal('show');                    
                },
                error: function()
                {                    
                    alert('Error ...!');
                }
            });
        });

        $('.view_data').click(function(){            
            var short_text = $(this).attr("short_text");
            var supplier_name = $(this).attr("supplier_name");

            $.ajax({
                url: "pMA_PC_Data_view.php",
                method: "post",
                data: {short_text: short_text, supplier_name: supplier_name},
                success: function(data){
                    $('#view_detail').html(data);
                    $('#view_modal').modal('show');
                },
                error: function()
                {                    
                    alert('Error ...!');
                }
            });            
        });

        $('.delete_data').click(function(){            
            var short_text = $(this).attr("short_text");
            var supplier_name = $(this).attr("supplier_name");

            var lConfirm = confirm("Do you want to delete this record?");
            if (lConfirm)
            {                
                $.ajax({
                    url: "pMA_PC_Data_delete.php",
                    method: "post",
                    data: {short_text: short_text, supplier_name: supplier_name},
                    success: function(data){
                        alert("Data was deleted completely ...!");
                        location.reload();
                    },
                    error: function(){
                        alert("Error ...!");
                    }
                });  
            } 
        });
        
        $("#quantity").keyup(function()
        {               
            //alert('Key up !');            
            price = parseFloat($('#price').val());
            quantity = parseFloat($('#quantity').val());            
            var amt = price * quantity;
            console.log(price);
            console.log(quantity);
            console.log(amt);            
            amt = formatMoney(amt);
            console.log(amt);
                                
            $("#amount").attr('value', amt);
        });
    });

    function formatMoney(inum) // ฟังก์ชันสำหรับแปลงค่าตัวเลขให้อยู่ในรูปแบบ เงิน
    {
        var s_inum=new String(inum);
        var num2=s_inum.split(".");
        var n_inum="";  
        if(num2[0] != undefined)
        {
            var l_inum=num2[0].length;  
            for(i=0;i<l_inum;i++)
            {  
                if(parseInt(l_inum-i)%3 == 0)
                {  
                    if(i==0)
                    {  
                        n_inum+=s_inum.charAt(i);         
                    }
                    else
                    {  
                        n_inum+=","+s_inum.charAt(i);         
                    }     
                }
                else
                {  
                    n_inum+=s_inum.charAt(i);  
                }  
            }  
        }
        else
        {            
            n_inum=inum;
        }
        
        if(num2[1] != undefined)
        {
            n_inum+="."+num2[1];
        }

        return n_inum;
    }
</script>