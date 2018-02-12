<?php
require 'root.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Latest</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Our Custom CSS -->
    <link rel="stylesheet/less" href="less/style.less">
    <link rel="stylesheet/less" href="less/list-style.less">
    <link rel="stylesheet/less" href="less/sidebar.less">
    <link rel="stylesheet/less" href="less/add.less">

    <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/2.7.2/less.min.js"></script>
</head>
<body>
<?php
include 'template-parts/list-small-window-sidebar.php';
?>
<div id="wrapper">
    <?php
    include 'template-parts/top-bar.php';
    ?>
    <div id="body-content">
        <div id="left-sidebar" class="col-md-2 plr-0">
            <?php include 'template-parts/list-left-sidebar.php';?>
        </div>
        <div class="list-content col-md-7 col-sm-12">
            <h3>List Created</h3>
            <h4>Add List Items</h4>
            <div class="add-items" style="margin-top: 50px">
                <form id="addNewList" class="addLinksForm" action="http://gpt.website/post" method="POST" role="form">
                    <input name="_token" value="dj24FZZ0xFWQKGfwr56QQ7OsezvjGSygNFZY7Pmz" type="hidden">
                    <div class="form-group">
                        <label for="storyTitle">Item Name</label>
                        <input name="title" id="storyTitle" class="form-control" placeholder="Title" type="text">
                    </div>
                    <div class="form-group">
                        <label for="image">Item Image</label>
                        <div class="input-group input-file" name="image">
                            <span class="input-group-btn">
                                <button class="btn btn-default btn-choose" type="button">Choose</button>
                            </span>
                                            <input type="text" class="form-control" placeholder='Choose a file...' />
                                            <span class="input-group-btn">
                                 <button class="btn btn-warning btn-reset" type="button">Reset</button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="storyDesc">Description</label>
                        <textarea type="text" name="description" id="storyDesc" rows="5" class="form-control"></textarea>
                    </div>
                    <label for="storyLink">Item Link</label>
                    <div class="form-group">
                        <input name="link" id="storyLink" class="form-control" placeholder="Link" type="text">
                    </div>
                    <div class="form-group" style="margin-top: 20px">
                        <a class="btn btn-block btn-default"><i class="fa fa-plus-circle"></i> Add More</a>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="storySubmit" id="storySubmit" class="btn-link-submit btn btn-block btn-danger">Submit</button>
                    </div>
                </form>


            </div>
        </div>
        <div id="right-sidebar" class="col-md-3">
            <?php
            include 'template-parts/list-right-sidebar.php';
            ?>
        </div>
    </div>

    <div class="overlay"></div>
</div>


<!-- jQuery CDN -->
<!--         <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Bootstrap Js CDN -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
<!-- jQuery Nicescroll CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.6.8-fix/jquery.nicescroll.min.js"></script>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<script>
    $('.selectpicker').selectpicker();
</script>
<script src="js/home.js"></script>
<script>
    function bs_input_file() {
        $(".input-file").before(
            function() {
                if ( ! $(this).prev().hasClass('input-ghost') ) {
                    var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0'>");
                    element.attr("name",$(this).attr("name"));
                    element.change(function(){
                        element.next(element).find('input').val((element.val()).split('\\').pop());
                    });
                    $(this).find("button.btn-choose").click(function(){
                        element.click();
                    });
                    $(this).find("button.btn-reset").click(function(){
                        element.val(null);
                        $(this).parents(".input-file").find('input').val('');
                    });
                    $(this).find('input').css("cursor","pointer");
                    $(this).find('input').mousedown(function() {
                        $(this).parents('.input-file').prev().click();
                        return false;
                    });
                    return element;
                }
            }
        );
    }
    $(function() {
        bs_input_file();
    });
</script>

</body>
</html>
