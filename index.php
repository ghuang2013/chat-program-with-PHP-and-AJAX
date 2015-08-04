<?php require_once('php/account.php');?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Chat Program</title>
        <link rel="stylesheet" href="../foundation-5.5.2/css/normalize.css">
        <link rel="stylesheet" href="../foundation-5.5.2/css/foundation.min.css">
        <link rel="stylesheet" href="../foundation-5.5.2/foundation-icons/foundation-icons/foundation-icons.css">
        <link href="http://fonts.googleapis.com/css?family=Marck+Script" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="style.css">
        <script src="../foundation-5.5.2/js/vendor/modernizr.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    </head>
    <body>
        <div id="mainwrapper">
            <div class="row">
                <div class="small-8 small-centered columns">
                    <h1 id="main_title">Chatty Room</h1>
                    <div id="chat_window">
                            <div id="account">
                                <button class="button small secondary split">
                                   <i class="fi-torso large"></i>
                                    <div id="username">
                                   <?php 
                                        if(!$_SESSION){
                                            echo '<h6>My Account</h6>';
                                        }else{
                                            echo '<h6>'.$username.'</h6>';
                                        }
                                    ?>
                                    </div>
                                    <span data-dropdown="drop"></span>
                                </button>
                                <ul id="drop" class="f-dropdown"
                                    data-dropdown-content>
                                    <?php if(!$_SESSION){?>
                                        <li><a data-reveal-id="login">Login</a></li>
                                        <li><a data-reveal-id="sign_up">Sign up</a></li>
                                    <?php }else{?>
                                        <li><a href="log_out.php">Logout</a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div id="message_window">
                            </div>
                            <div id="send_message">
                                <form action="php/account.php" method="post">
                                    <div class="row collapse">
                                        <div class="small-10 columns">
                                          <input type="text" 
                                                 name="message"
                                                 id="message">
                                        </div>
                                        <div class="small-2 columns">
                                          <input type="submit"
                                             name="reply"
                                             class="button postfix"
                                             value="Reply">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
            include('inc/sign_up.php');
            include('inc/login.php');
            ?>
        <script src="../foundation-5.5.2/js/vendor/jquery.js"></script>
        <script src="../foundation-5.5.2/js/foundation.min.js"></script>
        <script src="../foundation-5.5.2/js/foundation/foundation.reveal.js"></script>
        <script>
            $(document).foundation();   
            update();
            $('#send_message form').on('submit',function(e){
                $input_field = $('input[id=message]');
                var msg = $input_field.val();
                var name = $('#username h6').text();
                var date = new Date();
                var time = date.getTime()/1000;
                            
                e.preventDefault();
                
                $.ajax({
                    method: 'POST',
                    url: 'php/submit_msg.php',
                    data:{name:name,msg:msg,time:time},
                    success: function(data){
                        update();
                        $input_field.val("");
                    }
                });
            });
            function update(){
                $message_window = $('#message_window');
                $.ajax({
                    method: 'POST',
                    url: 'php/submit_msg.php',
                    data: {refresh:true},
                    success: function(data){
                        $message_window.html(data);
                        $message_window.scrollTop(1624);
                    }
                });
            }
            setInterval (update, 2500);	
        </script>
    </body>
</html>
<?php $connect->close(); ?>