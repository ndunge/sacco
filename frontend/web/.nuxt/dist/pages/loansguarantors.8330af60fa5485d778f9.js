webpackJsonp([7],{"8XvH":function(t,n,e){n=t.exports=e("FZ+f")(!1),n.push([t.i,"",""])},BU0n:function(t,n,e){"use strict";n.a={created:function(){var t=this;console.log("loansguarantors component created <<< ");this.$axios.get("https://localhost:8090/sacco/frontend/web/dashboard/loansguarantors",{withCredentials:!0}).then(function(n){console.log("<<< loansguarantors component created response ",n.data),t.rows=n.data}).catch(function(t){console.log("loansguarantors component err",t),400==t.response.status&&(document.body.innerHTML=t.response.data)})},data:function(){return{cols:[{title:"Loan Number",key:"LoanNumber",width:150,fixed:"left",render:function(t,n){return t("div",[t("strong",n.row["Loan Number"])])}},{title:"Client Code",key:"Client Code",width:150,render:function(t,n){return t("div",[t("strong",n.row["Client Code"])])}},{title:"Client Name",key:"Client Name",width:150,render:function(t,n){return t("div",[t("strong",n.row["Client Name"])])}},{title:"Security No_",key:"SecurityNo",width:150,render:function(t,n){return t("div",[t("strong",n.row["Security No_"])])}},{title:"Name",key:"Name",width:200,render:function(t,n){return t("div",[t("strong",n.row.Name)])}},{title:"Outstanding_Balance",key:"Outstanding_Balance",width:150,render:function(t,n){var e=Math.abs(parseInt(n.row.Outstanding_Balance)).toFixed(2);return t("div",[t("strong",isNaN(e)?0:e)])}},{title:"Outstanding_Interest",key:"Outstanding_Interest",width:150,render:function(t,n){var e=Math.abs(parseInt(n.row.Outstanding_Interest)).toFixed(2);return t("div",[t("strong",isNaN(e)?0:e)])}}],rows:[]}},methods:{show:function(t){},remove:function(t){}}}},BkFM:function(t,n,e){"use strict";function r(t){e("gIuA")}var o=e("BU0n"),a=e("FKwM"),s=e("VU/8"),i=r,u=s(o.a,a.a,!1,i,null,null);n.a=u.exports},FKwM:function(t,n,e){"use strict";var r=function(){var t=this,n=t.$createElement;return(t._self._c||n)("Table",{attrs:{border:"",width:"500",height:"150",border:"",columns:t.cols,data:t.rows}})},o=[],a={render:r,staticRenderFns:o};n.a=a},KO5x:function(t,n,e){"use strict";var r=function(){var t=this,n=t.$createElement,e=t._self._c||n;return e("div",{staticStyle:{padding:".5rem",background:"#f1f2f3","min-height":"90vh"}},[e("div",{staticStyle:{background:"#eee",padding:"10px"}},[e("Card",{attrs:{bordered:!1}},[e("p",{attrs:{slot:"title"},slot:"title"},[t._v(" Loan Gurantors ")]),e("p",[e("loansguarantors")],1)])],1)])},o=[],a={render:r,staticRenderFns:o};n.a=a},OwwA:function(t,n,e){"use strict";var r=e("BkFM");n.a={created:function(){},layout:"dashboard",components:{loansguarantors:r.a}}},gIuA:function(t,n,e){var r=e("8XvH");"string"==typeof r&&(r=[[t.i,r,""]]),r.locals&&(t.exports=r.locals);e("rjj0")("5fdb253f",r,!0)},zprL:function(t,n,e){"use strict";Object.defineProperty(n,"__esModule",{value:!0});var r=e("OwwA"),o=e("KO5x"),a=e("VU/8"),s=a(r.a,o.a,!1,null,null,null);n.default=s.exports}});
//# sourceMappingURL=loansguarantors.8330af60fa5485d778f9.js.map