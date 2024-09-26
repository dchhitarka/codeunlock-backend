function __vite__mapDeps(indexes) {
  if (!__vite__mapDeps.viteFileDeps) {
    __vite__mapDeps.viteFileDeps = ["assets/index-DcZMDsWX.js","assets/index-B0ALUG50.css"]
  }
  return indexes.map((i) => __vite__mapDeps.viteFileDeps[i])
}
import{r as o,i as r,j as s,_ as l}from"./index-DcZMDsWX.js";/* empty css              */import{p as n}from"./Reducers-FdYVeQEV.js";import{P as c}from"./PostCard-C1mg2RmO.js";import{P as p}from"./PostListView-BJRl6jFP.js";import"./react-markdown-Bh_9KXKW.js";import"./noimage-y3vxIS37.js";import"./Popup-bydbHcy1.js";const d=o.lazy(()=>l(()=>import("./index-DcZMDsWX.js").then(t=>t.a0),__vite__mapDeps([0,1])));function g(){document.title="Posts | CodeUnlock.in";const[t,i]=o.useReducer(n,{loading:!0});return o.useEffect(()=>{r(i)},[]),s.jsxs("section",{className:"posts",children:[t.loading&&s.jsx(d,{}),!t.loading&&s.jsxs(s.Fragment,{children:[s.jsx("div",{className:"post-info",children:s.jsxs("div",{className:"post-info-child",children:[s.jsx("div",{className:"post-header",children:s.jsx("h1",{className:"post_count",children:"All Posts"})}),s.jsx(p,{})]})}),s.jsxs("ul",{className:"post-list",children:[t.posts.length>0&&t.posts.map((a,e)=>s.jsx(c,{index:e,post:a},e)),t.posts.length===0&&s.jsx("div",{style:{fontStyle:"italic"},children:"No posts available at the moment!"})]})]})]})}export{g as default};
