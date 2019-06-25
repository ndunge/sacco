using System;
using System.Collections.Generic;

using Highchart.Core;
using Highchart.Core.Data.Chart;
using Highchart.Core.PlotOptions;
using Highchart.Core.Appearance;

namespace HighchartSamples
{
    public partial class frmHighchartSample : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            #region Line chart
            //Defining Axis
            hcLinechart.YAxis.Add(new YAxisItem { title = new Title("Faturamento") });
            hcLinechart.XAxis.Add(new XAxisItem { categories = new[] { "1994", "1995", "1996", "1997", "1998", "1999", "2000", "2001", "2002" } });

            //New data collection
            //var series = new Collection<Serie>();
            var series = new List<Serie>();
            series.Add(new Serie { data = new object[] { 400, 435, 446, 479, 554, 634, 687, 750, 831 } });

            //bind data to chart
            hcLinechart.DataSource = series;
            hcLinechart.DataBind();
            #endregion

            #region Column chart
            ///----------------------
            hcColumnChart.Title = new Title("Quarterly Average Rainfall by City");
            hcColumnChart.SubTitle = new SubTitle("Source: World Climate.com");

            // Axis
            hcColumnChart.YAxis.Add(new YAxisItem { title = new Title("Rainfall (mm)") });
            hcColumnChart.XAxis.Add(new XAxisItem { categories = new[] { "Qtr1", "Qtr2", "Qtr3", "Qtr4"
                                                                        //"Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" 
                                                                        } });

            // Data
            series = new List<Serie>();
            series.Add(new Serie { name = "Tokyo", data = new Object[] { 49.9, 71.5, 106.4, 129.2
                                                                        //, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4 
                                                                        } });
            series.Add(new Serie { name = "New York", data = new Object[] { 83.6, 78.8, 98.5, 93.4
                                                                        //, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3 
                                                                        } });
            series.Add(new Serie { name = "London", data = new object[] { 48.9, 38.8, 39.3, 41.4
                                                                        //, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2 
                                                                        } });
            series.Add(new Serie { name = "Berlin", data = new object[] { 42.4, 33.2, 34.5, 39.7
                                                                        //, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8, 51.1 
                                                                        } });

            hcColumnChart.PlotOptions = new PlotOptionsColumn { borderColor = "#dedede", borderRadius = 4 };
            hcColumnChart.Tooltip = new ToolTip("'<b>'+ this.series.name +'</b><br/>' + this.x + ': '+ this.y +'°C'");

            // Bind
            hcColumnChart.DataSource = series;
            hcColumnChart.DataBind();
            #endregion

            #region Pie chart
            hcPieChart.Title = new Title("Visitors by Browser");

            //Data
            series = new List<Serie>();
            series.Add(new Serie {
                        size = 130,
                        data = new object[] {
                            new object[] { "Firefox", 45 },
                            new object[] { "IE", 24.8 },
                            new object[] { "Chrome", 12.8 },
                            new object[] { "Safari", 8.5 },
                            new object[] { "Opera", 5.2 },
                            new object[] { "Outros", 3.7 }
                        }
            });

            hcPieChart.PlotOptions = new PlotOptionsPie
            {
                allowPointSelect = true,
                cursor = "pointer",
                dataLabels = new DataLabels { enabled = true }
            };

            hcPieChart.Tooltip = new ToolTip("'<b>'+ this.point.name +'</b>: '+ this.y +' %'");
            hcPieChart.Theme = "pink-floral";

            // Bind
            hcPieChart.DataSource = series;
            hcPieChart.DataBind();
            #endregion

            #region Area Spline chart 
            //Title
            hcAreaSplineChart.Title = new Title("Consumption of energy");

            //definining axis
            hcAreaSplineChart.YAxis.Add(new YAxisItem { title = new Title("Kw/hour") });
            hcAreaSplineChart.XAxis.Add(new XAxisItem { categories = new[] { "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" } });

            //Data
            series = new List<Serie>();
            series.Add(new Serie { name = "Refrigerator", data = new object[] { 10, 11, 12, 10, 9, 7, 9 } });
            series.Add(new Serie { name = "Television", data = new object[] { 4, 6, 7, 7, 8, 13, 11 } });

            //Making the graphics become on top of each other, and setting opacity
            hcAreaSplineChart.PlotOptions = new PlotOptionsAreaSpline { stacking = Stacking.normal, fillOpacity = 0.3 };

            //customizing the tooltip
            hcAreaSplineChart.Tooltip = new ToolTip("this.x +': '+ this.y +' Kw/hour'");

            //customizing the legend
            hcAreaSplineChart.Legend = new Legend
            {
                layout = Layout.horizontal,
                borderWidth = 3,
                align = Align.center,
                //y = 20,
                //x = 0,
                verticalAlign = VerticalAlign.bottom,
                shadow = true,
                backgroundColor = "#e3e6be"
            };

            //bind
            hcAreaSplineChart.DataSource = series;
            hcAreaSplineChart.DataBind();
            #endregion

            #region Line chart - theme
            hcLineChartTheme.Title = new Title("Annual Sales (eCommerce)");
            hcLineChartTheme.SubTitle = new SubTitle("Gross Revenue");

            //Defining Axis
            hcLineChartTheme.YAxis.Add(new YAxisItem { title = new Title("Revenue by sector") });
            hcLineChartTheme.XAxis.Add(new XAxisItem { categories = new[] { "1994", "1995", "1996", "1997", "1998", "1999", "2000", "2001", "2002" } });

            //New data collection
            //var series = new Collection<Serie>();
            series = new List<Serie>();
            series.Add(new Serie { data = new object[] { 400, 435, 446, 479, 554, 634, 687, 750, 831 }, name = "Electronics" });
            series.Add(new Serie { data = new object[] { 254, 402, 576, 85, 257, 684, 601, 410, 543 }, name = "Clothing" });
            series.Add(new Serie { data = new object[] { 125, 471, 247, 120, 397, 451 }, name = "Sports" });

            hcLineChartTheme.Theme = "gray" ;
            hcLineChartTheme.Legend = new Legend { align = Align.center, layout = Layout.horizontal, verticalAlign = VerticalAlign.bottom, borderWidth = 0 };
            //hcLineChartTheme.Appearance = new Appearance { marginBottom = 30, marginRight = 130, borderRadius = 15 };

            //bind data to chart
            hcLineChartTheme.DataSource = series;
            hcLineChartTheme.DataBind();
            #endregion
        }
    }
}