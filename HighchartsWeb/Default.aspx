<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="Default.aspx.cs" Inherits="HighchartSamples.frmHighchartSample" %>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title>Sample Dashboard (Highcharts)</title>
    <script type="text/javascript" src="js/TweenLite.min.js"></script>
    <script type="text/javascript" src="js/TweenMax.min.js"></script>
    <%--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript"></script>--%>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
    <%--<script src="js/highcharts.js" type="text/javascript"></script>--%>

<!--Ref.: Metro UI HTML Template designed by TechGyo
    http://techgyo.com/index.php/free-metro-ui-html-template-by-techgyo/-->
<style>
body{
	margin:0;
	background-color: #FFF;/*#369*/
	overflow:auto;
}

#btn1{
	height:300px;
	width:300px;
	left:1200px;
	/*	background:#06F;*/
    /*margin-left:10px;    font-size:14px;	line-height:15px;	padding-left:10px;        */
}
#btn2{
	/*background:#C30;cursor:pointer;font-family:"Lucida Sans Unicode", "Lucida Grande", sans-serif;text-align:left;*/
	height:300px;
	width:300px;
	left:1200px;
	/*margin-left:10px;	font-size:25px;color:#FFF;	line-height:300px;	padding-left:10px;        */
}
#btn3{
	/*background:#F60;border-color:#F60;position:relative;cursor:pointer;font-family:"Lucida Sans Unicode", "Lucida Grande", sans-serif;text-align:left;*/
	height:300px;
	width:300px;
	left:1200px;
	/*margin-left:10px;color:#FFF;	font-size:25px;	line-height:300px;	padding-left:10px;        */
}
#btn4{
	/*background:#C3C;border-color:#F60;position:relative;cursor:pointer;font-family:"Lucida Sans Unicode", "Lucida Grande", sans-serif;text-align:left;*/
	height:300px;
	width:300px;
	margin-top:30px;
	left:1200px;
	/*color:#FFF;	margin-left:10px;	font-size:25px;	line-height:300px;	padding-left:10px;        */
}
#btn5{
	/*background:#F36; border-color:#F60;position:relative;cursor:pointer;font-family:"Lucida Sans Unicode", "Lucida Grande", sans-serif;text-align:left;*/
	height:300px;
	width:300px;
	margin-top:30px;
	left:1200px;
	/*color:#FFF;	margin-left:10px;	font-size:25px;	line-height:300px;	padding-left:10px;        */
}
#btn6{
	/*background:#6C0;position:relative;cursor:pointer;font-family:"Lucida Sans Unicode", "Lucida Grande", sans-serif;text-align:left;*/
	height:300px;
	width:300px;
	margin-top:30px;
	left:1200px;
	/*color:#FFF;	margin-left:10px;	font-size:25px;	line-height:300px;	padding-left:10px;        */
}

#content{
	background:#FFF; /*369*/
	height:880px;
	width:950px;
	position:relative;
	top:1200px;
	z-index:0;
}

#backbutton{
	position:relative;
	left:760px;
	cursor:pointer;
}

#caption{
	position:relative;
	top:-60px;
	
	color:#FFF;
	font-size:25px;
	font-family:"Lucida Sans Unicode", "Lucida Grande", sans-serif;
}

#pagecaption{
	position:relative;
	top:-60px;
	
	color:#FFF;
	font-size:25px;
	font-family:"Lucida Sans Unicode", "Lucida Grande", sans-serif;
}
</style>

</head>

<body><%-- link="#FFFFFF"--%>
    <form id="form1" runat="server">

        <div style="width:100%; height:80px; overflow:hidden; margin: 0 auto; background-color:#333">

          <div style="width:750px; height:80px; margin: 0 auto; overflow:hidden; position:relative">
		
                <div id="caption" style="height:44px; margin-top:20px;float:left; margin-left:12px; position:absolute"> Company Title </div>
        
                <div id="backbutton" style="height:44px; width:44px; margin-top:15px; float:left; position:absolute"> <img src="imgs/backbtn.png" width="44" height="44" /> </div>
        
               <div id="pagecaption" style="height:44px; margin-top:20px;float:left; margin-left:12px; position:absolute"> Caption </div>
          </div>

        </div>

        <!--buttons-->
        <div style="width:1000px; height:700px; overflow:visible; margin: 0 auto; position:relative; margin-top:35px;">

	        <a href="1.html" target="main">
                <div id="btn1" style="float:left;background:#FFF;position:relative;cursor:pointer;color:#FFF;font-family:Lucida Sans Unicode, Lucida Grande, sans-serif;text-align:left;"><%-- <p> About Us </p>--%>
                    <highchart:linechart id="hcLinechart" runat="server" Width="300" Height="300" />
                </div>
	        </a>

            <a href="2.html" target="main">
                <div id="btn2" style="float:left;background:#FFF;position:relative;cursor:pointer;color:#FFF;font-family:Lucida Sans Unicode, Lucida Grande, sans-serif;text-align:left;"> <%--<p> Our Products </p>--%> 
                    <highchart:ColumnChart ID="hcColumnChart" runat="server" Width="300" Height="300" />
                </div> 
            </a>

            <a href="3.html" target="main">
                <div id="btn3" style="float:left;background:#FFF;border-color:#F60;position:relative;cursor:pointer;font-family:Lucida Sans Unicode, Lucida Grande, sans-serif;text-align:left;"><%-- <p> Who We Are? </p>--%> 
                    <highchart:PieChart ID="hcPieChart" runat="server" Width="300" Height="300" />
                </div> 
            </a>

            <a href="4.html" target="main">
                <div id="btn4" style="float:left;background:#FFF;border-color:#F60;position:relative;cursor:pointer;font-family:Lucida Sans Unicode, Lucida Grande, sans-serif;text-align:left;"><%-- <p> We on Map </p>--%> 
                    <highchart:AreaSplineChart ID="hcAreaSplineChart" runat="server" Width="300" Height="300" />
                </div> 

            </a>
            <a href="5.html" target="main">
                <div id="btn5" style="float:left;background:#FFF; border-color:#F60;position:relative;cursor:pointer;font-family:Lucida Sans Unicode, Lucida Grande, sans-serif;text-align:left;"><%-- <p> Contact Us </p> --%>
                    <highchart:linechart id="hcLineChartTheme" runat="server" Width="300" Height="300" />
                </div> 

            </a>
            <a href="6.html" target="main">
                <div id="btn6" style="float:left;background:#6C0;position:relative;cursor:pointer;font-family:Lucida Sans Unicode, Lucida Grande, sans-serif;text-align:left;"><%-- <p> Feedback </p> --%>

                </div> 
            </a>
    
        <div id="content" style="position:absolute"> <iframe name="main" frameborder="0" height="750" width="800"></iframe>  </div>
        </div>




        <!--footer-->
        <div style="width:100%; height:60px; overflow:hidden; margin: 0 auto; background-color:#333; margin-top:20px;">
            <div style="width:750px; height:80px; margin: 0 auto;">
            	<p style="text-align:center; color:#FFF; font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:x-small">
			&copy; 2013 All rights reserved.
		</p>
            </div>
        </div>

    </form>

<script type="text/javascript">
    $(document).ready(function () {
        TweenLite.to($("#caption"), 2, { css: { top: 0 }, delay: 1, ease: Power2.easeOut });
        TweenLite.to($("#btn1"), 2, { css: { left: 0 }, delay: 2, ease: Power2.easeOut });
        TweenLite.to($("#btn2"), 2, { css: { left: 20 }, delay: 2.5, ease: Power2.easeOut });
        TweenLite.to($("#btn3"), 2, { css: { left: 40 }, delay: 3, ease: Power2.easeOut });
        TweenLite.to($("#btn4"), 2, { css: { left: 0 }, delay: 3.5, ease: Power2.easeOut });
        TweenLite.to($("#btn5"), 2, { css: { left: 20 }, delay: 4, ease: Power2.easeOut });
        TweenLite.to($("#btn6"), 2, { css: { left: 40 }, delay: 4.5, ease: Power2.easeOut });

    });


    $("#btn1").click(function () {
        TweenLite.to($("#content"), 0.5, { css: { top: 0 }, ease: Power2.easeOut });
        TweenLite.to($("#backbutton"), 1, { css: { left: 650, rotation: -180 }, ease: Power2.easeOut });
        TweenLite.to($("#pagecaption"), 1, { css: { top: 0 }, ease: Power2.easeOut });
        TweenLite.to($("#caption"), 1, { css: { top: 90 }, ease: Power2.easeOut });
        $("#pagecaption").text("About Us");

    });

    $("#btn2").click(function () {
        TweenLite.to($("#content"), 0.5, { css: { top: 0 }, ease: Power2.easeOut });
        TweenLite.to($("#backbutton"), 1, { css: { left: 650, rotation: -180 }, ease: Power2.easeOut });
        TweenLite.to($("#pagecaption"), 1, { css: { top: 0 }, ease: Power2.easeOut });
        TweenLite.to($("#caption"), 1, { css: { top: 90 }, ease: Power2.easeOut });
        $("#pagecaption").text("Our Products");

    });

    $("#btn3").click(function () {
        TweenLite.to($("#content"), 0.5, { css: { top: 0 }, ease: Power2.easeOut });
        TweenLite.to($("#backbutton"), 1, { css: { left: 650, rotation: -180 }, ease: Power2.easeOut });
        TweenLite.to($("#pagecaption"), 1, { css: { top: 0 }, ease: Power2.easeOut });
        TweenLite.to($("#caption"), 1, { css: { top: 90 }, ease: Power2.easeOut });
        $("#pagecaption").text("Who We Are?");

    });

    $("#btn4").click(function () {
        TweenLite.to($("#content"), 0.5, { css: { top: 0 }, ease: Power2.easeOut });
        TweenLite.to($("#backbutton"), 1, { css: { left: 650, rotation: -180 }, ease: Power2.easeOut });
        TweenLite.to($("#pagecaption"), 1, { css: { top: 0 }, ease: Power2.easeOut });
        TweenLite.to($("#caption"), 1, { css: { top: 90 }, ease: Power2.easeOut });
        $("#pagecaption").text("We on Map");

    });

    $("#btn5").click(function () {
        TweenLite.to($("#content"), 0.5, { css: { top: 0 }, ease: Power2.easeOut });
        TweenLite.to($("#backbutton"), 1, { css: { left: 650, rotation: -180 }, ease: Power2.easeOut });
        TweenLite.to($("#pagecaption"), 1, { css: { top: 0 }, ease: Power2.easeOut });
        TweenLite.to($("#caption"), 1, { css: { top: 90 }, ease: Power2.easeOut });
        $("#pagecaption").text("Contact Us");

    });

    $("#btn6").click(function () {
        TweenLite.to($("#content"), 0.5, { css: { top: 0 }, ease: Power2.easeOut });
        TweenLite.to($("#backbutton"), 1, { css: { left: 650, rotation: -180 }, ease: Power2.easeOut });
        TweenLite.to($("#pagecaption"), 1, { css: { top: 0 }, ease: Power2.easeOut });
        TweenLite.to($("#caption"), 1, { css: { top: 90 }, ease: Power2.easeOut });
        $("#pagecaption").text("Feedback");

    });


    $("#backbutton").click(function () {
        TweenLite.to($("#content"), 1, { css: { top: 900 }, ease: Power2.easeIn });
        TweenLite.to($("#backbutton"), 1, { css: { left: 760, rotation: 0 }, ease: Power2.easeIn });
        TweenLite.to($("#pagecaption"), 1, { css: { top: -60 }, ease: Power2.easeOut });
        TweenLite.to($("#caption"), 1, { css: { top: 0 }, ease: Power2.easeOut });
    });
</script>	

</body>
</html>
