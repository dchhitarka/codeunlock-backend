(this.webpackJsonpfrontend=this.webpackJsonpfrontend||[]).push([[6],{526:function(e,t,r){"use strict";r.r(t),r.d(t,"Verify",(function(){return b})),r.d(t,"Verified",(function(){return m}));var s=r(1),a=r.n(s),c=r(3),n=r(15),i=r(0),o=r(6),u=r(18),l=r(19),j=r(2),b=function(e){var t=Object.assign({},e),r=(null===t||void 0===t?void 0:t.props).msg,s=Object(i.useState)(""),o=Object(n.a)(s,2),b=o[0],m=o[1],d=Object(i.useState)(""),f=Object(n.a)(d,2),O=f[0],h=f[1],p=Object(i.useState)(!1),v=Object(n.a)(p,2),x=v[0],g=v[1],N=Object(i.useState)(""),y=Object(n.a)(N,2),S=y[0],w=y[1];return Object(j.jsxs)("div",{className:"login",children:[x&&Object(j.jsx)(l.a,{}),Object(j.jsxs)("form",{className:"login-form",onSubmit:function(e){(e.preventDefault(),""===b)?h("Email can't be empty"):function(){var e=Object(c.a)(a.a.mark((function e(){var t;return a.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return h(null),g(!0),e.next=4,Object(u.t)(b);case 4:(t=e.sent).status?(g(!1),w(t.message)):h(t.error),g(!1);case 7:case"end":return e.stop()}}),e)})));return function(){return e.apply(this,arguments)}}()()},children:[Object(j.jsxs)("div",{className:"form-header",style:{textAlign:"center",paddingTop:"10px"},children:[Object(j.jsx)("div",{className:"form-heading",children:"Account Verification"}),Object(j.jsx)("div",{className:"form-error",style:{color:"red"},children:O}),Object(j.jsx)("div",{className:"form-error",style:{color:"green"},children:r}),Object(j.jsx)("div",{className:"form-error",style:{color:"green"},children:S})]}),Object(j.jsx)("div",{className:"form-header",children:Object(j.jsx)("div",{className:"form-error",style:{color:"black"},children:"Resend Verification Mail"})}),Object(j.jsxs)("div",{className:"form-input",children:[Object(j.jsx)("label",{className:"form-label",children:"Email"}),Object(j.jsx)("input",{type:"email",value:b,name:"email",id:"email",placeholder:"user@account.com",onChange:function(e){return m(e.target.value)},required:!0})]}),Object(j.jsx)("div",{className:"form-submit",children:Object(j.jsx)("button",{className:"form-button login-button active-button",children:"SEND"})})]})]})},m=function(){var e=Object(o.h)(),t=e.hash,r=e.email_hash,s=Object(i.useState)(!0),b=Object(n.a)(s,2),m=b[0],d=b[1],f=Object(i.useState)({status:!1,msg:void 0}),O=Object(n.a)(f,2),h=O[0],p=O[1],v=Object(i.useState)({status:!1,err:void 0}),x=Object(n.a)(v,2),g=x[0],N=x[1],y=Object(o.g)();return Object(i.useEffect)((function(){function e(){return(e=Object(c.a)(a.a.mark((function e(){var s;return a.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,Object(u.A)(t,r);case 2:(s=e.sent).status?(d(!1),p({status:!0,msg:s.message})):N({status:!0,err:s.error});case 4:case"end":return e.stop()}}),e)})))).apply(this,arguments)}!function(){e.apply(this,arguments)}()})),Object(j.jsxs)("div",{children:[m&&Object(j.jsx)(l.a,{}),h&&y.push({pathname:"/u/login",state:{msg:h.msg}}),g.status&&y.push({pathname:"/u/verify",state:{error:g.err}})]})}}}]);
//# sourceMappingURL=6.9b36546e.chunk.js.map