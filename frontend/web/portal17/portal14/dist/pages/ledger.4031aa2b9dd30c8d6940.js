webpackJsonp([6],{"58L+":function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var o=n("pBCK"),r=n("R02Y"),i=n("VU/8"),s=i(o.a,r.a,!1,null,null,null);e.default=s.exports},I5au:function(t,e,n){e=t.exports=n("FZ+f")(!1),e.push([t.i,"",""])},R02Y:function(t,e,n){"use strict";var o=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticStyle:{padding:".5rem",background:"#f1f2f3","min-height":"90vh"}},[n("div",{staticStyle:{background:"#eee",padding:"10px"}},[n("Card",{attrs:{bordered:!1}},[n("p",{attrs:{slot:"title"},slot:"title"},[t._v(" Member Statement Report ")]),n("p",[n("ledger")],1)])],1)])},r=[],i={render:o,staticRenderFns:r};e.a=i},"Z+fL":function(t,e,n){var o=n("I5au");"string"==typeof o&&(o=[[t.i,o,""]]),o.locals&&(t.exports=o.locals);n("rjj0")("0c4da753",o,!0)},hp49:function(t,e,n){"use strict";function o(t){n("Z+fL")}var r=n("tgXw"),i=n("xYpE"),s=n("VU/8"),a=o,d=s(r.a,i.a,!1,a,null,null);e.a=d.exports},pBCK:function(t,e,n){"use strict";var o=n("hp49");e.a={created:function(){console.log("ledger created >>>",this.getCookie("_identity"))},layout:"dashboard",components:{ledger:o.a},data:function(){return{visible:!0}},methods:{show:function(){alert("show")},getCookie:function(t){for(var e=t+"=",n=decodeURIComponent(document.cookie),o=n.split(";"),r=0;r<o.length;r++){for(var i=o[r];" "==i.charAt(0);)i=i.substring(1);if(0==i.indexOf(e))return i.substring(e.length,i.length)}return""}}}},tgXw:function(t,e,n){"use strict";var o=n("fZjL"),r=n.n(o);e.a={created:function(){var t=this;console.log("ledger component created <<< ");var e=window.location.search.split("?")[1]?window.location.search.split("?")[1].split("=")[1]:0,n="https://localhost:8090/sacco/frontend/web/dashboard/view?postingtype="+e;this.$axios.get(n,{withCredentials:!0}).then(function(e){console.log("<<< ledger component created response ",e.data),t.ledger=e.data}).catch(function(t){console.log("ledger component err",e,t),t.response&&400==t.response.status&&(document.body.innerHTML=t.response.data)})},data:function(){return{loading:!0,cols:[{title:"Product Code",key:"ProductCode",render:function(t,e){return t("div",[t("strong",e.row["Product Code"])])}},{title:"Posting Date",key:"PostingDate",render:function(t,e){return t("div",[t("strong",new Date(e.row["Posting Date"]).toISOString().slice(0,10))])}},{title:"Posting Type",key:"PostingType",render:function(t,e){return t("div",[t("strong",e.row["Posting Description"])])}},{title:"Document No",key:"DocumentNo",render:function(t,e){return t("div",[t("strong",e.row["Document No_"])])}},{title:"Customer No",key:"Customer No",render:function(t,e){return t("div",[t("strong",e.row["Customer No_"])])}},{title:"Amount",key:"Amount",render:function(t,e){return t("div",[t("strong",Math.abs(parseInt(e.row.Amount)).toFixed(2))])}}],ledger:[]}},methods:{show:function(t){this.$Modal.info({title:"User Info",content:"Name："+this.rows[t].name+"<br>Age："+this.rows[t].age+"<br>Address："+this.rows[t].address})},remove:function(t){this.rows.splice(t,1)},getData:function(t){return console.log(this.ledger),r()(this.ledger).includes(t[0]["Posting Type"])?this.ledger[t[0]["Posting Type"]]:this.ledger[t[0]["Product Code"]]},isLoading:function(t){return r()(this.ledger).includes(t[0]["Posting Type"])?!this.ledger[t[0]["Posting Type"]].length:!this.ledger[t[0]["Product Code"]].length},getDescription:function(t){return r()(this.ledger).includes(t[0]["Product Code"])?"Loan "+t[0]["Product Code"]:t[0]["Posting Description"]}}}},xYpE:function(t,e,n){"use strict";var o=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",t._l(t.ledger,function(e){return n("div",{staticClass:"card card-2",staticStyle:{"margin-bottom":"1rem"}},[n("h3",{staticStyle:{"text-transform":"capitalize",padding:".5rem",margin:"0"}},[t._v(" "+t._s(t.getDescription(e))+" ")]),n("Table",{attrs:{border:"",columns:t.cols,data:t.getData(e),loading:t.isLoading(e)}})],1)}))},r=[],i={render:o,staticRenderFns:r};e.a=i}});
//# sourceMappingURL=ledger.4031aa2b9dd30c8d6940.js.map