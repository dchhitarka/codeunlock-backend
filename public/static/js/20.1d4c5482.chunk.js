(this.webpackJsonpfrontend=this.webpackJsonpfrontend||[]).push([[20],{46:function(e,a,r){"use strict";r.d(a,"b",(function(){return c})),r.d(a,"c",(function(){return n})),r.d(a,"d",(function(){return o})),r.d(a,"a",(function(){return l}));var t=r(5),s=r(4),c=function(e,a){switch(a.type){case s.n:return{loading:!0};case s.i:return{posts:a.payload,loading:!1};case s.h:case"EDIT_POST":return Object(t.a)(Object(t.a)({},a.payload),{},{loading:!1});case s.o:case s.c:return Object(t.a)(Object(t.a)({},a.payload),{},{loading:!1});case s.f:return{msg:a.payload,loading:!1,error:!0};default:return e}},n=function(e,a){switch(a.type){case s.n:return Object(t.a)(Object(t.a)({},e),{},{loading:!0});case s.k:return{tags:a.payload,loading:!1};case s.d:case s.j:case s.p:case s.f:return Object(t.a)(Object(t.a)({},a.payload),{},{loading:!1});default:return e}},o=function(e,a){switch(a.type){case s.n:return Object(t.a)(Object(t.a)({},e),{},{loading:!0});case s.m:return a.payload;case s.l:return{user:a.payload,loading:!1};case s.e:case s.f:return{user:null,error:a.payload,loading:!1};case"STOP_LOADING":return Object(t.a)(Object(t.a)({},e),{},{loading:!1});default:return e}},l=function(e,a){switch(a.type){case s.g:case s.b:case s.a:case s.f:return a.payload;default:return e}}},48:function(e,a,r){},524:function(e,a,r){"use strict";r.r(a),r.d(a,"default",(function(){return b}));var t=r(5),s=r(15),c=r(0),n=(r(48),r(6)),o=r(16),l=r(19),i=r(46),d=r(18),u=r(2);function b(){var e=Object(c.useState)("rgba(0,0,0,0.2)"),a=Object(s.a)(e,2),r=a[0],b=a[1],j=Object(c.useState)("rgba(0,0,0,0.2)"),m=Object(s.a)(j,2),O=m[0],f=m[1],p=Object(c.useState)({name:"",email:"",password:"",cPassword:"",accept:!0}),h=Object(s.a)(p,2),g=h[0],w=h[1],x=Object(c.useReducer)(i.d,{loading:!1}),v=Object(s.a)(x,2),y=v[0],N=v[1],E=Object(n.g)(),P=Object(c.useState)({passwordErr:"",confirmPassErr:"",formErr:""}),S=Object(s.a)(P,2),C=S[0],k=S[1];return Object(u.jsx)("div",{className:"register",children:y.loading?Object(u.jsx)(l.a,{}):Object(u.jsxs)("form",{className:"register-form",onSubmit:function(e){e.preventDefault(),""===g.email||""===g.password?k(Object(t.a)(Object(t.a)({},C),{},{formErr:"Email or Password can't be empty"})):(k(Object(t.a)(Object(t.a)({},C),{},{formErr:""})),Object(d.z)(g,N).then((function(e){e.status?E.push({pathname:"/u/verify",state:{msg:"You are registered successfully! Click on the link sent to your mail to verify your account.",sendmail:!1}}):k(Object(t.a)(Object(t.a)({},C),{},{formErr:e.message}))})).catch((function(e){return k(Object(t.a)(Object(t.a)({},e),{},{formErr:e.message}))})))},children:[Object(u.jsxs)("div",{className:"form-header",children:[Object(u.jsx)("div",{className:"form-heading",children:"REGISTER"}),Object(u.jsx)("div",{className:"form-error",children:C.formErr})]}),Object(u.jsxs)("div",{className:"form-input",children:[Object(u.jsx)("label",{className:"form-label",children:"Name"}),Object(u.jsx)("input",{type:"text",value:g.name,name:"name",id:"name",placeholder:"",onChange:function(e){return w(Object(t.a)(Object(t.a)({},g),{},{name:e.target.value}))},required:!0})]}),Object(u.jsxs)("div",{className:"form-input",children:[Object(u.jsx)("label",{className:"form-label",children:"Email"}),Object(u.jsx)("input",{type:"email",value:g.email,name:"email",id:"email",placeholder:"user@account.com",onChange:function(e){return w(Object(t.a)(Object(t.a)({},g),{},{email:e.target.value}))},required:!0})]}),Object(u.jsxs)("div",{className:"form-input",children:[Object(u.jsx)("label",{className:"form-label",children:"Password"}),Object(u.jsx)("input",{type:"password",value:g.password,name:"password",id:"password",style:{borderColor:r},onChange:function(e){w(Object(t.a)(Object(t.a)({},g),{},{password:e.target.value})),e.target.value.length<5?(b("red"),k(Object(t.a)(Object(t.a)({},C),{},{passwordErr:"Password must be greater than 5 characters"}))):(b("green"),k(Object(t.a)(Object(t.a)({},C),{},{passwordErr:"Password is greater than 5 characters"}))),""!==g.cPassword&&(g.cPassword===g.password?(f("green"),k(Object(t.a)(Object(t.a)({},C),{},{confirmPasswordErr:"Password Confirmed"}))):(f("red"),k(Object(t.a)(Object(t.a)({},C),{},{confirmPasswordErr:"Password does not match"}))))},required:!0})]}),Object(u.jsx)("div",{className:"password-msg",style:{color:r,fontSize:"12px",marginLeft:"8px"},children:C.passwordErr}),Object(u.jsxs)("div",{className:"form-input",children:[Object(u.jsx)("label",{className:"form-label",children:"Confirm Password"}),Object(u.jsx)("input",{type:"password",value:g.cPassword,name:"password",id:"cpassword",style:{borderColor:O},onChange:function(e){w(Object(t.a)(Object(t.a)({},g),{},{cPassword:e.target.value})),""!==e.target.value&&(e.target.value===g.password?(f("green"),k(Object(t.a)(Object(t.a)({},C),{},{confirmPasswordErr:"Password Confirmed"}))):(f("red"),k(Object(t.a)(Object(t.a)({},C),{},{confirmPasswordErr:"Password does not match"}))))},required:!0})]}),Object(u.jsx)("div",{className:"password-msg",style:{color:O,fontSize:"12px",marginLeft:"8px"},children:C.confirmPasswordErr}),Object(u.jsx)("div",{className:"form-input form-foot",children:Object(u.jsxs)("label",{className:"form-label remember",children:[Object(u.jsx)("input",{type:"checkbox",value:g.accept,required:!0,name:"accept",id:"accept",onChange:function(e){return w(Object(t.a)(Object(t.a)({},g),{},{accept:e.target.checked}))}}),Object(u.jsxs)("span",{children:["Accept ",Object(u.jsx)("a",{target:"_blank",rel:"noopener noreferrer",href:"https://www.termsandconditionsgenerator.com/live.php?token=wvWK6xVNeRGwwnlnNeymBSSOKRmcrvAM",style:{color:"blue"},children:"Terms and Conditions"})]})]})}),Object(u.jsxs)("div",{className:"form-submit",children:[Object(u.jsx)("button",{className:"form-button register-button active-button",children:"REGISTER"}),Object(u.jsx)(o.b,{to:"/u/login",children:Object(u.jsx)("button",{className:"form-button login-button unactive-button",children:"LOGIN"})})]})]})})}}}]);
//# sourceMappingURL=20.1d4c5482.chunk.js.map