import{j as e,n as c,L as d}from"./index-DcZMDsWX.js";import{R as g}from"./react-markdown-Bh_9KXKW.js";import{n as m}from"./noimage-y3vxIS37.js";/* empty css              */import{S as x,a as h}from"./a11y-dark-upxbRWMY.js";function v({post:a}){const o=["red","indigo","blue","green","yellow","orange","violet"];return e.jsxs("section",{className:"post",children:[e.jsx("h1",{className:"title",children:a.post_title}),e.jsxs("div",{className:"metadata",children:[e.jsx("div",{className:"post-date",style:{display:"flex",alignItems:"center"},children:e.jsxs("span",{children:["Published On: ",c((a==null?void 0:a.published_on)??(a==null?void 0:a.created_at))]})}),e.jsx("div",{className:"post-tags",children:a.tags&&a.tags.map((s,r)=>e.jsx(d,{to:`/tags/${s.tag_slug}`,children:e.jsx("span",{className:"post-tag",onMouseOver:t=>t.target.style.opacity="0.8",onMouseLeave:t=>t.target.style.opacity="1",style:{backgroundColor:o[r]},children:`#${s.tag}`},r)},r))})]}),e.jsx("img",{className:"image",onError:s=>{s.target.src=m,s.target.style.display="none"},src:a.post_image??"",alt:"Post"}),e.jsx("div",{className:"content",children:e.jsx(g,{children:a.post_body,components:{code({node:s,inline:r,className:t,children:n,...l}){const i=/language-(\w+)/.exec(t||"");return!r&&i?e.jsx(x,{children:String(n).replace(/\n$/,""),style:h,language:i[1],PreTag:"div",...l}):e.jsx("code",{className:t,...l,children:n})}}})}),e.jsx("hr",{})]})}export{v as default};
