<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Metro, a sleek, intuitive, and powerful framework for faster and easier web development for Windows Metro Style.">
    <meta name="keywords" content="HTML, CSS, JS, JavaScript, framework, metro, front-end, frontend, web development">
    <meta name="author" content="Sergey Pimenov and Metro UI CSS contributors">

    <link rel='shortcut icon' type='image/x-icon' href='favicon.ico' />
    <title>Sidebar :: Metro UI CSS - The front-end framework for developing projects on the web in Windows Metro Style</title>

    <link href="css/metro.css" rel="stylesheet">
    <link href="css/metro-icons.css" rel="stylesheet">
    <link href="css/metro-responsive.css" rel="stylesheet">
    <link href="css/metro-schemes.css" rel="stylesheet">

    <link href="css/docs.css" rel="stylesheet">

    <script src="js/jquery-2.1.3.min.js"></script>
    <script src="js/metro.js"></script>
    <script src="js/docs.js"></script>
    <script src="//cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
    <script src="js/ga.js"></script>
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

</head>
<body>
    <div class="container page-content">
        <h1><a href="index.html" class="nav-button transform"><span></span></a>&nbsp;Sidebar</h1>

        @@adsense

        
            <div class="grid responsive">
               
          
               
                    <div class="cell">
                        <h5>.sidebar2</h5>
                  Skip to content
Features
Business
Explore
Marketplace
Pricing
This repository
Search
Sign in or Sign up
 Watch 604  Star 5,389  Fork 1,844 olton/Metro-UI-CSS
 Code  Issues 97  Pull requests 18  Projects 0  Wiki Insights 
Branch: master Find file Copy pathMetro-UI-CSS/docs/sidebar.html
226583b  on Sep 12, 2016
@olton olton add metroDialog.create and $.Dialog methods
1 contributor
RawBlameHistory     
377 lines (360 sloc)  18.5 KB
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Metro, a sleek, intuitive, and powerful framework for faster and easier web development for Windows Metro Style.">
    <meta name="keywords" content="HTML, CSS, JS, JavaScript, framework, metro, front-end, frontend, web development">
    <meta name="author" content="Sergey Pimenov and Metro UI CSS contributors">

    <link rel='shortcut icon' type='image/x-icon' href='favicon.ico' />
    <title>Sidebar :: Metro UI CSS - The front-end framework for developing projects on the web in Windows Metro Style</title>

    <link href="css/metro.css" rel="stylesheet">
    <link href="css/metro-icons.css" rel="stylesheet">
    <link href="css/metro-responsive.css" rel="stylesheet">
    <link href="css/metro-schemes.css" rel="stylesheet">

    <link href="css/docs.css" rel="stylesheet">

    <script src="js/jquery-2.1.3.min.js"></script>
    <script src="js/metro.js"></script>
    <script src="js/docs.js"></script>
    <script src="//cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
    <script src="js/ga.js"></script>
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

</head>
<body>
    <div class="container page-content">
        <h1><a href="index.html" class="nav-button transform"><span></span></a>&nbsp;Sidebar</h1>

        @@adsense

        <div class="example" data-text="example">
            <div class="grid responsive">
                <div class="row cells4">
                    <div class="cell">
                        <h5>.sidebar</h5>
                        <ul class="sidebar">
                            <li><a href="#">
                                <span class="mif-apps icon"></span>
                                <span class="title">all items</span>
                                <span class="counter">0</span>
                            </a></li>
                            <li><a href="#">
                                <span class="mif-vpn-publ icon"></span>
                                <span class="title">websites</span>
                                <span class="counter">0</span>
                            </a></li>
                            <li class="active"><a href="#">
                                <span class="mif-drive-eta icon"></span>
                                <span class="title">Virtual machines</span>
                                <span class="counter">0</span>
                            </a></li>
                            <li><a href="#">
                                <span class="mif-cloud icon"></span>
                                <span class="title">Cloud services</span>
                                <span class="counter">0</span>
                            </a></li>
                            <li><a href="#">
                                <span class="mif-database icon"></span>
                                <span class="title">SQL Databases</span>
                                <span class="counter">0</span>
                            </a></li>
                            <li><a href="#">
                                <span class="mif-cogs icon"></span>
                                <span class="title">Automation</span>
                                <span class="counter">0</span>
                            </a></li>
                            <li><a href="#">
                                <span class="mif-apps icon"></span>
                                <span class="title">all items</span>
                                <span class="counter">0</span>
                            </a></li>
                            <li><a href="#">
                                <span class="mif-vpn-publ icon"></span>
                                <span class="title">websites</span>
                                <span class="counter">0</span>
                            </a></li>
                            <li><a href="#">
                                <span class="mif-vpn-publ icon"></span>
                                <span class="title">websites</span>
                                <span class="counter">0</span>
                            </a></li>
                        </ul>
                    </div>
                    <div class="cell">
                        <h5>.sidebar & .compact</h5>
                        <ul class="sidebar no-responsive-future" id="sidebar-2">
                            <li><a href="#">
                                <span class="mif-apps icon"></span>
                                <span class="title">all items</span>
                                <span class="counter">0</span>
                            </a></li>
                            <li><a href="#">
                                <span class="mif-vpn-publ icon"></span>
                                <span class="title">websites</span>
                                <span class="counter">0</span>
                            </a></li>
                            <li class="active"><a href="#">
                                <span class="mif-drive-eta icon"></span>
                                <span class="title">Virtual machines</span>
                                <span class="counter">0</span>
                            </a></li>
                            <li><a href="#">
                                <span class="mif-cloud icon"></span>
                                <span class="title">Cloud services</span>
                                <span class="counter">0</span>
                            </a></li>
                            <li><a href="#">
                                <span class="mif-database icon"></span>
                                <span class="title">SQL Databases</span>
                                <span class="counter">0</span>
                            </a></li>
                            <li><a href="#">
                                <span class="mif-cogs icon"></span>
                                <span class="title">Automation</span>
                                <span class="counter">0</span>
                            </a></li>
                            <li><a href="#">
                                <span class="mif-apps icon"></span>
                                <span class="title">all items</span>
                                <span class="counter">0</span>
                            </a></li>
                            <li><a href="#">
                                <span class="mif-vpn-publ icon"></span>
                                <span class="title">websites</span>
                                <span class="counter">0</span>
                            </a></li>
                            <li><a href="#">
                                <span class="mif-vpn-lock icon"></span>
                                <span class="title">websites</span>
                                <span class="counter">0</span>
                            </a></li>
                        </ul>
                        <script>
                            $(function(){
                                setInterval(function(){
                                    $("#sidebar-2").toggleClass('compact');
                                }, 3000);
                            });
                        </script>
                    </div>
                    <div class="cell">
                        <h5>.sidebar2</h5>
                        <ul class="sidebar2 ">
                            <li class="title">Title 1</li>
                            <li class="active"><a href="#"><span class="mif-home icon"></span>Dashboard</a></li>
                            <li class="stick bg-red"><a href="#"><span class="mif-cog icon"></span>Layouts</a></li>
                            <li class="stick bg-green">
                                <a class="dropdown-toggle" href="#"><span class="mif-tree icon"></span>Sub menu</a>
                                <ul class="d-menu" data-role="dropdown">
                                    <li><a href=""><span class="mif-vpn-lock icon"></span> Subitem 1</a></li>
                                    <li><a href="">Subitem 2</a></li>
                                    <li><a href="">Subitem 3</a></li>
                                    <li><a href="">Subitem 4</a></li>
                                    <li class="disabled"><a href="">Subitem 5</a></li>
                                </ul>
                            </li>
                            <li class=""><a href="#">Thread item</a></li>
                            <li class="disabled"><a href="#">Disabled item</a></li>

                            <li class="title">Title 2</li>
                            <li><a href="#">Other Item 1</a></li>
                            <li><a href="#">Other item 2</a></li>
                            <li><a href="#">Other item 3</a></li>
                        </ul>
                    </div>
                    <div class="cell">
                        <h5>.sidebar2 & .dark</h5>
                        <ul class="sidebar2 dark">
                            <li class="title">Title 1</li>
                            <li class="active"><a href="#"><span class="mif-home icon"></span>Dashboard</a></li>
                            <li class="stick bg-red"><a href="#"><span class="mif-cog icon"></span>Layouts</a></li>
                            <li class="stick bg-green">
                                <a class="dropdown-toggle" href="#"><span class="mif-tree icon"></span>Sub menu</a>
                                <ul class="d-menu" data-role="dropdown">
                                    <li><a href=""><span class="mif-vpn-publ icon"></span> Subitem 1</a></li>
                                    <li><a href="">Subitem 2</a></li>
                                    <li><a href="">Subitem 3</a></li>
                                    <li><a href="">Subitem 4</a></li>
                                    <li class="disabled"><a href="">Subitem 5</a></li>
                                </ul>
                            </li>
                            <li class=""><a href="#">Thread item</a></li>
                            <li class="disabled"><a href="#">Disabled item</a></li>

                            <li class="title">Title 2</li>
                            <li><a href="#">Other Item 1</a></li>
                            <li><a href="#">Other item 2</a></li>
                            <li><a href="#">Other item 3</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <h3>Color schemes</h3>
        <p>
            This future required <strong>metro-schemes(.min).css</strong> module
        </p>
        <div class="example" data-text="example">
            <h5>darcula, pink, navy, red, green, orange</h5>
            <ul class="sidebar darcula" style="width: 200px; margin-left: 10px; margin-bottom: 10px; float: left;">
                <li><a href="#">
                    <span class="mif-apps icon"></span>
                    <span class="title">all items</span>
                    <span class="counter">0</span>
                </a></li>
                <li><a href="#">
                    <span class="mif-vpn-publ icon"></span>
                    <span class="title">websites</span>
                    <span class="counter">0</span>
                </a></li>
                <li class="active"><a href="#">
                    <span class="mif-drive-eta icon"></span>
                    <span class="title">Virtual machines</span>
                    <span class="counter">0</span>
                </a></li>
                <li><a href="#">
                    <span class="mif-cloud icon"></span>
                    <span class="title">Cloud services</span>
                    <span class="counter">0</span>
                </a></li>
                <li><a href="#">
                    <span class="mif-database icon"></span>
                    <span class="title">SQL Databases</span>
                    <span class="counter">0</span>
                </a></li>
            </ul>

            <ul class="sidebar pink" style="width: 200px; margin-left: 10px; margin-bottom: 10px; float: left;">
                <li><a href="#">
                    <span class="mif-apps icon"></span>
                    <span class="title">all items</span>
                    <span class="counter">0</span>
                </a></li>
                <li><a href="#">
                    <span class="mif-vpn-publ icon"></span>
                    <span class="title">websites</span>
                    <span class="counter">0</span>
                </a></li>
                <li class="active"><a href="#">
                    <span class="mif-drive-eta icon"></span>
                    <span class="title">Virtual machines</span>
                    <span class="counter">0</span>
                </a></li>
                <li><a href="#">
                    <span class="mif-cloud icon"></span>
                    <span class="title">Cloud services</span>
                    <span class="counter">0</span>
                </a></li>
                <li><a href="#">
                    <span class="mif-database icon"></span>
                    <span class="title">SQL Databases</span>
                    <span class="counter">0</span>
                </a></li>
            </ul>

            <ul class="sidebar navy" style="width: 200px; margin-left: 10px; margin-bottom: 10px; float: left;">
                <li><a href="#">
                    <span class="mif-apps icon"></span>
                    <span class="title">all items</span>
                    <span class="counter">0</span>
                </a></li>
                <li><a href="#">
                    <span class="mif-vpn-publ icon"></span>
                    <span class="title">websites</span>
                    <span class="counter">0</span>
                </a></li>
                <li class="active"><a href="#">
                    <span class="mif-drive-eta icon"></span>
                    <span class="title">Virtual machines</span>
                    <span class="counter">0</span>
                </a></li>
                <li><a href="#">
                    <span class="mif-cloud icon"></span>
                    <span class="title">Cloud services</span>
                    <span class="counter">0</span>
                </a></li>
                <li><a href="#">
                    <span class="mif-database icon"></span>
                    <span class="title">SQL Databases</span>
                    <span class="counter">0</span>
                </a></li>
            </ul>

            <ul class="sidebar red" style="width: 200px; margin-left: 10px; margin-bottom: 10px; float: left;">
                <li><a href="#">
                    <span class="mif-apps icon"></span>
                    <span class="title">all items</span>
                    <span class="counter">0</span>
                </a></li>
                <li><a href="#">
                    <span class="mif-vpn-publ icon"></span>
                    <span class="title">websites</span>
                    <span class="counter">0</span>
                </a></li>
                <li class="active"><a href="#">
                    <span class="mif-drive-eta icon"></span>
                    <span class="title">Virtual machines</span>
                    <span class="counter">0</span>
                </a></li>
                <li><a href="#">
                    <span class="mif-cloud icon"></span>
                    <span class="title">Cloud services</span>
                    <span class="counter">0</span>
                </a></li>
                <li><a href="#">
                    <span class="mif-database icon"></span>
                    <span class="title">SQL Databases</span>
                    <span class="counter">0</span>
                </a></li>
            </ul>

            <ul class="sidebar green" style="width: 200px; margin-left: 10px; margin-bottom: 10px; float: left;">
                <li><a href="#">
                    <span class="mif-apps icon"></span>
                    <span class="title">all items</span>
                    <span class="counter">0</span>
                </a></li>
                <li><a href="#">
                    <span class="mif-vpn-publ icon"></span>
                    <span class="title">websites</span>
                    <span class="counter">0</span>
                </a></li>
                <li class="active"><a href="#">
                    <span class="mif-drive-eta icon"></span>
                    <span class="title">Virtual machines</span>
                    <span class="counter">0</span>
                </a></li>
                <li><a href="#">
                    <span class="mif-cloud icon"></span>
                    <span class="title">Cloud services</span>
                    <span class="counter">0</span>
                </a></li>
                <li><a href="#">
                    <span class="mif-database icon"></span>
                    <span class="title">SQL Databases</span>
                    <span class="counter">0</span>
                </a></li>
            </ul>

            <ul class="sidebar orange" style="width: 200px; margin-left: 10px; margin-bottom: 10px; float: left;">
                <li><a href="#">
                    <span class="mif-apps icon"></span>
                    <span class="title">all items</span>
                    <span class="counter">0</span>
                </a></li>
                <li><a href="#">
                    <span class="mif-vpn-publ icon"></span>
                    <span class="title">websites</span>
                    <span class="counter">0</span>
                </a></li>
                <li class="active"><a href="#">
                    <span class="mif-drive-eta icon"></span>
                    <span class="title">Virtual machines</span>
                    <span class="counter">0</span>
                </a></li>
                <li><a href="#">
                    <span class="mif-cloud icon"></span>
                    <span class="title">Cloud services</span>
                    <span class="counter">0</span>
                </a></li>
                <li><a href="#">
                    <span class="mif-database icon"></span>
                    <span class="title">SQL Databases</span>
                    <span class="counter">0</span>
                </a></li>
            </ul>

        </div>
    </div>
</body>
</html>
Contact GitHub API Training Shop Blog About
© 2017 GitHub, Inc. Terms Privacy Security Status Help
                    </div>
           
               
            </div>
        

  

      

          

     

      

         

        </div>
    </div>
</body>
</html>