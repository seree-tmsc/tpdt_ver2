<script type="text/javascript">
    $(document).ready(function() {
        $('.btnClose').click(function() {
            $('#insert-form')[0].reset();
        })

        /* attach a submit handler to the form */
        $("#insert-form").submit(function(event) {
            /* stop form from submitting normally */
            event.preventDefault();

            console.log($(this).serialize());
            $.ajax({
                url: "pMA_PDLT_Insert.php",
                method: "post",
                data: $('#insert-form').serialize(),
                beforeSend: function() {
                    $('#insert').val('Insert...')
                },
                success: function(data) {
                    if (data == '') {
                        $('#insert-form')[0].reset();
                        $('#insert_modal').modal('hide');
                        location.reload();
                    } else {
                        alert(data);
                        location.reload();
                    }
                }
            });
        });

        $("#edit-form").submit(function(event) {
            /* stop form from submitting normally */
            event.preventDefault();

            console.log($(this).serialize());
            $.ajax({
                url: "pMA_PDLT_Edit.php",
                method: "post",
                data: $('#edit-form').serialize(),
                beforeSend: function() {
                    $('#edit').val('Edit...')
                },
                success: function(data) {
                    if (data == '') {
                        $('#edit-form')[0].reset();
                        $('#edit_modal').modal('hide');
                        location.reload();
                    } else {
                        alert(data);
                        location.reload();
                    }
                }
            });
        });

        $('.edit_data').click(function() {
            //alert('Edit Mode ...!');

            var pd_code = $(this).attr("pd_code");

            $.ajax({
                url: "pMA_PDLT_Fetch.php",
                method: "post",
                data: {
                    pd_code: pd_code
                },
                dataType: "json",
                success: function(data) {
                    var cDay = new Date(data['enter_date']).getDate();
                    var cMonth = new Date(data['enter_date']).getMonth() + 1;
                    var cYear = new Date(data['enter_date']).getFullYear();
                    var cDate = cDay.toString() + " / " + cMonth.toString() + " / " + cYear.toString();
                    //alert(typeof cDay);
                    $('#editEntDate').val(cDate);
                    $('#editPdCode').val(data['pd_code']);
                    $('#parameditPdCode').val(data['pd_code']);
                    $('#editPdName').val(data['pd_name']);

                    $('#editPdLt').val(data['pd_lead_time']);

                    $('#editPdSbu').val(data['pd_sbu']);
                    $('#editPdGroup').val(data['pd_group']);

                    $('#edit_modal').modal('show');
                },
                error: function() {
                    alert('Error ...!');
                }
            });
        });

        $('.delete_data').click(function() {
            var pd_code = $(this).attr("pd_code");

            var lConfirm = confirm("Do you want to delete this record?");
            if (lConfirm) {
                $.ajax({
                    url: "pMA_PDLT_Delete.php",
                    method: "post",
                    data: {
                        pd_code: pd_code
                    },
                    success: function(data) {
                        alert("Data was deleted completely ...!");
                        location.reload();
                    },
                    error: function() {
                        alert("Error ...!");
                    }
                });
            }
        });
    });

    function formatMoney(inum) // ฟังก์ชันสำหรับแปลงค่าตัวเลขให้อยู่ในรูปแบบ เงิน
    {
        var s_inum = new String(inum);
        var num2 = s_inum.split(".");
        var n_inum = "";
        if (num2[0] != undefined) {
            var l_inum = num2[0].length;
            for (i = 0; i < l_inum; i++) {
                if (parseInt(l_inum - i) % 3 == 0) {
                    if (i == 0) {
                        n_inum += s_inum.charAt(i);
                    } else {
                        n_inum += "," + s_inum.charAt(i);
                    }
                } else {
                    n_inum += s_inum.charAt(i);
                }
            }
        } else {
            n_inum = inum;
        }

        if (num2[1] != undefined) {
            n_inum += "." + num2[1];
        }

        return n_inum;
    }
</script>