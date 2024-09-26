import{r as i,j as e,q as u,L as p}from"./index-DcZMDsWX.js";import{n as h}from"./noimage-y3vxIS37.js";import{P as d}from"./Popup-bydbHcy1.js";function j(){const[s,l]=i.useState({post_title:"",post_body:"",post_image:void 0,post_status:0}),[r,c]=i.useState(void 0),[n,m]=i.useState(void 0);return document.title="Create New Post | Admin | CodeUnlock.in",e.jsxs("div",{className:"post-edit",children:[r&&e.jsx(d,{message:r,type:"success"}),n&&e.jsx(d,{message:n,type:"error"}),e.jsxs("form",{className:"post-form",onSubmit:t=>{t.preventDefault();const a=[];document.querySelectorAll(".post_tags").forEach(o=>a.push(o.value)),u({...s,tags:a}).then(o=>{m((o==null?void 0:o.error)??void 0),c((o==null?void 0:o.message)??void 0)})},children:[e.jsxs("div",{className:"form-header",style:{flexDirection:"row",justifyContent:"space-between"},children:[e.jsx("button",{className:"form-button",children:"CREATE"}),e.jsx("div",{className:"form-heading",children:"NEW POST"}),e.jsx(p,{to:"/admin/posts",children:e.jsx("button",{className:"form-button unactive-button",children:"BACK"})})]}),e.jsxs("div",{className:"admin-post-top",children:[e.jsxs("div",{className:"admin-post-top-left",children:[e.jsxs("div",{className:"form-input",children:[e.jsx("label",{className:"form-label",children:"Title"}),e.jsx("input",{type:"text",value:s.post_title,name:"post_title",id:"title",onChange:t=>l({...s,post_title:t.target.value}),placeholder:"Add New Title",required:!0})]}),e.jsxs("div",{className:"form-input",children:[e.jsx("label",{className:"form-label",children:"Status"}),e.jsxs("select",{name:"post_status",id:"post_status",onChange:t=>l({...s,post_status:parseInt(t.target.value)}),required:!0,children:[e.jsx("option",{value:"0",defaultValue:!!s.post_status,children:"Draft"}),e.jsx("option",{value:"1",defaultValue:!!s.post_status,children:"Published"})]})]}),e.jsxs("div",{className:"form-input",children:[e.jsx("label",{className:"form-label",children:"Image (Add Drive link where the image is stored)"}),e.jsx("input",{type:"text",value:s.post_image??"https://drive.google.com/uc?export=view&id=",onChange:t=>l({...s,post_image:t.target.value})})]})]}),e.jsx("div",{className:"admin-post-top-right",children:e.jsx("img",{src:s.post_image,onError:t=>t.target.src=h,id:"post_image",width:"200",height:"200",alt:"Post Cover"})})]}),e.jsxs("div",{className:"form-input",children:[e.jsxs("label",{className:"form-label",style:{display:"flex",justifyContent:"space-between"},children:[e.jsx("span",{children:"Body"}),e.jsx("div",{className:"words-count",style:{color:"grey",fontStyle:"italic",fontSize:"15px"},children:s.post_body.length===0?"0 words":`${s.post_body.split(" ").length} words`})]}),e.jsx("textarea",{type:"text",rows:"50",value:s.post_body,name:"post_body",id:"post_body",onChange:t=>l({...s,post_body:t.target.value}),required:!0})]}),e.jsxs("div",{className:"form-input",children:[e.jsx("label",{className:"form-label",children:"Tags"}),e.jsx("div",{className:"tags-list",children:e.jsx("input",{type:"text",name:"tags",className:"post_tags",required:!0})}),e.jsxs("div",{className:"action-buttons",children:[e.jsx("button",{className:"form-button",onClick:t=>{t.preventDefault();let a=document.createElement("INPUT");a.className="post_tags",a.required=!0,document.querySelector(".tags-list").appendChild(a)},children:"ADD"}),e.jsx("button",{className:"form-button unactive-button",onClick:t=>{t.preventDefault();let a=document.querySelector(".tags-list");a.childElementCount>1?a.removeChild(a.lastElementChild):alert("One tag is required")},children:"REMOVE"})]})]})]})]})}export{j as default};
