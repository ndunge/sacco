webpackJsonp([10],{"58L+":function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r=n("pBCK"),o=n("tN+3"),i=n("VU/8"),s=i(r.a,o.a,!1,null,null,null);e.default=s.exports},"GjL+":function(t,e,n){"use strict";var r=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",t._l(t.ledger,function(e){return n("div",{staticClass:"card card-2",staticStyle:{"margin-bottom":"1rem"}},[n("h3",{staticStyle:{"text-transform":"capitalize",padding:".5rem",margin:"0"}},[t._v(" "+t._s(t.getDescription(e))+" ")]),n("Table",{attrs:{border:"",columns:t.cols,data:t.getData(e),loading:t.isLoading(e)}})],1)}))},o=[],i={render:r,staticRenderFns:o};e.a=i},Jg5j:function(t,e,n){var r=n("qvXo");"string"==typeof r&&(r=[[t.i,r,""]]),r.locals&&(t.exports=r.locals);n("rjj0")("3727be0b",r,!0)},hp49:function(t,e,n){"use strict";function r(t){n("Jg5j")}var o=n("tgXw"),i=n("GjL+"),s=n("VU/8"),a=r,d=s(o.a,i.a,!1,a,null,null);e.a=d.exports},pBCK:function(t,e,n){"use strict";var r=n("hp49");e.a={created:function(){console.log("ledger created >>>",this.getCookie("_identity"))},layout:"dashboard",components:{ledger:r.a},data:function(){return{visible:!0}},methods:{show:function(){alert("show")},getCookie:function(t){for(var e=t+"=",n=decodeURIComponent(document.cookie),r=n.split(";"),o=0;o<r.length;o++){for(var i=r[o];" "==i.charAt(0);)i=i.substring(1);if(0==i.indexOf(e))return i.substring(e.length,i.length)}return""}}}},qvXo:function(t,e,n){e=t.exports=n("FZ+f")(!1),e.push([t.i,"",""])},"tN+3":function(t,e,n){"use strict";var r=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticStyle:{padding:".5rem",background:"#f1f2f3","min-height":"90vh"}},[n("div",{staticStyle:{background:"#eee",padding:"10px"}},[n("Card",{attrs:{bordered:!1}},[n("p",{attrs:{slot:"title"},slot:"title"},[t._v(" Member Statement Report ")]),n("p",[t._v("From: "),n("input",{attrs:{type:"date",id:"datepicker"}}),t._v("\n         \n         To: "),n("input",{attrs:{type:"date",id:"datepicker"}})]),n("br"),n("br"),n("p",[n("ledger")],1)])],1)])},o=[],i={render:r,staticRenderFns:o};e.a=i},tgXw:function(t,e,n){"use strict";var r=n("fZjL"),o=n.n(r);e.a={created:function(){var t=this;console.log("ledger component created <<< ");var e=window.location.search.split("?")[1]?window.location.search.split("?")[1].split("=")[1]:0,n="http://localhost:85/sacco/frontend/web/dashboard/view?postingtype="+e;this.$axios.get(n,{withCredentials:!0}).then(function(e){console.log("<<< ledger component created response ",e.data),t.ledger=e.data}).catch(function(t){console.log("ledger component err",e,t),t.response&&400==t.response.status&&(document.body.innerHTML=t.response.data)})},data:function(){return{loading:!0,cols:[{title:"Posting Date",key:"PostingDate",render:function(t,e){return t("div",[t("strong",new Date(e.row["Posting Date"]).toISOString().slice(0,10))])}},{title:"Document No",key:"DocumentNo",render:function(t,e){return t("div",[t("strong",e.row["Document No_"])])}},{title:"Posting Type",key:"PostingType",render:function(t,e){return t("div",[t("strong",e.row["Posting Description"])])}},{title:"Debit Amount",key:"Debit_Amount",render:function(t,e){return t("div",[t("strong",parseFloat(e.row.Debit_Amount).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g,","))])}},{title:"Credit Amount",key:"Credit_Amount",render:function(t,e){return t("div",[t("strong",parseFloat(e.row.Credit_Amount).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g,","))])}},{title:"Amount",key:"Amount",render:function(t,e){return t("div",[t("strong",parseFloat(e.row.Amount).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g,","))])}},{title:"Balance",key:"Balance",render:function(t,e){return t("div",[t("strong",Math.abs(parseFloat(e.row.Balance)).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g,","))])}}],ledger:[]}},methods:{show:function(t){this.$Modal.info({title:"User Info",content:"Name："+this.rows[t].name+"<br>Age："+this.rows[t].age+"<br>Address："+this.rows[t].address})},remove:function(t){this.rows.splice(t,1)},getData:function(t){return console.log(this.ledger),o()(this.ledger).includes(t[0]["Posting Type"])?this.ledger[t[0]["Posting Type"]]:this.ledger[t[0]["Product Code"]]},isLoading:function(t){return o()(this.ledger).includes(t[0]["Posting Type"])?!this.ledger[t[0]["Posting Type"]].length:!this.ledger[t[0]["Product Code"]].length},getDescription:function(t){return o()(this.ledger).includes(t[0]["Product Code"])?"Loan "+t[0]["Product Code"]:t[0]["Posting Description"]}}}}});
//# sourceMappingURL=ledger.cce349c3897e9e2476f0.js.map