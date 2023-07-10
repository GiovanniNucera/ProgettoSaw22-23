
    $(document).ready(function() {
        $('#donate').DataTable({
            ajax: 'selectall_crowdfunding.php',
            dom: 'Bfrtip',
            buttons: ['print'],
            order: [
                [6, 'desc']
            ] // default sorting
        });
    });

    $(document).ready(function() {
        $('#donators').DataTable({
            ajax: 'selectall_donators.php',
            dom: 'Bfrtip',
            buttons: ['print'],
            order: [
                [3, 'asc']
            ] // default sorting
        });
    });

    $(document).ready(function() {
        var table = $('#insert').DataTable({
            ordering: false,
            searching: false,
            paging: false,
            bInfo: false

        });
    });

 
var table = $('#example').DataTable(
);

    

    function edt(id) {
        var answer = confirm("edit Product Information? Product ID = " + id + ". This action is permanent and cannot be undone.");
        if (answer) {
            window.location.href = "update_product.php" + '?id=' + id;
        }
    }

    function dlt(id) {
        var answer = confirm("Delete Product Information? Product ID = " + id + ". This action is permanent and cannot be undone. Are you certain you wish to delete all of product information?");
        if (answer) {
            $.ajax({
                type: 'POST',
                url: 'delete.php',
                data: 'action=product&id=' + id,
                success: function() {
                    document.getElementById(id).remove();
                }
            });
        }
    }


    function edt_1(id) {
        var answer = confirm("edit Product Information? Product ID = " + id + ". This action is permanent and cannot be undone.");
        if (answer) {
            window.location.href = "update_user.php" + '?id=' + id;
        }
    }

    function dlt_1(id) {
        var answer = confirm("Delete Product Information? Product ID = " + id + ". This action is permanent and cannot be undone. Are you certain you wish to delete all of product information?");
        if (answer) {
            $.ajax({
                type: 'POST',
                url: 'delete.php',
                data: 'action=user&id=' + id,
                success: function() {
                    document.getElementById(id).remove();
                }
            });
        }
    }

    function show(id) {
        window.location.href = "show_last_news.php" + '?id=' + id;
    }

