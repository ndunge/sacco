webpackJsonp([2],{"+hWa":function(e,t,i){t=e.exports=i("FZ+f")(!1),t.push([e.i,".fieldvalue{border:1px solid #e1e2e3;padding:2px;padding:.125rem}.flexc{display:-webkit-box;display:-ms-flexbox;display:flex;padding:0;margin:4px;margin:.25rem}.flexc>div,.info_btn{-webkit-box-flex:1;-ms-flex:1;flex:1}.info_btn{font-weight:700;cursor:default;margin:4px;margin:.25rem;padding:4px;padding:.25rem;border:1px solid #e1e2e3}",""])},"/J6v":function(e,t,i){"use strict";var a=function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("div",{staticStyle:{padding:".5rem",background:"#f1f2f3","min-height":"90vh"}},[i("div",{staticStyle:{background:"#eee",padding:"10px"}},[i("Card",{attrs:{bordered:!1}},[i("p",{attrs:{slot:"title",id:"titre"},slot:"title"},[i("span",{staticStyle:{"font-size":".99rem"}},[e._v("  Member Details  ")]),i("span",{staticStyle:{"margin-left":"auto"}},["readonly"==e.mode?i("Button",{attrs:{type:"primary"},on:{click:e.enableEdit}},[e._v(" Edit ")]):e._e(),"readwrite"==e.mode?i("Button",{attrs:{type:"primary"},on:{click:e.disableEdit}},[e._v(" Cancel ")]):e._e()],1)]),i("p",[i("profile",{attrs:{mode:e.mode}})],1)])],1)])},n=[],o={render:a,staticRenderFns:n};t.a=o},"8faQ":function(e,t,i){t=e.exports=i("FZ+f")(!1),t.push([e.i,"#titre{min-height:32px;min-height:2rem;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center}",""])},"8rqa":function(e,t,i){"use strict";function a(e){i("Luqt")}var n=i("khOZ"),o=i.n(n),s=i("KotU"),r=i("VU/8"),l=a,d=r(o.a,s.a,!1,l,null,null);t.a=d.exports},KotU:function(e,t,i){"use strict";var a=function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("div",{staticStyle:{"box-shadow":"0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24)",padding:".5rem"}},[i("ul",{},[i("li",{staticClass:"flexc",staticStyle:{"font-size":".88rem"}},[i("div",[e._v(" Full Names ")]),i("div",{staticClass:"fieldvalue",staticStyle:{"font-weight":"normal"}},[i("Input",{attrs:{size:"small",disabled:"readonly"===e.mode},model:{value:e.profile.name,callback:function(t){e.profile.name=t},expression:"profile.name"}})],1)]),i("li",{staticClass:"flexc",staticStyle:{"font-size":".88rem"}},[i("div",[e._v(" Address ")]),i("div",{staticClass:"fieldvalue",staticStyle:{"font-weight":"normal"}},[i("Input",{attrs:{size:"small",disabled:"readonly"===e.mode},model:{value:e.profile.address,callback:function(t){e.profile.address=t},expression:"profile.address"}})],1)]),i("li",{staticClass:"flexc",staticStyle:{"font-size":".88rem"}},[i("div",[e._v(" Member since ")]),i("div",{staticClass:"fieldvalue",staticStyle:{"font-weight":"normal"}},[i("Input",{attrs:{size:"small",disabled:"readonly"===e.mode},model:{value:e.profile.joined,callback:function(t){e.profile.joined=t},expression:"profile.joined"}})],1)]),i("li",{staticClass:"flexc",staticStyle:{"font-size":".88rem"}},[i("div",[e._v(" Phone Number ")]),i("div",{staticClass:"fieldvalue",staticStyle:{"font-weight":"normal"}},[i("Input",{attrs:{size:"small",disabled:"readonly"===e.mode},model:{value:e.profile.number,callback:function(t){e.profile.number=t},expression:"profile.number"}})],1)])]),i("div",{staticStyle:{background:"#eee",padding:"10px","text-align":"right"}},["readwrite"==e.mode?i("Button",{attrs:{type:"primary"},on:{click:e.saveChanges}},[e._v(" Save ")]):e._e()],1)])},n=[],o={render:a,staticRenderFns:n};t.a=o},Luqt:function(e,t,i){var a=i("+hWa");"string"==typeof a&&(a=[[e.i,a,""]]),a.locals&&(e.exports=a.locals);i("rjj0")("fd163b36",a,!0)},N66W:function(e,t,i){"use strict";function a(e){i("ndBD")}Object.defineProperty(t,"__esModule",{value:!0});var n=i("fe91"),o=i("/J6v"),s=i("VU/8"),r=a,l=s(n.a,o.a,!1,r,null,null);t.default=l.exports},fe91:function(e,t,i){"use strict";var a=i("8rqa");t.a={created:function(){console.log("dashboard created >>>",this.getCookie("_identity"))},layout:"dashboard",components:{profile:a.a},data:function(){return{mode:"readonly"}},methods:{show:function(){},enableEdit:function(){this.mode="readwrite"},disableEdit:function(){this.mode="readonly"},getCookie:function(e){for(var t=e+"=",i=decodeURIComponent(document.cookie),a=i.split(";"),n=0;n<a.length;n++){for(var o=a[n];" "==o.charAt(0);)o=o.substring(1);if(0==o.indexOf(t))return o.substring(t.length,o.length)}return""}}}},khOZ:function(e,t){e.exports={created:function(){var e=this;console.log("dashboard component created <<< ",this.mode);this.$axios.get("http://localhost:8090/sacco/frontend/web/dashboard/memberstatement",{withCredentials:!0}).then(function(t){console.log("created",t),e.profile=t.data}).catch(function(e){console.log("err",e)})},data:function(){return{profile:{}}},props:["mode"],methods:{saveChanges:function(){var e=this;this.$axios.get("http://localhost:8090/sacco/frontend/web/dashboard/memberstatement",{withCredentials:!0}).then(function(t){console.log("created",t),e.profile=t.data}).catch(function(e){console.log("err",e)})}}}},ndBD:function(e,t,i){var a=i("8faQ");"string"==typeof a&&(a=[[e.i,a,""]]),a.locals&&(e.exports=a.locals);i("rjj0")("1f0bffca",a,!0)}});
//# sourceMappingURL=profile.5b25ed503ce3206009ca.js.map