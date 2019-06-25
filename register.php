<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>KCB SACCO</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="no-skin">

  <!--This is the default bootstrap nav bar-->
  <nav class="navbar navbar-default" style="background-color:#228B22;">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header" style="background-color:#228B22;">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#" style="background-color:#228B22;">KCB SACCO</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav" style="background-color:#228B22;">
                <li ><a href="/">Home <span class="sr-only">(current)</span></a></li>
                <li><a href="/">ABOUT KCB SACCO</a></li>
              <!-- <li><a href="/about">Nearby Booze Joints</a></li>
                <li><a href="/about">Gifts and Offers</a></li>
                <li><a href="/contact">Contact</a></li> -->

            </ul>
      
      <ul class="nav navbar-nav navbar-right" style="background-color:#228B22;">
        
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Account <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Separated link</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
    <div class="container">
     
  <!--  <h3>Add Booze Joint</h3> -->
    <hr>
    <div class="main-container" id="main-container">
     <div id="side-bar" class="side-bar responsive">
       
     
     </div> 
     <div class="main-content">
     <div class="page-content">
       <div class="page-header">
       <div class="row">
       <div class="col-xs-12">

         <form action="insert.php" method="post">
    
  <!--   <div class="form-group">
         
             <label name="Email">Booze Category</label>
             <select class="form-control">
  <option> Category1</option>
  <option>Category2</option>
  <option>Category3</option>
  <option>Category4</option>
  <option>Category5</option>
</select>
     </div> -->

     <div class="form-group">      
             <label name="subject">ID NUMBER</label>
             <input id="idnumber" type="text" name="idnumber" class="form-control">

       </div>

       <div class="form-group">      
             <label name="subject">Full Names</label>
             <input id="fullnames" type="text" name="fullnames" class="form-control">

       </div>

       <div class="form-group">      
             <label name="subject">Email</label>
             <input id="email" name="email" type="text" class="form-control">

       </div>
     
       <div class="form-group">      
             <label name="subject">Password</label>
             <input id="password" type="password" name="password" class="form-control">

       </div> 

       
       
      <div class="g-recaptcha" data-sitekey="" >
      <div style="width:340px; height:78px;">
        
             <input type="submit" class="btn btn-primary" value="Submit"/> 
         <div class="space-6"></div>   
       <!--  <a href="register.php">Register</a> -->

       </div> 

     </div>


     </form>
         
       </div>
     </div>

    </div>
  

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>
</html>